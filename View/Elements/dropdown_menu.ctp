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
		<a href="#" data-toggle="modal" data-target="#page-add">
			<?php echo __d('pages', 'Add page'); ?>
		</a>
	</li>
	<li>
		<a href="#" data-toggle="modal" data-target="#page-edit">
			<?php echo __d('pages', 'Edit page'); ?>
		</a>
	</li>
	<li class="divider"></li>
	<li>
		<a href="#">
			<?php echo __d('pages', 'Edit layout')?>
		</a>
	</li>
	<li>
		<?php echo $this->Html->link(__d('net_commons', 'Theme setting'), '/theme_settings/site/') ?>
	</li>
</ul>
