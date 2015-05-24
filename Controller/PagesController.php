<?php
/**
 * Pages Controller
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('PagesAppController', 'Pages.Controller');

/**
 * Pages Controller
 *
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @package NetCommons\Pages\Controller
 */
class PagesController extends PagesAppController {

/**
 * use layout
 *
 * @var string
 */
	public $layout = 'Pages.default';

/**
 * uses
 *
 * @var array
 */
	public $uses = array(
		'Pages.Page',
		'Rooms.PluginsRoom'
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'pageEditable' => array('add'),
			),
		),
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'Pages.Layout'
	);

/**
 * index method
 *
 * @throws NotFoundException
 * @return void
 */
	public function index() {
		if (Page::isSetting() && ! $this->viewVars['pageEditable']) {
			$paths = func_get_args();
			$path = implode('/', $paths);
			$this->redirect('/' . $path);
			return;
		}

		Configure::write('Pages.isSetting', Page::isSetting());

		$paths = func_get_args();
		$path = implode('/', $paths);

		$page = $this->Page->getPageWithFrame($path);
		if (empty($page)) {
			throw new NotFoundException();
		}
		$page = $this->camelizeKeyRecursive($page);
		$this->set('page', $page);

		$page['container'] = Hash::combine($page['container'], '{n}.type', '{n}');
		$page['box'] = Hash::combine($page['box'], '{n}.id', '{n}', '{n}.containerId');
		$this->set('path', $path);

		$page['container'] = array(Container::TYPE_MAIN => $page['container'][Container::TYPE_MAIN]);
		$this->set('pageMainContainer', $page);

		//プラグインデータ取得
		$plugins = $this->PluginsRoom->getPlugins($page['page']['roomId'], $page['language'][0]['id']);
		$plugins = $this->camelizeKeyRecursive($plugins);
		$this->set('plugins', $plugins);

		$pluginMap = [];
		foreach ($plugins as $plugin) {
			$pluginMap[$plugin['plugin']['key']] = $plugin['plugin'];
		}
		$this->set('pluginMap', $pluginMap);
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Page->create();
			$page = $this->Page->savePage($this->request->data);
			if ($page) {
				$this->Session->setFlash(__('The page has been saved.'));
				return $this->redirect('/' . Page::SETTING_MODE_WORD . '/' . $page['Page']['permalink']);
			} else {
				$this->Session->setFlash(__('The page could not be saved. Please, try again.'));
				// It should review error handling
				return $this->redirect('/' . Page::SETTING_MODE_WORD . '/' . $page['Page']['permalink']);
			}
		}
	}

}
