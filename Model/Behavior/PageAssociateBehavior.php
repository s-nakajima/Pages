<?php
/**
 * PageAssociate Behavior
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
 * PageAssociate Behavior
 *
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @package NetCommons\Pages\Model
 */
class PageAssociateBehavior extends ModelBehavior {

/**
 * use model
 *
 * @var array
 */
	public $model;

/**
 * Setup
 *
 * @param Model $model instance of model
 * @param array $config array of configuration settings.
 * @return void
 */
	public function setup(Model $model, $config = array()) {
		$this->model = $model;
	}

/**
 * Save container data.
 *
 * @return mixed On success Model::$data if its not empty or true, false on failure
 */
	public function saveContainer(Model $model, $data) {
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
	public function saveBox(Model $model, $data) {
		$this->model->Box->create();
		$data = array(
			'Box' => array(
				'container_id' => $data['Container']['id'],
				'type' => Box::TYPE_WITH_PAGE,
				'space_id' => 1,//$this->model->data['Box']['space_id'],
				'room_id' => $data['Page']['room_id'],
				'page_id' => $data['Page']['id']
			)
		);

		return $this->model->Box->save($data);
	}

/**
 * Save containersPage for page
 *
 * @return bool True on success
 */
	public function saveContainersPage(Model $model, $data) {
		$query = array(
			'conditions' => array(
				'ContainersPage.page_id' => $this->getReferencePageId($model, $data),
				'Container.type !=' => Container::TYPE_MAIN
			)
		);
		$containersPages = $this->model->ContainersPage->find('all', $query);
		$containersPages[] = array(
			'ContainersPage' => array(
				'page_id' => $data['Page']['id'],
				'container_id' => $data['Container']['id'],
				'is_published' => true
			)
		);

		foreach ($containersPages as $containersPage) {
			$data = array(
				'page_id' => $data['Page']['id'],
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
	public function saveBoxesPage(Model $model, $data) {
		$query = array(
			'conditions' => array(
				'BoxesPage.page_id' => $this->getReferencePageId($model, $data),
				'Box.type !=' => Box::TYPE_WITH_PAGE
			)
		);
		$boxesPages = $this->model->BoxesPage->find('all', $query);
		$boxesPages[] = array(
			'BoxesPage' => array(
				'page_id' => $data['Page']['id'],
				'box_id' => $data['Box']['id'],
				'is_published' => true
			)
		);

		foreach ($boxesPages as $boxesPage) {
			$data = array(
				'page_id' => $data['Page']['id'],
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
	public function getTopPageId() {
		$topPageId = null;
		$topPage = $this->model->findByLft('1', array('id'));

		if (!empty($topPage)) {
			$topPageId = $topPage['Page']['id'];
		}

		return $topPageId;
	}

/**
 * Get Reference page ID. Return top page ID if it has no parent.
 *
 * @return string
 */
	public function getReferencePageId(Model $model, $data) {
		if (!empty($data['Page']['parent_id'])) {
			return $data['Page']['parent_id'];
		}

		return $this->getTopPageId();
	}

}
