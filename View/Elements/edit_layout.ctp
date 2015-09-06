<?php
/**
 * Element of edit layout
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>

<section class="modal fade" id="edit-layout" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<?php echo $this->Form->create('EditLayout', array(
				'type' => 'post',
				'url' => '/pages/pages/layout/' . Current::read('Page.id')
			)); ?>

		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<?php echo __d('pages', 'Edit layout')?>
			</div>

			<div class="modal-body">
				<?php if ($layouts = $this->PageLayout->getLayouts()) : ?>
					<div class="clearfix"
						ng-controller="PagesController"
						ng-init="initialize(<?php echo (int)$this->PageLayout->hasContainer(Container::TYPE_HEADER) . ', ' .
										(int)$this->PageLayout->hasContainer(Container::TYPE_MAJOR) . ', ' .
										(int)$this->PageLayout->hasContainer(Container::TYPE_MINOR) . ', ' .
										(int)$this->PageLayout->hasContainer(Container::TYPE_FOOTER); ?>)">

						<?php echo $this->Form->hidden('Page.id', array(
								'value' => Current::read('Page.id'),
							)); ?>

						<?php foreach (array(Container::TYPE_HEADER, Container::TYPE_MAJOR, Container::TYPE_MINOR, Container::TYPE_FOOTER) as $containerType) : ?>
							<?php echo $this->Form->hidden('ContainersPage.' . $containerType . '.id'); ?>
							<?php echo $this->Form->hidden('ContainersPage.' . $containerType . '.page_id'); ?>
							<?php echo $this->Form->hidden('ContainersPage.' . $containerType . '.container_id'); ?>

							<?php
								if ($containerType === Container::TYPE_HEADER) {
									$ngValue = 'header';
								} elseif ($containerType === Container::TYPE_MAJOR) {
									$ngValue = 'major';
								} elseif ($containerType === Container::TYPE_MINOR) {
									$ngValue = 'minor';
								} elseif ($containerType === Container::TYPE_FOOTER) {
									$ngValue = 'footer';
								}
							?>
							<?php echo $this->Form->hidden('ContainersPage.' . $containerType . '.is_published', array(
									'ng-value' => $ngValue,
								)); ?>
							<?php $this->Form->unlockField('ContainersPage.' . $containerType . '.is_published'); ?>
						<?php endforeach; ?>

						<?php foreach ($layouts as $layout) : ?>
							<a href="" class="pull-left page-edit-layout"
								ng-class="{'bg-primary': (currentLayout === '<?php echo $layout; ?>')}"
								ng-click="selectLayout(<?php echo (int)substr($layout, 0, 1) . ', ' .
									(int)substr($layout, 2, 1) . ', ' .
									(int)substr($layout, 4, 1) . ', ' .
									(int)substr($layout, 6, 1); ?>)">

								<?php echo $this->Html->image('Pages.layouts/' . $layout, array('class' => 'img-thumbnail')); ?>
							</a>
						<?php endforeach; ?>
					</div>

					<div class="page-edit-layout">
						<?php echo $this->Form->checkbox('allPages', array(
								'div' => false,
								'value' => true,
								'disabled' => true
							)); ?>
						<?php echo $this->Form->label('all', __d('pages', 'Save all pages')); ?>
					</div>
				<?php endif; ?>
			</div>

			<div class="modal-footer">
				<div class="text-center">
					<?php echo $this->NetCommonsForm->cancelButton(__d('net_commons', 'Cancel'), '',
							array(
								'data-dismiss' => 'modal',
								'aria-hidden' => 'true',
							)
						); ?>
					<?php echo $this->NetCommonsForm->saveButton(__d('net_commons', 'OK')); ?>
				</div>
			</div>

			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</section>
