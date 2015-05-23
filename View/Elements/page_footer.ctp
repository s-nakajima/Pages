<?php
/**
 * Element of page footer
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>
<?php if ($this->Layout->hasContainer(Container::TYPE_FOOTER)): ?>
	<!-- area-footer -->
	<footer id="container-footer" role="contentinfo">
		<?php
			echo $this->element('Boxes.render_boxes',
				array('boxes' => $this->Layout->getBox(Container::TYPE_FOOTER)));
		?>
	</footer>
<?php endif; 

