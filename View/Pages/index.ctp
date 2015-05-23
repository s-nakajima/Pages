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

<?php
if (Page::isSetting()) {
	echo $this->element('Pages.plugin_list');
	echo $this->element('Pages.setting_menu');
}

echo $this->element('Boxes.render_boxes',
	array('boxes' => $pageMainContainer['Box'][$pageMainContainer['Container'][Container::TYPE_MAIN]['id']]));
