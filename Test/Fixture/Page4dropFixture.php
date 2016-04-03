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
class Page4dropFixture extends PageFixture {

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
 * Initialize the fixture.
 *
 * @return void
 */
	public function init() {
		$db = ConnectionManager::getDataSource($this->useDbConfig);
		$this->drop($db);
	}

/**
 * Run before all tests execute, should return SQL statement to create table for this fixture could be executed successfully.
 *
 * @param DboSource $db An instance of the database object used to create the fixture table
 * @return bool True on success, false on failure
 */
	public function create($db) {
		return true;
	}

/**
 * Run before each tests is executed, should return a set of SQL statements to insert records for the table
 * of this fixture could be executed successfully.
 *
 * @param DboSource $db An instance of the database into which the records will be inserted
 * @return bool on success or if there are no records to insert, or false on failure
 * @throws CakeException if counts of values and fields do not match.
 */
	public function insert($db) {
		return true;
	}

/**
 * Truncates the current fixture. Can be overwritten by classes extending
 * CakeFixture to trigger other events before / after truncate.
 *
 * @param DboSource $db A reference to a db instance
 * @return bool
 */
	public function truncate($db) {
		return true;
	}

}