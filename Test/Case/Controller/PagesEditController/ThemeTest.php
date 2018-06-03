<?php
/**
 * PagesEditController::theme()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('PagesControllerTestCase', 'Pages.TestSuite');
App::uses('AssetComponent', 'NetCommons.Controller/Component');

/**
 * PagesEditController::theme()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Controller\PagesEditController
 */
class PagesEditControllerThemeTest extends PagesControllerTestCase {

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'pages';

/**
 * Controller name
 *
 * @var string
 */
	protected $_controller = 'pages_edit';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		$this->generateNc(Inflector::camelize($this->_controller),
			['components' => [
				'Flash',
			]
		]);

		//ログイン
		TestAuthGeneral::login($this);

		$reflectionClass = new ReflectionClass('AssetComponent');
		$property = $reflectionClass->getProperty('__theme');
		$property->setAccessible(true);
		$property->setValue('AssetComponent', null);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		//ログアウト
		TestAuthGeneral::logout($this);

		parent::tearDown();
	}

/**
 * theme()アクションのGetリクエストテスト
 *
 * @return void
 */
	public function testThemeGet() {
		//テストデータ
		$roomId = '2';
		$pageId = '4';

		//テスト実行
		$this->_testGetAction(array('action' => 'theme', $roomId, $pageId), array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->assertInput('form', null, '/pages/pages_edit/theme/2/4', $this->view);
		$this->assertInput('input', '_method', 'PUT', $this->view);
		$this->assertInput('input', 'data[Page][id]', '4', $this->view);
		$this->assertInput('input', 'data[Page][theme]', null, $this->view);

		$this->assertEquals('default', $this->controller->theme);
	}

/**
 * theme()アクションのGetリクエストテスト(themeパラメータ付き)
 *
 * @return void
 */
	public function testThemeGetWithTheme() {
		//テストデータ
		$roomId = '2';
		$pageId = '4';

		//テスト実行
		$this->_testGetAction('/pages/pages_edit/theme/' . $roomId . '/' . $pageId . '?theme=Default',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->assertInput('form', null, '/pages/pages_edit/theme/2/4', $this->view);
		$this->assertInput('input', '_method', 'PUT', $this->view);
		$this->assertInput('input', 'data[Page][id]', '4', $this->view);
		$this->assertInput('input', 'data[Page][theme]', null, $this->view);

		$this->assertEquals('Default', $this->controller->theme);
	}

/**
 * POSTリクエストデータ生成
 *
 * @return array リクエストデータ
 */
	private function __data() {
		$data = array(
			'_NetCommonsUrl' => array('redirect' => '/pages/pages_edit/index/2/20')
		);
		return $data;
	}

/**
 * edit()アクションのPOSTリクエストテスト
 *
 * @return void
 */
	public function testThemePost() {
		//テストデータ
		$roomId = '2';
		$pageId = '4';

		$this->_mockForReturnTrue('Pages.Page', 'saveTheme');

		$this->controller->Components->Flash
			->expects($this->once())->method('set')
			->with(__d('net_commons', 'Successfully saved.'));

		//テスト実行
		$this->_testPostAction('put', $this->__data(),
				array('action' => 'theme', $roomId, $pageId), null, 'view');

		//チェック
		$header = $this->controller->response->header();
		$this->assertTextContains('/pages/pages_edit/index/2/20', $header['Location']);
	}

/**
 * edit()アクションのPOSTリクエストのExceptionErrorテスト
 *
 * @return void
 */
	public function testLayoutPostOnExceptionError() {
		//テストデータ
		$roomId = '2';
		$pageId = '4';

		$this->_mockForReturnFalse('Pages.Page', 'saveTheme');

		//テスト実行
		$this->_testPostAction('put', $this->__data(),
				array('action' => 'theme', $roomId, $pageId), 'BadRequestException', 'view');
	}

}
