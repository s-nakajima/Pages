<?php
/**
 * PageAssociationsBehavior::deleteContainers()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('PagesModelTestCase', 'Pages.TestSuite');

/**
 * PageAssociationsBehavior::deleteContainers()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Model\Behavior\PageAssociationsBehavior
 */
class PageAssociationsBehaviorDeleteContainersTest extends PagesModelTestCase {

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
 * deleteContainers()テストのDataProvider
 *
 * ### 戻り値
 *  - pageId ページID
 *
 * @return array データ
 */
	public function dataProvider() {
		$result[0] = array();
		$result[0]['pageId'] = '7';

		return $result;
	}

/**
 * deleteContainers()のテスト
 *
 * @param int $pageId ページID
 * @dataProvider dataProvider
 * @return void
 */
	public function testDeleteContainers($pageId) {
		//事前チェック
		$count = $this->PageContainer->find('count', array(
			'recursive' => -1,
			'conditions' => array('page_id' => $pageId),
		));
		$this->assertEquals(5, $count);

		//テスト実施
		$result = $this->TestModel->deleteContainers($pageId);

		//戻り値チェック
		$this->assertTrue($result);

		//データチェック
		$count = $this->TestModel->PageContainer->find('count', array(
			'recursive' => -1,
			'conditions' => array('page_id' => $pageId),
		));
		$this->assertEquals(0, $count);
	}

/**
 * deleteContainers()のContainer->deleteAll()のExceptionErrorテスト
 *
 * @param int $pageId ページID
 * @dataProvider dataProvider
 * @return void
 */
	public function testDeleteContainersOnContainerExceptionError($pageId) {
		$this->_mockForReturnFalse('TestModel', 'Pages.PageContainer', 'deleteAll');

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$this->TestModel->deleteContainers($pageId);
	}

/**
 * deleteContainers()のContainersPage->deleteAll()のExceptionErrorテスト
 *
 * @param int $pageId ページID
 * @dataProvider dataProvider
 * @return void
 */
	public function testDeleteContainersOnContainersPageExceptionError($pageId) {
		$this->_mockForReturnFalse('TestModel', 'Pages.PageContainer', 'deleteAll');

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$this->TestModel->deleteContainers($pageId);
	}

}
