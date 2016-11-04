<?php
/**
 * View/Elements/page_footerのテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('PagesControllerTestCase', 'Pages.TestSuite');

/**
 * View/Elements/page_footerのテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\View\Elements\PageFooter
 */
class PagesViewElementsPageFooterTest extends PagesControllerTestCase {

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
		$this->generateNc('TestPages.TestViewElementsPageFooter');
	}

/**
 * View/Elements/page_footerのテスト
 *
 * @return void
 */
	public function testPageFooter() {
		//テスト実行
		$this->_testGetAction('/test_pages/test_view_elements_page_footer/page_footer/2?frame_id=6',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = 'View/Elements/page_footer';
		$this->assertTextContains($pattern, $this->view);

		$pattern = '<footer id="container-footer" role="contentinfo">';
		$this->assertTextContains($pattern, $this->view);

		$pattern = 'test_pages/test_page/index';
		$this->assertTextContains($pattern, $this->view);
	}

/**
 * View/Elements/page_footerのテスト
 *
 * @return void
 */
	public function testPageFooterWOPageLayoutHelper() {
		//テスト実行
		$this->_testGetAction('/test_pages/test_view_elements_page_footer/w_o_page_layout_helper/2?frame_id=6',
				array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$pattern = 'View/Elements/page_footer';
		$this->assertTextContains($pattern, $this->view);

		$pattern = 'test_pages/test_page/index';
		$this->assertTextNotContains($pattern, $this->view);
	}

}
