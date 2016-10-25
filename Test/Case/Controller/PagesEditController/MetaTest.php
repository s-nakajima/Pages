<?php
/**
 * PagesEditController::meta()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * PagesEditController::meta()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Controller\PagesEditController
 */
class PagesEditControllerMetaTest extends NetCommonsControllerTestCase {

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
 * meta()アクションのGetリクエストテスト
 *
 * @return void
 */
	public function testMetaGet() {
		//テストデータ
		$roomId = '2';
		$pageId = '4';

		//テスト実行
		$this->_testGetAction(array('action' => 'meta', $roomId, $pageId), array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->assertInput('form', null, '/pages/pages_edit/meta/2/4', $this->view);
		$this->assertInput('input', '_method', 'PUT', $this->view);
		$this->assertInput('input', 'data[Page][id]', '4', $this->view);

		$this->assertInput('input', 'data[Page][id]', $pageId, $this->view);
		$this->assertInput('input', 'data[LanguagesPage][id]', '8', $this->view);
		$this->assertInput('input', 'data[LanguagesPage][language_id]', '2', $this->view);
		$this->assertInput('input', 'data[LanguagesPage][meta_title]', '{X-PAGE_NAME} - {X-SITE_NAME}', $this->view);
		$this->assertInput('input', 'data[LanguagesPage][meta_description]', null, $this->view);
		$this->assertInput('input', 'data[LanguagesPage][meta_keywords]', null, $this->view);
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
 * meta()アクションのPOSTリクエストテスト
 *
 * @return void
 */
	public function testPost() {
		//テストデータ
		$roomId = '2';
		$pageId = '4';

		$this->_mockForReturnTrue('Pages.LanguagesPage', 'saveLanguagesPage');

		$this->controller->Components->Session
			->expects($this->once())->method('setFlash')
			->with(__d('net_commons', 'Successfully saved.'));

		//テスト実行
		$this->_testPostAction('put', $this->__data(),
				array('action' => 'meta', $roomId, $pageId), null, 'view');

		//チェック
		$header = $this->controller->response->header();
		$this->assertTextContains('/pages/pages_edit/index/2/20', $header['Location']);
	}

/**
 * meta()アクションのexistPage()のエラーテスト
 *
 * @return void
 */
	public function testOnExceptionError() {
		$roomId = '2';
		$pageId = '4';
		$this->_mockForReturnFalse('Pages.Page', 'existPage');

		//テスト実行
		$this->_testGetAction(array('action' => 'meta', $roomId, $pageId), null, 'BadRequestException', 'view');
	}

/**
 * ValidationErrorテスト
 *
 * @return void
 */
	public function testOnValidationError() {
		$roomId = '2';
		$pageId = '4';
		$this->_mockForReturnCallback('Pages.LanguagesPage', 'saveLanguagesPage', function () {
			$message = sprintf(__d('net_commons', 'Please input %s.'), __d('pages', 'Title tag'));
			$this->controller->LanguagesPage->invalidate('meta_title', $message);
			return false;
		});

		//テスト実行
		$this->_testPostAction('put', $this->__data(),
				array('action' => 'meta', $roomId, $pageId), null, 'view');

		//チェック
		$message = sprintf(__d('net_commons', 'Please input %s.'), __d('pages', 'Title tag'));
		$this->assertTextContains($message, $this->view);
	}

}
