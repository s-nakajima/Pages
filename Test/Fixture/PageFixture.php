<?php
/**
 * PageFixture
 *
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * PageFixture
 *
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @package NetCommons\Pages\Test\Fixture
 */
class PageFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => '1',
			'room_id' => '1',
			'root_id' => null,
			'parent_id' => null,
			'lft' => '1',
			'rght' => '4',
			'permalink' => '',
			'slug' => null,
			'is_container_fluid' => true,
		),
		array(
			'id' => '2',
			'room_id' => '1',
			'root_id' => '1',
			'parent_id' => '1',
			'lft' => '2',
			'rght' => '3',
			'permalink' => 'home',
			'slug' => 'home',
			'is_container_fluid' => true,
		),
		//別ルーム(room_id=4)
		array(
			'id' => '3',
			'room_id' => '4',
			'parent_id' => null,
			'lft' => '5',
			'rght' => '6',
			'permalink' => 'test2',
			'slug' => 'test2',
			'is_container_fluid' => true,
		),
		//別ルーム(room_id=5、ブロックなし)
		array(
			'id' => '4',
			'room_id' => '5',
			'parent_id' => null,
			'lft' => '7',
			'rght' => '8',
			'permalink' => 'test3',
			'slug' => 'test3',
			'is_container_fluid' => true,
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('Pages') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new PagesSchema())->tables['pages'];
		parent::init();
	}

}
