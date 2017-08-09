<?php
/**
 * RolesRoomsUser4testFixture
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('RolesRoomsUserFixture', 'Rooms.Test/Fixture');

/**
 * RolesRoomsUser4testFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Rooms\Test\Fixture
 */
class RolesRoomsUser4pagesFixture extends RolesRoomsUserFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'RolesRoomsUser';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'roles_rooms_users';

/**
 * Records
 *
 * @var array
 */
	protected $_addRecords = array(
		//管理者のプライベート
		// * room_id=7、ユーザID=1
		array(
			'roles_room_id' => '16',
			'user_id' => '1',
			'room_id' => '7',
		),
	);

/**
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		parent::init();

		$this->records = array_merge($this->records, $this->_addRecords);
	}

}
