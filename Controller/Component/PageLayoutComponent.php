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
 * @package NetCommons\Pages\Controller\Component
 */
class PageLayoutComponent extends Component {

/**
 * modalフラグ
 *
 * @var string
 */
	public $modal = null;

/**
 * beforeRender
 *
 * @param Controller $controller Controller
 * @return void
 * @throws NotFoundException
 */
	public function beforeRender(Controller $controller) {
		// Ajax用
		if ($controller->request->is('ajax')) {
			return;
		}

		//RequestActionの場合、スキップする
		if (! empty($controller->request->params['requested'])) {
			return;
		}

		//pathからページデータ取得
		if (isset($controller->viewVars['page'])) {
			$page = $controller->viewVars['page'];
		} else {
			$this->Page = ClassRegistry::init('Pages.Page');
			$page = $this->Page->getPageWithFrame(Current::read('Page.permalink'));
			if (empty($page)) {
				throw new NotFoundException();
			}
			$controller->set('page', $page);
		}

		$controller->set('modal', $this->modal);

		//ヘルパーセット
		if (! isset($controller->helpers['NetCommons.Composer']) ||
				! in_array('NetCommons.Composer', $controller->helpers, true)) {
			$controller->helpers[] = 'NetCommons.Composer';
		}
		$controller->helpers[] = 'Pages.PageLayout';
	}

}
