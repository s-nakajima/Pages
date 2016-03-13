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
class PagesEditController extends PagesAppController {

/**
 * uses
 *
 * @var array
 */
	public $uses = array(
		'Containers.ContainersPage',
		'Pages.LanguagesPage',
		'Pages.Page',
		'Rooms.Room',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.Permission' => array(
			'allow' => array(
				'index,add,edit,delete,layout' => 'page_editable',
			),
		),
		'Pages.PageLayout',
		'Security',
		'ThemeSettings.ThemeSettings',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Composer',
		'Pages.PagesEdit',
	);

/**
 * beforeRender
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();

		//ルームデータ取得
		$conditions = array('Room.id' => Current::read('Room.id'));
		$room = $this->Room->find('first', $this->Room->getReadableRoomsConditions($conditions));
		if (! $room) {
			$this->setAction('throwBadRequest');
			return;
		}
		$this->set('room', $room);
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		//ページでテータ取得
		$pages = $this->Page->getPages();
		if (! $pages) {
			return $this->throwBadRequest();
		}
		$this->set('pages', $pages);

		//Treeリスト取得
		$this->__setPageTreeList();
	}

/**
 * add
 *
 * @return void
 */
	public function add() {
		$this->view = 'edit';

		if ($this->request->isPost()) {
			//登録処理
			$page = $this->Page->savePage($this->request->data);
			if ($page) {
				//正常の場合
				$this->redirect(NetCommonsUrl::actionUrl(array(
					'plugin' => $this->params['plugin'],
					'controller' => $this->params['controller'],
					'action' => 'index',
					'key' => Current::read('Room.id'),
					$page['Page']['id'],
				)));
			}

		} else {
			//表示処理
			if (Hash::get($this->request->params, 'pass.1')) {
				$result = $this->Page->existPage(Hash::get($this->request->params, 'pass.1'));
				if (! $result) {
					return $this->throwBadRequest();
				}
			}
			$slug = 'page_' . date('YmdHis');
			$this->request->data = Hash::merge($this->request->data,
				$this->Page->create(array(
					'id' => null,
					'slug' => $slug,
					'permalink' => $slug,
					'room_id' => Current::read('Room.id'),
					'parent_id' => Hash::get($this->request->params, 'pass.1'),
				)),
				$this->LanguagesPage->create(array(
					'id' => null,
					'language_id' => Current::read('Language.id'),
					'name' => sprintf(__d('pages', 'New page %s'), date('YmdHis')),
				))
			);
			$this->request->data['Room'] = Current::read('Room');
		}
	}

/**
 * edit
 *
 * @return void
 */
	public function edit() {
		if ($this->request->isPut()) {
			//登録処理
			$page = $this->Page->savePage($this->request->data);
			if ($page) {
				//正常の場合
				$this->redirect(NetCommonsUrl::actionUrl(array(
					'plugin' => $this->params['plugin'],
					'controller' => $this->params['controller'],
					'action' => 'index',
					'key' => Current::read('Room.id'),
					$page['Page']['id'],
				)));
			}

		} else {
			$result = $this->Page->existPage(Current::read('Page.id'));
			if (! $result) {
				return $this->throwBadRequest();
			}
			//表示処理
			$this->request->data = Hash::merge($this->request->data,
				$this->LanguagesPage->getLanguagesPage(Current::read('Page.id'), Current::read('Language.id'))
			);
			$this->request->data['Room'] = Current::read('Room');
		}
	}

/**
 * delete
 *
 * @return void
 */
	public function delete() {
		if (! $this->request->isDelete()) {
			return $this->throwBadRequest();
		}
		if ($this->Page->deletePage($this->data)) {
			$this->redirect('/' . Current::SETTING_MODE_WORD);
		}
	}

/**
 * layout
 *
 * @return void
 * @throws NotFoundException
 */
	public function layout() {
		if ($this->request->isPost()) {
			unset($this->request->data['save']);

			if ($this->ContainersPage->saveContainersPage($this->request->data)) {
				//正常の場合
				$this->NetCommons->setFlashNotification(__d('net_commons', 'Successfully saved.'), array('class' => 'success'));
			} else {
				$this->NetCommons->handleValidationError($this->ContainersPage->validationErrors);
			}
			$this->redirect('/' . Current::read('Page.permalink'));
		} else {
			$page = $this->Page->getPageWithFrame(Current::read('Page.permalink'));
			if (empty($page)) {
				throw new NotFoundException();
			}
			$this->request->data['ContainersPage'] = Hash::combine($page, 'Container.{n}.type', 'Container.{n}.ContainersPage');
		}
	}

/**
 * theme
 *
 * @return void
 */
	public function theme() {
		$this->ThemeSettings->setThemes();

		if ($this->request->isPost()) {
			unset($this->request->data['save']);

			if ($this->Page->saveTheme($this->request->data)) {
				//正常の場合
				$this->NetCommons->setFlashNotification(__d('net_commons', 'Successfully saved.'), array('class' => 'success'));
			} else {
				$this->NetCommons->handleValidationError($this->Page->validationErrors);
			}
			$this->redirect('/' . Current::read('Page.permalink'));
		} else {
			$this->request->data['Page'] = Current::read('Page');
			$this->theme = Hash::get($this->request->query, 'theme', $this->theme);
		}
	}

/**
 * move
 *
 * @return void
 */
	public function move() {
		if ($this->request->is('post')) {
			if ($this->Page->saveMove($this->request->data)) {
				//正常の場合
				$this->NetCommons->setFlashNotification(__d('net_commons', 'Successfully saved.'), array(
					'class' => 'success',
					'parentList' => $this->viewVars['parentList'],
					'treeList' => $this->viewVars['treeList'],
				));
				return $this->redirect(NetCommonsUrl::actionUrl(array(
					'plugin' => $this->params['plugin'],
					'controller' => $this->params['controller'],
					'action' => 'index',
					'key' => Current::read('Room.id'),
					$page['Page']['id'],
				)));
			}
		}

		return $this->throwBadRequest();
	}

/**
 * pageTreeListのセット
 *
 * @return void
 */
	private function __setPageTreeList() {
		//Treeリスト取得
		$pageTreeList = $this->Page->generateTreeList(
				array('Page.room_id' => Current::read('Room.id')), null, null, Page::$treeParser);

		foreach ($pageTreeList as $pageId => $tree) {
			$treeList[] = $pageId;

			$page = Hash::get($this->viewVars['pages'], $pageId);
			$parentId = (int)$page['Page']['parent_id'];

			// * ページ順
			if (isset($parentList[$parentId])) {
				$weight = count($parentList[$parentId]) + 1;
			} else {
				$weight = 1;
			}

			$nest = substr_count($tree, Page::$treeParser);
			$parentList[$parentId][$pageId] = array(
				'index' => count($treeList) - 1,
				'weight' => $weight,
				'nest' => $nest,
			);
		}

		$this->set('parentList', $parentList);
		$this->set('treeList', $treeList);
	}

}
