<?php
/**
 * Initial data generation of Migration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * Initial data generation of Migration
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Config\Migration
 */
class Records extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'records';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(),
		'down' => array(),
	);

/**
 * Records keyed by model name.
 *
 * @var array $records
 */
	public $records = array(
		'Page' => array(
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
				'id' => '3', 'room_id' => '3', 'root_id' => null, 'parent_id' => null, 'lft' => '7', 'rght' => '8',
				'permalink' => '', 'slug' => null,
			),
		),
		'LanguagesPage' => array(
			//パブリックスペース自体のページ
			// * 英語
			array('page_id' => '1', 'language_id' => '1', 'name' => ''),
			// * 日本語
			array('page_id' => '1', 'language_id' => '2', 'name' => ''),
			//プライベートスペース自体のページ
			// * 英語
			array('page_id' => '2', 'language_id' => '1', 'name' => ''),
			// * 日本語
			array('page_id' => '2', 'language_id' => '2', 'name' => ''),
			//ルームスペース自体のページ
			// * 英語
			array('page_id' => '3', 'language_id' => '1', 'name' => ''),
			// * 日本語
			array('page_id' => '3', 'language_id' => '2', 'name' => ''),
			//パブリックスペースのホーム
			//英語
			array('page_id' => '4', 'language_id' => '1', 'name' => 'Home'),
			//日本語
			array('page_id' => '4', 'language_id' => '2', 'name' => 'ホーム'),
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction Direction of migration process (up or down)
 * @return bool Should process continue
 */
	public function after($direction) {
		foreach ($this->records as $model => $records) {
			if ($direction === 'up') {
				if (!$this->updateRecords($model, $records)) {
					return false;
				}
			} elseif ($direction === 'down') {
				if ($model == 'LanguagesPage') {
					if (!$this->deleteRecords($model, $records, 'page_id')) {
						return false;
					}
				} else {
					if (!$this->deleteRecords($model, $records)) {
						return false;
					}
				}
			}
		}
		return true;
	}

}
