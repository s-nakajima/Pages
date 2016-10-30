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
	public $records = array();

/**
 * ページID
 *
 * @var array
 */
	protected $_maxPageId = 4;

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		require_once App::pluginPath('Pages') . 'Config' . DS . 'Schema' . DS . 'schema.php';
		$this->fields = (new PagesSchema())->tables['page_containers'];

		$this->setRecords();
		parent::init();
	}

/**
 * recordsのセット
 *
 * @return void
 */
	public function setRecords() {
		$id = 0;
		for ($pageId = 1; $pageId <= $this->_maxPageId; $pageId++) {
			for ($containerType = 1; $containerType <= 5; $containerType++) {
				$id++;
				$this->records[] = array(
					'id' => (string)$id,
					'page_id' => (string)$pageId,
					'container_type' => (string)$containerType,
					'is_published' => '1',
					'is_configured' => '0'
				);
			}
		}
	}

}
