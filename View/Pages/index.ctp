<?php
/**
 * Pages template.
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

$page['Container'] = Hash::combine($page['Container'], '{n}.type', '{n}');
$page['Container'] = array(Container::TYPE_MAIN => $page['Container'][Container::TYPE_MAIN]);
$page['Box'] = Hash::combine($page['Box'], '{n}.id', '{n}', '{n}.container_id');

echo $this->element('Boxes.render_boxes', array(
		'boxes' => Hash::get($page['Box'], Hash::get($page, 'Container.' . Container::TYPE_MAIN . '.id')),
		'containerType' => Container::TYPE_MAIN
	));
