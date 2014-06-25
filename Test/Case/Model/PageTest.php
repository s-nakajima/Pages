<?php
/**
 * Page Test Case
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@netcommons.org>
 * @since 3.0.0.0
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('Page', 'Pages.Model');

/**
 * Summary for Page Test Case
 */
class PageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.pages.page',
		//'plugin.pages.box',
		//'plugin.pages.page',
		//'plugin.pages.containers_page'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Page = ClassRegistry::init('Pages.Page');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Page);

		parent::tearDown();
	}

/**
 * test method
 *
 * @return void
 */
	public function test() {
	}

}
