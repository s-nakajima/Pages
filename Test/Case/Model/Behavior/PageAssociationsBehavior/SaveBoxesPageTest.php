<?php
/**
 * PageAssociationsBehavior::saveBoxesPage()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * PageAssociationsBehavior::saveBoxesPage()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Model\Behavior\PageAssociationsBehavior
 */
class PageAssociationsBehaviorSaveBoxesPageTest extends NetCommonsModelTestCase {

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
	}

/**
 * saveBoxesPage()テストのDataProvider
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
			'Box' => array('id' => '88'),
		);

		return $result;
	}

/**
 * saveBoxesPage()のテスト
 *
 * @param array $page ページデータ
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveBoxesPage($page) {
		//事前チェック
		$BoxesPage = ClassRegistry::init('Boxes.BoxesPage');
		$count = $BoxesPage->find('count', array(
			'recursive' => -1,
			'conditions' => array('page_id' => Hash::get($page, 'Page.id')),
		));
		$this->assertEqual(0, $count);

		//テスト実施
		$result = $this->TestModel->saveBoxesPage($page);

		//戻り値チェック
		$this->assertTrue($result);

		//データチェック
		$count = $this->TestModel->BoxesPage->find('count', array(
			'recursive' => -1,
			'conditions' => array('page_id' => Hash::get($page, 'Page.id')),
		));
		$this->assertEqual(5, $count);

		$count = $this->TestModel->BoxesPage->find('count', array(
			'recursive' => -1,
			'conditions' => array(
				'page_id' => Hash::get($page, 'Page.id'),
				'box_id' => Hash::get($page, 'Box.id'),
			),
		));
		$this->assertEqual(1, $count);
	}

/**
 * saveBoxesPage()のExceptionErrorテスト
 *
 * @param array $page ページデータ
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveBoxesPageOnExceptionError($page) {
		$this->_mockForReturnFalse('TestModel', 'Boxes.BoxesPage', 'save');

		//テスト実施
		$result = $this->TestModel->saveBoxesPage($page);

		//戻り値チェック
		$this->assertFalse($result);
	}

}
