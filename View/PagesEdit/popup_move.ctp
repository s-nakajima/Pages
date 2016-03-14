<?php
/**
 * ページ設定のindex
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>

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
<?php echo $this->NetCommonsForm->hidden('Page.id', array('value' => Current::read('Page.id'))); ?>
<?php echo $this->NetCommonsForm->hidden('Page.room_id', array('value' => Current::read('Room.id'))); ?>
<?php echo $this->NetCommonsForm->unlockField('Page.parent_id'); ?>
<?php echo $this->NetCommonsForm->hidden('Page.type', array('value' => 'move')); ?>

<table class="table table-hover">
	<tbody>
		<?php foreach ($treeList as $pageId) : ?>
		<tr>
			<td>
				<?php echo $this->PagesEdit->indent($pageId); ?>
				<?php echo $this->PagesEdit->radioPageMove($pageId); ?>

				<?php echo h(Hash::get($pages, $pageId . '.LanguagesPage.name')); ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<hr>

<div class="text-center">
	<button name="cancel" type="button" ng-disabled="sending" ng-click="cancel()" class="btn btn-default btn-workflow">
		<span class="glyphicon glyphicon-remove"></span> <?php echo __d('net_commons', 'Cancel'); ?>
	</button>
	<button type="submit" ng-disabled="sending" class="btn btn-primary btn-workflow" name="save">
		<?php echo __d('net_commons', 'OK'); ?>
	</button>
</div>

<?php echo $this->NetCommonsForm->end();
