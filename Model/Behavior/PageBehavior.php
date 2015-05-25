<?php
/**
 * Page Behavior
 *
 * @property Room $Room
 * @property Page $ParentPage
 * @property Box $Box
 * @property Page $ChildPage
 * @property Box $Box
 * @property Container $Container
 * @property Language $Language
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('ModelBehavior', 'Model');

/**
 * Page Behavior
 *
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @package NetCommons\Pages\Model
 */
class PageBehavior extends ModelBehavior {

/**
 * use model
 *
 * @var array
 */
	public $model;

/**
 * Save container data.
 *
 * @return mixed On success Model::$data if its not empty or true, false on failure
 */
	public function saveContainer(Model $model) {
		$this->model = $model;

		$this->model->Container->create();
		$data = array(
			'Container' => array(
				'type' => Container::TYPE_MAIN
			)
		);

		return $this->model->Container->save($data);
	}

/**
 * Save box data.
 *
 * @return mixed On success Model::$data if its not empty or true, false on failure
 */
	public function saveBox(Model $model, $page) {
		$this->model = $model;

		$this->model->Box->create();
		$data = array(
			'Box' => array(
				'container_id' => $page['Container']['id'],
				'type' => Box::TYPE_WITH_PAGE,
				'space_id' => 1,//$this->model->data['Box']['space_id'],
				'room_id' => $page['Page']['room_id'],
				'page_id' => $page['Page']['id']
			)
		);

		return $this->model->Box->save($data);
	}

/**
 * Save containersPage for page
 *
 * @return bool True on success
 */
	public function saveContainersPage(Model $model, $page) {
		$this->model = $model;

		$query = array(
			'conditions' => array(
				'ContainersPage.page_id' => $this->getReferencePageId($model, $page),
				'Container.type !=' => Container::TYPE_MAIN
			)
		);

		$containersPages = $this->model->ContainersPage->find('all', $query);
		$containersPages[] = array(
			'ContainersPage' => array(
				'page_id' => $page['Page']['id'],
				'container_id' => $page['Container']['id'],
				'is_published' => true
			)
		);

		foreach ($containersPages as $containersPage) {
			$data = array(
				'page_id' => $page['Page']['id'],
				'container_id' => $containersPage['ContainersPage']['container_id'],
				'is_published' => $containersPage['ContainersPage']['is_published']
			);

			$this->model->ContainersPage->create();
			if (!$this->model->ContainersPage->save($data)) {
				return false;
			}
		}

		return true;
	}

/**
 * Save boxesPage for page
 *
 * @return bool True on success
 */
	public function saveBoxesPage(Model $model, $page) {
		$this->model = $model;

		$query = array(
			'conditions' => array(
				'BoxesPage.page_id' => $this->getReferencePageId($model, $page),
				'Box.type !=' => Box::TYPE_WITH_PAGE
			)
		);
		$boxesPages = $this->model->BoxesPage->find('all', $query);
		$boxesPages[] = array(
			'BoxesPage' => array(
				'page_id' => $page['Page']['id'],
				'box_id' => $page['Box']['id'],
				'is_published' => true
			)
		);

		foreach ($boxesPages as $boxesPage) {
			$data = array(
				'page_id' => $page['Page']['id'],
				'box_id' => $boxesPage['BoxesPage']['box_id'],
				'is_published' => $boxesPage['BoxesPage']['is_published']
			);

			$this->model->BoxesPage->create();
			if (!$this->model->BoxesPage->save($data)) {
				return false;
			}
		}

		return true;
	}

/**
 * Get page ID of top.
 *
 * @return string
 */
	private function __getTopPageId() {
		$topPageId = null;
		$topPage = $this->model->findByLft('1', array('id'));
		if (! empty($topPage)) {
			$topPageId = $topPage['Page']['id'];
		}

		return $topPageId;
	}

/**
 * Get Reference page ID. Return top page ID if it has no parent.
 *
 * @return string
 */
	public function getReferencePageId(Model $model, $page) {
		$this->model = $model;

		if (! empty($page['Page']['parent_id'])) {
			return $page['Page']['parent_id'];
		}

		return $this->__getTopPageId();
	}

/**
 * delete containersPage for page
 *
 * @return bool True on success
 */
	public function deleteContainers(Model $model, $pageId) {
		$this->model = $model;

		$conditions = array(
			'ContainersPage.page_id' => $pageId,
			'Container.type' => Container::TYPE_MAIN
		);
		$containers = $this->model->ContainersPage->find('list', array(
			'recursive' => 0,
			'fields' => 'Container.id',
			'conditions' => $conditions
		));
		$containerIds = array_values($containers);

		if (! $this->model->Container->deleteAll(array('Container.id' => $containerIds), false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		if (! $this->model->ContainersPage->deleteAll(array('ContainersPage.page_id' => $pageId), false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return true;
	}

/**
 * delete boxesPage for page
 *
 * @return bool True on success
 */
	public function deleteBoxes(Model $model, $pageId) {
		$this->model = $model;

		if (! $this->model->Box->deleteAll(array('Box.page_id' => $pageId), false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		if (! $this->model->BoxesPage->deleteAll(array('BoxesPage.page_id' => $pageId), false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return true;
	}

}
