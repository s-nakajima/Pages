<?php
/**
 * PagesEditHelper::beforeRender()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('PagesControllerTestCase', 'Pages.TestSuite');

/**
 * PagesEditHelper::beforeRender()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Controller\Component\PagesEditHelper
 */
class PagesEditHelperBeforeRenderTest extends PagesControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

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
	}

/**
 * beforeRender()のテスト
 *
 * @return void
 */
	public function testBeforeRender() {
		//テストコントローラ生成
		$this->generateNc('TestPages.TestPagesEditHelperBeforeRender');

		//テスト実行
		$this->_testGetAction('/test_pages/test_pages_edit_helper_before_render/index',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Helper/TestPagesEditHelperBeforeRender', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		//cssのURLチェック
		$pattern = '/<link.*?' . preg_quote('/pages/css/style.css', '/') . '.*?>|' .
				'<link.*?' . preg_quote('/css/pages/style.css', '/') . '.*?>/';
		$this->assertRegExp($pattern, $this->contents);
	}

}
