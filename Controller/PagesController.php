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
//	public $layout = 'Pages.default';

/**
 * uses
 *
 * @var array
 */
	public $uses = array(
		'Pages.Page',
		'Pages.LanguagesPage',
		'Rooms.PluginsRoom',
		'M17n.Language',
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
				'pageEditable' => array('add', 'edit', 'delete'),
			),
		),
		'Security',
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
		$this->set('path', '/' . $path);

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
 * add
 *
 * @return void
 */
	public function add($roomId = null, $pageId = null) {
		$this->view = 'edit';

		$language = $this->Language->findByCode(Configure::read('Config.language'));
		$this->set('languageId', $language['Language']['id']);

		if (! $page = $this->Page->getPage($pageId, $roomId)) {
			$this->throwBadRequest();
			return;
		}
		$this->set('path', '/' . $page['Page']['slug']);

		$cancelUrl = '/' . Page::SETTING_MODE_WORD . '/' . $page['Page']['slug'];
		$this->set('cancelUrl', $cancelUrl);

		$page = $this->Page->create(array(
			'id' => null,
			'parent_id' => null,
			'slug' => Security::hash($this->params['plugin'] . mt_rand() . microtime(), 'md5')
		));
		$languagesPage = $this->LanguagesPage->create(array(
			'id' => null,
			'language_id' => $this->viewVars['languageId'],
			'name' => sprintf(__d('pages', 'New page %s'), date('YmdHis')),
		));

		$formPage = Hash::merge($page, $languagesPage);

		if ($this->request->isPost()) {
			$page = $this->Page->savePage($this->request->data);
			if ($this->handleValidationError($this->Page->validationErrors)) {
				//正常の場合
				$this->redirect('/' . Page::SETTING_MODE_WORD . '/' . $page['Page']['permalink']);
				return;
			}

			$formPage = Hash::merge($formPage, $this->request->data);
		}

		$formPage = $this->camelizeKeyRecursive($formPage);
		$this->set('formPage', $formPage);
	}

/**
 * edit
 *
 * @return void
 */
	public function edit($roomId = null, $pageId = null) {
		$language = $this->Language->findByCode(Configure::read('Config.language'));
		$this->set('languageId', $language['Language']['id']);

		if (! $page = $this->Page->getPage($pageId, $roomId)) {
			$this->throwBadRequest();
			return;
		}
		$this->set('path', '/' . $page['Page']['slug']);

		$cancelUrl = '/' . Page::SETTING_MODE_WORD . '/' . $page['Page']['slug'];
		$this->set('cancelUrl', $cancelUrl);

		if (! $languagesPage = $this->LanguagesPage->getLanguagesPage($pageId, $this->viewVars['languageId'])) {
			$this->throwBadRequest();
			return;
		}

		$formPage = Hash::merge($page, $languagesPage);

		if ($this->request->isPost()) {
			$page = $this->Page->savePage($this->request->data);
			if ($this->handleValidationError($this->Page->validationErrors)) {
				//正常の場合
				$this->redirect('/' . Page::SETTING_MODE_WORD . '/' . $page['Page']['permalink']);
				return;
			}

			$formPage = Hash::merge($formPage, $this->request->data);
		}

		$formPage = $this->camelizeKeyRecursive($formPage);
		$this->set('formPage', $formPage);
	}

/**
 * delete
 *
 * @return void
 */
	public function delete($roomId = null, $pageId = null) {
		$language = $this->Language->findByCode(Configure::read('Config.language'));
		$this->set('languageId', $language['Language']['id']);

		if (! $page = $this->Page->getPage($pageId, $roomId)) {
			$this->throwBadRequest();
			return;
		}
		$this->set('path', '/' . $page['Page']['slug']);

		$cancelUrl = '/' . Page::SETTING_MODE_WORD . '/' . $page['Page']['slug'];
		$this->set('cancelUrl', $cancelUrl);

		if (! $languagesPage = $this->LanguagesPage->getLanguagesPage($pageId, $this->viewVars['languageId'])) {
			$this->throwBadRequest();
			return;
		}

		$formPage = Hash::merge($page, $languagesPage);

		if ($this->request->isDelete()) {
			if ($this->Page->deletePage($this->data)) {
				$this->redirect('/' . Page::SETTING_MODE_WORD);
				return;
			}
		}

		$formPage = $this->camelizeKeyRecursive($formPage);
		$this->set('formPage', $formPage);
	}

}
