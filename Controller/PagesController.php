<?php
/**
 * Pages Controller
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('PagesAppController', 'Pages.Controller');

/**
 * Pages Controller
 *
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @package NetCommons\Pages\Controller
 */
class PagesController extends PagesAppController {

/**
 * uses
 *
 * @var array
 */
	public $uses = array(
		'Pages.Page',
	);

/**
 * use components
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
		$this->components[] = 'Pages.PageLayout';

		if (Current::isSettingMode() && ! Current::permission('page_editable')) {
			$paths = func_get_args();
			$path = implode('/', $paths);
			$this->redirect('/' . $path);
			return;
		}

		$paths = func_get_args();
		$path = implode('/', $paths);

		$page = $this->Page->getPageWithFrame($path);
		if (empty($page)) {
			throw new NotFoundException();
		}
		$this->set('page', $page);
	}

}
