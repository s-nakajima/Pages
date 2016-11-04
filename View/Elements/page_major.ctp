<?php
/**
 * 右カラム Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<div id="container-major" class="<?php echo $this->PageLayout->containerSize(Container::TYPE_MAJOR); ?>">
	<?php
		echo $this->element('Boxes.render_boxes', array(
			'boxes' => $this->PageLayout->getBox(Container::TYPE_MAJOR),
			'containerType' => Container::TYPE_MAJOR
		));
	?>
</div>

