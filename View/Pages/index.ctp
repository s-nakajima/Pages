<?php
/**
 * Pages template.
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>
<?php echo $this->Html->script('/pages/js/pages.js', false); ?>

<div>
<?php
if (Page::isSetting()) {
	echo $this->element('Pages.plugin_list');
	echo $this->element('Pages.setting_menu');
}

echo $this->element('Containers.render_containers',
	array(
		'containers' => $pageMainContainer['Container'],
		'boxes' => $pageMainContainer['Box']
	));
?>
</div>
