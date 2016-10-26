<?php
/**
 * Page Behavior
 *
 * @property Room $Room
 * @property Page $ParentPage
 * @property Box $Box
 * @property Page $ChildPage
 * @property Box $Box
 * @property Container $Container
 * @property Language $Language
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

App::uses('ModelBehavior', 'Model');
App::uses('Page', 'Pages.Model');
App::uses('Container', 'Containers.Model');

/**
 * Page Behavior
 *
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @package NetCommons\Pages\Model
 */
class PageAssociationsBehavior extends ModelBehavior {

/**
 * Save container data.
 *
 * @param Model $model ビヘイビア呼び出し前のモデル
 * @param array $page ページデータ
 * @return mixed On success Model::$data
 * @throws InternalErrorException
 */
//	public function saveContainer(Model $model, $page) {
//		$model->loadModels([
//			'Container' => 'Containers.Container',
//		]);
//
//		$model->Container->create(false);
//		$data = array(
//			'Container' => array(
//				'type' => Container::TYPE_MAIN
//			)
//		);
//
//		$result = $model->Container->save($data);
//		if (! $result) {
//			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
//		}
//		return $result;
//	}

/**
 * Save box data.
 *
 * @param Model $model ビヘイビア呼び出し前のモデル
 * @param array $page ページデータ
 * @return mixed On success Model::$data
 * @throws InternalErrorException
 */
	public function saveBox(Model $model, $page) {
		$model->loadModels([
			'Box' => 'Boxes.Box',
		]);

		$containerTypes = array(
			Container::TYPE_HEADER, Container::TYPE_MAJOR, Container::TYPE_MAIN,
			Container::TYPE_MINOR, Container::TYPE_FOOTER,
		);

		$boxes['Box'] = array();
		foreach ($containerTypes as $containerType) {
			$model->Box->create(false);
			$data = array(
				'Box' => array(
					'type' => Box::TYPE_WITH_PAGE,
					'space_id' => $page['Room']['space_id'],
					'room_id' => $page['Page']['room_id'],
					'page_id' => $page['Page']['id'],
					'container_type' => $containerType,
				)
			);

			$result = $model->Box->save($data);
			if (! $result) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			$boxes['Box'][$containerType] = $result;
		}

		return $boxes;
	}

/**
 * PageContainersの登録処理
 *
 * @param Model $model ビヘイビア呼び出し前のモデル
 * @param array $page ページデータ
 * @return array
 * @throws InternalErrorException
 */
	public function savePageContainers(Model $model, $page) {
		$model->loadModels([
			'PageContainer' => 'Pages.PageContainer',
		]);

		$query = array(
			'recursive' => -1,
			'conditions' => array(
				'page_id' => $model->getReferencePageId($model, $page),
			)
		);
		$pageContainers = $model->PageContainer->find('all', $query);

		$results['PageContainer'] = array();
		foreach ($pageContainers as $pageContainer) {
			$data = array(
				'page_id' => $page['Page']['id'],
				'container_type' => $pageContainer['PageContainer']['container_type'],
				'is_published' => $pageContainer['PageContainer']['is_published'],
				'is_configured' => $pageContainer['PageContainer']['is_configured']
			);

			$model->PageContainer->create(false);
			$result = $model->PageContainer->save($data);
			if (! $result) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}

			$results['PageContainer'][$data['container_type']] = $result;
		}

		return $results;
	}

/**
 * PageBoxesの登録処理
 *
 * @param Model $model ビヘイビア呼び出し前のモデル
 * @param array $page ページデータ
 * @return bool True on success
 * @throws InternalErrorException
 */
	public function saveBoxesPageContainers(Model $model, $page) {
		$model->loadModels([
			'Box' => 'Boxes.Box',
			'BoxesPageContainer' => 'Boxes.BoxesPageContainer',
		]);

		$query = array(
			'recursive' => 0,
			'conditions' => array(
				'BoxesPageContainer.page_id' => $model->getReferencePageId($model, $page),
				'BoxesPageContainer.container_type !=' => Container::TYPE_MAIN
			)
		);
		$parentBoxesPages = $model->BoxesPageContainer->find('all', $query);
		$parentBoxesPages[] = array(
			'BoxesPageContainer' => array(
				'container_type' => Container::TYPE_MAIN,
				'is_published' => true,
				'weight' => '1',
			),
			'Box' => array(
				'page_id' => true
			),
		);

		foreach ($parentBoxesPages as $boxPage) {
			$containerType = $boxPage['BoxesPageContainer']['container_type'];
			if (! $boxPage['Box']['page_id']) {
				$boxId = $boxPage['Box']['id'];
			} else {
				$boxId = $page['Box'][$containerType]['Box']['id'];
			}
			$pageContaireId = $page['PageContainer'][$containerType]['PageContainer']['id'];

			$data = array(
				'page_container_id' => $pageContaireId,
				'page_id' => $page['Page']['id'],
				'container_type' => $containerType,
				'box_id' => $boxId,
				'is_published' => $boxPage['BoxesPageContainer']['is_published'],
				'weight' => $boxPage['BoxesPageContainer']['weight'],
			);
			$model->BoxesPageContainer->create(false);
			if (!$model->BoxesPageContainer->save($data)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
		}

		return true;
	}

/**
 * PageContainersを作成するためのコピー元のページIDを取得する
 * ※親のページとするが、ない場合は、NC3では、強制的にパブリックスペースのものとする
 *
 * @param Model $model ビヘイビアの呼び出し前のモデル
 * @param array $page ページデータ
 * @return string
 */
	public function getReferencePageId(Model $model, $page) {
		if (! is_array($page)) {
			return Page::PUBLIC_ROOT_PAGE_ID;
		}
		return Hash::get($page, 'Page.parent_id', Page::PUBLIC_ROOT_PAGE_ID);
	}

/**
 * Containerの削除処理
 *
 * @param Model $model ビヘイビア呼び出し前のモデル
 * @param int $pageId ページID
 * @return bool True on success
 * @throws InternalErrorException
 */
	public function deleteContainers(Model $model, $pageId) {
		$model->loadModels([
			'Container' => 'Containers.Container',
			'ContainersPage' => 'Containers.ContainersPage',
		]);

		$conditions = array(
			'ContainersPage.page_id' => $pageId,
			'Container.type' => Container::TYPE_MAIN
		);
		$containers = $model->ContainersPage->find('list', array(
			'recursive' => -1,
			'fields' => 'Container.id',
			'joins' => array(
				array(
					'table' => $model->Container->table,
					'alias' => $model->Container->alias,
					'type' => 'INNER',
					'conditions' => array(
						$model->ContainersPage->alias . '.container_id' . ' = ' . $model->Container->alias . ' .id',
					),
				),
			),
			'conditions' => $conditions
		));
		$containerIds = array_values($containers);

		if (! $model->Container->deleteAll(array('Container.id' => $containerIds), false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		if (! $model->ContainersPage->deleteAll(array('ContainersPage.page_id' => $pageId), false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return true;
	}

/**
 * Boxの削除処理
 *
 * @param Model $model ビヘイビア呼び出し前のモデル
 * @param int $pageId ページID
 * @return bool True on success
 * @throws InternalErrorException
 */
	public function deleteBoxes(Model $model, $pageId) {
		$model->loadModels([
			'Box' => 'Boxes.Box',
			'BoxesPage' => 'Boxes.BoxesPage',
		]);

		if (! $model->Box->deleteAll(array('Box.page_id' => $pageId), false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		if (! $model->BoxesPage->deleteAll(array('BoxesPage.page_id' => $pageId), false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		return true;
	}

}
