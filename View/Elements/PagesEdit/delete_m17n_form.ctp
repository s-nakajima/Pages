<?php
/**
 * 削除 Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="nc-danger-zone" ng-init="dangerZone=false;">
	<?php echo $this->NetCommonsForm->create('Page', array('type' => 'delete',
				'url' => NetCommonsUrl::actionUrlAsArray(
					array(
						'action' => 'delete_page_language',
						'key' => Current::read('Room.id'),
						'key2' => Current::read('Page.id')
					)
				)
			)); ?>
		<uib-accordion close-others="false">
			<div uib-accordion-group is-open="dangerZone" class="panel-warning">
				<uib-accordion-heading class="clearfix">
					<span style="cursor: pointer">
						<?php echo __d('pages', 'Delete m17n page'); ?>
					</span>
					<span class="pull-right glyphicon" ng-class="{'glyphicon-chevron-down': dangerZone, 'glyphicon-chevron-right': ! dangerZone}"></span>
				</uib-accordion-heading>

				<div class="pull-left">
					<?php echo __d('pages', 'Delete all data associated with the page.'); ?>
				</div>

				<?php echo $this->NetCommonsForm->hidden('Page.id'); ?>
				<?php echo $this->NetCommonsForm->hidden('Room.id'); ?>
				<?php echo $this->NetCommonsForm->hidden('PagesLanguage.id'); ?>
				<?php echo $this->NetCommonsForm->hidden('PagesLanguage.language_id'); ?>
				<?php echo $this->NetCommonsForm->hidden('_NetCommonsUrl.redirect'); ?>

				<?php echo $this->Button->delete(
						__d('net_commons', 'Delete'),
						sprintf(__d('net_commons', 'Deleting the %s. Are you sure to proceed?'), __d('pages', 'Page')),
						array('addClass' => 'pull-right', 'btnType' => 'btn-warning')
					); ?>

			</div>
		</uib-accordion>
	<?php echo $this->NetCommonsForm->end(); ?>
</div>
