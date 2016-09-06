<?php
/**
 * LanguagesPage Fixture
 *
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * LanguagesPage Fixture
 *
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @package NetCommons\Pages\Test\Fixture
 */
class LanguagesPageFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//メインページ
		array(
			'id' => 1,
			'page_id' => 1,
			'language_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'created_user' => 1,
			'created' => '2014-08-04 04:47:08',
			'modified_user' => 1,
			'modified' => '2014-08-04 04:47:08'
		),
		array(
			'id' => 2,
			'page_id' => 1,
			'language_id' => 2,
			'name' => 'Lorem ipsum dolor sit amet',
			'created_user' => 2,
			'created' => '2014-08-04 04:47:08',
			'modified_user' => 2,
			'modified' => '2014-08-04 04:47:08'
		),
		//page.permalink=test
		array(
			'id' => 3,
			'page_id' => 2,
			'language_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'created_user' => 3,
			'created' => '2014-08-04 04:47:08',
			'modified_user' => 3,
			'modified' => '2014-08-04 04:47:08'
		),
		array(
			'id' => 4,
			'page_id' => 2,
			'language_id' => 2,
			'name' => 'Lorem ipsum dolor sit amet',
			'created_user' => 4,
			'created' => '2014-08-04 04:47:08',
			'modified_user' => 4,
			'modified' => '2014-08-04 04:47:08'
		),
		//別ルーム(room_id=2)
		array(
			'id' => 5,
			'page_id' => 3,
			'language_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
		),
		array(
			'id' => 6,
			'page_id' => 3,
			'language_id' => 2,
			'name' => 'Lorem ipsum dolor sit amet',
		),
		//別ルーム(room_id=3、ブロックなし)
		array(
			'id' => 7,
			'page_id' => 4,
			'language_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
		),
		array(
			'id' => 8,
			'page_id' => 4,
			'language_id' => 2,
			'name' => 'Lorem ipsum dolor sit amet',
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('Pages') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new PagesSchema())->tables['languages_pages'];
		parent::init();
	}

}
