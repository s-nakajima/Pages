<?php
/**
 * ルームリストのelement
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<tr ng-repeat="pageId in treeList">
	<td>
		<span class="pages-tree" ng-repeat="i in indent(pageId)"> </span>

		<span class="pages-move">
			<button type="button" class="btn btn-default btn-xs"
					ng-click="saveWeight('up', pageId)" ng-class="{disabled: moveDisabled('up', pageId)}">
				<span class="glyphicon glyphicon-arrow-up"> </span>
			</button>
			<button type="button" class="btn btn-default btn-xs"
					ng-click="saveWeight('down', pageId)" ng-class="{disabled: moveDisabled('down', pageId)}">
				<span class="glyphicon glyphicon-arrow-down"> </span>
			</button>
		</span>

		<span class="pages-move">
			<button type="button" class="btn btn-default btn-xs">
				<?php echo __d('net_commons', 'Move'); ?>
			</button>
		</span>

		<a ng-href="<?php echo $this->NetCommonsHtml->url('/') . '{{permalink(pageId)}}'; ?>">
			{{pages[pageId]['LanguagesPage']['name']}}
		</a>

		<?php echo $this->LinkButton->edit('', '',
				array(
					'iconSize' => 'btn-xs',
					'ng-href' => $this->NetCommonsHtml->url(array('action' => 'edit')) .
								'/{{pages[pageId][\'Page\'][\'room_id\']}}/{{pageId}}',
				)
			); ?>
	</td>

	<td class="text-right">
		<?php echo $this->LinkButton->add(__d('pages', 'Add new page'), '',
				array(
					'iconSize' => 'btn-xs',
					'ng-href' => $this->NetCommonsHtml->url(array('action' => 'add')) .
								'/{{pages[pageId][\'Page\'][\'room_id\']}}/{{pageId}}',
				)
			); ?>
	</td>
</tr>