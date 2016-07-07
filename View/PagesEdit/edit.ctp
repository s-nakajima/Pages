<?php
/**
 * 編集・追加画面View
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div class="control-panel">
	<article>
		<?php echo $this->element('PagesEdit/header'); ?>
		<?php echo $this->element('PagesEdit/tabs'); ?>

		<div class="panel panel-default">
			<?php echo $this->NetCommonsForm->create('Page'); ?>

				<div class="panel-body">
					<?php echo $this->element('PagesEdit/edit_form', array('action' => $this->params['action'])); ?>
				</div>

				<div class="panel-footer text-center">
					<?php echo $this->Button->cancelAndSave(__d('net_commons', 'Cancel'), __d('net_commons', 'OK'),
							$this->NetCommonsHtml->url(array('action' => 'index', Current::read('Room.id')))); ?>
				</div>
			<?php echo $this->NetCommonsForm->end(); ?>
		</div>

		<?php if ($this->params['action'] === 'edit') : ?>
			<?php echo $this->element('PagesEdit/delete_form'); ?>
		<?php endif; ?>
	</article>
</div>

