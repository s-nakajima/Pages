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

<?php echo $this->Form->hidden('Page.id'); ?>
<?php echo $this->Form->hidden('Page.parent_id'); ?>
<?php echo $this->Form->hidden('Page.permalink'); ?>
<?php echo $this->Form->hidden('Page.room_id'); ?>
<?php echo $this->Form->hidden('Room.id'); ?>
<?php echo $this->Form->hidden('Room.space_id'); ?>
<?php echo $this->Form->hidden('LanguagesPage.id'); ?>
<?php echo $this->Form->hidden('LanguagesPage.language_id'); ?>

<?php echo $this->NetCommonsForm->input('LanguagesPage.name', array(
		'type' => 'text',
		'label' => __d('pages', 'Page name'),
		'required' => true,
	)); ?>

<?php if ($action === 'add' || isset($this->data['Page']['permalink']) && $this->data['Page']['permalink']) : ?>
	<?php echo $this->NetCommonsForm->input('Page.slug', array(
			'type' => 'text',
			'label' => __d('pages', 'Slug'),
			'required' => true,
		)); ?>
<?php endif;
