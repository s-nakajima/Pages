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
<?php echo $this->Html->script('/pages/js/pages.js', false); ?>

<div class="modal fade in" id="page-setting" tabindex="-1" aria-hidden="false" role="dialog" style="display: block;">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" aria-hidden="true" onclick="location.href = '<?php echo $cancelUrl; ?>'">&times;</button>
				<?php if ($this->params['action'] === 'add') : ?>
					<?php echo __d('pages', 'Add page'); ?>
				<?php else : ?>
					<?php echo __d('pages', 'Edit page'); ?>
				<?php endif; ?>
			</div>

			<div class="modal-body">
				<div class="panel panel-default">
					<?php echo $this->Form->create('Page', array('name' => 'form', 'novalidate' => true)); ?>

						<div class="panel-body has-feedback">
							<?php echo $this->element('Pages/edit_form', array('action' => $this->params['action'])); ?>
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

				<?php if ($this->params['action'] === 'edit' && $formPage['page']['permalink']) : ?>
					<?php echo $this->element('Pages/delete_form'); ?>
				<?php endif; ?>
			</div>

		</div>
	</div>
</div>

