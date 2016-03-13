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

/**
 * Page Behavior
 *
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @package NetCommons\Pages\Model
 */
class PageBehavior extends ModelBehavior {

/**
 * beforeValidate is called before a model is validated, you can use this callback to
 * add behavior validation rules into a models validate array. Returning false
 * will allow you to make the validation fail.
 *
 * @param Model $model Model using this behavior
 * @param array $options Options passed from Model::save().
 * @return mixed False or null will abort the operation. Any other result will continue.
 * @see Model::save()
 */
	public function beforeValidate(Model $model, $options = array()) {
		//ページデータをセット
		$referencePageId = $model->getReferencePageId($model->data);
		$fields = array(
			'room_id',
			'permalink'
		);
		$targetPage = $model->findById($referencePageId, $fields);
		if (empty($targetPage)) {
			return false;
		}
		if (! $model->data['Page']['room_id']) {
			$model->data['Page']['room_id'] = Current::read('Room.id');
		}

		$slug = $model->data['Page']['slug'];
		if (! isset($slug)) {
			$slug = '';
		}
		$model->data['Page']['slug'] = $slug;

		//$permalink = '';
		//if (strlen($targetPage['Page']['permalink']) !== 0) {
		//	$permalink = $targetPage['Page']['permalink'] . '/';
		//}
		//$permalink .= $slug;
		$model->data['Page']['permalink'] = $slug;
		$model->data['Page']['is_published'] = true;
		$model->data['Page']['is_container_fluid'] = false;

		return parent::beforeValidate($model, $options);
	}

/**
 * afterValidate is called just after model data was validated, you can use this callback
 * to perform any data cleanup or preparation if needed
 *
 * @param Model $model Model using this behavior
 * @return mixed False will stop this event from being passed to other behaviors
 */
	public function afterValidate(Model $model) {
		$model->LanguagesPage->create(false);
		$model->LanguagesPage->set($model->data['LanguagesPage']);
		if (! $model->LanguagesPage->validates()) {
			$model->validationErrors = Hash::merge($model->validationErrors, $model->LanguagesPage->validationErrors);
			return false;
		}

		return true;
	}

/**
 * afterSave is called after a model is saved.
 *
 * @param Model $model Model using this behavior
 * @param bool $created True if this save created a new record
 * @param array $options Options passed from Model::save().
 * @return bool
 * @throws InternalErrorException
 * @see Model::save()
 */
	public function afterSave(Model $model, $created, $options = array()) {
		$model->LanguagesPage->data['LanguagesPage']['page_id'] = $model->data['Page']['id'];
		if (! $model->LanguagesPage->save(null, false)) {
			throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
		}

		if ($created) {
			if (! $result = $model->saveContainer($model->data)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			$model->data = Hash::merge($model->data, $result);

			if (! $result = $model->saveBox($model->data)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			$model->data = Hash::merge($model->data, $result);

			if (! $result = $model->saveContainersPage($model->data)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			$model->data = Hash::merge($model->data, $result);

			if (! $result = $model->saveBoxesPage($model->data)) {
				throw new InternalErrorException(__d('net_commons', 'Internal Server Error'));
			}
			$model->data = Hash::merge($model->data, $result);
		}

		return parent::afterSave($model, $created, $options);
	}

}
