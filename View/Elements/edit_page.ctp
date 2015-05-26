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

<div class="modal fade" id="page-<?php echo $action; ?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<?php if ($action === 'add') : ?>
					<?php echo __d('pages', 'Add page'); ?>
				<?php else : ?>
					<?php echo __d('pages', 'Edit page'); ?>
				<?php endif; ?>
			</div>

			<div class="modal-body">
				<div class="panel panel-default">
					<?php echo $this->Form->create('Page', array(
							'name' => $action. 'Form',
							'novalidate' => true,
							'action' => $action . '/' . $roomId . '/' . $pageId
						)); ?>

						<div class="panel-body has-feedback">
							<?php echo $this->element('Pages/edit_form', array('action' => $action, 'formPage' => $formPage)); ?>
						</div>

						<div class="panel-footer text-center">
							<button type="button" class="btn btn-default btn-workflow" data-dismiss="modal" aria-hidden="true">
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

				<?php if ($action === 'edit' && $formPage['page']['permalink']) : ?>
					<?php echo $this->element('Pages/delete_form'); ?>
				<?php endif; ?>
			</div>

			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
