<?php
/**
 * Element of dropdown menu
 * 後で削除
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>

<a href="" class="dropdown-toggle" data-toggle="dropdown">
	<?php echo __d('pages', 'Page Setting'); ?> <span class="caret"></span>
</a>
<ul class="dropdown-menu">
	<li>
		<?php echo $this->NetCommonsHtml->link(__d('pages', 'Add page'), '/' . Current::SETTING_MODE_WORD . '/pages/pages/add/' . Current::read('Page.id')) ?>
	</li>
	<li>
		<?php echo $this->NetCommonsHtml->link(__d('pages', 'Edit page'), '/' . Current::SETTING_MODE_WORD . '/pages/pages/edit/' . Current::read('Page.id')) ?>
	<li class="divider"></li>
	<li>
		<a href="" data-toggle="modal" data-target="#edit-layout">
			<?php echo __d('pages', 'Edit layout')?>
		</a>
	</li>
	<li>
		<?php echo $this->NetCommonsHtml->link(__d('net_commons', 'Theme setting'), '/theme_settings/site/') ?>
	</li>
</ul>
