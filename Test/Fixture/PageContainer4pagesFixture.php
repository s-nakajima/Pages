<?php
/**
 * PageContainerFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * PageContainerFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Fixture
 */
class PageContainer4pagesFixture extends PageContainerFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'PageContainer';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'page_containers';

/**
 * ページID
 *
 * @var array
 */
	protected $_maxPageId = 9;

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		parent::init();
	}

}
