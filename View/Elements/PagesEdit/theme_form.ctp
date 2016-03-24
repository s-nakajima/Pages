<?php
/**
 * Element of edit layout
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

$url = array(
	'action' => 'theme',
	'key' => Current::read('Room.id'),
	Current::read('Page.id'),
	'?' => array('theme' => h($theme['key'])),
);
?>

<?php echo $this->NetCommonsForm->create('EditTheme', array('type' => 'put',
		'url' => $this->NetCommonsHtml->url(array('key' => Current::read('Room.id'), Current::read('Page.id'))),
	)); ?>

	<?php echo $this->NetCommonsForm->hidden('Page.id'); ?>
	<?php echo $this->NetCommonsForm->hidden('Page.theme', array('value' => $theme['key'])); ?>

	<a class="btn btn-default btn-xs" href="<?php echo $this->NetCommonsHtml->url($url); ?>">
		<?php echo __d('net_commons', 'Preview')?>
	</a>

	<?php echo $this->Button->save(__d('net_commons', 'OK'), array('class' => 'btn btn-primary btn-xs')); ?>
<?php echo $this->NetCommonsForm->end();

