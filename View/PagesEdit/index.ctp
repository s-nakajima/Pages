<?php
/**
 * ページ設定のindex
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

echo $this->NetCommonsHtml->script('/pages/js/pages.js');
?>

<div class="control-panel">
	<article>
		<?php echo $this->element('PagesEdit/header'); ?>

		<?php echo $this->NetCommonsForm->create('Page',
				array(
					'type' => 'post',
					'url' => $this->NetCommonsHtml->url(array('action' => 'move'))
				)
			); ?>

		<?php echo $this->NetCommonsForm->hidden('_NetCommonsUrl.redirect', array('value' =>
			$this->NetCommonsHtml->url(
				array('action' => 'index', Current::read('Room.id'), Current::read('Page.id'),
			)
		))); ?>
		<?php echo $this->NetCommonsForm->hidden('Page.id'); ?>
		<?php echo $this->NetCommonsForm->unlockField('Page.id'); ?>

		<?php echo $this->NetCommonsForm->hidden('Page.room_id', array('value' => Current::read('Room.id'))); ?>

		<?php echo $this->NetCommonsForm->hidden('Page.parent_id'); ?>
		<?php echo $this->NetCommonsForm->unlockField('Page.parent_id'); ?>

		<?php echo $this->NetCommonsForm->hidden('Page.type'); ?>
		<?php echo $this->NetCommonsForm->unlockField('Page.type'); ?>

		<table class="table table-hover" ng-controller="PagesEditController"
				ng-init="initialize(<?php echo h(json_encode($pages)) . ', ' . h(json_encode($treeList)) . ', ' . h(json_encode($parentList)); ?>)">
			<thead>
				<tr ng-init="pageId = treeList[0]">
					<th class="h2">
						<a ng-href="<?php echo $this->NetCommonsHtml->url('/') . '{{permalink(pageId)}}'; ?>">
							{{pages[pageId]['LanguagesPage']['name']}}
						</a>
						<?php echo $this->LinkButton->edit('', '', array(
								'iconSize' => 'btn-xs',
								'ng-href' => $this->NetCommonsHtml->url(array('action' => 'layout')) .
											'/{{pages[pageId][\'Page\'][\'room_id\']}}/{{pageId}}',
							)); ?>
					</th>

					<th class="text-right">
						<?php echo $this->LinkButton->add(__d('pages', 'Add new page'), '', array(
								'iconSize' => 'btn-xs',
								'ng-href' => $this->NetCommonsHtml->url(array('action' => 'add')) .
											'/{{pages[pageId][\'Page\'][\'room_id\']}}/{{pageId}}',
							)); ?>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="pageId in treeList" ng-show="indented(pageId)">
					<td>
						<span class="pages-tree" ng-repeat="i in indent(pageId)"> </span>
						<span class="pages-move" ng-show="indented(pageId)">
							<button type="button" class="btn btn-default btn-xs"
									ng-click="saveWeight('up', pageId)" ng-disabled="moveDisabled('up', pageId)">
								<span class="glyphicon glyphicon-arrow-up"> </span>
							</button>
							<button type="button" class="btn btn-default btn-xs"
									ng-click="saveWeight('down', pageId)" ng-disabled="moveDisabled('down', pageId)">
								<span class="glyphicon glyphicon-arrow-down"> </span>
							</button>
						</span>

						<span class="pages-move" ng-show="indented(pageId)">
							<button type="button" class="btn btn-default btn-xs"
									ng-disabled="moveDisabled('move', pageId)" ng-click="showMoveDialog(pageId)">
								<?php echo __d('net_commons', 'Move'); ?>
							</button>
						</span>

						<a ng-href="<?php echo $this->NetCommonsHtml->url('/') . '{{permalink(pageId)}}'; ?>">
							{{pages[pageId]['LanguagesPage']['name']}}
						</a>

						<?php echo $this->LinkButton->edit('', '', array(
								'iconSize' => 'btn-xs',
								'ng-href' => $this->NetCommonsHtml->url(array('action' => 'edit')) .
											'/{{pages[pageId][\'Page\'][\'room_id\']}}/{{pageId}}',
							)); ?>
					</td>

					<td class="text-right">
						<?php echo $this->LinkButton->add(__d('pages', 'Add new page'), '', array(
								'iconSize' => 'btn-xs',
								'ng-href' => $this->NetCommonsHtml->url(array('action' => 'add')) .
											'/{{pages[pageId][\'Page\'][\'room_id\']}}/{{pageId}}',
							)); ?>
					</td>
				</tr>
			</tbody>
		</table>

		<?php echo $this->NetCommonsForm->end(); ?>
	</article>
</div>
