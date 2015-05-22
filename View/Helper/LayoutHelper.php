<?php
/**
 * LayoutHelper
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('AppHelper', 'View/Helper');

/**
 * LayoutHelper
 *
 */
class LayoutHelper extends AppHelper {

/**
 * Before layout callback. beforeLayout is called before the layout is rendered.
 *
 * Overridden in subclasses.
 *
 * @param string $layoutFile The layout about to be rendered.
 * @return void
 */
	public function afterRender($layoutFile) {
		if (!empty($this->request->params['requested'])) {
			return;
		}

		$pageModel = ClassRegistry::init('Pages.Page');
		$path = '';
		$page = $pageModel->getPageWithFrame($path);
		if (empty($page)) {
			throw new NotFoundException();
		}

/* 		$boxes = Hash::combine($page['Box'], '{n}.id', '{n}', '{n}.container_id');
		foreach ($page['Container'] as $container) {
			$containerId = $container['id'];

			$out = $this->_View->element(
				'Boxes.render_boxes',
				array('boxes' => $boxes[$container['id']])
			);
		}
 */
		$page['Container'] = Hash::combine($page['Container'], '{n}.type', '{n}');
		unset($page['Container'][Container::TYPE_MAIN]);
		$page['Box'] = Hash::combine($page['Box'], '{n}.id', '{n}', '{n}.container_id');
//var_dump(this->_View->);
$this->_View->layout = 'Pages.default';
		$this->_View->set('containers', $page['Container']);
		$this->_View->set('boxes', $page['Box']);
//var_Dump($layoutFile);
	}
}
