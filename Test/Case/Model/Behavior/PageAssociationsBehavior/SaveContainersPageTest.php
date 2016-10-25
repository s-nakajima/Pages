<?php
/**
 * PageAssociationsBehavior::saveContainersPage()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * PageAssociationsBehavior::saveContainersPage()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Model\Behavior\PageAssociationsBehavior
 */
class PageAssociationsBehaviorSaveContainersPageTest extends NetCommonsModelTestCase {

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
		'plugin.pages.pages_language4pages',
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
		$this->ContainersPage = ClassRegistry::init('Containers.ContainersPage');
	}

/**
 * saveContainersPage()テストのDataProvider
 *
 * ### 戻り値
 *  - page ページデータ
 *
 * @return array データ
 */
	public function dataProvider() {
		$result[0] = array();
		$result[0]['page'] = array(
			'Page' => array('id' => '99'),
			'Container' => array('id' => '88'),
		);

		return $result;
	}

/**
 * saveContainersPage()のテスト
 *
 * @param array $page ページデータ
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveContainersPage($page) {
		//事前チェック
		$count = $this->ContainersPage->find('count', array(
			'recursive' => -1,
			'conditions' => array('page_id' => Hash::get($page, 'Page.id')),
		));
		$this->assertEquals(0, $count);

		//テスト実施
		$result = $this->TestModel->saveContainersPage($page);

		//戻り値チェック
		$this->assertTrue($result);

		//データチェック
		$count = $this->TestModel->ContainersPage->find('count', array(
			'recursive' => -1,
			'conditions' => array('page_id' => Hash::get($page, 'Page.id')),
		));
		$this->assertEquals(5, $count);

		$count = $this->TestModel->ContainersPage->find('count', array(
			'recursive' => -1,
			'conditions' => array(
				'page_id' => Hash::get($page, 'Page.id'),
				'container_id' => Hash::get($page, 'Container.id'),
			),
		));
		$this->assertEquals(1, $count);
	}

/**
 * saveContainersPage()のExceptionErrorテスト
 *
 * @param array $page ページデータ
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveContainersPageOnExceptionError($page) {
		$this->_mockForReturnFalse('TestModel', 'Containers.ContainersPage', 'save');

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$this->TestModel->saveContainersPage($page);
	}

}
