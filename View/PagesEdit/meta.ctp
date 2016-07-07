<?php
/**
 * Element of edit layout
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */

echo $this->NetCommonsHtml->script('/pages/js/pages.js');
?>

<div class="control-panel">
	<article>
		<?php echo $this->element('PagesEdit/header'); ?>
		<?php echo $this->element('PagesEdit/tabs'); ?>

		<div class="panel panel-default">
			<?php echo $this->NetCommonsForm->create('EditMeta', array('type' => 'put',
					'url' => $this->NetCommonsHtml->url(array('key' => Current::read('Room.id'), Current::read('Page.id')))
				)); ?>

				<div class="panel-body">
					<?php echo $this->element('PagesEdit/meta_form'); ?>
				</div>

				<div class="panel-footer text-center">
					<?php echo $this->Button->cancelAndSave(__d('net_commons', 'Cancel'), __d('net_commons', 'OK'),
							$this->NetCommonsHtml->url(array('action' => 'index', Current::read('Room.id')))); ?>
				</div>
			<?php echo $this->NetCommonsForm->end(); ?>
		</div>
	</article>
</div>

