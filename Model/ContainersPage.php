<?php
/**
 * ContainersPage Model
 *
 * @property Page $Page
 * @property Container $Container
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('PagesAppModel', 'Pages.Model');

/**
 * Summary for ContainersPage Model
 */
class ContainersPage extends PagesAppModel {

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Page' => array(
			'className' => 'Pages.Page',
			'foreignKey' => 'page_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Container' => array(
			'className' => 'Containers.Container',
			'foreignKey' => 'container_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * Save page each association model
 *
 * @param array $data request data
 * @throws InternalErrorException
 * @return mixed On success Model::$data if its not empty or true, false on failure
 */
	public function saveContainersPage($data) {
		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			if (! $this->validateContainersPage($data['ContainersPage'])) {
				return false;
			}

			if (! $this->saveMany($data['ContainersPage'], ['validate' => false])) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$dataSource->commit();

		} catch (Exception $ex) {
			$dataSource->rollback();
			CakeLog::error($ex);
			throw $ex;
		}
	}

/**
 * validate ContainersPage
 *
 * @param array $data received post data
 * @return bool True on success, false on error
 */
	public function validateContainersPage($data) {
		//バリデーション
		$this->validateMany($data);

		if ($this->validationErrors) {
			return false;
		}

		return true;
	}

}
