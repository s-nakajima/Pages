<?php
/**
 * LanguagesPage::saveLanguagesPage()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsSaveTest', 'NetCommons.TestSuite');
App::uses('LanguagesPageFixture', 'Pages.Test/Fixture');

/**
 * LanguagesPage::saveLanguagesPage()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Model\LanguagesPage
 */
class LanguagesPageSaveLanguagesPageTest extends NetCommonsSaveTest {

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
	protected $_modelName = 'LanguagesPage';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'saveLanguagesPage';

/**
 * Save用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *
 * @return array テストデータ
 */
	public function dataProviderSave() {
		$data['LanguagesPage'] = (new LanguagesPageFixture())->records[0];
		$data['LanguagesPage']['meta_title'] = 'TEST TITLE - {X-SITE_NAME}';
		$data['LanguagesPage']['meta_description'] = 'TEST DESCRIPTION';
		$data['LanguagesPage']['meta_keywords'] = 'TEST KEYWORD';
		$data['LanguagesPage']['meta_robots'] = null;

		$results = array();
		// * 編集の登録処理
		$results[0] = array($data);
		// * 新規の登録処理
		$results[1] = array($data);
		$results[1] = Hash::insert($results[1], '0.LanguagesPage.id', null);
		$results[1] = Hash::remove($results[1], '0.LanguagesPage.created_user');
		$results[1] = Hash::remove($results[1], '0.LanguagesPage.created');

		return $results;
	}

/**
 * SaveのExceptionError用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド
 *
 * @return array テストデータ
 */
	public function dataProviderSaveOnExceptionError() {
		$data = $this->dataProviderSave()[0][0];

		return array(
			array($data, 'Pages.LanguagesPage', 'save'),
		);
	}

/**
 * SaveのValidationError用DataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - mockModel Mockのモデル
 *  - mockMethod Mockのメソッド(省略可：デフォルト validates)
 *
 * @return array テストデータ
 */
	public function dataProviderSaveOnValidationError() {
		$data = $this->dataProviderSave()[0][0];

		return array(
			array($data, 'Pages.LanguagesPage'),
		);
	}

}
