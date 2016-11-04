<?php
/**
 * PageAssociationsBehavior::savePageContainers()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('PagesModelTestCase', 'Pages.TestSuite');

/**
 * PageAssociationsBehavior::savePageContainers()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Model\Behavior\PageAssociationsBehavior
 */
class PageAssociationsBehaviorSavePageContainersTest extends PagesModelTestCase {

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
		$this->PageContainer = ClassRegistry::init('Pages.PageContainer');
	}

/**
 * savePageContainers()テストのDataProvider
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
		);

		return $result;
	}

/**
 * savePageContainers()のテスト
 *
 * @param array $page ページデータ
 * @dataProvider dataProvider
 * @return void
 */
	public function testSavePageContainers($page) {
		//事前チェック
		$count = $this->PageContainer->find('count', array(
			'recursive' => -1,
			'conditions' => array('page_id' => Hash::get($page, 'Page.id')),
		));
		$this->assertEquals(0, $count);

		//テスト実施
		$result = $this->TestModel->savePageContainers($page);
		$result = Hash::remove($result, '{s}.{n}.{s}.created');
		$result = Hash::remove($result, '{s}.{n}.{s}.modified');

		//戻り値チェック
		$expected = array(
			'PageContainer' => array(
				1 => array(
					'PageContainer' => array(
						'page_id' => '99', 'container_type' => '1',
						'is_published' => true, 'is_configured' => false, 'id' => '46',
					),
				),
				2 => array(
					'PageContainer' => array(
						'page_id' => '99', 'container_type' => '2',
						'is_published' => true, 'is_configured' => false, 'id' => '47',
					),
				),
				3 => array(
					'PageContainer' => array(
						'page_id' => '99', 'container_type' => '3',
						'is_published' => true, 'is_configured' => false, 'id' => '48',
					),
				),
				4 => array(
					'PageContainer' => array(
						'page_id' => '99', 'container_type' => '4',
						'is_published' => true, 'is_configured' => false, 'id' => '49',
					),
				),
				5 => array(
					'PageContainer' => array(
						'page_id' => '99', 'container_type' => '5',
						'is_published' => true, 'is_configured' => false, 'id' => '50',
					),
				),
			),
		);
		$this->assertEquals($expected, $result);

		//データチェック
		$count = $this->TestModel->PageContainer->find('count', array(
			'recursive' => -1,
			'conditions' => array('page_id' => Hash::get($page, 'Page.id')),
		));
		$this->assertEquals(5, $count);
	}

/**
 * saveContainersPage()のExceptionErrorテスト
 *
 * @param array $page ページデータ
 * @dataProvider dataProvider
 * @return void
 */
	public function testSavePageContainersOnExceptionError($page) {
		$this->_mockForReturnFalse('TestModel', 'Pages.PageContainer', 'save');

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$this->TestModel->savePageContainers($page);
	}

}
