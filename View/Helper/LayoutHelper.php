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
 * Bootstrap col default size
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
 * Before layout callback. beforeLayout is called before the layout is rendered.
 *
 * Overridden in subclasses.
 *
 * @param string $layoutFile The layout about to be rendered.
 * @return void
 */
	public function afterRender($layoutFile) {
CakeLog::debug('LayoutHelper::afterRender(' . $layoutFile . ')');

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

		if (isset($this->_View->viewVars['page'])) {
			$page = $this->_View->viewVars['page'];
		} else {
			$pageModel = ClassRegistry::init('Pages.Page');
			$path = $this->_View->request->data['current']['Page']['permalink'];
			$page = $pageModel->getPageWithFrame($path);
			if (empty($page)) {
				throw new NotFoundException();
			}
		}

		$this->__containers = Hash::combine($page['Container'], '{n}.type', '{n}');
		$this->__boxes = Hash::combine($page['Box'], '{n}.id', '{n}', '{n}.container_id');
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
					$result = 'col-sm-' . self::COL_DEFAULT_SIZE;
				}
				break;
			case Container::TYPE_MINOR:
				if ($this->hasContainer($containerType)) {
					$result = 'col-sm-' . self::COL_DEFAULT_SIZE;
				}
				break;
			default:
				$col = self::COL_MAX_SIZE;
				if ($this->hasContainer(Container::TYPE_MAJOR)) {
					$col -= self::COL_DEFAULT_SIZE;
				}
				if ($this->hasContainer(Container::TYPE_MINOR)) {
					$col -= self::COL_DEFAULT_SIZE;
				}
				$result = 'col-sm-' . $col;
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
			$frames = Hash::combine($box, '{n}.Frame.{n}.id', '{n}.Frame.{n}');
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

}
