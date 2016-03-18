<?php
/**
 * Unitテスト用Fixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('PageFixture', 'Pages.Test/Fixture');

/**
 * Unitテスト用Fixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Fixture
 */
class Page4testFixture extends PageFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'Page';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'pages';

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		//パブリックスペースのページ（使われることはない）
		array(
			'id' => '1', 'room_id' => '1', 'root_id' => null, 'parent_id' => null, 'lft' => '1', 'rght' => '4',
			'permalink' => '', 'slug' => null,
		),
		//トップページのページ
		array(
			'id' => '4', 'room_id' => '1', 'root_id' => '1', 'parent_id' => '1', 'lft' => '2', 'rght' => '3',
			'permalink' => 'home', 'slug' => 'home',
		),
		//プライベートスペースのページ（使われることはない）
		array(
			'id' => '2', 'room_id' => '2', 'root_id' => null, 'parent_id' => null, 'lft' => '5', 'rght' => '6',
			'permalink' => '', 'slug' => null,
		),
		//グループスペースのページ（使われることはない）
		array(
			'id' => '3', 'room_id' => '3', 'root_id' => null, 'parent_id' => null, 'lft' => '7', 'rght' => '12',
			'permalink' => '', 'slug' => null,
		),
		//別ルーム(room_id=4)
		array(
			'id' => '5', 'room_id' => '4', 'root_id' => '3', 'parent_id' => '3', 'lft' => '8', 'rght' => '9',
			'permalink' => 'test2', 'slug' => 'test2',
		),
		//別ルーム(room_id=5、ブロックなし)
		array(
			'id' => '6', 'room_id' => '5', 'root_id' => '3', 'parent_id' => '3', 'lft' => '10', 'rght' => '11',
			'permalink' => 'test3', 'slug' => 'test3',
		),
	);

}
