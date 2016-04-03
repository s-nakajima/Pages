<?php
/**
 * BoxFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BoxFixture', 'Boxes.Test/Fixture');

/**
 * BoxFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Fixture
 */
class Box4pagesFixture extends BoxFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'Box';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'boxes';

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('Boxes') . 'Config' . DS . 'Migration' . DS . '9999999999_box_records.php';
		$this->records = (new BoxRecords())->records[$this->name];

		//パブリックスペースのホーム/test4
		$this->records[] = array(
			'id' => '17', 'container_id' => '17', 'type' => '4', 'space_id' => '2',
			'room_id' => '1', 'page_id' => '7', 'weight' => '1',
		);
		parent::init();
	}

}