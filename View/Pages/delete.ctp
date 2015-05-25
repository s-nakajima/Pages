<?php
/**
 * Delete template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->Form->create('Page', array('type' => 'delete')); ?>
	<div class="panel panel-danger">
		<div class="panel-heading">
			<?php echo __d('net_commons', 'Danger Zone'); ?>
			- <?php echo sprintf(__d('pages', 'Delete "%s"'), h($formPage['languagesPage']['name'])); ?>
		</div>

		<div class="panel-body">

			<div class="inline-block">
				<?php echo sprintf(__d('net_commons', 'Delete all data associated with the %s.'), __d('pages', 'Page', h($formPage['languagesPage']['name']))); ?>
			</div>

			<?php echo $this->Form->input('Page.id', array(
					'type' => 'hidden',
					'value' => $formPage['page']['id']
				)); ?>
			<?php echo $this->Form->button('<span class="glyphicon glyphicon-trash"> </span> ' . __d('net_commons', 'Delete'), array(
					'name' => 'delete',
					'class' => 'btn btn-danger pull-right',
					'onclick' => 'return confirm(\'' . sprintf(__d('net_commons', 'Deleting the %s. Are you sure to proceed?'), __d('pages', 'Page')) . '\')'
				)); ?>
		</div>
	</div>
<?php echo $this->Form->end();
