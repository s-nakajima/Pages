<?php
/**
 * ContainersPageFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('PageContainerFixture', 'Containers.Test/Fixture');

/**
 * ContainersPageFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Fixture
 */
class PageContainer4routesFixture extends PageContainerFixture {

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
	protected $_maxPageId = 12;

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		parent::init();
	}

}
