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
	<small>
		<?php if ($this->params['action'] === 'add') : ?>
			<?php echo __d('pages', 'Add page'); ?>
		<?php else : ?>
			<?php echo __d('pages', 'Edit page'); ?>
		<?php endif; ?>
	</small>
</h1>

<div class="panel panel-default">
	<?php echo $this->Form->create('Page', array('name' => 'form', 'novalidate' => true)); ?>

		<div class="panel-body has-feedback">

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

			<?php if ($page['page']['permalink']) : ?>
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
			<?php endif; ?>
		</div>

		<div class="panel-footer text-center">
			<button type="button" class="btn btn-default btn-workflow" onclick="location.href = '<?php echo $cancelUrl; ?>'">
				<span class="glyphicon glyphicon-remove"></span>
				<?php echo __d('net_commons', 'Cancel'); ?>
			</button>

			<?php echo $this->Form->button(__d('net_commons', 'OK'), array(
					'class' => 'btn btn-primary btn-workflow',
					'name' => 'save',
				)); ?>
		</div>
	<?php echo $this->Form->end(); ?>
</div>

