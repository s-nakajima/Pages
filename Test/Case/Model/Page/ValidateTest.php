<?php
/**
 * Page::validate()のテスト
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsValidateTest', 'NetCommons.TestSuite');
App::uses('PageFixture', 'Pages.Test/Fixture');

/**
 * Page::validate()のテスト
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Case\Model\Page
 */
class PageValidateTest extends NetCommonsValidateTest {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'plugin.pages.pages_language4pages',
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
	protected $_modelName = 'Page';

/**
 * Method name
 *
 * @var string
 */
	protected $_methodName = 'validates';

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();

		//純粋にバリデーションのテストを行いたいため、ビヘイビアをunloadする
		$this->Page->Behaviors->unload('Pages.SavePage');
	}

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
 * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
 */
	public function dataProviderValidationError() {
		$data['Page'] = (new PageFixture())->records[2];
		$data['Page']['permalink'] = 'dummy';

		$slugMessage = sprintf(
			__d('pages', 'Use of %s is prohibited. Please enter a different entry.'),
			__d('pages', 'Slug')
		);
		return array(
			// * slug
			array('data' => $data, 'field' => 'slug', 'value' => '',
				'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('pages', 'Slug'))),
			// ** NGワード
			// 「%」「 」「#」「<」「>」「+」「\」「"」「'」「&」「?」「=」「~」「:」「;」「,」「$」「@」
			// 「./」「/.」「.$(最後にドット)」「^.(最初にドット)」「|」「]」「[」「!」「(」「)」「*」
			array('data' => $data, 'field' => 'slug', 'value' => '%aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa%aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa%', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => ' aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa ', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '#aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa#aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa#', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '<aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa<aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa<', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '>aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa>aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa>', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '<aaa></aaa>', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '+aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa+aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa+', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '\aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa\naa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa\\aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa\\', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '"aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa"aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa"', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '"aaa""aaa"', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => "'aaaaaa", 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => "aaa'aaa", 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => "aaaaaa'", 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => "'aaaaaa'", 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '&aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa&aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa&', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '&amp;&nbsp;', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '?aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa?aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa?', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '=aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa=aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa=', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '~aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa~aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa~', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => ':aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa:aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa:', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => ';aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa;aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa;', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => ',aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa,aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa,', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '$aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa$aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa$', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '@aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa@aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa@', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '/aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa/', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => './aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa./aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa./', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '/.aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa/.aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa/.', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '.aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '..', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '.', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa.', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '|aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa|aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa|', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '[aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa[aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa]', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => ']aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa]aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa]', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '[aaaaaa]', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '!aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa!aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa!', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '(aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa(aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa(', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => ')aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa)aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa)', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '(aaaaaa)', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '*aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa*aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaaaaa*', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => '@aaaaaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa.*aaa', 'message' => $slugMessage),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaa/aaa', 'message' => true),
			array('data' => $data, 'field' => 'slug', 'value' => 'aaabaaa', 'message' => true),

			// * permalink
			array('data' => $data, 'field' => 'permalink', 'value' => '',
				'message' => sprintf(__d('net_commons', 'Please input %s.'), __d('pages', 'Slug'))),
			array('data' => $data, 'field' => 'permalink', 'value' => 'home',
				'message' => sprintf(__d('net_commons', '%s is already in use.'), __d('pages', 'Slug'))),
			array('data' => $data, 'field' => 'permalink', 'value' => '%aaaaaa',
				'message' => sprintf(
					__d('pages', 'Use of %s is prohibited. Please enter a different entry.'),
					__d('pages', 'Slug')
				)),
			// * root_id
			array('data' => $data, 'field' => 'root_id', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			// * is_container_fluid
			array('data' => $data, 'field' => 'is_container_fluid', 'value' => 'a',
				'message' => __d('net_commons', 'Invalid request.')),
			array('data' => $data, 'field' => 'is_container_fluid', 'value' => '2',
				'message' => __d('net_commons', 'Invalid request.')),
			// * theme
			array('data' => $data, 'field' => 'theme', 'value' => 'A',
				'message' => __d('net_commons', 'Invalid request.')),
		);
	}

}
