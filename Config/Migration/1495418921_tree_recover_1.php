<?php
/**
 * インデックスの見直し
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('NetCommonsMigration', 'NetCommons.Config/Migration');

/**
 * インデックスの見直し
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Config\Migration
 */
class TreeRecover1 extends NetCommonsMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'tree_recover_1';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
		),
		'down' => array(
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
		$this->loadModels(['Page' => 'Pages.Page']);

		if ($this->connection !== 'test' && Configure::read('NetCommons.installed')) {
			$this->Page->setMasterDataSource();
			$this->Page->recover();
		}
		return true;
	}
}
