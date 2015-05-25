<?php
/**
 * Page Model
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

App::uses('PagesAppModel', 'Pages.Model');

/**
 * Page Model
 *
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @package NetCommons\Pages\Model
 */
class Page extends PagesAppModel {

/**
 * constant value
 */
	const SETTING_MODE_WORD = 'setting';

/**
 * is setting mode true
 *
 * @var bool
 */
	private static $__isSetting = null;

/**
 * Default behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'Tree',
		'Containable',
		'Pages.PageAssociate'
	);

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array();

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Room' => array(
			'className' => 'Rooms.Room',
			'foreignKey' => 'room_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ParentPage' => array(
			'className' => 'Page',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'ChildPage' => array(
			'className' => 'Page',
			'foreignKey' => 'parent_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Box' => array(
			'className' => 'Boxes.Box',
			'joinTable' => 'boxes_pages',
			'foreignKey' => 'page_id',
			'associationForeignKey' => 'box_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		),
		'Container' => array(
			'className' => 'Containers.Container',
			'joinTable' => 'containers_pages',
			'foreignKey' => 'page_id',
			'associationForeignKey' => 'container_id',
			'unique' => 'keepExisting',
			'conditions' => array('ContainersPage.is_published' => true),
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		),
		'Language' => array(
			'className' => 'Language',
			'joinTable' => 'languages_pages',
			'foreignKey' => 'page_id',
			'associationForeignKey' => 'language_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

/**
 * Called during validation operations, before validation. Please note that custom
 * validation rules can be defined in $validate.
 *
 * @param array $options Options passed from Model::save().
 * @return bool True if validate operation should continue, false to abort
 * @link http://book.cakephp.org/2.0/en/models/callback-methods.html#beforevalidate
 * @see Model::save()
 */
	public function beforeValidate($options = array()) {
		$this->validate = Hash::merge($this->validate, array(
			'slug' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('pages', 'Slug')),
					'required' => true
				),
			),
			'permalink' => array(
				'notEmpty' => array(
					'rule' => array('notEmpty'),
					'message' => __d('net_commons', 'Invalid request.'),
					'required' => true
				),
				'isUnique' => array(
					'rule' => array('isUnique'),
					'message' => sprintf(__d('net_commons', '%s is already in use.'), __d('pages', 'Permalink')),
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'from' => array(
				'datetime' => array(
					'rule' => array('datetime'),
					'message' => 'Please enter a valid date and time.',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
			'to' => array(
				'datetime' => array(
					'rule' => array('datetime'),
					'message' => 'Please enter a valid date and time.',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
			),
		));

		return parent::beforeValidate($options);
	}

/**
 * Check setting mode
 *
 * @return bool
 */
	public static function isSetting() {
		if (isset(self::$__isSetting)) {
			return self::$__isSetting;
		}

		$offset = strlen(Router::url('/'));
		$pos = strpos(Router::url(), self::SETTING_MODE_WORD, $offset);
		$pos = $pos - $offset;
		self::$__isSetting = ($pos === 0);

		return self::$__isSetting;
	}

/**
 * Unset setting mode value. Use for test.
 *
 * @return void
 */
	public static function unsetIsSetting() {
		self::$__isSetting = null;
	}

/**
 * Get page data
 *
 * @param int $pageId pages.id
 * @param int $roomId rooms.id
 * @return array
 */
	public function getPage($pageId, $roomId) {
		$conditions = array(
			'Page.id' => $pageId,
			'Page.room_id' => $roomId,
		);

		$page = $this->find('first', array(
			'recursive' => -1,
			'conditions' => $conditions,
		));

		return $page;
	}

/**
 * Get page with frame
 *
 * @param string $permalink Permalink
 * @return array
 */
	public function getPageWithFrame($permalink) {
		$query = array(
			'conditions' => array(
				'Page.permalink' => $permalink
			),
			'contain' => array(
				'Box' => $this->Box->getContainableQueryNotAssociatedPage(),
				'Container' => array(
					'conditions' => array(
						// It must check settingmode
						'ContainersPage.is_published' => true
					)
				),
				'Language' => array(
					'conditions' => array(
						'Language.code' => 'ja'
					)
				)
			)
		);

		return $this->find('first', $query);
	}
//
///**
// * Get page ID of top.
// *
// * @return string
// */
//	private function __getTopPageId() {
//		$topPageId = null;
//		$topPage = $this->findByLft('1', array('id'));
//		if (!empty($topPage)) {
//			$topPageId = $topPage['Page']['id'];
//		}
//
//		return $topPageId;
//	}

/**
 * Save page each association model
 *
 * @param array $data request data
 * @throws Exception
 * @return mixed On success Model::$data if its not empty or true, false on failure
 */
	public function savePage($data) {
//		$this->ContainersPage = ClassRegistry::init('Pages.ContainersPage');
//		$this->BoxesPage = ClassRegistry::init('Pages.BoxesPage');
//
//		$this->setDataSource('master');
//		$this->Container->setDataSource('master');
//		$this->Box->setDataSource('master');
//		$this->ContainersPage->setDataSource('master');
//		$this->BoxesPage->setDataSource('master');

		$this->loadModels([
			'ContainersPage' => 'Pages.ContainersPage',
			'BoxesPage' => 'Pages.BoxesPage',
			'Container' => 'Containers.Container',
			'Box' => 'Boxes.Box',
			'LanguagesPage' => 'Pages.LanguagesPage',
		]);

		//トランザクションBegin
		$this->setDataSource('master');
		$dataSource = $this->getDataSource();
		$dataSource->begin();

		try {
			if ($this->validatePage($data, ['languagesPage'])) {
				return false;
			}

			$exists = $this->exists();
//			$page = $this->__savePage($data);
			if (! $page = $this->__savePage()) {

				var_dump($page, $data);
				var_dump($this->validationErrors);
				var_dump($this->LanguagesPage->validationErrors);



			}

			if (! $exists) {
				if (! $container = $this->saveContainer($page)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error1'));
				}
				$page = Hash::merge($page, $container);

				if (! $box = $this->saveBox($page)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error2'));
				}
				$page = Hash::merge($page, $box);

				if (! $this->saveContainersPage($page)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error3'));
				}
				if (! $this->saveBoxesPage($page)) {
					throw new InternalErrorException(__d('net_commons', 'Internal Server Error4'));
				}
			}

			$dataSource->commit();
			return $page;

		} catch (Exception $ex) {
			$dataSource->rollback();
			//CakeLog::debug(print_r($ex, true));
			throw $ex;
			//return false;
		}
	}

/**
 * Save page
 *
 * @param array $data request data
 * @return mixed On success Model::$data if its not empty or true, false on failure
 */
	private function __savePage() {
//		$this->set($data);
//
//		$referencePageId = $this->getReferencePageId();
//
//		$fields = array(
//			'room_id',
//			'permalink'
//		);
//		$targetPage = $this->findById($referencePageId, $fields);
//		if (empty($targetPage)) {
//			return false;
//		}
//
//		$this->set('room_id', $targetPage['Page']['room_id']);
//
//		$slug = $this->data['Page']['slug'];
//		if (!isset($slug)) {
//			$slug = '';
//		}
//		$this->set('slug', $slug);
//
//		$permalink = '';
//		if (strlen($targetPage['Page']['permalink']) !== 0) {
//			$permalink = $targetPage['Page']['permalink'] . '/';
//		}
//		$permalink .= $slug;
//		$this->set('permalink', $permalink);
//
//		// It should check parts
//		$this->set('is_published', true);

		if (! $page = $this->save(null, false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		$this->LanguagesPage->data['page_id'] = $page['Page']['id'];
		if (! $this->LanguagesPage->save(null, false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return $page;
	}

//
///**
// * Save container data.
// *
// * @return mixed On success Model::$data if its not empty or true, false on failure
// */
//	private function __saveContainer() {
//		$this->Container->create();
//		$data = array(
//			'Container' => array(
//				'type' => Container::TYPE_MAIN
//			)
//		);
//
//		return $this->Container->save($data);
//	}
//
///**
// * Save box data.
// *
// * @return mixed On success Model::$data if its not empty or true, false on failure
// */
//	private function __saveBox() {
//		$this->Box->create();
//		$data = array(
//			'Box' => array(
//				'container_id' => $this->Container->getLastInsertID(),
//				'type' => Box::TYPE_WITH_PAGE,
//				'space_id' => $this->data['Box']['space_id'],
//				'room_id' => $this->data['Page']['room_id'],
//				'page_id' => $this->getLastInsertID()
//			)
//		);
//
//		return $this->Box->save($data);
//	}
//
///**
// * Save containersPage for page
// *
// * @return bool True on success
// */
//	private function __saveContainersPage() {
//		$query = array(
//			'conditions' => array(
//				'ContainersPage.page_id' => $this->__getReferencePageId(),
//				'Container.type !=' => Container::TYPE_MAIN
//			)
//		);
//		$containersPages = $this->ContainersPage->find('all', $query);
//		$containersPages[] = array(
//			'ContainersPage' => array(
//				'page_id' => $this->getLastInsertID(),
//				'container_id' => $this->Container->getLastInsertID(),
//				'is_published' => true
//			)
//		);
//
//		foreach ($containersPages as $containersPage) {
//			$data = array(
//				'page_id' => $this->getLastInsertID(),
//				'container_id' => $containersPage['ContainersPage']['container_id'],
//				'is_published' => $containersPage['ContainersPage']['is_published']
//			);
//
//			$this->ContainersPage->create();
//			if (!$this->ContainersPage->save($data)) {
//				return false;
//			}
//		}
//
//		return true;
//	}
//
///**
// * Save boxesPage for page
// *
// * @return bool True on success
// */
//	private function __saveBoxesPage() {
//		$query = array(
//			'conditions' => array(
//				'BoxesPage.page_id' => $this->__getReferencePageId(),
//				'Box.type !=' => Box::TYPE_WITH_PAGE
//			)
//		);
//		$boxesPages = $this->BoxesPage->find('all', $query);
//		$boxesPages[] = array(
//			'BoxesPage' => array(
//				'page_id' => $this->getLastInsertID(),
//				'box_id' => $this->Box->getLastInsertID(),
//				'is_published' => true
//			)
//		);
//
//		foreach ($boxesPages as $boxesPage) {
//			$data = array(
//				'page_id' => $this->getLastInsertID(),
//				'box_id' => $boxesPage['BoxesPage']['box_id'],
//				'is_published' => $boxesPage['BoxesPage']['is_published']
//			);
//
//			$this->BoxesPage->create();
//			if (!$this->BoxesPage->save($data)) {
//				return false;
//			}
//		}
//
//		return true;
//	}
//
///**
// * Get Reference page ID. Return top page ID if it has no parent.
// *
// * @return string
// */
//	private function __getReferencePageId() {
//		if (!empty($this->data['Page']['parent_id'])) {
//			return $this->data['Page']['parent_id'];
//		}
//
//		return $this->__getTopPageId();
//	}

/**
 * validate page
 *
 * @param array $data received post data
 * @param array $contains Optional validate sets
 * @return bool True on success, false on error
 */
	public function validatePage($data, $contains = []) {
		//ページデータをセット
		$this->set($data);

		$referencePageId = $this->getReferencePageId($data);
		$fields = array(
			'room_id',
			'permalink'
		);
		$targetPage = $this->findById($referencePageId, $fields);
		if (empty($targetPage)) {
			return false;
		}
		$this->set('room_id', $targetPage['Page']['room_id']);

		$slug = $data['Page']['slug'];
		if (! isset($slug)) {
			$slug = '';
		}
		$this->set('slug', $slug);

		$permalink = '';
		if (strlen($targetPage['Page']['permalink']) !== 0) {
			$permalink = $targetPage['Page']['permalink'] . '/';
		}
		$permalink .= $slug;
		$this->set('permalink', $permalink);

		$this->set('is_published', true); // It should check parts

		//バリデーション実行
		$this->validates();
		if ($this->validationErrors) {
			return false;
		}

		if (in_array('languagesPage', $contains, true)) {
			if (! $this->LanguagesPage->validateLanguagesPage($data)) {
				$this->validationErrors = Hash::merge($this->validationErrors, $this->LanguagesPage->validationErrors);
				return false;
			}
		}

		return true;
	}

}
