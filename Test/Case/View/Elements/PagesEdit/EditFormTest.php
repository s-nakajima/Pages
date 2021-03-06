<?php
/**
 * View/Elements/PagesEdit/edit_formのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('PagesControllerTestCase', 'Pages.TestSuite');

/**
 * View/Elements/PagesEdit/edit_formのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\View\Elements\PagesEdit\EditForm
 */
class PagesViewElementsPagesEditEditFormTest extends PagesControllerTestCase {

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
		$this->generateNc('TestPages.TestViewElementsPagesEditEditForm');
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
 * View/Elements/PagesEdit/edit_formのテスト
 *
 * @return void
 */
	public function testEditForm() {
		//テスト実行
		$this->_testGetAction('/test_pages/test_view_elements_pages_edit_edit_form/edit/2?frame_id=6',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/PagesEdit/edit_form', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$this->assertInput('input', 'data[Page][id]', '7', $this->view);
		$this->assertInput('input', 'data[Page][root_id]', '1', $this->view);
		$this->assertInput('input', 'data[Page][parent_id]', '4', $this->view);
		$this->assertInput('input', 'data[Page][permalink]', 'test4', $this->view);
		$this->assertInput('input', 'data[Page][room_id]', '2', $this->view);
		$this->assertInput('input', 'data[Room][id]', '2', $this->view);
		$this->assertInput('input', 'data[Room][space_id]', '2', $this->view);
		$this->assertInput('input', 'data[PagesLanguage][id]', '10', $this->view);
		$this->assertInput('input', 'data[PagesLanguage][name]', 'Test page 4', $this->view);
		$this->assertInput('input', 'data[Page][permalink]', 'test4', $this->view);
	}

}
