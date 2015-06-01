<?php
/**
 * Element of dropdown menu
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>

<a href="#" class="dropdown-toggle" data-toggle="dropdown" data-target="#dropdown-page-menu" aria-expanded="false">
	<?php echo __d('pages', 'Page Setting'); ?> <span class="caret"></span>
</a>
<ul id="dropdown-page-menu" class="dropdown-menu" role="menu">
	<li>
		<?php echo $this->Html->link(__d('pages', 'Add page'), '/' . Page::SETTING_MODE_WORD . '/pages/pages/add/' . PageLayoutHelper::$page['roomId'] . '/' . PageLayoutHelper::$page['id']) ?>
	</li>
	<li>
		<?php echo $this->Html->link(__d('pages', 'Edit page'), '/' . Page::SETTING_MODE_WORD . '/pages/pages/edit/' . PageLayoutHelper::$page['roomId'] . '/' . PageLayoutHelper::$page['id']) ?>
	<li class="divider"></li>
	<li class="disabled">
		<a href="#">
			<?php echo __d('pages', 'Edit layout')?>
		</a>
	</li>
	<li>
		<?php echo $this->Html->link(__d('net_commons', 'Theme setting'), '/theme_settings/site/') ?>
	</li>
</ul>
