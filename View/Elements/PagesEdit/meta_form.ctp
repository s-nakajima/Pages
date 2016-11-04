<?php
/**
 * メタデータ編集 Element
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>

<?php echo $this->NetCommonsForm->hidden('Page.id'); ?>
<?php echo $this->NetCommonsForm->hidden('PagesLanguage.id'); ?>
<?php echo $this->NetCommonsForm->hidden('PagesLanguage.language_id'); ?>

<?php echo $this->NetCommonsForm->input('PagesLanguage.meta_title', array(
		'type' => 'text',
		'label' => __d('pages', 'Title tag (&lt;title&gt;&lt;/title&gt;)'),
		'required' => true,
		'help' => $this->PagesEdit->helpMetaTitle(),
	)); ?>

<?php echo $this->NetCommonsForm->input('PagesLanguage.meta_description', array(
		'type' => 'text',
		'label' => __d('pages', 'META description'),
		'help' => __d('pages', 'Set page description for the robot type search engine.'),
	)); ?>

<?php echo $this->NetCommonsForm->input('PagesLanguage.meta_keywords', array(
		'type' => 'text',
		'label' => __d('pages', 'META keywords'),
		'help' => __d('pages', 'Yon can set search keywords for the robot type search engine.Multi-keywords can be delimited by comma. ' .
								'Please note that it might be judged spam when describing more than the necessity.<br />' .
								'(exp: NetCommons,School,Research)'),
	));
