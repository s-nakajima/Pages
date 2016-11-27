<?php
/**
 * FramesLanguageFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('FramesLanguageFixture', 'Frames.Test/Fixture');

/**
 * FramesLanguageFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Fixture
 */
class FramesLanguage4pagesFixture extends FramesLanguageFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'FramesLanguage';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'frames_languages';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//ヘッダー
		array(
			'id' => '1',
			'language_id' => '2',
			'frame_id' => '1',
			'name' => 'Test frame header',
			'is_origin' => true,
			'is_translation' => false,
		),
		//レフト
		array(
			'id' => '2',
			'language_id' => '2',
			'frame_id' => '2',
			'name' => 'Test frame major',
			'is_origin' => true,
			'is_translation' => false,
		),
		//ライト
		array(
			'id' => '3',
			'language_id' => '2',
			'frame_id' => '3',
			'name' => 'Test frame minor',
			'is_origin' => true,
			'is_translation' => false,
		),
		//フッター
		array(
			'id' => '4',
			'language_id' => '2',
			'frame_id' => '4',
			'name' => 'Test frame footer',
			'is_origin' => true,
			'is_translation' => false,
		),
		//メイン
		array(
			'id' => '6',
			'language_id' => '2',
			'frame_id' => '6',
			'name' => 'Test frame main',
			'is_origin' => true,
			'is_translation' => false,
		),
	);

}
