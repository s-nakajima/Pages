<?php
/**
 * ヘッダーカラム Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<header id="container-header">
	<?php
		echo $this->element('Boxes.render_boxes', array(
			'boxes' => $this->PageLayout->getBox(Container::TYPE_HEADER),
			'containerType' => Container::TYPE_HEADER
		));
	?>
</header>
