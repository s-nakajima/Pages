<?php
/**
 * ページ表示 Controller
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('PagesAppController', 'Pages.Controller');
App::uses('Space', 'Rooms.Model');

/**
 * ページ表示 Controller
 *
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @package NetCommons\Pages\Controller
 */
class PagesController extends PagesAppController {

/**
 * 使用するModels
 *
 * - [Pages.Page](../../Pages/classes/Page.html)
 *
 * @var array
 */
	public $uses = array(
		'Pages.Page',
		'Rooms.Space',
	);

/**
 * 使用するComponents
 *
 * - [Pages.PageLayoutComponent](../../Pages/classes/PageLayoutComponent.html)
 *
 * @var array
 */
	public $components = array(
		'Pages.PageLayout',
	);

/**
 * index method
 *
 * @throws NotFoundException
 * @return void
 */
	public function index() {
CakeLog::debug("\t" . '-- -- -- -- PagesController::' . __FUNCTION__ . "\t" . 'start1 ' . microtime() . '');
$stime = microtime(true);

		if (Current::isSettingMode() && ! Current::permission('page_editable')) {
			$paths = $this->params->params['pass'];
			$path = implode('/', $paths);
			return $this->redirect('/' . $path);
		}
CakeLog::debug("\t" . '-- -- -- -- PagesController::' . __FUNCTION__ . "\t" . 'end1 ' . microtime() . "\t" . (microtime(true) - $stime) . '');
CakeLog::debug("\t" . '-- -- -- -- PagesController::' . __FUNCTION__ . "\t" . 'start2 ' . microtime() . '');
$stime = microtime(true);

		//ページデータの取得
		$paths = $this->params->params['pass'];
		$path = implode('/', $paths);

		$spacePermalink = Hash::get($this->request->params, 'spacePermalink', '');
		$space = $this->Space->find('first', array(
			'recursive' => -1,
			'conditions' => array('permalink' => $spacePermalink, 'id !=' => Space::WHOLE_SITE_ID)
		));
CakeLog::debug("\t" . '-- -- -- -- PagesController::' . __FUNCTION__ . "\t" . 'end2 ' . microtime() . "\t" . (microtime(true) - $stime) . '');
CakeLog::debug("\t" . '-- -- -- -- PagesController::' . __FUNCTION__ . "\t" . 'star3 ' . microtime() . '');
$stime = microtime(true);

		$page = $this->Page->getPageWithFrame($path, $space['Space']['id']);
		if (empty($page)) {
			throw new NotFoundException();
		}
		$this->set('page', $page);
CakeLog::debug("\t" . '-- -- -- -- PagesController::' . __FUNCTION__ . "\t" . 'end3 ' . microtime() . "\t" . (microtime(true) - $stime) . '');
	}

}
