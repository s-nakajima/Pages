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
			$this->NetCommonsHtml->url(array(
				'action' => 'index',
				Current::read('Room.id'),
				Current::read('Page.id'),
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
				<?php echo $this->element('PagesEdit/render_head'); ?>
			</thead>
			<tbody>
				<?php echo $this->element('PagesEdit/render_index'); ?>
			</tbody>
		</table>

		<?php echo $this->NetCommonsForm->end(); ?>
	</article>
</div>
