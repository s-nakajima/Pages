<?php
/**
 * PageAssociationsBehavior::saveBox()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('PagesModelTestCase', 'Pages.TestSuite');

/**
 * PageAssociationsBehavior::saveBox()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Model\Behavior\PageAssociationsBehavior
 */
class PageAssociationsBehaviorSaveBoxTest extends PagesModelTestCase {

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
		$this->TestModel = ClassRegistry::init('TestPages.TestPageAssociationsBehaviorModel');

		//事前チェック用
		$this->Box = ClassRegistry::init('Boxes.Box');
	}

/**
 * saveBox()テストのDataProvider
 *
 * ### 戻り値
 *  - page ページデータ
 *
 * @return array データ
 */
	public function dataProvider() {
		$result[0] = array();
		$result[0]['page'] = array(
			'Page' => array('id' => '99', 'room_id' => '10'),
			'Room' => array('space_id' => '2'),
		);

		return $result;
	}

/**
 * saveBox()のテスト
 *
 * @param array $page ページデータ
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveBox($page) {
		//事前チェック
		$count = $this->Box->find('count', array(
			'recursive' => -1,
			'conditions' => array('page_id' => Hash::get($page, 'Page.id')),
		));
		$this->assertEquals(0, $count);

		//テスト実施
		$result = $this->TestModel->saveBox($page);
		$result = Hash::remove($result, '{s}.{n}.{s}.created');
		$result = Hash::remove($result, '{s}.{n}.{s}.modified');

		//戻り値チェック
		$expected = array(
			'Box' => array(
				1 => array(
					'Box' => array(
						'type' => '4', 'space_id' => '2', 'room_id' => '10', 'page_id' => '99',
						'container_type' => '1', 'id' => '64',
					),
				),
				2 => array(
					'Box' => array(
						'type' => '4', 'space_id' => '2', 'room_id' => '10', 'page_id' => '99',
						'container_type' => '2', 'id' => '65',
					),
				),
				3 => array(
					'Box' => array(
						'type' => '4', 'space_id' => '2', 'room_id' => '10', 'page_id' => '99',
						'container_type' => '3', 'id' => '66',
					),
				),
				4 => array(
					'Box' => array(
						'type' => '4', 'space_id' => '2', 'room_id' => '10', 'page_id' => '99',
						'container_type' => '4', 'id' => '67',
					),
				),
				5 => array(
					'Box' => array(
						'type' => '4', 'space_id' => '2', 'room_id' => '10', 'page_id' => '99',
						'container_type' => '5', 'id' => '68',
					),
				),
			),
		);
		$this->assertEquals($expected, $result);

		//データチェック
		$count = $this->TestModel->Box->find('count', array(
			'recursive' => -1,
			'conditions' => array('page_id' => Hash::get($page, 'Page.id')),
		));
		$this->assertEquals(5, $count);
	}

/**
 * saveBox()のExceptionErrorテスト
 *
 * @param array $page ページデータ
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveBoxOnExceptionError($page) {
		$this->_mockForReturnFalse('TestModel', 'Boxes.Box', 'save');

		//テスト実施
		$this->setExpectedException('InternalErrorException');
		$this->TestModel->saveBox($page);
	}

}
