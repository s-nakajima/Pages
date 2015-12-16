<?php
/**
 * Migration file
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

/**
 * Migration file
 *
 * * テーマ設定フィールド(theme)の追加
 *
 * @package NetCommons\UserAttributes\Config\Migration
 * @link https://github.com/NetCommons3/Pages/issues/33
 */
class AddTheme extends CakeMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = 'add_theme';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_field' => array(
				'pages' => array(
					'theme' => array('type' => 'string', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8', 'after' => 'is_container_fluid'),
				),
			),
		),
		'down' => array(
			'drop_field' => array(
				'pages' => array('theme'),
			),
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
		return true;
	}
}
