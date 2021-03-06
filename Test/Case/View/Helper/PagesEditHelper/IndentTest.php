<?php
/**
 * PagesEditHelper::indent()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('PagesHelperTestCase', 'Pages.TestSuite');

/**
 * PagesEditHelper::indent()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\View\Helper\PagesEditHelper
 */
class PagesEditHelperIndentTest extends PagesHelperTestCase {

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
 * DataProvider
 *
 * ### 戻り値
 *  - nest インデントのネスト数
 *
 * @return array テストデータ
 */
	public function dataProvider() {
		return array(
			array('nest' => 0),
			array('nest' => 1),
			array('nest' => 2),
			array('nest' => 3),
		);
	}

/**
 * indent()のテスト
 *
 * @param int $nest インデントのネスト数
 * @dataProvider dataProvider
 * @return void
 */
	public function testIndent($nest) {
		//データ生成
		$pageId = '2';
		$parentId = '1';

		//Helperロード
		$viewVars = array();
		$viewVars = Hash::insert($viewVars, 'pages.' . $pageId . '.Page.parent_id', $parentId);
		$viewVars = Hash::insert($viewVars, 'parentList._' . $parentId . '._' . $pageId . '.nest', $nest);

		$requestData = array();
		$params = array();
		$this->loadHelper('Pages.PagesEdit', $viewVars, $requestData, $params);

		//テスト実施
		$result = $this->PagesEdit->indent($pageId);

		//チェック
		$this->assertEquals($nest, preg_match_all('/' . preg_quote('<span class="pages-tree"> </span>', '/') . '/', $result));
	}

}
