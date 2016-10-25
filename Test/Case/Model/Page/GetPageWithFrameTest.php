<?php
/**
 * Page::getPageWithFrame()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsGetTest', 'NetCommons.TestSuite');

/**
 * Page::getPageWithFrame()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Model\Page
 */
class PageGetPageWithFrameTest extends NetCommonsGetTest {

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
		'plugin.pages.room4pages',
	);

/**
 * Plugin name
 *
 * @var string
 */
	public $plugin = 'pages';

/**
 * Model name
 *
 * @var string
 */
	protected $_modelName = 'Page';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'getPageWithFrame';

/**
 * getPageWithFrame()のテスト
 *
 * @return void
 */
	public function testGetPageWithFrame() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		$permalink = 'test4';

		//テスト実施
		$result = $this->$model->$methodName($permalink);

		//チェック
		$expected = array('Page', 'Box', 'Container', 'Language', 'PagesLanguage');
		$this->assertEquals($expected, array_keys($result));

		$this->__assertPage($result['Page'], array());
		$this->__assertBoxes($result['Box'], array(
			'header' => array(),
			'minor' => array(),
			'major' => array(),
			'footer' => array(),
			'main' => array(),
		));
		$this->__assertContainers($result['Container'], array());
	}

/**
 * getPageWithFrame()のテスト
 *
 * @return void
 */
	public function testGetPageWithFrameByRoot() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		Current::write('Room.page_id_top', '7');

		//データ生成
		$permalink = '';

		//テスト実施
		$result = $this->$model->$methodName($permalink);

		//チェック
		$expected = array('Page', 'Box', 'Container', 'Language', 'PagesLanguage');
		$this->assertEquals($expected, array_keys($result));

		$this->__assertPage($result['Page']);
		$this->__assertBoxes($result['Box']);
		$this->__assertContainers($result['Container']);
	}

/**
 * Pageのチェック
 *
 * @param array $result 結果データ
 * @return void
 */
	private function __assertPage($result) {
		$result = Hash::remove($result, 'created_user');
		$result = Hash::remove($result, 'created');
		$result = Hash::remove($result, 'modified_user');
		$result = Hash::remove($result, 'modified');

		$expected = array(
			'id' => '7', 'room_id' => '2', 'root_id' => '1', 'parent_id' => '4', 'lft' => '3', 'rght' => '4',
			'permalink' => 'test4', 'slug' => 'test4', 'is_container_fluid' => false, 'theme' => null,
		);
		$this->assertEquals($expected, $result);
	}

/**
 * Boxesのチェック
 *
 * @param array $result 結果データ
 * @return void
 */
	private function __assertBoxes($result) {
		$result = Hash::remove($result, '{n}.created_user');
		$result = Hash::remove($result, '{n}.created');
		$result = Hash::remove($result, '{n}.modified_user');
		$result = Hash::remove($result, '{n}.modified');

		$result = Hash::remove($result, '{n}.{s}.created_user');
		$result = Hash::remove($result, '{n}.{s}.created');
		$result = Hash::remove($result, '{n}.{s}.modified_user');
		$result = Hash::remove($result, '{n}.{s}.modified');

		$this->assertCount(5, $result);
		$this->__assertBoxHeader(Hash::extract($result, '{n}[id=1]')[0]);
		$this->__assertBoxMinor(Hash::extract($result, '{n}[id=4]')[0]);
		$this->__assertBoxMajor(Hash::extract($result, '{n}[id=2]')[0]);
		$this->__assertBoxFooter(Hash::extract($result, '{n}[id=5]')[0]);
		$this->__assertBoxMain(Hash::extract($result, '{n}[id=17]')[0]);
	}

/**
 * Boxのチェック(レフト)
 *
 * @param array $result 結果データ
 * @return void
 */
	private function __assertBoxMajor($result) {
		$result = Hash::remove($result, 'Frame.{n}.created_user');
		$result = Hash::remove($result, 'Frame.{n}.created');
		$result = Hash::remove($result, 'Frame.{n}.modified_user');
		$result = Hash::remove($result, 'Frame.{n}.modified');

		$expected = array(
			// * Box
			'id' => '2', 'container_id' => '2', 'type' => '1', 'space_id' => '2',
			'room_id' => '2', 'page_id' => '1', 'weight' => '1',
			// * BoxesPage
			'BoxesPage' => array(
				'id' => '22', 'page_id' => '7', 'box_id' => '2', 'is_published' => true,
			),
			// * Frame
			'Frame' => array(0 => array(
				'id' => '2',
				'language_id' => '2',
				'room_id' => '2',
				'box_id' => '2',
				'plugin_key' => 'test_pages',
				'block_id' => '2',
				'key' => 'frame_major',
				'name' => 'Test frame major',
				'header_type' => 'default',
				'weight' => '1',
				'is_deleted' => false,
				'default_action' => '',
			))
		);
		$this->assertEquals($expected, $result);
	}

/**
 * Boxのチェック(フッター)
 *
 * @param array $result 結果データ
 * @return void
 */
	private function __assertBoxFooter($result) {
		$result = Hash::remove($result, 'Frame.{n}.created_user');
		$result = Hash::remove($result, 'Frame.{n}.created');
		$result = Hash::remove($result, 'Frame.{n}.modified_user');
		$result = Hash::remove($result, 'Frame.{n}.modified');

		$expected = array(
			// * Box
			'id' => '5', 'container_id' => '5', 'type' => '1', 'space_id' => '2',
			'room_id' => '2', 'page_id' => '1', 'weight' => '1',
			// * BoxesPage
			'BoxesPage' => array(
				'id' => '25', 'page_id' => '7', 'box_id' => '5', 'is_published' => true,
			),
			// * Frame
			'Frame' => array(0 => array(
				'id' => '4',
				'language_id' => '2',
				'room_id' => '2',
				'box_id' => '5',
				'plugin_key' => 'test_pages',
				'block_id' => '2',
				'key' => 'frame_footer',
				'name' => 'Test frame footer',
				'header_type' => 'default',
				'weight' => '1',
				'is_deleted' => false,
				'default_action' => '',
			))
		);
		$this->assertEquals($expected, $result);
	}

/**
 * Boxのチェック(メイン)
 *
 * @param array $result 結果データ
 * @return void
 */
	private function __assertBoxMain($result) {
		$expected = array(
			// * Box
			'id' => '17', 'container_id' => '17', 'type' => '4', 'space_id' => '2',
			'room_id' => '2', 'page_id' => '7', 'weight' => '1',
			// * BoxesPage
			'BoxesPage' => array(
				'id' => '23', 'page_id' => '7', 'box_id' => '17', 'is_published' => true,
			),
			// * Frame
			//'Frame' => array()
		);
		$this->assertEquals($expected, $result);
	}

/**
 * Boxのチェック(ヘッダー)
 *
 * @param array $result 結果データ
 * @return void
 */
	private function __assertBoxHeader($result) {
		$result = Hash::remove($result, 'Frame.{n}.created_user');
		$result = Hash::remove($result, 'Frame.{n}.created');
		$result = Hash::remove($result, 'Frame.{n}.modified_user');
		$result = Hash::remove($result, 'Frame.{n}.modified');

		$expected = array(
			// * Box
			'id' => '1', 'container_id' => '1', 'type' => '1', 'space_id' => '2',
			'room_id' => '2', 'page_id' => '1', 'weight' => '1',
			// * BoxesPage
			'BoxesPage' => array(
				'id' => '21', 'page_id' => '7', 'box_id' => '1', 'is_published' => true,
			),
			// * Frame
			'Frame' => array(0 => array(
				'id' => '1',
				'language_id' => '2',
				'room_id' => '2',
				'box_id' => '1',
				'plugin_key' => 'test_pages',
				'block_id' => '2',
				'key' => 'frame_header',
				'name' => 'Test frame header',
				'header_type' => 'default',
				'weight' => '1',
				'is_deleted' => false,
				'default_action' => '',
			))
		);
		$this->assertEquals($expected, $result);
	}

/**
 * Boxのチェック(ライト)
 *
 * @param array $result 結果データ
 * @return void
 */
	private function __assertBoxMinor($result) {
		$result = Hash::remove($result, 'Frame.{n}.created_user');
		$result = Hash::remove($result, 'Frame.{n}.created');
		$result = Hash::remove($result, 'Frame.{n}.modified_user');
		$result = Hash::remove($result, 'Frame.{n}.modified');

		$expected = array(
			// * Box
			'id' => '4', 'container_id' => '4', 'type' => '1', 'space_id' => '2',
			'room_id' => '2', 'page_id' => '1', 'weight' => '1',
			// * BoxesPage
			'BoxesPage' => array(
				'id' => '24', 'page_id' => '7', 'box_id' => '4', 'is_published' => true,
			),
			// * Frame
			'Frame' => array(0 => array(
				'id' => '3',
				'language_id' => '2',
				'room_id' => '2',
				'box_id' => '4',
				'plugin_key' => 'test_pages',
				'block_id' => '2',
				'key' => 'frame_minor',
				'name' => 'Test frame minor',
				'header_type' => 'default',
				'weight' => '1',
				'is_deleted' => false,
				'default_action' => '',
			))
		);
		$this->assertEquals($expected, $result);
	}

/**
 * Containersのチェック
 *
 * @param array $result 結果データ
 * @return void
 */
	private function __assertContainers($result) {
		$result = Hash::remove($result, '{n}.created_user');
		$result = Hash::remove($result, '{n}.created');
		$result = Hash::remove($result, '{n}.modified_user');
		$result = Hash::remove($result, '{n}.modified');

		$result = Hash::remove($result, '{n}.{s}.created_user');
		$result = Hash::remove($result, '{n}.{s}.created');
		$result = Hash::remove($result, '{n}.{s}.modified_user');
		$result = Hash::remove($result, '{n}.{s}.modified');

		$expected = array(
			0 => array(
				'id' => '1', 'type' => '1',
				'ContainersPage' => array(
					'id' => '21', 'page_id' => '7', 'container_id' => '1', 'is_published' => true, 'is_configured' => false,
				)
			),
			1 => array(
				'id' => '2', 'type' => '2',
				'ContainersPage' => array(
					'id' => '22', 'page_id' => '7', 'container_id' => '2', 'is_published' => true, 'is_configured' => false,
				)
			),
			2 => array(
				'id' => '17', 'type' => '3',
				'ContainersPage' => array(
					'id' => '23', 'page_id' => '7', 'container_id' => '17', 'is_published' => true, 'is_configured' => false,
				)
			),
			3 => array(
				'id' => '4', 'type' => '4',
				'ContainersPage' => array(
					'id' => '24', 'page_id' => '7', 'container_id' => '4', 'is_published' => true, 'is_configured' => false,
				)
			),
			4 => array(
				'id' => '5', 'type' => '5',
				'ContainersPage' => array(
					'id' => '25', 'page_id' => '7', 'container_id' => '5', 'is_published' => true, 'is_configured' => false,
				)
			)
		);
		$this->assertEquals($expected, $result);
	}

}
