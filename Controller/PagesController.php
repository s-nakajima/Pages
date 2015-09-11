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
 * uses
 *
 * @var array
 */
	public $uses = array(
		'Pages.Page',
		'Pages.LanguagesPage',
		'Containers.ContainersPage',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'NetCommons.Permission' => array(
			//アクセスの権限
			'allow' => array(
				'add,edit,delete,layout' => 'page_editable',
			),
		),
		'Pages.PageLayout',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Composer',
		'Workflow.Workflow'
	);

/**
 * index method
 *
 * @throws NotFoundException
 * @return void
 */
	public function index() {
		if (Current::isSettingMode() && ! Current::permission('page_editable')) {
			$paths = func_get_args();
			$path = implode('/', $paths);
			$this->redirect('/' . $path);
			return;
		}

		$paths = func_get_args();
		$path = implode('/', $paths);

		$page = $this->Page->getPageWithFrame($path);
		if (empty($page)) {
			throw new NotFoundException();
		}
		$this->set('page', $page);

		$page['Container'] = Hash::combine($page['Container'], '{n}.type', '{n}');
		$page['Box'] = Hash::combine($page['Box'], '{n}.id', '{n}', '{n}.container_id');

		$page['Container'] = array(Container::TYPE_MAIN => $page['Container'][Container::TYPE_MAIN]);
		$this->set('pageMainContainer', $page);
	}

/**
 * add
 *
 * @param int $roomId rooms.id
 * @return void
 */
	public function add() {
		$this->view = 'edit';
		$this->layout = 'Pages.dialog';

		if ($this->request->isPost()) {
			//登録処理
			$data = $this->request->data;
			if ($page = $this->Page->savePage($data)) {
				//正常の場合
				$this->redirect('/' . Current::SETTING_MODE_WORD . '/' . $page['Page']['permalink']);
			}

		} else {
			//表示処理
			$slug = 'page_' . date('YmdHis');
			$this->request->data = Hash::merge($this->request->data,
				$this->Page->create(array(
					'id' => null,
					'slug' => $slug,
					'permalink' => $slug,
					'room_id' => Current::read('Room.id'),
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
		$this->layout = 'Pages.dialog';

		if ($this->request->isPut()) {
			//登録処理
			$data = $this->request->data;
			if ($page = $this->Page->savePage($data)) {
				//正常の場合
				$this->redirect('/' . Current::SETTING_MODE_WORD . '/' . $page['Page']['permalink']);
			}

		} else {
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
			$this->throwBadRequest();
			return;
		}
		if ($this->Page->deletePage($this->data)) {
			$this->redirect('/' . Current::SETTING_MODE_WORD);
		}
	}

/**
 * edit
 *
 * @param int $roomId rooms.id
 * @param int $pageId pages.id
 * @return void
 */
	public function layout() {
		if (! $this->request->isPost()) {
			$this->throwBadRequest();
			return;
		}
		$data = $this->request->data;
		unset($data['save']);

		$this->ContainersPage->saveContainersPage($data);
		if ($this->ContainersPage->saveContainersPage($data)) {
			//正常の場合
			$this->NetCommons->setFlashNotification(__d('net_commons', 'Successfully saved.'), array('class' => 'success'));
		} else {
			$this->NetCommons->handleValidationError($this->ContainersPage->validationErrors);
		}
		$this->redirect('/' . Current::SETTING_MODE_WORD . '/' . Current::read('Page.permalink'));
	}

}
