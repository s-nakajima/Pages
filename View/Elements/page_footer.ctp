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
<?php if (! empty($this->PageLayout) && $this->PageLayout->hasContainer(Container::TYPE_FOOTER)): ?>
	<footer id="container-footer" role="contentinfo">
		<?php
			echo $this->element('Boxes.render_boxes', array(
				'boxes' => $this->PageLayout->getBox(Container::TYPE_FOOTER),
				'containerType' => Container::TYPE_FOOTER
			));
		?>
	</footer>
<?php endif;

