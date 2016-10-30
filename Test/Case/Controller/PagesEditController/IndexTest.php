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
				'_1' => array('index' => 0, 'weight' => 1, 'nest' => 0)
			),
			'_1' => array(
				'_4' => array('index' => 1, 'weight' => 1, 'nest' => 1),
				'_8' => array('index' => 3, 'weight' => 2, 'nest' => 1)
			),
			'_4' => array(
				'_7' => array('index' => 2, 'weight' => 1, 'nest' => 2)
			),
			'_3' => array(
				'_5' => array('index' => 4, 'weight' => 1, 'nest' => 0),
				'_6' => array('index' => 6, 'weight' => 2, 'nest' => 0),
			),
			'_5' => array(
				'_9' => array('index' => 5, 'weight' => 1, 'nest' => 1)
			),
		);
		$this->assertEquals($expected, $this->controller->viewVars['parentList']);

		// * viewVars['treeList']のチェック
		$expected = array(1, 4, 7, 8, 5, 9, 6);
		$this->assertEquals($expected, $this->controller->viewVars['treeList']);

		// * viewVars['pages']のチェック
		$this->assertCount(7, $this->controller->viewVars['pages']);

		$actual = $this->controller->viewVars['pages'];
		$actual = Hash::remove($actual, '{n}.{s}.created_user');
		$actual = Hash::remove($actual, '{n}.{s}.created');
		$actual = Hash::remove($actual, '{n}.{s}.modified_user');
		$actual = Hash::remove($actual, '{n}.{s}.modified');

		$expected = array(
			1 => array(
				'Page' => array(
					'id' => '1', 'room_id' => '2', 'root_id' => null, 'parent_id' => '0', 'lft' => '1', 'rght' => '8',
					'permalink' => '', 'slug' => null, 'is_container_fluid' => false, 'theme' => null, 'type' => ''
				),
				'PagesLanguage' => array(
					'name' => 'Room name',
				)
			),
			4 => array(
				'Page' => array(
					'id' => '4', 'room_id' => '2', 'root_id' => '1', 'parent_id' => '1', 'lft' => '2', 'rght' => '5',
					'permalink' => 'home', 'slug' => 'home', 'is_container_fluid' => false, 'theme' => null, 'type' => ''
				),
				'PagesLanguage' => array(
					'name' => 'Home ja',
				)
			),
			7 => array(
				'Page' => array(
					'id' => '7', 'room_id' => '2', 'root_id' => '1', 'parent_id' => '4', 'lft' => '3', 'rght' => '4',
					'permalink' => 'test4', 'slug' => 'test4', 'is_container_fluid' => false, 'theme' => null, 'type' => ''
				),
				'PagesLanguage' => array(
					'name' => 'Test page 4',
				)
			),
			8 => array(
				'Page' => array(
					'id' => '8', 'room_id' => '2', 'root_id' => '1', 'parent_id' => '1', 'lft' => '6', 'rght' => '7',
					'permalink' => 'test5', 'slug' => 'test5', 'is_container_fluid' => false, 'theme' => null, 'type' => ''
				),
				'PagesLanguage' => array(
					'name' => 'Test page 5',
				)
			),
			5 => array(
				'Page' => array(
					'id' => '5', 'room_id' => '5', 'root_id' => '3', 'parent_id' => '3', 'lft' => '12', 'rght' => '15',
					'permalink' => 'test2', 'slug' => 'test2', 'is_container_fluid' => false, 'theme' => null, 'type' => '',
				),
				'PagesLanguage' => array(
					'name' => 'Test page 2',
				)
			),
			9 => array(
				'Page' => array(
					'id' => '9', 'room_id' => '5', 'root_id' => '3', 'parent_id' => '5', 'lft' => '13', 'rght' => '14',
					'permalink' => 'test2/home', 'slug' => 'home', 'is_container_fluid' => false, 'theme' => null, 'type' => '',
				),
				'PagesLanguage' => array(
					'name' => 'Test page 2 - home',
				)
			),
			6 => array(
				'Page' => array(
					'id' => '6', 'room_id' => '6', 'root_id' => '3', 'parent_id' => '3', 'lft' => '16', 'rght' => '17',
					'permalink' => 'test3', 'slug' => 'test3', 'is_container_fluid' => false, 'theme' => null, 'type' => '',
				),
				'PagesLanguage' => array(
					'name' => 'Test page 3',
				)
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

}
