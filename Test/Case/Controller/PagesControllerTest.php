<?php
/**
 * PagesController Test Case
 *
 * @author   Jun Nishikawa <topaz2@m0n0m0n0.com>
 * @link     http://www.netcommons.org NetCommons Project
 * @license  http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('PagesController', 'Controller');

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
		'app.SiteSetting',
		'app.SiteSettingValue',
		'plugin.PublicSpace.Room',
		'plugin.PublicSpace.Page',
		'plugin.PublicSpace.Box',
		'plugin.PublicSpace.BoxesPage',
		'plugin.PublicSpace.Container',
		'plugin.PublicSpace.ContainersPage',
		'plugin.PublicSpace.Language',
		'plugin.PublicSpace.LanguagesPage',
	);

/**
 * testIndex method
 *
 * @return void
 */
	public function testIndex() {
		$this->testAction('/', array('return' => 'view'));
		$this->assertTextContains('<header id="container-header">', $this->view);
	}

/**
 * testIndexNotFound method
 *
 * @return void
 */
	public function testIndexNotFound() {
		$this->setExpectedException('NotFoundException');
		$this->testAction('/pages/abc');
	}

/**
 * testIndexSetting method
 *
 * @return void
 */
	public function testIndexSetting() {
		$url = '/' . Configure::read('Pages.settingModeWord') . '/';
		$assertText = '<div class="modal fade" '
						. 'id="pluginList" '
						. 'tabindex="-1" '
						. 'role="dialog" '
						. 'aria-labelledby="pluginListLabel" '
						. 'aria-hidden="true">';

		$this->testAction($url, array('return' => 'view'));
		$this->assertTextContains($assertText, $this->view);
	}

}
