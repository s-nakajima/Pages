<?php
/**
 * BoxFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('BoxFixture', 'Boxes.Test/Fixture');

/**
 * BoxFixture
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\Fixture
 */
class Box4routesFixture extends BoxFixture {

/**
 * Model name
 *
 * @var string
 */
	public $name = 'Box';

/**
 * Full Table Name
 *
 * @var string
 */
	public $table = 'boxes';

/**
 * ルームID
 *
 * @var array
 */
	protected $_roomId = array(
		'2' => array('2', '5', '6'),
	);

/**
 * ページID
 *
 * @var array
 */
	protected $_pageId = array(
		'2' => array('1', '4', '7', '8', '9', '10', '11', '12'),
		'5' => array('5'),
		'6' => array('6'),
	);

}
