<?php
/**
 * PagesEditController::delete()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('PagesControllerTestCase', 'Pages.TestSuite');

/**
 * PagesEditController::delete()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Controller\PagesEditController
 */
class PagesEditControllerDeleteTest extends PagesControllerTestCase {

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

		//ログイン
		TestAuthGeneral::login($this);
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
 * delete()アクションのGetリクエストテスト
 *
 * @return void
 */
	public function testDeleteGet() {
		//テストデータ
		$roomId = '2';
		$pageId = '4';

		//テスト実行
		$this->_testGetAction(array('action' => 'delete', $roomId, $pageId), null, 'BadRequestException', 'view');
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
 * delete()アクションのPOSTテスト
 *
 * @return void
 */
	public function testDeletePost() {
		//テストデータ
		$roomId = '2';
		$pageId = '4';
		$this->_mockForReturnTrue('Pages.Page', 'deletePage');

		//テスト実行
		$this->_testPostAction('delete', $this->__data(),
				array('action' => 'delete', $roomId, $pageId), null, 'view');

		//チェック
		$header = $this->controller->response->header();
		$this->assertNotEmpty($header['Location']);
	}

/**
 * delete()アクションのExceptionErrorテスト
 *
 * @return void
 */
	public function testDeletePostOnExceptionError() {
		//テストデータ
		$roomId = '2';
		$pageId = '4';
		$this->_mockForReturnFalse('Pages.Page', 'deletePage');

		//テスト実行
		$this->_testPostAction('delete', $this->__data(),
				array('action' => 'delete', $roomId, $pageId), 'BadRequestException', 'view');
	}

}
