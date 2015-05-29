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
		//RequestActionの場合、スキップする
		if (! empty($controller->request->params['requested'])) {
			return;
		}

		//Layoutのセット
		if ($controller->layout === 'NetCommons.setting') {
			$controller->layout = 'Frames.setting';
		}
		if ($controller->layout === 'NetCommons.default') {
			$controller->layout = 'Pages.default';
		}

		if (isset($controller->viewVars['page'])) {
			$page = $controller->viewVars['page'];
		} else {
			if (isset($controller->current)) {
				$path = $controller->current['page']['permalink'];
			} else {
				$path = '';
			}
			$pageModel = ClassRegistry::init('Pages.Page');
			$page = $pageModel->getPageWithFrame($path);
			if (empty($page)) {
				throw new NotFoundException();
			}
			$page = $controller->camelizeKeyRecursive($page);
		}
//		$this->_View->set('page', $page);

		if (! isset($controller->viewVars['cancelUrl'])) {
			$controller->set('cancelUrl', $page['page']['permalink']);
		}
		//$controller->set('path', '/' . $page['permalink']);


//		//ページデータ取得
//		if (isset($this->_View->viewVars['page'])) {
//			$page = $this->_View->viewVars['page'];
//		} else {
//			if (isset($this->_View->viewVars['current'])) {
//				$path = $this->_View->viewVars['current']['page']['permalink'];
//			} else {
//				$path = '';
//			}
//
//			$pageModel = ClassRegistry::init('Pages.Page');
//			$page = $pageModel->getPageWithFrame($path);
//			if (empty($page)) {
//				throw new NotFoundException();
//			}
//			$page = NetCommonsAppController::camelizeKeyRecursive($page);
//			$this->_View->set('page', $page);
//		}
//		$this->_View->viewVars['current']['page'] = NetCommonsAppController::camelizeKeyRecursive($page['page']);
//		$this->_View->viewVars['current']['frame']['roomId'] = $this->_View->viewVars['current']['page']['roomId'];
//		$this->_View->viewVars['current']['frame']['languageId'] = $page['language'][0]['id'];
//		$this->_View->set('frame', $this->_View->viewVars['current']['frame']);
//
//		if (! isset($this->_View->viewVars['cancelUrl'])) {
//			$this->_View->set('cancelUrl', $this->_View->viewVars['current']['page']['permalink']);
//		}
//		$this->_View->set('path', '/' . $this->_View->viewVars['current']['page']['permalink']);
//
//		$this->__containers = Hash::combine($page['container'], '{n}.type', '{n}');
//		$this->__boxes = Hash::combine($page['box'], '{n}.id', '{n}', '{n}.containerId');
//
//		//プラグインデータ取得
//		if (! isset($this->_View->viewVars['plugins'])) {
//			$pluginsRoom = ClassRegistry::init('Rooms.PluginsRoom');
//			$plugins = $pluginsRoom->getPlugins(
//				$this->_View->viewVars['current']['frame']['roomId'],
//				$this->_View->viewVars['current']['frame']['languageId']
//			);
//			if (empty($plugins)) {
//				throw new NotFoundException();
//			}
//
//			$plugins = NetCommonsAppController::camelizeKeyRecursive($plugins);
//			$pluginMap = Hash::combine($plugins, '{n}.plugin.key', '{n}.plugin');
//
//			$this->_View->set('plugins', $plugins);
//			$this->_View->set('pluginMap', $pluginMap);
//		}

		$pluginsRoom = ClassRegistry::init('Rooms.PluginsRoom');
		$plugins = $pluginsRoom->getPlugins($page['page']['roomId'], $page['language'][0]['id']);
		if (empty($plugins)) {
			throw new NotFoundException();
		}


//		$pageModel = ClassRegistry::init('Pages.Page');
//		$path = '';
//		$page = $pageModel->getPageWithFrame($path);
//		if (empty($page)) {
//			throw new NotFoundException();
//		}
//
//		$page['Container'] = Hash::combine($page['Container'], '{n}.type', '{n}');
//		unset($page['Container'][Container::TYPE_MAIN]);
//		$page['Box'] = Hash::combine($page['Box'], '{n}.id', '{n}', '{n}.container_id');
//
//		$controller->set('containers', $page['Container']);
//		$controller->set('boxes', $page['Box']);
//
//		$controller->layout = 'Pages.default';

		//ページHelper読み込み
		if (in_array('Pages.Layout', $controller->helpers)) {
			unset($controller->helpers['Pages.Layout']);
		}

		$results = array(
			'current' => $controller->current,
			'containers' => Hash::combine($page['container'], '{n}.type', '{n}'),
			'boxes' => Hash::combine($page['box'], '{n}.id', '{n}', '{n}.containerId'),
			'plugins' => $controller->camelizeKeyRecursive($plugins),
//			'pluginMap' => Hash::combine($plugins, '{n}.plugin.key', '{n}.plugin')
		);
		$controller->helpers['Pages.Layout'] = $controller->camelizeKeyRecursive($results);

	}

}
