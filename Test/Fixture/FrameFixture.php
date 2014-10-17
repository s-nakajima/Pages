<?php
/**
 * FrameFixture
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

/**
 * Summary for FrameFixture
 */
class FrameFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'language_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 6),
		'room_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'box_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'plugin_key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'block_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'key' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Key of the frame.', 'charset' => 'utf8'),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'comment' => 'Name of the frame.', 'charset' => 'utf8'),
		'weight' => array('type' => 'integer', 'null' => true, 'default' => null, 'comment' => 'Display order.'),
		'is_published' => array('type' => 'boolean', 'null' => true, 'default' => null, 'comment' => '一般以下のパートが閲覧可能かどうか。

ルーム配下ならルーム管理者、またはそれに準ずるユーザ(room_parts.edit_page, room_parts.create_page 双方が true のユーザ)はこの値に関わらず閲覧できる。
e.g.) ルーム管理者、またはそれに準ずるユーザ: ルーム管理者、編集長'),
		'from' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'Datetime display frame from.'),
		'to' => array('type' => 'datetime', 'null' => true, 'default' => null, 'comment' => 'Datetime display frame to.'),
		'created_user' => array('type' => 'integer', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified_user' => array('type' => 'integer', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1),
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB'),
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'language_id' => 2,
			'room_id' => 1,
			'box_id' => 1,
			'plugin_key' => 'menus',
			'block_id' => 5,
			'weight' => 1,
			'is_published' => 1,
			'from' => '2014-07-25 08:10:53',
			'to' => '2014-07-25 08:10:53',
			'created_user' => 1,
			'created' => '2014-07-25 08:10:53',
			'modified_user' => 1,
			'modified' => '2014-07-25 08:10:53'
		),
		array(
			'id' => 2,
			'language_id' => 2,
			'room_id' => 2,
			'box_id' => 2,
			'plugin_key' => 'menus',
			'block_id' => 2,
			'weight' => 2,
			'is_published' => 1,
			'from' => '2014-07-25 08:10:53',
			'to' => '2014-07-25 08:10:53',
			'created_user' => 2,
			'created' => '2014-07-25 08:10:53',
			'modified_user' => 2,
			'modified' => '2014-07-25 08:10:53'
		),
		array(
			'id' => 3,
			'language_id' => 2,
			'room_id' => 3,
			'box_id' => 3,
			'plugin_key' => 'menus',
			'block_id' => 3,
			'weight' => 3,
			'is_published' => 1,
			'from' => '2014-07-25 08:10:53',
			'to' => '2014-07-25 08:10:53',
			'created_user' => 3,
			'created' => '2014-07-25 08:10:53',
			'modified_user' => 3,
			'modified' => '2014-07-25 08:10:53'
		),
		array(
			'id' => 4,
			'language_id' => 2,
			'room_id' => 4,
			'box_id' => 4,
			'plugin_key' => 'menus',
			'block_id' => 4,
			'weight' => 4,
			'is_published' => 1,
			'from' => '2014-07-25 08:10:53',
			'to' => '2014-07-25 08:10:53',
			'created_user' => 4,
			'created' => '2014-07-25 08:10:53',
			'modified_user' => 4,
			'modified' => '2014-07-25 08:10:53'
		),
		array(
			'id' => 5,
			'language_id' => 2,
			'room_id' => 5,
			'box_id' => 5,
			'plugin_key' => 'menus',
			'block_id' => 5,
			'weight' => 5,
			'is_published' => 1,
			'from' => '2014-07-25 08:10:53',
			'to' => '2014-07-25 08:10:53',
			'created_user' => 5,
			'created' => '2014-07-25 08:10:53',
			'modified_user' => 5,
			'modified' => '2014-07-25 08:10:53'
		),
		array(
			'id' => 6,
			'language_id' => 2,
			'room_id' => 6,
			'box_id' => 6,
			'plugin_key' => 'menus',
			'block_id' => 6,
			'weight' => 6,
			'is_published' => 1,
			'from' => '2014-07-25 08:10:53',
			'to' => '2014-07-25 08:10:53',
			'created_user' => 6,
			'created' => '2014-07-25 08:10:53',
			'modified_user' => 6,
			'modified' => '2014-07-25 08:10:53'
		),
		array(
			'id' => 7,
			'language_id' => 2,
			'room_id' => 7,
			'box_id' => 7,
			'plugin_key' => 'menus',
			'block_id' => 7,
			'weight' => 7,
			'is_published' => 1,
			'from' => '2014-07-25 08:10:53',
			'to' => '2014-07-25 08:10:53',
			'created_user' => 7,
			'created' => '2014-07-25 08:10:53',
			'modified_user' => 7,
			'modified' => '2014-07-25 08:10:53'
		),
		array(
			'id' => 8,
			'language_id' => 2,
			'room_id' => 8,
			'box_id' => 8,
			'plugin_key' => 'menus',
			'block_id' => 8,
			'weight' => 8,
			'is_published' => 1,
			'from' => '2014-07-25 08:10:53',
			'to' => '2014-07-25 08:10:53',
			'created_user' => 8,
			'created' => '2014-07-25 08:10:53',
			'modified_user' => 8,
			'modified' => '2014-07-25 08:10:53'
		),
		array(
			'id' => 9,
			'language_id' => 2,
			'room_id' => 9,
			'box_id' => 9,
			'plugin_key' => 'menus',
			'block_id' => 9,
			'weight' => 9,
			'is_published' => 1,
			'from' => '2014-07-25 08:10:53',
			'to' => '2014-07-25 08:10:53',
			'created_user' => 9,
			'created' => '2014-07-25 08:10:53',
			'modified_user' => 9,
			'modified' => '2014-07-25 08:10:53'
		),
		array(
			'id' => 10,
			'language_id' => 2,
			'room_id' => 10,
			'box_id' => 10,
			'plugin_key' => 'menus',
			'block_id' => 10,
			'weight' => 10,
			'is_published' => 1,
			'from' => '2014-07-25 08:10:53',
			'to' => '2014-07-25 08:10:53',
			'created_user' => 10,
			'created' => '2014-07-25 08:10:53',
			'modified_user' => 10,
			'modified' => '2014-07-25 08:10:53'
		),
	);

}
