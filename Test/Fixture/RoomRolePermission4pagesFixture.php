<?php
/**
 * RoomRolePermission4testFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RoomRolePermissionFixture', 'Rooms.Test/Fixture');

/**
 * RoomRolePermission4testFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Fixture
 */
class RoomRolePermission4pagesFixture extends RoomRolePermissionFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'RoomRolePermission';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'room_role_permissions';

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		//パブリックスペース
		$this->records[] = array('roles_room_id' => '1', 'permission' => 'page_editable', 'value' => '1');
		$this->records[] = array('roles_room_id' => '2', 'permission' => 'page_editable', 'value' => '1');
		$this->records[] = array('roles_room_id' => '3', 'permission' => 'page_editable', 'value' => '0');
		$this->records[] = array('roles_room_id' => '4', 'permission' => 'page_editable', 'value' => '0');
		$this->records[] = array('roles_room_id' => '5', 'permission' => 'page_editable', 'value' => '0');

		//サイト全体
		$this->records[] = array('roles_room_id' => '15', 'permission' => 'page_editable', 'value' => '1');

		parent::init();
	}

}
