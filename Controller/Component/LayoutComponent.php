<?php
/**
 * LayoutComponent
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('Component', 'Controller');

/**
 * LayoutComponent
 *
 */
class LayoutComponent extends Component {

/**
 * beforeRender
 *
 * @param Controller $controller Controller
 * @return void
 * @throws NotFoundException
 */
	public function beforeRender(Controller $controller) {
		if (!empty($controller->request->params['requested'])) {
			return;
		}

		$pageModel = ClassRegistry::init('Pages.Page');
		$path = '';
		$page = $pageModel->getPageWithFrame($path);
		if (empty($page)) {
			throw new NotFoundException();
		}

		$page['Container'] = Hash::combine($page['Container'], '{n}.type', '{n}');
		unset($page['Container'][Container::TYPE_MAIN]);
		$page['Box'] = Hash::combine($page['Box'], '{n}.id', '{n}', '{n}.container_id');

		$controller->set('containers', $page['Container']);
		$controller->set('boxes', $page['Box']);

		$controller->layout = 'Pages.default';
	}

}
