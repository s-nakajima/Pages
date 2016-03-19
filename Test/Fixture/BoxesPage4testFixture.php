<?php
/**
 * BoxFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BoxesPageFixture', 'Boxes.Test/Fixture');

/**
 * BoxFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Fixture
 */
class BoxesPage4testFixture extends BoxesPageFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'BoxesPage';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'boxes_pages';

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('Boxes') . 'Config' . DS . 'Migration' . DS . '9999999999_box_records.php';
		$this->records = (new BoxRecords())->records[$this->name];

		//パブリックスペースのホーム/test4
		$this->records[] = array('id' => '21', 'page_id' => '7', 'box_id' => '1', 'is_published' => true);
		$this->records[] = array('id' => '22', 'page_id' => '7', 'box_id' => '2', 'is_published' => true);
		$this->records[] = array('id' => '23', 'page_id' => '7', 'box_id' => '17', 'is_published' => true);
		$this->records[] = array('id' => '24', 'page_id' => '7', 'box_id' => '4', 'is_published' => true);
		$this->records[] = array('id' => '25', 'page_id' => '7', 'box_id' => '5', 'is_published' => true);

		parent::init();
	}

}
