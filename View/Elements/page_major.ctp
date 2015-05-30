<?php
/**
 * Element of page major
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>
<?php if (! empty($this->PageLayout) && $this->PageLayout->hasContainer(Container::TYPE_MAJOR)): ?>
	<!-- container-major -->
	<div id="container-major" class="<?php echo $this->PageLayout->getContainerSize(Container::TYPE_MAJOR); ?>">
		<?php echo $this->element('Boxes.render_boxes', array(
				'boxes' => $this->PageLayout->getBox(Container::TYPE_MAJOR),
				'containerType' => Container::TYPE_MAJOR
			)); ?>
	</div>
<?php endif;

