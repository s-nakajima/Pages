<?php
/**
 * PagesEditController::index()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('PagesControllerTestCase', 'Pages.TestSuite');

/**
 * PagesEditController::index()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Controller\PagesEditController
 */
class PagesEditControllerIndexTest extends PagesControllerTestCase {

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
 * Constructs
 *
 * @param string $name The name parameter on PHPUnit_Framework_TestCase::__construct()
 * @param array  $data The data parameter on PHPUnit_Framework_TestCase::__construct()
 * @param string $dataName The dataName parameter on PHPUnit_Framework_TestCase::__construct()
 * @return void
 */
	public function __construct($name = null, array $data = array(), $dataName = '') {
		parent::__construct($name, $data, $dataName);

		$key = array_search('plugin.pages.page4pages', $this->fixtures);
		unset($this->fixtures[$key]);
		$key = array_search('plugin.rooms.room', $this->fixtures);
		unset($this->fixtures[$key]);

		$this->fixtures[] = 'plugin.pages.Page4PageEditControllerIndex';
		$this->fixtures[] = 'plugin.pages.Room4PageEditControllerIndex';
	}

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
 * index()アクションのGetリクエストテスト
 *
 * @return void
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
	public function testIndexGet() {
		$roomId = '2';
		$this->_testGetAction(array('action' => 'index', $roomId), array('method' => 'assertNotEmpty'), null, 'view');

		//scriptのURLチェック
		$pattern = '/<script.*?' . preg_quote('/pages/js/pages.js', '/') . '.*?>/';
		$this->assertRegExp($pattern, $this->contents);

		//チェック
		// * viewファイルのチェック
		$this->assertInput('form', null, '/pages/pages_edit/move', $this->view);
		$this->assertInput('input', '_method', 'PUT', $this->view);
		$this->assertInput('input', 'data[_NetCommonsUrl][redirect]', null, $this->view);
		$this->assertInput('input', 'data[Page][id]', null, $this->view);
		$this->assertInput('input', 'data[Page][room_id]', '2', $this->view);
		$this->assertInput('input', 'data[Room][id]', '2', $this->view);
		$this->assertInput('input', 'data[Page][parent_id]', null, $this->view);
		$this->assertInput('input', 'data[Page][type]', null, $this->view);

		// * viewVars['parentList']のチェック
		$expected = array(
			'_0' => array(
				'_1' => array('weight' => 1, 'nest' => 0)
			),
			'_1' => array(
				'_4' => array('weight' => 1, 'nest' => 1),
				'_8' => array('weight' => 2, 'nest' => 1),
				'_5' => array('weight' => 3, 'nest' => 1),
				'_6' => array('weight' => 4, 'nest' => 1),
			),
			'_4' => array(
				'_7' => array('weight' => 1, 'nest' => 2)
			),
		);
		$this->assertEquals($expected, $this->controller->viewVars['parentList']);

		// * viewVars['treeList']のチェック
		$expected = array(1, 4, 7, 8, 5, 6);
		$this->assertEquals($expected, $this->controller->viewVars['treeList']);

		// * viewVars['pages']のチェック
		$this->assertCount(6, $this->controller->viewVars['pages']);

		$actual = $this->controller->viewVars['pages'];
		$actual = Hash::remove($actual, '{n}.{s}.created_user');
		$actual = Hash::remove($actual, '{n}.{s}.created');
		$actual = Hash::remove($actual, '{n}.{s}.modified_user');
		$actual = Hash::remove($actual, '{n}.{s}.modified');

		$expected = array(
			1 => array(
				'Page' => array(
					'id' => '1', 'room_id' => '2', 'root_id' => null, 'parent_id' => '0', 'lft' => '1', 'rght' => '14',
					'permalink' => '', 'slug' => null, 'is_container_fluid' => false, 'theme' => null, 'type' => '',
					'full_permalink' => '', 'hide_m17n' => true,
				),
				'PagesLanguage' => array(
					'name' => 'Room name',
				),
				'pageNameCss' => 'page-tree-node-page'
			),
			4 => array(
				'Page' => array(
					'id' => '4', 'room_id' => '2', 'root_id' => '1', 'parent_id' => '1', 'lft' => '2', 'rght' => '5',
					'permalink' => 'home', 'slug' => 'home', 'is_container_fluid' => false, 'theme' => null, 'type' => '',
					'full_permalink' => 'home', 'hide_m17n' => true,
				),
				'PagesLanguage' => array(
					'name' => 'Home ja',
				),
				'pageNameCss' => 'page-tree-node-page'
			),
			7 => array(
				'Page' => array(
					'id' => '7', 'room_id' => '2', 'root_id' => '1', 'parent_id' => '4', 'lft' => '3', 'rght' => '4',
					'permalink' => 'test4', 'slug' => 'test4', 'is_container_fluid' => false, 'theme' => null, 'type' => '',
					'full_permalink' => 'test4', 'hide_m17n' => true,
				),
				'PagesLanguage' => array(
					'name' => 'Test page 4',
				),
				'pageNameCss' => 'page-tree-leaf-page'
			),
			8 => array(
				'Page' => array(
					'id' => '8', 'room_id' => '2', 'root_id' => '1', 'parent_id' => '1', 'lft' => '6', 'rght' => '7',
					'permalink' => 'test5', 'slug' => 'test5', 'is_container_fluid' => false, 'theme' => null, 'type' => '',
					'full_permalink' => 'test5', 'hide_m17n' => true,
				),
				'PagesLanguage' => array(
					'name' => 'Test page 5',
				),
				'pageNameCss' => 'page-tree-leaf-page'
			),
			5 => array(
				'Page' => array(
					'id' => '5', 'room_id' => '5', 'root_id' => '1', 'parent_id' => '1', 'lft' => '8', 'rght' => '11',
					'permalink' => 'test2', 'slug' => 'test2', 'is_container_fluid' => false, 'theme' => null, 'type' => '',
					'full_permalink' => 'test2', 'hide_m17n' => true,
				),
				'PagesLanguage' => array(
					'name' => 'Test page 2',
				),
				'pageNameCss' => 'page-tree-room'
			),
			6 => array(
				'Page' => array(
					'id' => '6', 'room_id' => '6', 'root_id' => '1', 'parent_id' => '1', 'lft' => '12', 'rght' => '13',
					'permalink' => 'test3', 'slug' => 'test3', 'is_container_fluid' => false, 'theme' => null, 'type' => '',
					'full_permalink' => 'test3', 'hide_m17n' => true,
				),
				'PagesLanguage' => array(
					'name' => 'Test page 3',
				),
				'pageNameCss' => 'page-tree-room'
			)
		);

		$this->assertEquals($expected, $actual);
	}

/**
 * index()アクションのExceptionErrorテスト
 *
 * @return void
 */
	public function testIndexGetOnExceptionError() {
		$this->_mockForReturnFalse('Pages.Page', 'getPages');

		$roomId = '2';
		$this->_testGetAction(array('action' => 'index', $roomId), null, 'BadRequestException', 'view');
	}

/**
 * サブルームのテスト
 *
 * @return void
 */
	public function testSubRoom() {
		$this->_testGetAction(array('action' => 'index', '5'), array('method' => 'assertNotEmpty'), null, 'view');
		$this->assertCount(2, $this->controller->viewVars['pages']);
	}

/**
 * 配下のページが1件もないケース
 *
 * @return void
 */
	public function testChildPageNone() {
		$this->_testGetAction(array('action' => 'index', '6'), array('method' => 'assertNotEmpty'), null, 'view');
		$this->assertCount(1, $this->controller->viewVars['pages']);
	}

}
