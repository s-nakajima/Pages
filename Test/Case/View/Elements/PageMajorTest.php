<?php
/**
 * View/Elements/page_majorのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * View/Elements/page_majorのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\View\Elements\PageMajor
 */
class PagesViewElementsPageMajorTest extends NetCommonsControllerTestCase {

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
		'plugin.pages.pages_language4pages',
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
		//テストコントローラ生成
		$this->generateNc('TestPages.TestViewElementsPageMajor');
	}

/**
 * View/Elements/page_majorのテスト
 *
 * @return void
 */
	public function testPageMajor() {
		//テスト実行
		$this->_testGetAction('/test_pages/test_view_elements_page_major/page_major/2?frame_id=6',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/page_major', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$pattern = '<div id="container-major" class="col-md-3 col-md-pull-6">';
		$this->assertTextContains($pattern, $this->view);

		$pattern = 'test_pages/test_page/index';
		$this->assertTextContains($pattern, $this->view);
	}

/**
 * View/Elements/page_majorのテスト(PageLayoutHelperなし)
 *
 * @return void
 */
	public function testPageHeaderWOPageLayoutHelper() {
		//テスト実行
		$this->_testGetAction('/test_pages/test_view_elements_page_major/w_o_page_layout_helper/2?frame_id=6',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = '/' . preg_quote('View/Elements/page_major', '/') . '/';
		$this->assertRegExp($pattern, $this->view);

		$pattern = '<div id="container-major" class="col-md-3 col-md-pull-6">';
		$this->assertTextNotContains($pattern, $this->view);

		$pattern = 'test_pages/test_page/index';
		$this->assertTextNotContains($pattern, $this->view);
	}

}
