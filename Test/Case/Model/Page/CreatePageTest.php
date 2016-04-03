<?php
/**
 * Page::createPage()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * Page::createPage()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Model\Page
 */
class PageCreatePageTest extends NetCommonsModelTestCase {

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
	protected $_methodName = 'createPage';

/**
 * createPage()のテスト
 *
 * @return void
 */
	public function testCreatePage() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		Current::write('Page', array(
			'id' => '1',
			'root_id' => null,
		));
		//テスト実施
		$result = $this->$model->$methodName();

		//チェック
		$this->assertEquals(array('Page', 'LanguagesPage'), array_keys($result));
		$this->assertEquals('1', Hash::get($result, 'Page.root_id'));
		$this->assertEquals('1', Hash::get($result, 'Page.parent_id'));
		$this->assertRegExp('/page_20[0-9]{2}[0-9]{10}/', Hash::get($result, 'Page.permalink'));
		$this->assertRegExp('/page_20[0-9]{2}[0-9]{10}/', Hash::get($result, 'Page.slug'));
	}

/**
 * createPage()のテスト(root_idがある)
 *
 * @return void
 */
	public function testCreatePageWRootId() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		Current::write('Page', array(
			'id' => '4',
			'root_id' => '1',
		));
		//テスト実施
		$result = $this->$model->$methodName();

		//チェック
		$this->assertEquals(array('Page', 'LanguagesPage'), array_keys($result));
		$this->assertEquals('1', Hash::get($result, 'Page.root_id'));
		$this->assertEquals('4', Hash::get($result, 'Page.parent_id'));
		$this->assertRegExp('/page_20[0-9]{2}[0-9]{10}/', Hash::get($result, 'Page.permalink'));
		$this->assertRegExp('/page_20[0-9]{2}[0-9]{10}/', Hash::get($result, 'Page.slug'));
	}

}