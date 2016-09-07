<?php
/**
 * Page::getTopPageId()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsGetTest', 'NetCommons.TestSuite');

/**
 * Page::getTopPageId()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Model\Page
 */
class PageGetTopPageIdTest extends NetCommonsGetTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.pages.languages_page',
		'plugin.pages.page',
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
	protected $_methodName = 'getTopPageId';

/**
 * getTopPageId()のテスト
 *
 * @return void
 */
	public function testGetTopPageId() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成

		//テスト実施
		$result = $this->$model->$methodName();

		//チェック
		$this->assertEquals('1', $result);
	}

}
