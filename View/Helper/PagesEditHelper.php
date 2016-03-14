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

		return h(json_encode($pages)) . ', ' . h(json_encode($treeList)) . ', ' . h(json_encode($parentList));
	}

}
