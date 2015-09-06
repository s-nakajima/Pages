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
App::uses('Folder', 'Utility');

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
	const COL_DEFAULT_SIZE = 3;

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
 * frame data
 *
 * @var array
 */
	public $frame = null;

/**
 * page data
 *
 * @var array
 */
	public static $page = null;

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
		$this->__pluginMap = Hash::combine($this->__plugins, '{n}.Plugin.key', '{n}.Plugin');

		$this->frame = Current::read('Frame');

		if (isset($settings['current']['Page'])) {
			self::$page = $settings['current']['Page'];
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

		$mainCol = self::COL_MAX_SIZE;
		if ($this->hasContainer(Container::TYPE_MAJOR)) {
			$mainCol -= self::COL_DEFAULT_SIZE;
		}
		if ($this->hasContainer(Container::TYPE_MINOR)) {
			$mainCol -= self::COL_DEFAULT_SIZE;
		}

		switch ($containerType) {
			case Container::TYPE_MAJOR:
				if ($this->hasContainer($containerType)) {
					$result = ' col-md-' . self::COL_DEFAULT_SIZE . ' col-md-pull-' . $mainCol;
				}
				break;
			case Container::TYPE_MINOR:
				if ($this->hasContainer($containerType)) {
					$result = ' col-md-' . self::COL_DEFAULT_SIZE;
				}
				break;
			default:
				$result = ' col-md-' . $mainCol;
				if ($this->hasContainer(Container::TYPE_MAJOR)) {
					$result .= ' col-md-push-' . self::COL_DEFAULT_SIZE;
				}
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
		if (! $result = isset($this->__containers[$containerType]) && $this->__containers[$containerType]['ContainersPage']['is_published']) {
			return false;
		}

		if (! Current::isSettingMode()) {
			$box = $this->getBox($containerType);
			$frames = Hash::combine($box, '{n}.Frame.{n}.id', '{n}.Frame.{n}');
			$result = count($frames);
		}

		return $result;
	}

/**
 * Get containers_pages.id
 *
 * @param string $containerType Container type.
 *    e.g.) Container::TYPE_HEADER or TYPE_MAJOR or TYPE_MAIN or TYPE_MINOR or TYPE_FOOTER
 * @return int containers_pages.id
 */
	public function getContainersPageId($containerType) {
		return (int)$this->__containers[$containerType]['ContainersPage']['id'];
	}

/**
 * Get the box data for container
 *
 * @param string $containerType Container type.
 *    e.g.) Container::TYPE_MAJOR or Container::TYPE_MAIN or Container::TYPE_MINOR
 * @return array Box data
 */
	public function getBox($containerType) {
		if (isset($this->__containers[$containerType]['id']) &&
				isset($this->__boxes[$this->__containers[$containerType]['id']])) {
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
		if (isset($this->_View->viewVars['current']['Page']) &&
				$this->_View->viewVars['current']['Page']['is_container_fluid']) {
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
		if (isset($this->__pluginMap[$pluginKey]['default_action']) && $this->__pluginMap[$pluginKey]['default_action'] !== '') {
			$action = $this->__pluginMap[$pluginKey]['default_action'];
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
		if (isset($this->__pluginMap[$pluginKey]['default_setting_action']) && $this->__pluginMap[$pluginKey]['default_setting_action'] !== '') {
			$action = $this->__pluginMap[$pluginKey]['default_setting_action'];
		} else {
			$action = '';
		}

		return $action;
	}

/**
 * Get the plugins data
 *
 * @return array P;ugins data
 */
	public function getLayouts() {
		$dir = new Folder(
			CakePlugin::path('Pages') . WEBROOT_DIR . DS . 'img' . DS . 'layouts'
		);
		$files = $dir->find('.*\.png', true);

		return $files;
	}

}
