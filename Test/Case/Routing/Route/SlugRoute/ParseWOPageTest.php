<?php
/**
 * SlugRoute::parse()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsCakeTestCase', 'NetCommons.TestSuite');
App::uses('SlugRoute', 'Pages.Routing/Route');

/**
 * SlugRoute::parse()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Routing\Route\SlugRoute
 */
class PagesRoutingRouteSlugRouteParseWOPageTestTest extends NetCommonsCakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

/**
 * Fixture merge
 *
 * @var array
 */
	protected $_isFixtureMerged = false;

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
	}

/**
 * DataProvider
 *
 * ### 戻り値
 * - template テンプレート
 * - url URL
 * - expected 期待値
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		return array(
			// * 「/*」のケース
			array('template' => '/*', 'url' => '/', 'expected' => false),
		);
	}

/**
 * parse()のテスト
 *
 * @param string $template テンプレート
 * @param string $url URL
 * @param bool|array $expected 期待値
 * @dataProvider dataProvider
 * @return void
 */
	public function testParse($template, $url) {
		//テスト実施
		$route = new SlugRoute($template,
			array('plugin' => 'pages', 'controller' => 'pages', 'action' => 'index')
		);

		$route->compile();
		$result = $route->parse($url);
		$this->assertFalse($result);
	}

}
