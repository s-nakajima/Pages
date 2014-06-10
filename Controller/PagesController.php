<?php
/**
 * Pages Controller
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@netcommons.org>
 * @since 3.0.0.0
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('PagesAppController', 'Pages.Controller');

class PagesController extends PagesAppController {

/**
 * index method
 *
 * @throws NotFoundException
 * @return void
 */
	public function index() {
		Configure::write('Pages.isSetting', $this->__isSettingMode());

		$paths = func_get_args();
		$path = implode('/', $paths);

		$page = $this->Page->findByPermalink($path);
		if (empty($page)) {
			throw new NotFoundException();
		}

		$containers = $this->__getContainersEachType($page['Container']);

		$this->set('path', $path);
		$this->set('page', $page);
		$this->set('containers',$containers);
	}

/**
 * Check setting mode
 *
 * @return bool
 */
	private function __isSettingMode() {
		$pos = strpos($this->request->url, Configure::read('Pages.settingModeWord'));

		return ($pos === 0);
	}

/**
 * Get containers each type
 *
 * @param array $containers
 * @return array
 */
	private function __getContainersEachType($containers) {
		$containersEachType = array();
		foreach ($containers as $container) {
			$type = $container['type'];
			$containersEachType[$type] = $container;
		}

		return $containersEachType;
	}

}
