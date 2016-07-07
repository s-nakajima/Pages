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

$page['Container'] = Hash::combine($page['Container'], '{n}.type', '{n}');
$page['Container'] = array(Container::TYPE_MAIN => $page['Container'][Container::TYPE_MAIN]);
$page['Box'] = Hash::combine($page['Box'], '{n}.id', '{n}', '{n}.container_id');

echo $this->element('Boxes.render_boxes', array(
		'boxes' => Hash::get($page['Box'], Hash::get($page, 'Container.' . Container::TYPE_MAIN . '.id')),
		'containerType' => Container::TYPE_MAIN
	));
