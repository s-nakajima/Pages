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
 * Bootstrap col max size
 *
 * @var int
 */
	const COL_MAX_SIZE = 12;

/**
 * Bootstrap col-sm default size
 *
 * @var int
 */
	const COL_DEFAULT_SM_SIZE = 3;

/**
 * Bootstrap col-md default size
 *
 * @var int
 */
	const COL_DEFAULT_MD_SIZE = 3;

/**
 * Bootstrap col-lg default size
 *
 * @var int
 */
	const COL_DEFAULT_LG_SIZE = 3;

/**
 * Containers data
 *
 * @var array
 */
	private $__containers;

/**
 * Boxes data
 *
 * @var array
 */
	private $__boxes;

/**
 * Before layout callback. beforeLayout is called before the layout is rendered.
 *
 * Overridden in subclasses.
 *
 * @param string $layoutFile The layout about to be rendered.
 * @return void
 */
	public function afterRender($layoutFile) {
CakeLog::debug('LayoutHelper::afterRender(' . $layoutFile . ')');
		if ($this->_View->layout === 'NetCommons.setting') {
			$this->_View->layout = 'Frames.setting';
		}
		if ($this->_View->layout === 'NetCommons.default') {
			$this->_View->layout = 'Pages.default';
		}
	}

/**
 * Before layout callback. beforeLayout is called before the layout is rendered.
 *
 * Overridden in subclasses.
 *
 * @param string $layoutFile The layout about to be rendered.
 * @return void
 */
	public function beforeLayout($layoutFile) {
CakeLog::debug('LayoutHelper::beforeLayout(' . $layoutFile . ')');

		//ページデータ取得
		if (isset($this->_View->viewVars['page'])) {
			$page = $this->_View->viewVars['page'];
			$this->_View->viewVars['current']['page'] = NetCommonsAppController::camelizeKeyRecursive($page['page']);
		} else {
			if (! isset($this->_View->viewVars['current'])) {
				return;
			}
			$path = $this->_View->viewVars['current']['page']['permalink'];
			$this->_View->set('frame', $this->_View->viewVars['current']['frame']);

			$pageModel = ClassRegistry::init('Pages.Page');
			$page = $pageModel->getPageWithFrame($path);
			if (empty($page)) {
				throw new NotFoundException();
			}
			$page = NetCommonsAppController::camelizeKeyRecursive($page);
		}

		if (! isset($this->_View->viewVars['cancelUrl'])) {
			$this->_View->set('cancelUrl', $this->_View->viewVars['current']['page']['permalink']);
		}
//var_dump($this->__containers);

		$this->__containers = Hash::combine($page['container'], '{n}.type', '{n}');
		$this->__boxes = Hash::combine($page['box'], '{n}.id', '{n}', '{n}.containerId');

		//プラグインデータ取得
		if (! isset($this->_View->viewVars['plugins'])) {
			$pluginsRoom = ClassRegistry::init('Rooms.PluginsRoom');
			$plugins = $pluginsRoom->getPlugins(
				$this->_View->viewVars['current']['frame']['roomId'],
				$this->_View->viewVars['current']['frame']['languageId']
			);
			if (empty($plugins)) {
				throw new NotFoundException();
			}

			$plugins = NetCommonsAppController::camelizeKeyRecursive($plugins);
			$pluginMap = Hash::combine($plugins, '{n}.plugin.key', '{n}.plugin');

			$this->_View->set('plugins', $plugins);
			$this->_View->set('pluginMap', $pluginMap);
		}

	}

/**
 * Get the container size for layout
  *
 * @param string $containerType Container type.
 *    e.g.) Container::TYPE_MAJOR or Container::TYPE_MAIN or Container::TYPE_MINOR
 * @return string Html class attribute
 */
	public function getContainerSize($containerType) {
CakeLog::debug('LayoutHelper::getContainerSize(' . $containerType . ')');

		$result = '';
		switch ($containerType) {
			case Container::TYPE_MAJOR:
				if ($this->hasContainer($containerType)) {
					$result = 'col-sm-' . self::COL_DEFAULT_SM_SIZE .
							' col-md-' . self::COL_DEFAULT_MD_SIZE .
							' col-lg-' . self::COL_DEFAULT_LG_SIZE;
				}
				break;
			case Container::TYPE_MINOR:
				if ($this->hasContainer($containerType)) {
					$result = 'col-sm-' . self::COL_DEFAULT_SM_SIZE .
							' col-md-' . self::COL_DEFAULT_MD_SIZE .
							' col-lg-' . self::COL_DEFAULT_LG_SIZE;
				}
				break;
			default:
				$smCol = self::COL_MAX_SIZE;
				$mdCol = self::COL_MAX_SIZE;
				$lgCol = self::COL_MAX_SIZE;
				if ($this->hasContainer(Container::TYPE_MAJOR)) {
					$smCol -= self::COL_DEFAULT_SM_SIZE;
					$mdCol -= self::COL_DEFAULT_MD_SIZE;
					$lgCol -= self::COL_DEFAULT_LG_SIZE;
				}
				if ($this->hasContainer(Container::TYPE_MINOR)) {
					$smCol -= self::COL_DEFAULT_SM_SIZE;
					$mdCol -= self::COL_DEFAULT_MD_SIZE;
					$lgCol -= self::COL_DEFAULT_LG_SIZE;
				}
				$result = 'col-sm-' . $smCol . ' col-md-' . $mdCol . ' col-lg-' . $lgCol;
		}

		return $result;
	}

/**
 * Get the container size for layout
  *
 * @param string $containerType Container type.
 *    e.g.) Container::TYPE_HEADER or TYPE_MAJOR or TYPE_MAIN or TYPE_MINOR or TYPE_FOOTER
 * @return bool The layout have container
 */
	public function hasContainer($containerType) {
CakeLog::debug('LayoutHelper::hasContainer(' . $containerType . ')');
		$result = false;

		if (Page::isSetting()) {
			$result = isset($this->__containers[$containerType]);
		} else {
			$box = $this->getBox($containerType);
			$frames = Hash::combine($box, '{n}.frame.{n}.id', '{n}.frame.{n}');
			$result = isset($this->__containers[$containerType]) && count($frames);
		}

		return $result;
	}

/**
 * Get the box data for container
  *
 * @param string $containerType Container type.
 *    e.g.) Container::TYPE_MAJOR or Container::TYPE_MAIN or Container::TYPE_MINOR
 * @return array Box data
 */
	public function getBox($containerType) {
CakeLog::debug('LayoutHelper::getBox(' . $containerType . ')');

		return $this->__boxes[$this->__containers[$containerType]['id']];
	}

/**
 * Get the style sheet for container fluid
  *
 * @return string Box data
 */
	public function getContainerFluid() {
CakeLog::debug('LayoutHelper::getContainerFluid()');

		$result = '';
		if (! isset($this->_View->viewVars['current']['page'])) {
			return $result;
		}
		if ($this->_View->viewVars['current']['page']['isContainerFluid']) {
			$result = 'container-fluid';
		} else {
			$result = 'container';
		}

		return $result;
	}

}
