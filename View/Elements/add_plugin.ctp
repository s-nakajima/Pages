<?php
/**
 * Element of add page
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
				<?php if ($plugins = $this->PageLayout->getPlugins()) : ?>
				<div class="list-group">
					<?php foreach ($plugins as $plugin) : ?>
						<article class="list-group-item clearfix">
							<?php echo $this->Form->create('FrameAdd' . $plugin['Plugin']['id'], array('type' => 'post', 'url' => '/frames/frames/add')); ?>
								<div class="pull-left">
									<h4 class="list-group-item-heading clearfix">
										<?php echo h($plugin['Plugin']['name']); ?>

										<div class="dropdown inline-block">
											<a id="plugin-authors-<?php echo (int)$boxId . '-' . $plugin['Plugin']['id']; ?>"
													class="btn btn-info btn-xs"
													type="button" data-toggle="dropdown" aria-expanded="false">
												<span class="glyphicon glyphicon-user"></span>
											</a>
											<ul class="dropdown-menu" role="menu" aria-labelledby="plugin-authors-<?php echo (int)$boxId . '-' . $plugin['Plugin']['id']; ?>">
												<?php echo $this->Composer->getAuthors($plugin['Plugin']['key']); ?>
											</ul>
										</div>
									</h4>
									<?php echo $this->Composer->getDescription($plugin['Plugin']['key']); ?>
								</div>
								<div class="pull-right">
									<?php echo $this->Form->hidden('Frame.room_id', array(
											'value' => $roomId,
										)); ?>

									<?php echo $this->Form->hidden('Frame.language_id', array(
											'value' => $languageId,
										)); ?>

									<?php echo $this->Form->hidden('Frame.box_id', array(
											'value' => $boxId,
										)); ?>

									<?php echo $this->Form->hidden('Frame.plugin_key', array(
											'value' => $plugin['Plugin']['key'],
										)); ?>

									<?php echo $this->Form->button(
											'<span class="glyphicon glyphicon-plus"> </span>' . __d('net_commons', 'Add'),
											array(
												'class' => 'btn btn-success btn-workflow',
												'name' => 'save'
											)
										); ?>
								</div>
							<?php echo $this->Form->end(); ?>
						</article>
					<?php endforeach; ?>
				</div>
				<?php endif; ?>
			</div>

			<div class="modal-footer">
				<div class="text-center">
					<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">
						<span class="glyphicon glyphicon-remove"></span>
						<?php echo __d('net_commons', 'Close') ?>
					</button>
				</div>
			</div>
		</div>
	</div>
</section>
