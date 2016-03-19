<?php
/**
 * ContainersPageFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('ContainersPageFixture', 'Containers.Test/Fixture');

/**
 * ContainersPageFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Fixture
 */
class ContainersPage4testFixture extends ContainersPageFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'ContainersPage';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'containers_pages';

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('Containers') . 'Config' . DS . 'Migration' . DS . '9999999999_container_records.php';
		$this->records = (new ContainerRecords())->records[$this->name];

		//パブリックスペースのホーム/test4
		$this->records[] = array('id' => '21', 'page_id' => '7', 'container_id' => '1', 'is_published' => true);
		$this->records[] = array('id' => '22', 'page_id' => '7', 'container_id' => '2', 'is_published' => true);
		$this->records[] = array('id' => '23', 'page_id' => '7', 'container_id' => '17', 'is_published' => true);
		$this->records[] = array('id' => '24', 'page_id' => '7', 'container_id' => '4', 'is_published' => true);
		$this->records[] = array('id' => '25', 'page_id' => '7', 'container_id' => '5', 'is_published' => true);

		parent::init();
	}

}
