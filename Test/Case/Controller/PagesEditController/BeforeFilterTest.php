<?php
/**
 * PagesEditController::beforeFilter()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsControllerTestCase', 'NetCommons.TestSuite');

/**
 * PagesEditController::beforeFilter()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Controller\PagesEditController
 */
class PagesEditControllerBeforeFilterTest extends NetCommonsControllerTestCase {

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

		//テストプラグインのロード
		NetCommonsCakeTestCase::loadTestPlugin($this, 'Pages', 'TestPages');
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
 * index()アクションのテスト
 *
 * @return void
 */
	public function testBeforeFilterIndex() {
		//テスト実行
		$roomId = '1';
		$this->_testGetAction(array('action' => 'index', $roomId), array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->__assertBeforeFilter($roomId);
		$this->assertEquals('Room name', $this->vars['parentPathName']);
	}

/**
 * edit()アクションのテスト
 *
 * @return void
 */
	public function testBeforeFilterEdit() {
		//テスト実行
		$roomId = '1';
		$this->_testGetAction(array('action' => 'edit', $roomId, '4'), array('method' => 'assertNotEmpty'), null, 'view');

		//チェック
		$this->__assertBeforeFilter($roomId);
		$this->assertEquals('Room name / Home ja', $this->vars['parentPathName']);
	}

/**
 * edit()アクションのBadRequestExceptionテスト
 *
 * @return void
 */
	public function testBeforeFilterOnExceptinError() {
		//テスト実行
		$roomId = '999';
		$this->_testGetAction(array('action' => 'index', $roomId), null, 'BadRequestException', 'view');
	}

/**
 * index()アクションのチェック
 *
 * @param int $roomId ルームID
 * @return void
 */
	private function __assertBeforeFilter($roomId) {
		$expected = array(
			'Room', 'RolesRoom', 'RolesRoomsUser', 'ChildRoom', 'RoomsLanguage'
		);
		$this->assertEquals($expected, array_keys($this->vars['room']));

		$this->assertNotEmpty(Hash::extract($this->vars['room'], 'Room[id=' . $roomId . ']'));
		$this->assertNotEmpty(Hash::extract($this->vars['room'], 'RolesRoom[room_id=' . $roomId . ']'));
		$this->assertNotEmpty(Hash::extract($this->vars['room'], 'RolesRoomsUser[room_id=' . $roomId . ']'));
		$this->assertNotEmpty(Hash::extract($this->vars['room'], 'ChildRoom.{n}[parent_id=' . $roomId . ']'));
		$this->assertNotEmpty(Hash::extract($this->vars['room'], 'RoomsLanguage.{n}[room_id=' . $roomId . ']'));
	}

}