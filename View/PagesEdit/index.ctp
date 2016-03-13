<?php
/**
 * ページ設定のindex
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

		<table class="table table-hover" ng-controller="PagesEditController">
			<thead>
				<tr>
					<th>
						<?php echo __d('pages', 'Page name'); ?>
					</th>
					<th class="text-right">
						<?php if ($room['Room']['id'] === Room::PUBLIC_PARENT_ID) : ?>
							<?php echo $this->LinkButton->add(__d('pages', 'Add page'),
									array('action' => 'add', 'key' => $page['Page']['room_id']),
									array('iconSize' => 'btn-xs')
								); ?>
						<?php endif; ?>
					</th>
				</tr>
			</thead>
			<tbody ng-init="initialize(<?php echo $this->PagesEdit->getPagesEditJsInit(); ?>)">
				<?php echo $this->element('PagesEdit/render_index'); ?>
			</tbody>
		</table>
	</article>
</div>
