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
<div class="modal fade" id="pluginList" tabindex="-1" role="dialog" aria-labelledby="pluginListLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<?php echo __d('pages', 'Plugin list'); ?>
			</div>

			<div class="modal-body"
				 ng-controller="PluginController"
				 ng-init="initialize(<?php echo h(json_encode($plugins)); ?>)"
			>
				<div class="row">
					<?php
						echo $this->Form->create(
							null,
							array(
								'id' => 'pagesPlugin',
								'url' => '/frames/frames/add'
							));
							/*
							echo $this->Form->input(
								"Frame.box_id",
								array("type"=>"hidden"));
							*/
					?>
						<input name="box_id" type="hidden" ng-model="frames.boxId">
						<input name="plugin_key" type="hidden" ng-model="frames.pluginKey">

						<div class="col-sm-4 col-md-3" ng-repeat="plugin in plugins">
							<div class="thumbnail">
								<img  class="img-thumbnail" alt="{{plugin.plugin.name}}" ng-src="{{snapshot(plugin.plugin.snapshot)}}">
								<div class="text-center">
									<h3>{{plugin.plugin.name}}</h3>
									<button type="button" class="btn btn-primary" ng-click="selectPlugin(plugin.plugin.key)">
										<?php echo __d('pages', 'Add')?>
									</button>
								</div>
							</div>
						</div>
					<?php echo $this->Form->end(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
