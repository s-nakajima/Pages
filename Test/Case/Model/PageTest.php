<?php
/**
 * Page Test Case
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
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
		'plugin.pages.room',
		'plugin.pages.page',
		'plugin.pages.container',
		'plugin.pages.containers_page',
		'plugin.pages.languages_page',
		'plugin.pages.language',
		'plugin.pages.box',
		'plugin.pages.boxes_page',
		'plugin.pages.frame',
		'plugin.pages.plugin',
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
 * testGetPageWithFrame method
 *
 * @return void
 */
	public function testGetPageWithFrame() {
		$page = $this->Page->getPageWithFrame('');

		$this->assertCount(4, $page);

		$this->assertArrayHasKey('Page', $page, 'Page');
		$this->assertInternalType('array', $page['Page'], 'Page');
		$this->assertGreaterThanOrEqual(1, count($page['Page']), 'Page');

		$this->assertArrayHasKey('Container', $page, 'Container');
		$this->assertInternalType('array', $page['Container'], 'Container');
		$this->assertGreaterThanOrEqual(1, count($page['Container']));

		$this->assertArrayHasKey('ContainersPage', $page['Container'][0], 'ContainersPage');
		$this->assertInternalType('array', $page['Container'][0]['ContainersPage'], 'ContainersPage');
		$this->assertGreaterThanOrEqual(1, count($page['Container'][0]['ContainersPage']), 'ContainersPage');

		$this->assertArrayHasKey('Box', $page, 'Box');
		$this->assertInternalType('array', $page['Box'], 'Box');
		$this->assertGreaterThanOrEqual(1, count($page['Box']), 'Box');

		$this->assertArrayHasKey('Frame', $page['Box'][0], 'Frame');
		$this->assertInternalType('array', $page['Box'][0]['Frame'], 'Frame');
		$this->assertGreaterThanOrEqual(1, count($page['Box'][0]['Frame']), 'Frame');

		$this->assertArrayHasKey('Plugin', $page['Box'][0]['Frame'][0], 'Plugin');
		$this->assertInternalType('array', $page['Box'][0]['Frame'][0]['Plugin'], 'Plugin');
		//$this->assertEqual(0, count($page['Box'][0]['Frame'][0]['Plugin']));

		$this->assertArrayHasKey('Language', $page['Box'][0]['Frame'][0], 'Frame.Language');
		$this->assertInternalType('array', $page['Box'][0]['Frame'][0]['Language'], 'Frame.Language');
		$this->assertGreaterThanOrEqual(1, count($page['Box'][0]['Frame'][0]['Language']), 'Frame.Language');

		$this->assertArrayHasKey('Language', $page, 'page.Language');
		$this->assertInternalType('array', $page['Language'], 'page.Language');
		$this->assertGreaterThanOrEqual(1, count($page['Language']), 'page.Language');

		$this->assertArrayHasKey('LanguagesPage', $page['Language'][0], 'LanguagesPage');
		$this->assertInternalType('array', $page['Language'][0]['LanguagesPage'], 'LanguagesPage');
		$this->assertGreaterThanOrEqual(1, count($page['Language'][0]['LanguagesPage']), 'LanguagesPage');
	}

/**
 * test savePage method
 *
 * @return void
 */
	public function testSavePage() {
		$data = array(
			'Page' => array(
				'parent_id' => null,
				'slug' => 'test01'
			),
			'Language' => array(
				array(
					'LanguagesPage' => array(
						'language_id' => '1',
						'name' => 'テスト０１'
					)
				)
			)
		);

		$this->Page->create();
		$this->Page->savePage($data);
		$actualPage = $this->Page->findById($this->Page->getLastInsertID());

		$this->assertEquals('test01', $actualPage['Page']['permalink']);
		$actualContainer = array(
			$actualPage['Container'][0]['ContainersPage']['container_id'],
			$actualPage['Container'][1]['ContainersPage']['container_id'],
			$actualPage['Container'][2]['ContainersPage']['container_id'],
			$actualPage['Container'][3]['ContainersPage']['container_id'],
			$actualPage['Container'][4]['ContainersPage']['container_id'],
		);
		sort($actualContainer);
		$this->assertEquals('1', $actualContainer[0]);
		$this->assertEquals('2', $actualContainer[1]);
		$this->assertEquals('4', $actualContainer[2]);
		$this->assertEquals('5', $actualContainer[3]);
		$this->assertEquals('7', $actualContainer[4]);

		$this->assertEquals('1', $actualPage['Box'][0]['BoxesPage']['box_id']);
	}

/**
 * testPermalinkDuplicate method
 *
 * @return void
 */
	public function testPermalinkDuplicate() {
		$data = array(
			'Page' => array(
				'parent_id' => '1',
				'slug' => 'test'
			),
			'Language' => array(
				array(
					'LanguagesPage' => array(
						'language_id' => '1',
						'name' => 'テスト０２'
					)
				)
			)
		);

		$this->Page->create();
		$this->assertFalse($this->Page->savePage($data));
	}

/**
 * testGeneratedPermalink method
 *
 * @return void
 */
	public function testGeneratedPermalink() {
		$data = array(
			'Page' => array(
				'parent_id' => '2',
				'slug' => 'test03'
			),
			'Language' => array(
				array(
					'LanguagesPage' => array(
						'language_id' => '1',
						'name' => 'テスト０３'
					)
				)
			)
		);

		$this->Page->create();
		$actualPage = $this->Page->savePage($data);
		$this->assertEquals('test/test03', $actualPage['Page']['permalink']);
	}
}
