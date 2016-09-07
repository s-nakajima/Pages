<?php
/**
 * LanguagesPage::validate()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsValidateTest', 'NetCommons.TestSuite');
App::uses('LanguagesPageFixture', 'Pages.Test/Fixture');

/**
 * LanguagesPage::validate()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Model\LanguagesPage
 */
class LanguagesPageValidateTest extends NetCommonsValidateTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.pages.languages_page4pages',
		'plugin.pages.page4pages',
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
	protected $_methodName = 'validates';

/**
 * ValidationErrorのDataProvider
 *
 * ### 戻り値
 *  - data 登録データ
 *  - field フィールド名
 *  - value セットする値
 *  - message エラーメッセージ
 *  - overwrite 上書きするデータ(省略可)
 *
 * @return array テストデータ
 */
	public function dataProviderValidationError() {
		$data['LanguagesPage'] = (new LanguagesPageFixture())->records[0];

		return array(
			// * name
			array('data' => $data, 'field' => 'name', 'value' => '',
				'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('pages', 'Page name'))),
			// * page_id
			array('data' => $data, 'field' => 'page_id', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			// * language_id
			array('data' => $data, 'field' => 'language_id', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			// * meta_title
			array('data' => $data, 'field' => 'meta_title', 'value' => '',
				'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('pages', 'Title tag'))),
		);
	}

/**
 * LanguagesPage.meta_titleがデフォルト値と同じ場合、空値になるテスト用DataProvider
 *
 * ### 戻り値
 *  - metaTitle 入力メタタイトル
 *  - expected 期待値のメタタイトル
 *
 * @return array テストデータ
 */
	public function dataProviderMetaTitle() {
		return array(
			array('metaTitle' => '{X-PAGE_NAME} - {X-SITE_NAME}', 'expected' => ''),
			array('metaTitle' => 'TEST TITLE - {X-SITE_NAME}', 'expected' => 'TEST TITLE - {X-SITE_NAME}'),
		);
	}

/**
 * LanguagesPage.meta_titleがデフォルト値と同じ場合、空値になるテスト
 *
 * @param string $metaTitle 入力メタタイトル
 * @param string $expected 期待値のメタタイトル
 * @dataProvider dataProviderMetaTitle
 * @return void
 */
	public function testMetaTitle($metaTitle, $expected) {
		$model = $this->_modelName;

		$data['LanguagesPage'] = (new LanguagesPageFixture())->records[0];
		$data['LanguagesPage']['meta_title'] = $metaTitle;

		//validate処理実行
		$this->$model->set($data);
		$result = $this->$model->validates();
		$this->assertTrue($result);

		$this->assertEquals($this->$model->data['LanguagesPage']['meta_title'], $expected);
	}

}
