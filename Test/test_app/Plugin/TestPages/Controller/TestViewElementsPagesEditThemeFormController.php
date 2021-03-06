<?php
/**
 * View/Elements/PagesEdit/theme_formテスト用Controller
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('AppController', 'Controller');

/**
 * View/Elements/PagesEdit/theme_formテスト用Controller
 *
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Test\test_app\Plugin\TestPages\Controller
 */
class TestViewElementsPagesEditThemeFormController extends AppController {

/**
 * theme_form
 *
 * @return void
 */
	public function theme() {
		$this->autoRender = true;
		$this->view = 'theme_form';

		$this->request->params['plugin'] = 'pages';
		$this->request->params['controller'] = 'pages_edit';

		Current::write('Page', array('id' => '7', 'parent_id' => '4'));
		Current::write('Room', array('id' => '1'));
		$this->set('theme', array('key' => 'Default'));

		$this->request->data['Page'] = Current::read('Page');
		$this->request->data['Room'] = Current::read('Room');
	}

}
