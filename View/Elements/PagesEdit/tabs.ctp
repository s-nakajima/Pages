<?php
/**
 * タブElement
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

$disactive = (Hash::get($this->request->params, 'action') === 'add' ? 'disabled' : '');
?>

<ul class="nav nav-tabs" role="tablist">
	<?php
		if (Current::read('Page.parent_id') || $this->params['action'] === 'add') {
			echo '<li class="' . (in_array(Hash::get($this->request->params, 'action'), ['edit', 'add'], true) ? 'active' : '') . '">';
			if ($this->params['action'] === 'add') {
				$title = __d('pages', 'Add page');
				$action = 'add';
			} else {
				$title = __d('pages', 'Edit page');
				$action = 'edit';
			}
			if (! $disactive) {
				echo $this->NetCommonsHtml->link($title,
						array('action' => $action, 'key' => Current::read('Room.id'), Current::read('Page.id')));
			} else {
				echo '<a>' . $title . '</a>';
			}
			echo '</li>';
		}
	?>

	<li class="<?php echo (Hash::get($this->request->params, 'action') === 'layout' ? 'active' : $disactive); ?>">
		<?php
			if (! $disactive) {
				echo $this->NetCommonsHtml->link(__d('pages', 'Edit layout'),
						array('action' => 'layout', 'key' => Current::read('Room.id'), Current::read('Page.id')));
			} else {
				echo '<a>' . __d('pages', 'Edit layout') . '</a>';
			}
		?>
	</li>
	<li class="<?php echo (Hash::get($this->request->params, 'action') === 'theme' ? 'active' : $disactive); ?>">
		<?php
			if (! $disactive) {
				echo $this->NetCommonsHtml->link(__d('pages', 'Theme setting'),
						array('action' => 'theme', 'key' => Current::read('Room.id'), Current::read('Page.id')));
			} else {
				echo '<a>' . __d('pages', 'Theme setting') . '</a>';
			}
		?>
	</li>
</ul>
<br>