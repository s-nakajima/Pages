<?php
/**
 * Element of edit layout
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

echo $this->Html->script(
	array(
		'/pages/js/pages.js'
	),
	array(
		'plugin' => false,
		'once' => true,
		'inline' => false
	)
);
?>

<section class="modal fade" id="edit-layout" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
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

						<?php foreach ($layouts as $layout) : ?>
							<a href="" class="pull-left" style="margin: 8px; padding: 2px"
								ng-class="{'bg-primary': (currentLayout === '<?php echo $layout; ?>')}"
								ng-click="selectLayout(<?php echo (int)substr($layout, 0, 1) . ', ' .
									(int)substr($layout, 2, 1) . ', ' .
									(int)substr($layout, 4, 1) . ', ' .
									(int)substr($layout, 6, 1); ?>)">

								<?php echo $this->Html->image('Pages.layouts/' . $layout, array('class' => 'img-thumbnail')); ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
