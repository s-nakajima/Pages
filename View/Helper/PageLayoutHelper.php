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
App::uses('Container', 'Containers.Model');

/**
 * LayoutHelper
 *
 */
class PageLayoutHelper extends AppHelper {

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
 * Plugins data
 *
 * @var array
 */
	private $__plugins;

/**
 * Plugins map data
 *
 * @var array
 */
	private $__pluginMap;

/**
 * Plugins map data
 *
 * @var array
 */
	public static $frame = null;

/**
 * Default Constructor
 *
 * @param View $View The View this helper is being attached to.
 * @param array $settings Configuration settings for the helper.
 */
	public function __construct(View $View, $settings = array()) {
		parent::__construct($View, $settings);

		$this->__containers = $settings['containers'];
		$this->__boxes = $settings['boxes'];
		$this->__plugins = $settings['plugins'];
		$this->__pluginMap = Hash::combine($this->__plugins, '{n}.plugin.key', '{n}.plugin');

		if (isset($settings['current']['frame'])) {
			self::$frame = $settings['current']['frame'];
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
 * The layout have container
 *
 * @param string $containerType Container type.
 *    e.g.) Container::TYPE_HEADER or TYPE_MAJOR or TYPE_MAIN or TYPE_MINOR or TYPE_FOOTER
 * @return bool The layout have container
 */
	public function hasContainer($containerType) {
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
		if (isset($this->__boxes[$this->__containers[$containerType]['id']])) {
			return $this->__boxes[$this->__containers[$containerType]['id']];
		}

		return array();
	}

/**
 * Get the plugins data
 *
 * @return array P;ugins data
 */
	public function getPlugins() {
		return $this->__plugins;
	}

/**
 * Get the style sheet for container fluid
 *
 * @return string Box data
 */
	public function getContainerFluid() {
		$result = 'container';
		if (isset($this->_View->viewVars['current']['page']) &&
				$this->_View->viewVars['current']['page']['isContainerFluid']) {
			$result = 'container-fluid';
		}

		return $result;
	}

/**
 * Get the plugin default action
 *
 * @param string $pluginKey plugins.key
 * @return array action name
 */
	public function getDefaultAction($pluginKey) {
		if (isset($this->__pluginMap[$pluginKey]['defaultAction']) && $this->__pluginMap[$pluginKey]['defaultAction'] !== '') {
			$action = $this->__pluginMap[$pluginKey]['defaultAction'];
		} else {
			$action = $pluginKey . '/index';
		}

		return $action;
	}

/**
 * Get the plugin default setting action
 *
 * @param string $pluginKey plugins.key
 * @return array action name
 */
	public function getDefaultSettingAction($pluginKey) {
		if (isset($this->__pluginMap[$pluginKey]['defaultSettingAction']) && $this->__pluginMap[$pluginKey]['defaultSettingAction'] !== '') {
			$action = $this->__pluginMap[$pluginKey]['defaultSettingAction'];
		} else {
			$action = '';
		}

		return $action;
	}

}
