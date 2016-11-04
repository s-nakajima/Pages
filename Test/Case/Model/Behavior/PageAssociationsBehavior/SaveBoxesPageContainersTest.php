<?php
/**
 * PageAssociationsBehavior::saveBoxesPageContainers()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * PageAssociationsBehavior::saveBoxesPageContainers()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Model\Behavior\PageAssociationsBehavior
 */
class PageAssociationsBehaviorSaveBoxesPageContainersTest extends NetCommonsModelTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array();

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
		$this->BoxesPageContainer = ClassRegistry::init('Boxes.BoxesPageContainer');
	}

/**
 * saveBoxesPageContainers()テストのDataProvider
 *
 * ### 戻り値
 *  - page ページデータ
 *
 * @return array データ
 */
	public function dataProvider() {
		$result[0] = array();
		$result[0]['page'] = array(
			'Page' => array('id' => '99', 'room_id' => '10','parent_id' => '2'),
			'Room' => array('id' => '10', 'space_id' => '1'),
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
			'PageContainer' => array(
				1 => array(
					'PageContainer' => array(
						'page_id' => '99', 'container_type' => '1',
						'is_published' => true, 'is_configured' => false, 'id' => '46',
					),
				),
				2 => array(
					'PageContainer' => array(
						'page_id' => '99', 'container_type' => '2',
						'is_published' => true, 'is_configured' => false, 'id' => '47',
					),
				),
				3 => array(
					'PageContainer' => array(
						'page_id' => '99', 'container_type' => '3',
						'is_published' => true, 'is_configured' => false, 'id' => '48',
					),
				),
				4 => array(
					'PageContainer' => array(
						'page_id' => '99', 'container_type' => '4',
						'is_published' => true, 'is_configured' => false, 'id' => '49',
					),
				),
				5 => array(
					'PageContainer' => array(
						'page_id' => '99', 'container_type' => '5',
						'is_published' => true, 'is_configured' => false, 'id' => '50',
					),
				),
			),
		);

		return $result;
	}

/**
 * saveBoxesPageContainers()のテスト
 *
 * @param array $page ページデータ
 * @dataProvider dataProvider
 * @return void
 */
	public function testSaveBoxesPageContainers($page) {
		//事前チェック
		$count = $this->BoxesPageContainer->find('count', array(
			'recursive' => -1,
			'conditions' => array('page_id' => Hash::get($page, 'Page.id')),
		));
		$this->assertEquals(0, $count);

		//テスト実施
		$result = $this->TestModel->saveBoxesPageContainers($page);

		//戻り値チェック
		$this->assertTrue($result);

		//データチェック
		$count = $this->TestModel->BoxesPageContainer->find('count', array(
			'recursive' => -1,
			'conditions' => array('page_id' => Hash::get($page, 'Page.id')),
		));
		$this->assertEquals(17, $count);
	}

}
