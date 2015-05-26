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
	//echo $this->element('Pages.plugin_list');
	//echo $this->element('Pages.add_plugin');
	//echo $this->element('Pages.edit_page', array(
	//		'action' => 'add',
	//		'roomId' => $formPage['page']['roomId'],
	//		'pageId' => $formPage['page']['id'],
	//		'formPage' => array()
	//	));
	//echo $this->element('Pages.edit_page', array(
	//		'action' => 'edit',
	//		'roomId' => $formPage['page']['roomId'],
	//		'pageId' => $formPage['page']['id'],
	//		'formPage' => $formPage
	//	));
	//echo $this->element('Pages.setting_menu');
}

echo $this->element('Boxes.render_boxes', array(
		'boxes' => $pageMainContainer['box'][$pageMainContainer['container'][Container::TYPE_MAIN]['id']],
		'containerType' => Container::TYPE_MAIN
	));
