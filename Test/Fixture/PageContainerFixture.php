<?php
/**
 * PageContainerFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * PageContainerFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Fixture
 */
class PageContainerFixture extends CakeTestFixture {

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'page_id' => '1',
			'container_type' => 1,
			'is_published' => 1,
			'is_configured' => 1,
			'created_user' => 1,
			'created' => '2016-10-25 05:36:32',
			'modified_user' => 1,
			'modified' => '2016-10-25 05:36:32'
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('Pages') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new PagesSchema())->tables['page_containers'];
		parent::init();
	}

}
