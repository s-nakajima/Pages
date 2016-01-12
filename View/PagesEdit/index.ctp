<?php
/**
 * ページ設定
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>

<div class="control-panel">
	<article>
		<?php echo $this->element('PagesEdit/header'); ?>

		<table class="table table-hover">
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
			<tbody>

				<?php
					foreach ($pageTreeList as $pageId => $tree) {
						echo $this->PagesEdit->pageRender($pageId, $tree);
					}
				?>
			</tbody>
		</table>
	</article>
</div>
