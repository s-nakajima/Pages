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
				'url' => '/pages/pages/layout/' . PageLayoutHelper::$page['roomId'] . '/' . PageLayoutHelper::$page['id']
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
								'value' => PageLayoutHelper::$page['id'],
							)); ?>

						<?php echo $this->Form->hidden('ContainersPage.0.id', array(
								'value' => $this->PageLayout->getContainersPageId(Container::TYPE_HEADER)
							)); ?>
						<?php echo $this->Form->hidden('ContainersPage.0.is_published', array(
								'ng-value' => 'header',
							)); ?>
						<?php $this->Form->unlockField('ContainersPage.0.is_published'); ?>

						<?php echo $this->Form->hidden('ContainersPage.1.id', array(
								'value' => $this->PageLayout->getContainersPageId(Container::TYPE_MAJOR)
							)); ?>
						<?php echo $this->Form->hidden('ContainersPage.1.is_published', array(
								'ng-value' => 'major',
							)); ?>
						<?php $this->Form->unlockField('ContainersPage.1.is_published'); ?>

						<?php echo $this->Form->hidden('ContainersPage.2.id', array(
								'value' => $this->PageLayout->getContainersPageId(Container::TYPE_MINOR)
							)); ?>
						<?php echo $this->Form->hidden('ContainersPage.2.is_published', array(
								'ng-value' => 'minor',
							)); ?>
						<?php $this->Form->unlockField('ContainersPage.2.is_published'); ?>

						<?php echo $this->Form->hidden('ContainersPage.3.id', array(
								'value' => $this->PageLayout->getContainersPageId(Container::TYPE_FOOTER)
							)); ?>
						<?php echo $this->Form->hidden('ContainersPage.3.is_published', array(
								'ng-value' => 'footer',
							)); ?>
						<?php $this->Form->unlockField('ContainersPage.3.is_published'); ?>

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
					<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">
						<span class="glyphicon glyphicon-remove"></span>
						<?php echo __d('net_commons', 'Cancel'); ?>
					</button>

					<?php echo $this->Form->button(__d('net_commons', 'OK'), array(
							'class' => 'btn btn-primary btn-workflow',
							'name' => 'save',
						)); ?>
				</div>
			</div>

			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</section>
