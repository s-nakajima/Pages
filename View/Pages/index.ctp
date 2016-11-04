<?php
/**
 * ページ表示 View
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$pageContainer = Hash::combine($page['PageContainer'], '{n}.container_type', '{n}');
echo $this->element('Boxes.render_boxes', array(
		'boxes' => $pageContainer[Container::TYPE_MAIN]['Box'],
		'containerType' => Container::TYPE_MAIN
	));
