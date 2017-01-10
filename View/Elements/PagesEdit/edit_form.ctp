<?php
/**
 * 編集・追加画面 Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<?php echo $this->NetCommonsForm->hidden('Page.id'); ?>
<?php echo $this->NetCommonsForm->hidden('Page.root_id'); ?>
<?php echo $this->NetCommonsForm->hidden('Page.parent_id'); ?>
<?php echo $this->NetCommonsForm->hidden('Page.permalink'); ?>
<?php echo $this->NetCommonsForm->hidden('Page.room_id'); ?>
<?php echo $this->NetCommonsForm->hidden('Room.id'); ?>
<?php echo $this->NetCommonsForm->hidden('Room.space_id'); ?>
<?php echo $this->NetCommonsForm->hidden('PagesLanguage.id'); ?>
<?php echo $this->NetCommonsForm->hidden('PagesLanguage.language_id'); ?>

<?php echo $this->NetCommonsForm->input('PagesLanguage.name', array(
		'type' => 'text',
		'label' => __d('pages', 'Page name'),
		'required' => true,
	)); ?>

<div class="form-group">
	<?php echo $this->NetCommonsForm->label('Page.permalink', __d('pages', 'Slug')); ?>

	<div class="input-group">
		<div class="input-group-addon">
			<?php echo h($parentPermalink); ?>
		</div>

		<?php echo $this->NetCommonsForm->input('Page.permalink', array(
				'type' => 'text',
				'label' => false,
				'required' => true,
				'div' => false,
				'error' => false,
			)); ?>
	</div>

	<?php echo $this->NetCommonsForm->error('Page.permalink'); ?>
</div>
