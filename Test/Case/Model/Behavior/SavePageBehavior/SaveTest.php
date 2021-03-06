<?php
/**
 * SavePageBehavior::save()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('PagesModelTestCase', 'Pages.TestSuite');
App::uses('TestSavePageBehaviorSaveModelFixture', 'Pages.Test/Fixture');

/**
 * SavePageBehavior::save()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Model\Behavior\SavePageBehavior
 */
class SavePageBehaviorSaveTest extends PagesModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.pages.test_save_page_behavior_save_model',
		//'plugin.pages.pages_language',
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
		$this->TestModel = ClassRegistry::init('TestPages.TestSavePageBehaviorSaveModel');
	}

/**
 * save()のテスト(新規)
 *
 * @return void
 */
	public function testSaveInsert() {
		//テストデータ
		$data = array(
			'Page' => (new TestSavePageBehaviorSaveModelFixture())->records[0],
			'PagesLanguage' => array('id' => '1'),
		);
		$data = Hash::remove($data, 'Page.id');
		$this->_mockForReturnTrue('TestModel', 'Pages.PagesLanguage', array('save', 'validates'));

		$this->TestModel->Page = $this->getMockForModel('Pages.Page', array(
			'savePageContainers', 'saveBox', 'saveBoxesPageContainers'
		));
		$this->_mockForReturn('TestModel', 'Pages.Page', array('savePageContainers'), array(
			'PageContainer' => 'success1'
		));
		$this->_mockForReturn('TestModel', 'Pages.Page', array('saveBox'), array(
			'Box' => 'success2'
		));
		$this->_mockForReturnTrue('TestModel', 'Pages.Page', array(
			'saveBoxesPageContainers'
		));

		//事前チェック
		$this->assertNull(Hash::get($data, 'Page.created'));
		$this->assertNull(Hash::get($data, 'Page.modified'));

		//テスト実施
		$this->TestModel->set($data);
		$result = $this->TestModel->save();

		//チェック
		$this->assertDatetime(Hash::get($result, 'Page.created'));
		$this->assertDatetime(Hash::get($result, 'Page.modified'));
		$this->assertEquals('2', Hash::get($result, 'Page.id'));
		$this->assertEquals('2', Hash::get($this->TestModel->PagesLanguage->data, 'PagesLanguage.page_id'));
	}

/**
 * save()のテスト(更新)
 *
 * @return void
 */
	public function testSaveUpdate() {
		//テストデータ
		$data = array(
			'Page' => (new TestSavePageBehaviorSaveModelFixture())->records[0],
			'PagesLanguage' => array('id' => '1'),
		);
		$this->_mockForReturnTrue('TestModel', 'Pages.PagesLanguage', array('save', 'validates'));

		//事前チェック
		$this->assertNull(Hash::get($data, 'Page.modified'));

		//テスト実施
		$this->TestModel->set($data);
		$result = $this->TestModel->save();

		//チェック
		$this->assertEquals('1', Hash::get($this->TestModel->PagesLanguage->data, 'PagesLanguage.page_id'));
		$this->assertDatetime(Hash::get($result, 'Page.modified'));
	}

/**
 * save()のテスト(更新)
 *
 * @return void
 */
	public function testSaveOnExceptionError() {
		//テストデータ
		$data = array(
			'Page' => (new TestSavePageBehaviorSaveModelFixture())->records[0],
			'PagesLanguage' => array('id' => '1'),
		);
		$this->TestModel->PagesLanguage = $this->getMockForModel('Pages.PagesLanguage', array(
			'save', 'validates'
		));
		$this->_mockForReturnTrue('TestModel', 'Pages.PagesLanguage', 'validates');
		$this->_mockForReturnFalse('TestModel', 'Pages.PagesLanguage', 'save');

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$this->TestModel->set($data);
		$this->TestModel->save();
	}

}
