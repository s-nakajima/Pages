<?php
/**
 * Element of page header
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>

<?php if (Current::permission('page_editable')): ?>
	<?php echo $this->element('Pages.edit_layout'); ?>
<?php endif; ?>

<?php if (! empty($this->PageLayout) && $this->PageLayout->hasContainer(Container::TYPE_HEADER)): ?>
	<!-- container-header -->
	<header id="container-header">
		<?php echo $this->element('Boxes.render_boxes', array(
				'boxes' => $this->PageLayout->getBox(Container::TYPE_HEADER),
				'containerType' => Container::TYPE_HEADER
			)); ?>
	</header>
<?php endif;
