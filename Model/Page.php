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
App::uses('Current', 'NetCommons.Utility');

/**
 * Page Model
 *
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @package NetCommons\Pages\Model
 */
class Page extends PagesAppModel {

/**
 * TreeParser
 * __constructでセットする
 *
 * @var array
 */
	public static $treeParser;

/**
 * Default behaviors
 *
 * @var array
 */
	public $actsAs = array(
		'Tree',
		'Containable',
		'Pages.Page',
		'Pages.PageAssociations'
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
			'className' => 'Pages.Page',
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
			'className' => 'Pages.Page',
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
			//'conditions' => array('ContainersPage.is_published' => true),
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		),
		'Language' => array(
			'className' => 'M17n.Language',
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
 * Constructor. Binds the model's database table to the object.
 *
 * @param bool|int|string|array $id Set this ID for this model on startup,
 * can also be an array of options, see above.
 * @param string $table Name of database table to use.
 * @param string $ds DataSource connection name.
 * @see Model::__construct()
 * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
 */
	public function __construct($id = false, $table = null, $ds = null) {
		parent::__construct($id, $table, $ds);
		self::$treeParser = chr(9);
	}

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
				'notBlank' => array(
					'rule' => array('notBlank'),
					'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('pages', 'Slug')),
					'required' => true
				),
			),
			'permalink' => array(
				'notBlank' => array(
					'rule' => array('notBlank'),
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
 * ページデータ取得
 *
 * @param int|array $roomIds Room.id
 * @return array
 */
	public function getPages($roomIds = null) {
		$this->loadModels([
			'LanguagesPage' => 'Pages.LanguagesPage',
		]);

		if (! isset($roomIds)) {
			$roomIds = Current::read('Room.id');
		}

		$pages = $this->find('all', array(
			'recursive' => 1,
			'conditions' => array(
				'Page.room_id' => $roomIds,
			),
		));

		$pagesLanguages = $this->LanguagesPage->find('all', array(
			'recursive' => -1,
			'conditions' => array(
				'LanguagesPage.page_id' => Hash::extract($pages, '{n}.Page.id'),
				'LanguagesPage.language_id' => Current::read('Language.id'),
			),
		));

		return Hash::merge(
			Hash::combine($pages, '{n}.Page.id', '{n}'),
			Hash::combine($pagesLanguages, '{n}.LanguagesPage.page_id', '{n}')
		);
	}

/**
 * Get page with frame
 *
 * @param string $permalink Permalink
 * @param string $language Language.code
 * @return array
 */
	public function getPageWithFrame($permalink, $language = null) {
		if (! isset($language)) {
			$language = Configure::read('Config.language');
		}

		$query = array(
			'conditions' => array(
				'Page.permalink' => $permalink
			),
			'contain' => array(
				'Box' => $this->Box->getContainableQueryNotAssociatedPage(),
				'Container' => array(
					//'conditions' => array(
					//	// It must check settingmode
					//	'ContainersPage.is_published' => true
					//)
				),
				'Language' => array(
					'conditions' => array(
						'Language.code' => $language
					)
				)
			)
		);
		return $this->find('first', $query);
	}

/**
 * Save page each association model
 *
 * #### Options
 *
 * - `atomic`: If true (default), will attempt to save all records in a single transaction.
 *   Should be set to false if database/table does not support transactions.
 *
 * @param array $data request data
 * @param array $options Options to use when saving record data, See $options above.
 * @throws InternalErrorException
 * @return mixed On success Model::$data if its not empty or true, false on failure
 */
	public function savePage($data, $options = array()) {
		$this->loadModels([
			'Box' => 'Boxes.Box',
			'BoxesPage' => 'Boxes.BoxesPage',
			'Container' => 'Containers.Container',
			'ContainersPage' => 'Containers.ContainersPage',
			'LanguagesPage' => 'Pages.LanguagesPage',
		]);

		$options = Hash::merge(array('atomic' => true), $options);

		//トランザクションBegin
		if ($options['atomic']) {
			$this->begin();
		}

		//バリデーション
		$this->set($data);
		if (! $this->validates()) {
			return false;
		}

		try {
			if (! $page = $this->save(null, false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			if ($options['atomic']) {
				$this->commit();
			}

		} catch (Exception $ex) {
			if ($options['atomic']) {
				$this->rollback($ex);
			}
			throw $ex;
		}

		return $page;
	}

/**
 * テーマ
 *
 * @param array $data request data
 * @throws InternalErrorException
 * @return mixed True on success, false on failure
 */
	public function saveTheme($data) {
		//トランザクションBegin
		$this->begin();

		try {
			$this->id = $data[$this->alias]['id'];
			if (! $this->saveField('theme', $data[$this->alias]['theme'], array('callbacks' => false))) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$this->commit();

		} catch (Exception $ex) {
			$this->rollback($ex);
		}

		return true;
	}

/**
 * Delete page each association model
 * - `atomic`: If true (default), will attempt to save all records in a single transaction.
 *   Should be set to false if database/table does not support transactions.
 *
 * @param array $data request data
 * @param array $options Options to use when saving record data, See $options above.
 * @throws InternalErrorException
 * @return mixed On success Model::$data if its not empty or true, false on failure
 */
	public function deletePage($data, $options = array()) {
		$this->loadModels([
			'Box' => 'Boxes.Box',
			'BoxesPage' => 'Boxes.BoxesPage',
			'Container' => 'Containers.Container',
			'ContainersPage' => 'Containers.ContainersPage',
			'LanguagesPage' => 'Pages.LanguagesPage',
		]);

		$options = Hash::merge(array('atomic' => true), $options);

		//トランザクションBegin
		if ($options['atomic']) {
			$this->begin();
		}

		try {
			//Pageの削除
			if (! $this->deleteAll(array($this->alias . '.id' => $data[$this->alias]['id']), false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			if (! $this->LanguagesPage->deleteAll(array($this->LanguagesPage->alias . '.page_id' => $data[$this->alias]['id']), false)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			//Container関連の削除
			//$this->deleteContainers($data[$this->alias]['id']);

			//Box関連の削除
			//$this->deleteBoxes($data[$this->alias]['id']);

			if ($options['atomic']) {
				$this->commit();
			}
			return true;

		} catch (Exception $ex) {
			if ($options['atomic']) {
				$this->rollback($ex);
			}
			throw $ex;
		}
	}

}
