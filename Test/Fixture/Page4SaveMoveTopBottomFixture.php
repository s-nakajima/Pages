<?php
/**
 * Page4SaveMoveTopBottomFixture
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('PageFixture', 'Pages.Test/Fixture');

/**
 * Page4SaveMoveTopBottomFixture
 *
 */
class Page4SaveMoveTopBottomFixture extends PageFixture {

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
		// パブリックスペースのページ（使われることはない）
		array(
			'id' => '1', 'room_id' => '2', 'root_id' => null,
			'parent_id' => null,
			//'lft' => '1', 'rght' => '10',
			'weight' => '1',
			'sort_key' => '~00000001',
			'child_count' => '4',
			'permalink' => '', 'slug' => null,
		),
		// /home
		array(
			'id' => '4', 'room_id' => '2', 'root_id' => '1',
			'parent_id' => '1',
			//'lft' => '2', 'rght' => '9',
			'weight' => '1',
			'sort_key' => '~00000001-00000001',
			'child_count' => '3',
			'permalink' => 'home', 'slug' => 'home',
		),
		// home/tree05
		array(
			'id' => '5', 'room_id' => '2', 'root_id' => '1',
			'parent_id' => '4',
			//'lft' => '3', 'rght' => '4',
			'weight' => '1',
			'sort_key' => '~00000001-00000001-00000001',
			'child_count' => '0',
			'permalink' => 'tree05', 'slug' => 'tree05',
		),
		// ホーム/tree06
		array(
			'id' => '6', 'room_id' => '2', 'root_id' => '1',
			'parent_id' => '4',
			//'lft' => '5', 'rght' => '6',
			'weight' => '2',
			'sort_key' => '~00000001-00000001-00000002',
			'child_count' => '0',
			'permalink' => 'tree06', 'slug' => 'tree06',
		),
		// ホーム/tree07
			array(
			'id' => '7', 'room_id' => '2', 'root_id' => '1',
			'parent_id' => '4',
			//'lft' => '7', 'rght' => '8',
			'weight' => '3',
			'sort_key' => '~00000001-00000001-00000003',
			'child_count' => '0',
			'permalink' => 'tree07', 'slug' => 'tree07',
		),
	);

}
