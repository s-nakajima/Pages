<?php
/**
 * Setting menu element.
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>


<?php echo $this->Form->input('Page.id', array(
		'type' => 'hidden',
		'value' => $formPage['page']['id']
	)); ?>

<?php echo $this->Form->input('Page.parent_id', array(
		'type' => 'hidden',
		'value' => $formPage['page']['parentId']
	)); ?>

<?php echo $this->Form->input('LanguagesPage.id', array(
		'type' => 'hidden',
		'value' => isset($formPage['languagesPage']['id']) ? $formPage['languagesPage']['id'] : null
	)); ?>

<?php echo $this->Form->input('LanguagesPage.language_id', array(
		'type' => 'hidden',
		'value' => isset($formPage['languagesPage']['languageId']) ? $formPage['languagesPage']['languageId'] : $languageId
	)); ?>

<div class="form-group">
	<?php echo $this->Form->input('LanguagesPage.name', array(
			'label' => __d('pages', 'Page name') . $this->element('NetCommons.required'),
			'class' => 'form-control',
			'error' => false,
			'value' => isset($formPage['languagesPage']['name']) ? $formPage['languagesPage']['name'] : null
		)); ?>

	<?php echo $this->element(
		'NetCommons.errors', [
			'errors' => $this->validationErrors,
			'model' => 'LanguagesPage',
			'field' => 'name',
		]) ?>
</div>

<?php if ($formPage['page']['permalink']) : ?>
	<div class="form-group">
		<?php echo $this->Form->input('Page.slug', array(
				'label' => __d('pages', 'Slug') . $this->element('NetCommons.required'),
				'class' => 'form-control',
				'error' => false,
				'value' => isset($formPage['page']['slug']) ? $formPage['page']['slug'] : null
			)); ?>

		<?php echo $this->element(
			'NetCommons.errors', [
				'errors' => $this->validationErrors,
				'model' => 'Page',
				'field' => 'slug',
			]) ?>
	</div>
<?php endif;
