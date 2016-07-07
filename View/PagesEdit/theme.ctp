<?php
/**
 * テーマ設定 View
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->NetCommonsHtml->script('/pages/js/pages.js');
?>

<div class="control-panel">
	<article>
		<?php echo $this->element('PagesEdit/header'); ?>
		<?php echo $this->element('PagesEdit/tabs'); ?>

		<div class="panel panel-default">
			<div class="panel-body">
				<?php echo $this->ThemeSettings->render('PagesEdit/theme_form'); ?>
			</div>
			<div class="panel-footer text-center">
				<?php echo $this->Button->cancel(__d('net_commons', 'List'),
						$this->NetCommonsHtml->url(array('action' => 'index', Current::read('Room.id')))); ?>
			</div>
		</div>
	</article>
</div>

