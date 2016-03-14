<?php
/**
 * Element of edit form.
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>

<?php echo $this->NetCommonsForm->hidden('Page.id'); ?>
<?php echo $this->NetCommonsForm->hidden('Page.root_id'); ?>
<?php echo $this->NetCommonsForm->hidden('Page.parent_id'); ?>
<?php echo $this->NetCommonsForm->hidden('Page.permalink'); ?>
<?php echo $this->NetCommonsForm->hidden('Page.room_id'); ?>
<?php echo $this->NetCommonsForm->hidden('Room.id'); ?>
<?php echo $this->NetCommonsForm->hidden('Room.space_id'); ?>
<?php echo $this->NetCommonsForm->hidden('LanguagesPage.id'); ?>
<?php echo $this->NetCommonsForm->hidden('LanguagesPage.language_id'); ?>

<?php echo $this->NetCommonsForm->input('LanguagesPage.name', array(
		'type' => 'text',
		'label' => __d('pages', 'Page name'),
		'required' => true,
	)); ?>

<?php echo $this->NetCommonsForm->input('Page.slug', array(
		'type' => 'text',
		'label' => __d('pages', 'Slug'),
		'required' => true,
	));
