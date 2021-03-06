<?php
/**
 * View/Elements/PagesEdit/headerのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('PagesControllerTestCase', 'Pages.TestSuite');

/**
 * View/Elements/PagesEdit/headerのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\View\Elements\PagesEdit\Header
 */
class PagesViewElementsPagesEditHeaderTest extends PagesControllerTestCase {

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

		//テストコントローラ生成
		$this->generateNc('TestPages.TestViewElementsPagesEditHeader');

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
 * View/Elements/PagesEdit/headerのテスト
 *
 * @return void
 */
	public function testHeader() {
		//テスト実行
		$this->_testGetAction('/test_pages/test_view_elements_pages_edit_header/edit/2?frame_id=6',
				array('method' => 'assertNotEmpty'), null, 'view');

		//cssのURLチェック
		$pattern = '/<link.*?' . preg_quote('/control_panel/css/style.css', '/') . '.*?>|' .
				'<link.*?' . preg_quote('/css/control_panel/style.css', '/') . '.*?>/';
		$this->assertRegExp($pattern, $this->contents);

		//チェック
		$pattern = '/' . preg_quote('View/Elements/PagesEdit/header', '/') . '/';
		$this->assertRegExp($pattern, $this->view);
	}

}
