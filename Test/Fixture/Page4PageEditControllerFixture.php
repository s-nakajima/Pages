<?php
/**
 * Page4PageEditControllerFixture
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('PageFixture', 'Pages.Test/Fixture');

/**
 * Page4PageEditControllerFixture
 *
 */
class Page4PageEditControllerFixture extends PageFixture {

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
			'id' => '1', 'room_id' => '2', 'root_id' => null, 'parent_id' => null, 'lft' => '1', 'rght' => '14',
			'permalink' => '', 'slug' => null,
		),
		//パブリックスペースのホーム
		array(
			'id' => '4', 'room_id' => '2', 'root_id' => '1', 'parent_id' => '1', 'lft' => '2', 'rght' => '5',
			'permalink' => 'home', 'slug' => 'home',
		),
		//ホーム/test4
		array(
			'id' => '7', 'room_id' => '2', 'root_id' => '1', 'parent_id' => '4', 'lft' => '3', 'rght' => '4',
			'permalink' => 'test4', 'slug' => 'test4',
		),
		//パブリックスペースのtest5
		array(
			'id' => '8', 'room_id' => '2', 'root_id' => '1', 'parent_id' => '1', 'lft' => '6', 'rght' => '7',
			'permalink' => 'test5', 'slug' => 'test5',
		),
		//プライベートスペースのページ（使われることはない）
		array(
			'id' => '2', 'room_id' => '3', 'root_id' => null, 'parent_id' => null, 'lft' => '15', 'rght' => '16',
			'permalink' => '', 'slug' => null,
		),
		//グループスペースのページ（使われることはない）
		array(
			'id' => '3', 'room_id' => '4', 'root_id' => null, 'parent_id' => null, 'lft' => '17', 'rght' => '18',
			'permalink' => '', 'slug' => null,
		),
		//別ルーム(room_id=4)
		array(
			'id' => '5', 'room_id' => '5', 'root_id' => '1', 'parent_id' => '1', 'lft' => '8', 'rght' => '11',
			'permalink' => 'test2', 'slug' => 'test2',
		),
		array(
			'id' => '9', 'room_id' => '5', 'root_id' => '1', 'parent_id' => '5', 'lft' => '9', 'rght' => '10',
			'permalink' => 'test2/home', 'slug' => 'home',
		),
		//別ルーム(room_id=5、ブロックなし)
		array(
			'id' => '6', 'room_id' => '6', 'root_id' => '1', 'parent_id' => '1', 'lft' => '12', 'rght' => '13',
			'permalink' => 'test3', 'slug' => 'test3',
		),
	);

}
