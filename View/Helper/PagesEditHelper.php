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
 * インデント
 *
 * @return string HTML
 */
	public function indent($pageId) {
		$parentId = $this->_View->viewVars['pages'][$pageId]['Page']['parent_id'];
		$nest = $this->_View->viewVars['parentList']['_' . $parentId]['_' . $pageId]['nest'];
		return str_repeat('<span class="pages-tree"> </span> ', $nest);
	}

/**
 * 移動先のラジオボタン
 *
 * @param string $fieldName フィールド名(Model.field)
 * @param int $pageId ページID
 * @return string ラジオボタン
 */
	public function radioPageMove($pageId) {
		if (Current::read('Page.parent_id') === (string)$pageId) {
			return;
		}
		return $this->NetCommonsForm->radio('Page.parent_id', array($pageId => ''), array(
			'hiddenField' => false,
		));
	}

}
