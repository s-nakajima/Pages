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
		if (! empty($this->controller->request->params['requested'])) {
			return;
		}

		$this->controller = $controller;

		//Layoutのセット
		if ($this->controller->layout === 'NetCommons.setting') {
			$this->controller->layout = 'Frames.setting';
		}
		if ($this->controller->layout === 'NetCommons.default') {
			$this->controller->layout = 'Pages.default';
		}

		//pathからページデータ取得
		if (isset($this->controller->viewVars['page'])) {
			$page = $this->controller->viewVars['page'];
			$this->controller->current['page'] = $page['page'];
		} else {
			$this->Page = ClassRegistry::init('Pages.Page');
			$path = $this->__getPagePath();
			$page = $this->Page->getPageWithFrame($path);
			if (empty($page)) {
				throw new NotFoundException();
			}
			$page = $this->controller->camelizeKeyRecursive($page);
		}

		//cancelUrlをセット
		if (! isset($this->controller->viewVars['cancelUrl'])) {
			$this->controller->set('cancelUrl', $page['page']['permalink']);
		}

		//Pluginデータ取得
		$pluginsRoom = ClassRegistry::init('Rooms.PluginsRoom');
		$plugins = $pluginsRoom->getPlugins($page['page']['roomId'], $this->controller->viewVars['languageId']);

		//ページHelperにセット
		$results = array(
			'current' => $this->controller->current,
			'containers' => Hash::combine($page['container'], '{n}.type', '{n}'),
			'boxes' => Hash::combine($page['box'], '{n}.id', '{n}', '{n}.containerId'),
			'plugins' => $this->controller->camelizeKeyRecursive($plugins),
		);
		$this->controller->helpers['Pages.PageLayout'] = $this->controller->camelizeKeyRecursive($results);
	}

/**
 * Get page path
 *
 * @return string Page path
 */
	private function __getPagePath() {
		$path = '';
		if (isset($this->controller->current['page'])) {
			$path = $this->controller->current['page']['permalink'];
		} elseif (isset($this->controller->viewVars['path'])) {
			$path = substr($this->controller->viewVars['path'], 1);
		} elseif (isset($this->controller->current['Room']['page_id_top'])) {
			$options = array(
				'recursive' => -1,
				'conditions' => array('id' => (int)$this->controller->current['Room']['page_id_top']),
			);
			if ($page = $this->Page->find('first', $options)) {
				$this->controller->current['page'] = $page['Page'];
				$path = $this->controller->current['page']['permalink'];
			}
		}

		return $path;
	}

}
