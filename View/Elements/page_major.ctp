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
<?php if (is_object($this->Layout) && $this->Layout->hasContainer(Container::TYPE_MAJOR)): ?>
	<!-- container-major -->
	<div id="container-major" class="<?php echo $this->Layout->getContainerSize(Container::TYPE_MAJOR); ?>">
		<?php echo $this->element('Boxes.render_boxes', array(
				'boxes' => $this->Layout->getBox(Container::TYPE_MAJOR)
			)); ?>
	</div>
<?php endif;

