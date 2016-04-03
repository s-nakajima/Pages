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
		);
	}

}