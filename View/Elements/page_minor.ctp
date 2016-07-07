<?php
/**
 * 左カラム Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>
<?php if (! empty($this->PageLayout) && $this->PageLayout->hasContainer(Container::TYPE_MINOR)): ?>
	<div id="container-minor" class="<?php echo $this->PageLayout->containerSize(Container::TYPE_MINOR); ?>">
		<?php
			echo $this->element('Boxes.render_boxes', array(
					'boxes' => $this->PageLayout->getBox(Container::TYPE_MINOR),
					'containerType' => Container::TYPE_MINOR
				));
		?>
	</div>
<?php endif;
