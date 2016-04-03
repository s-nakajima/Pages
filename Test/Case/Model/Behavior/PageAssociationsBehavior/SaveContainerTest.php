<?php
/**
 * PageAssociationsBehavior::saveContainer()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * PageAssociationsBehavior::saveContainer()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Model\Behavior\PageAssociationsBehavior
 */
class PageAssociationsBehaviorSaveContainerTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.pages.box4pages',
		'plugin.pages.boxes_page4pages',
		'plugin.pages.container4pages',
		'plugin.pages.containers_page4pages',
		'plugin.pages.frame4pages',
		'plugin.pages.languages_page4pages',
		'plugin.pages.page4pages',
		'plugin.pages.plugin4pages',
		'plugin.pages.plugins_room4pages',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'pages';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'Pages', 'TestPages');
		$this->TestModel = ClassRegistry::init('TestPages.TestPageAssociationsBehaviorModel');

		//事前チェック用
		$this->Container = ClassRegistry::init('Containers.Container');
	}

/**
 * saveContainer()テストのDataProvider
 *
 * ### 戻り値
 *  - page ページデータ
 *
 * @return array データ
 */
	public function dataProvider() {
		$result[0] = array();
		$result[0]['page'] = null;

		return $result;
	}

/**
 * saveContainer()のテスト
 *
 * @param array $page ページデータ
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveContainer($page) {
		$containerId = '18';

		//事前チェック
		$count = $this->Container->find('count', array(
			'recursive' => -1,
			'conditions' => array('id' => $containerId),
		));
		$this->assertEquals(0, $count);

		//テスト実施
		$result = $this->TestModel->saveContainer($page);

		//戻り値チェック
		$this->assertDatetime($result['Container']['created']);
		$this->assertDatetime($result['Container']['modified']);

		unset($result['Container']['created']);
		unset($result['Container']['modified']);

		$expected = Hash::insert(array(), 'Container', array(
			'id' => $containerId, 'type' => '3'
		));
		$this->assertEquals($expected, $result);

		//データチェック
		$count = $this->TestModel->Container->find('count', array(
			'recursive' => -1,
			'conditions' => array('id' => $containerId),
		));
		$this->assertEquals(1, $count);
	}

/**
 * saveContainer()のExceptionErrorテスト
 *
 * @param array $page ページデータ
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveContainerOnExceptionError($page) {
		$this->_mockForReturnFalse('TestModel', 'Containers.Container', 'save');

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$this->TestModel->saveContainer($page);
	}

}