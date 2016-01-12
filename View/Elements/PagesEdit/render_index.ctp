<?php
/**
 * Rooms index template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>

<tr class="<?php echo $this->PagesEdit->activeCss($page); ?>">
	<td>
		<a class="text-muted" href="<?php echo $this->NetCommonsHtml->url(array('key' => $page['Page']['room_id'], $page['Page']['id'])); ?>">
			<?php echo $this->PagesEdit->pageName($page, $nest); ?>
		</a>

		<?php echo $this->LinkButton->edit('',
				array('action' => 'edit', 'key' => $page['Page']['room_id'], $page['Page']['id']),
				array('iconSize' => 'btn-xs')
			); ?>
	</td>

	<td class="text-right">
		<?php echo $this->LinkButton->add(__d('pages', 'Add new page'),
				array('action' => 'add', 'key' => $page['Page']['room_id'], $page['Page']['id']),
				array('iconSize' => 'btn-xs')
			); ?>
	</td>
</tr>
