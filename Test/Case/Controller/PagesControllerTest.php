<?php
/**
 * PagesController Test Case
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('PagesController', 'Controller');
App::uses('Page', 'Pages.Model');

/**
 * Summary for PagesController Test Case
 */
class PagesControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.blocks.block',
		'plugin.blocks.block_role_permission',
		'plugin.boxes.box',
		'plugin.boxes.boxes_page',
		'plugin.containers.container',
		'plugin.containers.containers_page',
		'plugin.frames.frame',
		'plugin.m17n.language',
		'plugin.m17n.languages_page',
		'plugin.net_commons.plugin',
		'plugin.net_commons.site_setting',
		'plugin.pages.page',
		'plugin.roles.default_role_permission',
		'plugin.rooms.roles_rooms_user',
		'plugin.rooms.plugins_room',
		'plugin.rooms.room',
		'plugin.rooms.room_role_permission',
		'plugin.users.user',
	);

/**
 * setUp
 *
 * @return   void
 */
	public function setUp() {
		parent::setUp();
		$this->generate('Pages.Pages');

		Configure::write('NetCommons.installed', true);
		Page::unsetIsSetting();
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$this->testAction('/', array('return' => 'view'));
		$this->assertTextContains('<header id="container-header">', $this->view);
		$this->assertEquals(5, count($this->vars['page']['Container']));
	}

/**
 * testIndex method
 *
 * @return void
 */
	public function testPermalink() {
		$this->testAction('/test', array('return' => 'vars'));
		$this->assertEquals(1, count($this->vars['page']['Container']));
	}

/**
 * testIndexNotFound method
 * It is affected by slug routing
 *
 * @return void
 */
	//public function testIndexNotFound() {
	//	$this->setExpectedException('NotFoundException');
	//	$this->testAction('/notFound');
	//}

/**
 * testIndexSetting method
 *
 * @return void
 */
	public function testIndexSetting() {
		$url = '/' . Page::SETTING_MODE_WORD . '/';
		$needle = '<div class="modal fade" ' .
			'id="pluginList" ' .
			'tabindex="-1" ' .
			'role="dialog" ' .
			'aria-labelledby="pluginListLabel" ' .
			'aria-hidden="true">';

		$this->testAction($url, array('return' => 'view'));
		$this->assertTextContains($needle, $this->view);
	}

/**
 * testAdd method
 *
 * @return void
 */
	public function testAdd() {
		$controller = $this->generate('Pages.Pages', array(
			'models' => array(
				'Pages.Page' => array('savePage')
			)
		));
		$controller->Page->expects($this->once())
			->method('savePage')
			->will($this->returnValue(true));

		$this->testAction('/pages/pages/add');
	}

/**
 * testAddError method
 *
 * @return void
 */
	public function testAddError() {
		$controller = $this->generate('Pages.Pages', array(
			'models' => array(
				'Pages.Page' => array('savePage')
			)
		));
		$controller->Page->expects($this->once())
			->method('savePage')
			->will($this->returnValue(false));

		$this->testAction('/pages/pages/add');
	}
}
