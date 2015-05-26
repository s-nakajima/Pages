<?php
/**
 * Pages template.
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>
<section class="modal fade" id="add-plugin-<?php echo (int)$boxId; ?>" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<?php echo __d('pages', 'Add plugin'); ?>
			</div>

			<div class="modal-body">
				<div class="list-group">
					<?php foreach ($plugins as $plugin) : ?>
						<article class="list-group-item clearfix">
							<?php echo $this->Form->create(null, array('type' => 'post' ,'url' => '/frames/frames/add')); ?>
								<div class="pull-left inline-block">
									<?php echo $this->Form->hidden('Frame.box_id', array(
											'value' => $boxId,
										)); ?>

									<?php echo $this->Form->hidden('Frame.plugin_key', array(
											'value' => $plugin['plugin']['key'],
										)); ?>

									<button type="submit" name="save" class="btn btn-success">
										<span class="glyphicon glyphicon-plus"> </span>
										<?php echo __d('pages', 'Add'); ?>
									</button>
								</div>
								<div class="pull-left">
									<h4 class="list-group-item-heading">
										<?php echo h($plugin['plugin']['name']); ?>
									</h4>
									<?php echo $this->Composer->getAuthors($plugin['plugin']['key']); ?>
								</div>
							<?php echo $this->Form->end(); ?>
						</article>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
