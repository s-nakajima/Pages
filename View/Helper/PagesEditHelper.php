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
		//'NetCommons.Button',
		'NetCommons.NetCommonsHtml',
		//'NetCommons.NetCommonsForm'
	);

/**
 * After render file callback.
 * Called after any view fragment is rendered.
 *
 * Overridden in subclasses.
 *
 * @param string $viewFile The file just be rendered.
 * @param string $content The content that was rendered.
 * @return void
 */
	public function afterRenderFile($viewFile, $content) {
		$content = $this->NetCommonsHtml->css('/pages/css/style.css') . $content;
		parent::afterRenderFile($viewFile, $content);
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
 * @param int $pageId ページデータ
 * @param string $tree Treeデータ
 * @return string HTML
 */
	public function pageRender($pageId, $tree) {
		$page = Hash::get($this->_View->viewVars['pages'], $pageId);
		$nest = substr_count($tree, Page::$treeParser);

		return $this->_View->element('PagesEdit/render_index', array('page' => $page, 'nest' => $nest));
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

/**
 * ページ名の出力
 *
 * @param array $page ページデータ配列
 * @param int|null $nest インデント
 * @return string HTML
 */
	public function pageName($page, $nest = null) {
		$output = '';
		if (isset($nest)) {
			$output .= str_repeat('<span class="pages-tree"> </span> ', $nest);
		}

		$output .= $this->moveButton($page);

		if (Current::read('Room.id') !== Room::PUBLIC_PARENT_ID && Hash::get($page, 'Page.id') === Current::read('Room.page_id_top')) {
			$title = h($this->roomName());
		} else {
			$title = h($page['LanguagesPage']['name']);
		}
		$output .= $this->NetCommonsHtml->link($title,
				array('key' => $page['Page']['room_id'], $page['Page']['id']),
				array('escapeTitle' => true));

		return $output;
	}

/**
 * 状態によるCSSのクラス定義を返す
 *
 * @param array $page ページデータ配列
 * @return string HTML
 */
	public function activeCss($page) {
		$output = '';
		if (Hash::get($page, 'Page.id') === Current::read('Page.id')) {
			$output .= 'active';
		}
		return $output;
	}

/**
 * 移動ボタンを返す
 *
 * @param array $page ページデータ配列
 * @return string HTML
 */
	public function moveButton($page) {
		$output = '';

		return $this->_View->element('PagesEdit/page_move');
	}

}
