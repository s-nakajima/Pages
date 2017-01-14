<?php
/**
 * FrameFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FramePublicLanguageFixture', 'Frames.Test/Fixture');

/**
 * FrameFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Fixture
 */
class FramePublicLanguage4pagesFixture extends FramePublicLanguageFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'FramePublicLanguage';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'frame_public_languages';

/**
 * Records
 *
 * @var array
 */
	protected $_records = array(
		//ヘッダー
		array(
			'frame_id' => '1',
			'language_id' => '0',
			'is_public' => '1',
		),
		//レフト
		array(
			'frame_id' => '2',
			'language_id' => '0',
			'is_public' => '1',
		),
		//ライト
		array(
			'frame_id' => '3',
			'language_id' => '0',
			'is_public' => '1',
		),
		//フッター
		array(
			'frame_id' => '4',
			'language_id' => '0',
			'is_public' => '1',
		),
		//メイン
		array(
			'frame_id' => '6',
			'language_id' => '0',
			'is_public' => '1',
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		parent::init();
	}

}
