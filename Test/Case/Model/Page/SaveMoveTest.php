<?php
/**
 * Page::saveMove()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * Page::saveMove()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Model\Page
 */
class PageSaveMoveTest extends NetCommonsModelTestCase {

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
	protected $_methodName = 'saveMove';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//テストクエリ
		$this->___query = array(
			'recursive' => -1,
			'fields' => array('id', 'parent_id', 'lft', 'rght'),
			'conditions' => array('id' => array('4', '7', '8')),
			'order' => array('lft' => 'asc'),
		);
		//事前チェック
		$model = $this->_modelName;
		$result = $this->$model->find('all', $this->___query);
		$expected = array(
			0 => array('Page' => array(
				'id' => '4', 'parent_id' => '1', 'lft' => '2', 'rght' => '5'
			)),
			1 => array('Page' => array(
				'id' => '7', 'parent_id' => '4', 'lft' => '3', 'rght' => '4'
			)),
			2 => array('Page' => array(
				'id' => '8', 'parent_id' => '1', 'lft' => '6', 'rght' => '7'
			)),
		);
		$this->assertEquals($expected, $result);
	}

/**
 * saveMove()のUpテスト
 *
 * @return void
 */
	public function testSaveMoveUp() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$pageId = '8';
		$roomId = '2';

		//テスト実施
		$data = array(
			'Page' => array('id' => $pageId, 'type' => 'up'),
			'Room' => array('id' => $roomId)
		);
		$result = $this->$model->$methodName($data);
		$this->assertTrue($result);

		//チェック
		$result = $this->$model->find('all', $this->___query);
		$expected = array(
			0 => array('Page' => array(
				'id' => '8', 'parent_id' => '1', 'lft' => '2', 'rght' => '3'
			)),
			1 => array('Page' => array(
				'id' => '4', 'parent_id' => '1', 'lft' => '4', 'rght' => '7'
			)),
			2 => array('Page' => array(
				'id' => '7', 'parent_id' => '4', 'lft' => '5', 'rght' => '6'
			)),
		);
		$this->assertEquals($expected, $result);
	}

/**
 * saveMove()のExceptionErrorテスト
 *
 * @return void
 */
	public function testSaveMoveUpOnExceptionError() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$pageId = '8';
		$roomId = '2';
		$this->_mockForReturnFalse($model, 'Rooms.Room', 'saveField');

		//テスト実施
		$data = array(
			'Page' => array('id' => $pageId, 'type' => 'up'),
			'Room' => array('id' => $roomId)
		);
		$this->setExpectedException('InternalErrorException');
		$this->$model->$methodName($data);
	}

/**
 * saveMove()の最上部のUpテスト
 *
 * @return void
 */
	public function testSaveMoveUpOnTop() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$pageId = '4';
		$roomId = '2';

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$data = array(
			'Page' => array('id' => $pageId, 'type' => 'up'),
			'Room' => array('id' => $roomId)
		);
		$this->$model->$methodName($data);
	}

/**
 * saveMove()のDownテスト
 *
 * @return void
 */
	public function testSaveMoveDown() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$pageId = '4';
		$roomId = '2';

		//テスト実施
		$data = array(
			'Page' => array('id' => $pageId, 'type' => 'down'),
			'Room' => array('id' => $roomId)
		);
		$result = $this->$model->$methodName($data);
		$this->assertTrue($result);

		//チェック
		$result = $this->$model->find('all', $this->___query);
		$expected = array(
			0 => array('Page' => array(
				'id' => '8', 'parent_id' => '1', 'lft' => '2', 'rght' => '3'
			)),
			1 => array('Page' => array(
				'id' => '4', 'parent_id' => '1', 'lft' => '4', 'rght' => '7'
			)),
			2 => array('Page' => array(
				'id' => '7', 'parent_id' => '4', 'lft' => '5', 'rght' => '6'
			)),
		);
		$this->assertEquals($expected, $result);
	}

/**
 * saveMove()の最下部のDownテスト
 *
 * @return void
 */
	public function testSaveMoveDownOnLast() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$pageId = '8';
		$roomId = '2';

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$data = array(
			'Page' => array('id' => $pageId, 'type' => 'down'),
			'Room' => array('id' => $roomId)
		);
		$this->$model->$methodName($data);
	}

/**
 * saveMove()の移動(Move)テスト(ケース1)
 *
 * @return void
 */
	public function testSaveMoveParentMove1() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$pageId = '8';
		$roomId = '2';

		//テスト実施
		$data = array(
			'Page' => array('id' => $pageId, 'type' => 'move', 'parent_id' => '4'),
			'Room' => array('id' => $roomId)
		);
		$result = $this->$model->$methodName($data);
		$this->assertTrue($result);

		//チェック
		$result = $this->$model->find('all', $this->___query);
		$expected = array(
			0 => array('Page' => array(
				'id' => '4', 'parent_id' => '1', 'lft' => '2', 'rght' => '7'
			)),
			1 => array('Page' => array(
				'id' => '7', 'parent_id' => '4', 'lft' => '3', 'rght' => '4'
			)),
			2 => array('Page' => array(
				'id' => '8', 'parent_id' => '4', 'lft' => '5', 'rght' => '6'
			)),
		);
		$this->assertEquals($expected, $result);
	}

/**
 * saveMove()の移動(Move)テスト(ケース2)
 *
 * @return void
 */
	public function testSaveMoveParentMove2() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$pageId = '4';
		$roomId = '2';

		//テスト実施
		$data = array(
			'Page' => array('id' => $pageId, 'type' => 'move', 'parent_id' => '8'),
			'Room' => array('id' => $roomId)
		);
		$result = $this->$model->$methodName($data);
		$this->assertTrue($result);

		//チェック
		$result = $this->$model->find('all', $this->___query);
		$expected = array(
			0 => array('Page' => array(
				'id' => '8', 'parent_id' => '1', 'lft' => '2', 'rght' => '7'
			)),
			1 => array('Page' => array(
				'id' => '4', 'parent_id' => '8', 'lft' => '3', 'rght' => '6'
			)),
			2 => array('Page' => array(
				'id' => '7', 'parent_id' => '4', 'lft' => '4', 'rght' => '5'
			)),
		);
		$this->assertEquals($expected, $result);
	}

/**
 * saveMove()の移動(Move)のExceptionErrorテスト(入れ子)
 *
 * @return void
 */
	public function testSaveMoveParentMoveOnExceptionError() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$pageId = '4';
		$roomId = '2';

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$data = array(
			'Page' => array('id' => $pageId, 'type' => 'move', 'parent_id' => '7'),
			'Room' => array('id' => $roomId)
		);
		$this->$model->$methodName($data);
	}

/**
 * saveMove()ののExceptionErrorテスト(不正パラメータ)
 *
 * @return void
 */
	public function testSaveMoveOnExceptionError() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$pageId = '4';
		$roomId = '2';

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$data = array(
			'Page' => array('id' => $pageId, 'type' => 'error'),
			'Room' => array('id' => $roomId)
		);
		$this->$model->$methodName($data);
	}

/**
 * saveMove()ののExistsErrorテスト(ページID不正)
 *
 * @return void
 */
	public function testSaveMoveExistsError() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;
		$pageId = '999';
		$roomId = '2';

		//テスト実施
		$data = array(
			'Page' => array('id' => $pageId, 'type' => 'error'),
			'Room' => array('id' => $roomId)
		);
		$result = $this->$model->$methodName($data);
		$this->assertFalse($result);
	}

}
