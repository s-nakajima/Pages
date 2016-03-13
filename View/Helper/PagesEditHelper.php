<?php
/**
 * LayoutHelper
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppHelper', 'View/Helper');
App::uses('Page', 'Pages.Model');

/**
 * LayoutHelper
 *
 */
class PagesEditHelper extends AppHelper {

/**
 * 使用するヘルパー
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.LinkButton',
		'NetCommons.NetCommonsHtml',
		'NetCommons.NetCommonsForm',
		'NetCommons.Token'
	);

/**
 * ページ順序配列
 *
 * @var array
 */
	protected $_pageWeight = array();

/**
 * Before render callback. beforeRender is called before the view file is rendered.
 *
 * Overridden in subclasses.
 *
 * @param string $viewFile The view file that is going to be rendered
 * @return void
 */
	public function beforeRender($viewFile) {
		$this->NetCommonsHtml->css('/pages/css/style.css');
		parent::beforeRender($viewFile);
	}

/**
 * レイアウト変更のimgデータ取得
 *
 * @return array imgリスト
 */
	public function getLayouts() {
		$dir = new Folder(
			CakePlugin::path('Pages') . WEBROOT_DIR . DS . 'img' . DS . 'layouts'
		);
		$files = $dir->find('.*\.png', true);

		return $files;
	}

/**
 * ページの出力
 *
 * @return string HTML
 */
	public function getPagesEditJsInit() {
		$pages = array();

		foreach ($this->_View->viewVars['treeList'] as $pageId) {
			$page = Hash::get($this->_View->viewVars['pages'], $pageId);
			$parentId = (int)$page['Page']['parent_id'];
			$page['Page']['parent_id'] = (string)$parentId;
			$page['Page']['type'] = '';

			// * ページ名
			if (Current::read('Room.id') !== Room::PUBLIC_PARENT_ID &&
					Hash::get($page, 'Page.id') === Current::read('Room.page_id_top')) {

				$page['LanguagesPage']['name'] = $this->roomName();
			}

			// * Tokenの値セット
			$data = array(
				'Page' => array(
					'id' => $page['Page']['id'],
					'parent_id' => $page['Page']['parent_id'],
					'type' => '',
				),
			);
			$tokenFields = Hash::flatten($data);
			$hiddenFields = $tokenFields;
			unset($hiddenFields['Page.type']);

			$this->_View->request->data = Hash::merge($this->_View->request->data, $data);
			$tokens = $this->Token->getToken('PagesEdit', '/pages/pages_edit/move.json', $tokenFields, array_keys($hiddenFields));

			$pages[$pageId] = Hash::merge(array(
				'Page' => $page['Page'],
				'LanguagesPage' => $page['LanguagesPage'],
			), $tokens);
		}

		return h(json_encode($pages)) . ', ' .
				h(json_encode($this->_View->viewVars['treeList'])) . ', ' .
				h(json_encode($this->_View->viewVars['parentList']));
	}

/**
 * ルーム名の出力
 *
 * @return string HTML
 */
	public function roomName() {
		$room = Hash::extract(
			$this->_View->viewVars['room'],
			'RoomsLanguage.{n}[language_id=' . Current::read('Language.id') . ']'
		);

		return Hash::get($room, '0.name');
	}

}
