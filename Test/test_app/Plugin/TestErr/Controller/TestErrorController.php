<?php
/**
 * Config/routes.phpテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

// @codeCoverageIgnoreStart
App::uses('AppController', 'Controller');
// @codeCoverageIgnoreEnd

/**
 * Config/routes.phpテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\test_app\Plugin\TestErr\Controller
 * @codeCoverageIgnore
 */
class TestErrorController extends AppController {

/**
 * index
 *
 * @return void
 */
	public function index() {
		$this->autoRender = true;
	}
}
