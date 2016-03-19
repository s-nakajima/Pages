<?php
/**
 * Page::existPage()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsModelTestCase', 'NetCommons.TestSuite');

/**
 * Page::existPage()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Model\Page
 */
class PageExistPageTest extends NetCommonsModelTestCase {

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
	protected $_methodName = 'existPage';

/**
 * existPage()のテスト(存在するページ)
 *
 * @return void
 */
	public function testExistPageTrue() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		Current::write('Room.id', '1');
		$pageId = '1';

		//テスト実施
		$result = $this->$model->$methodName($pageId);

		//チェック
		$this->assertTrue($result);
	}

/**
 * existPage()のテスト(存在しないページ)
 *
 * @return void
 */
	public function testExistPageFalse() {
		$model = $this->_modelName;
		$methodName = $this->_methodName;

		//データ生成
		Current::write('Room.id', '1');
		$pageId = '999';

		//テスト実施
		$result = $this->$model->$methodName($pageId);

		//チェック
		$this->assertFalse($result);
	}

}
