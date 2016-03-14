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

<tr ng-init="pageId = treeList[0]">
	<th class="h2">
		<a ng-href="<?php echo $this->NetCommonsHtml->url('/') . '{{permalink(pageId)}}'; ?>">
			{{pages[pageId]['LanguagesPage']['name']}}
		</a>
		<?php echo $this->LinkButton->edit('', '',
				array(
					'iconSize' => 'btn-xs',
					'ng-href' => $this->NetCommonsHtml->url(array('action' => 'layout')) .
								'/{{pages[pageId][\'Page\'][\'room_id\']}}/{{pageId}}',
				)
			); ?>
	</th>

	<th class="text-right">
		<?php echo $this->LinkButton->add(__d('pages', 'Add new page'), '',
				array(
					'iconSize' => 'btn-xs',
					'ng-href' => $this->NetCommonsHtml->url(array('action' => 'add')) .
								'/{{pages[pageId][\'Page\'][\'room_id\']}}/{{pageId}}',
				)
			); ?>
	</th>
</tr>