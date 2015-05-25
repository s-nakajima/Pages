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

<h1>
	<?php if ($this->params['action'] === 'add') : ?>
		<?php echo __d('pages', 'Add page'); ?>
	<?php else : ?>
		<?php echo __d('pages', 'Edit page'); ?>
	<?php endif; ?>
</h1>

<hr>

<?php echo $this->Form->create('Page', array(
		'name' => 'form',
		'novalidate' => true,
	)); ?>

	<?php echo $this->Form->input('Page.id', array(
			'type' => 'hidden',
			'value' => $formPage['page']['id']
		)); ?>

	<?php echo $this->Form->input('Page.parent_id', array(
			'type' => 'hidden',
			'value' => $formPage['page']['parentId']
		)); ?>

	<?php echo $this->Form->input('Language.0.id', array(
			'type' => 'hidden',
			'value' => isset($formPage['language'][0]['id']) ? $formPage['language'][0]['id'] : $languageId
		)); ?>

	<?php echo $this->Form->input('Language.0.LanguagesPage.language_id', array(
			'type' => 'hidden',
			'value' => isset($formPage['language'][0]['languagesPage']['languageId']) ? $formPage['language'][0]['languagesPage']['languageId'] : $languageId
		)); ?>

	<div class="form-group">
		<?php echo $this->Form->input('Language.0.LanguagesPage.name', array(
				'label' => __d('pages', 'Page name'),
				'class' => 'form-control',
				'error' => false,
				'value' => isset($formPage['language'][0]['languagesPage']['name']) ? $formPage['language'][0]['languagesPage']['name'] : null
			)); ?>

		<?php echo $this->element(
			'NetCommons.errors', [
				'errors' => $this->validationErrors,
				'model' => 'Language.0.LanguagesPage',
				'field' => 'name',
			]) ?>
	</div>

	<div class="form-group">
		<?php echo $this->Form->input('Page.slug', array(
				'label' => __d('pages', 'Slug'),
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

	<div class="text-center">
		<button type="button" class="btn btn-default btn-workflow" onclick="location.href = '<?php echo $cancelUrl; ?>'">
			<span class="glyphicon glyphicon-remove"></span>
			<?php echo __d('net_commons', 'Cancel'); ?>
		</button>

		<?php echo $this->Form->button(__d('net_commons', 'OK'), array(
				'class' => 'btn btn-primary btn-workflow',
				'name' => 'save',
			)); ?>
	</div>
<?php echo $this->Form->end();
