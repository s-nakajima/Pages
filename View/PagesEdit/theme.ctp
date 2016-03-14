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
			<div class="panel-body">
				<?php echo $this->ThemeSettings->render('PagesEdit/theme_form'); ?>
			</div>
			<div class="panel-footer text-center">
				<?php echo $this->Button->cancel(__d('net_commons', 'List'),
						$this->NetCommonsHtml->url(array('action' => 'index', Current::read('Room.id')))); ?>
			</div>
		</div>
	</article>
</div>

