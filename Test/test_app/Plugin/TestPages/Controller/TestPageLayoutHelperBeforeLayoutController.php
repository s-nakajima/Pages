<?php
/**
 * PageLayoutHelperテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * PageLayoutHelperテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\test_app\Plugin\TestPages\Controller
 */
class TestPageLayoutHelperBeforeLayoutController extends AppController {

/**
 * 使用コンポーネント
 *
 * @var array
 */
	public $components = array(
		'Pages.PageLayout'
	);

/**
 * 使用モデル
 *
 * @var array
 */
	public $uses = array(
		'Pages.Page',
	);

/**
 * beforeRender
 *
 * @return void
 */
	public function beforeFilter() {
		$result = $this->Page->find('first', array(
			'recursive' => 0,
			'conditions' => array('Page.id' => '7')
		));
		Current::write(null, $result);

		parent::beforeFilter();
	}

/**
 * index
 *
 * @return void
 */
	public function index() {
		$this->autoRender = true;
	}

}
