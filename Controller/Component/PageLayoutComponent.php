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
class PageLayoutComponent extends Component {

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

		//pathからページデータ取得
		if (isset($controller->viewVars['page'])) {
			$page = $controller->viewVars['page'];
		} else {
			if (isset($controller->current['page'])) {
				$path = $controller->current['page']['permalink'];
			} elseif (isset($controller->viewVars['path'])) {
				$path = substr($controller->viewVars['path'], 1);
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

		//cancelUrlをセット
		if (! isset($controller->viewVars['cancelUrl'])) {
			$controller->set('cancelUrl', $page['page']['permalink']);
		}

		if (! isset($controller->viewVars['languageId'])) {
			$pageModel = ClassRegistry::init('M17n.Language');
			$language = $controller->Language->findByCode(Configure::read('Config.language'));
			$controller->set('languageId', $language['Language']['id']);
		}

		//Pluginデータ取得
		$pluginsRoom = ClassRegistry::init('Rooms.PluginsRoom');
		$plugins = $pluginsRoom->getPlugins($page['page']['roomId'], $controller->viewVars['languageId']);

		//ページHelperにセット
		$results = array(
			'current' => $controller->current,
			'containers' => Hash::combine($page['container'], '{n}.type', '{n}'),
			'boxes' => Hash::combine($page['box'], '{n}.id', '{n}', '{n}.containerId'),
			'plugins' => $controller->camelizeKeyRecursive($plugins),
		);
		$controller->helpers['Pages.PageLayout'] = $controller->camelizeKeyRecursive($results);
	}

}
