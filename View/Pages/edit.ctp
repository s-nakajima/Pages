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

<div class="modal fade in" id="page-setting" tabindex="-1" aria-hidden="false" role="dialog" style="display: block;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" aria-hidden="true" onclick="location.href = '<?php echo Current::backToPageUrl(true); ?>'">&times;</button>
				<?php if ($this->params['action'] === 'add') : ?>
					<?php echo __d('pages', 'Add page'); ?>
				<?php else : ?>
					<?php echo __d('pages', 'Edit page'); ?>
				<?php endif; ?>
			</div>

			<div class="modal-body">
				<div class="panel panel-default">
					<?php echo $this->Form->create('Page', array('novalidate' => true)); ?>

						<div class="panel-body has-feedback">
							<?php echo $this->element('Pages/edit_form', array('action' => $this->params['action'])); ?>
						</div>

						<div class="panel-footer text-center">
							<?php echo $this->Button->cancelAndSave(__d('net_commons', 'Cancel'), __d('net_commons', 'OK'), Current::backToPageUrl(true)); ?>
						</div>
					<?php echo $this->Form->end(); ?>
				</div>

				<?php if ($this->params['action'] === 'edit' && $this->data['Page']['permalink']) : ?>
					<?php echo $this->element('Pages/delete_form'); ?>
				<?php endif; ?>
			</div>

		</div>
	</div>
</div>

