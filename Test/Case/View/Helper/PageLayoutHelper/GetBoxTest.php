<?php
/**
 * PageLayoutHelper::getBox()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsHelperTestCase', 'NetCommons.TestSuite');
App::uses('Container', 'Containers.Model');

/**
 * PageLayoutHelper::getBox()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\View\Helper\PageLayoutHelper
 */
class PageLayoutHelperGetBoxTest extends NetCommonsHelperTestCase {

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

		$this->Page = ClassRegistry::init('Pages.Page');
		$this->PluginsRoom = ClassRegistry::init('PluginManager.PluginsRoom');

		//テストデータ生成
		$result = $this->PluginsRoom->getPlugins('1', '2');
		Current::write('PluginsRoom', $result);

		//Helperロード
		$viewVars = array();
		$requestData = array();
		$params = array();

		$viewVars['page'] = $this->Page->getPageWithFrame('test4');
		$this->loadHelper('Pages.PageLayout', $viewVars, $requestData, $params);

		$this->PageLayout->containers = Hash::combine(
			Hash::get($this->PageLayout->_View->viewVars, 'page.Container', array()), '{n}.type', '{n}'
		);
		$this->PageLayout->boxes = Hash::combine(
			Hash::get($this->PageLayout->_View->viewVars, 'page.Box', array()), '{n}.id', '{n}', '{n}.container_id'
		);
		$this->PageLayout->plugins = Hash::combine(Current::read('PluginsRoom', array()), '{n}.Plugin.key', '{n}.Plugin');
	}

/**
 * getBox()のテスト
 *
 * @return void
 */
	public function testGetBox() {
		//データ生成
		$containerType = Container::TYPE_MAIN;

		//テスト実施
		$result = $this->PageLayout->getBox($containerType);

		//チェック
		$this->assertArrayHasKey('Frame', $result['17']);
	}

/**
 * getBox()のテスト(Containerなし)
 *
 * @return void
 */
	public function testGetBoxWOContainer() {
		//データ生成
		$containerType = Container::TYPE_MAIN;

		//テスト実施
		$this->PageLayout->containers = array();
		$result = $this->PageLayout->getBox($containerType);

		//チェック
		$this->assertEquals(array(), $result);
	}

/**
 * getBox()のテスト(Boxなし)
 *
 * @return void
 */
	public function testGetBoxWOBox() {
		//データ生成
		$containerType = Container::TYPE_MAIN;

		//テスト実施
		$this->PageLayout->boxes = array();
		$result = $this->PageLayout->getBox($containerType);

		//チェック
		$this->assertEquals(array(), $result);
	}

}
