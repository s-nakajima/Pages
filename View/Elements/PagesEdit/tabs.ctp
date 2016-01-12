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
	<li class="<?php echo (in_array(Hash::get($this->request->params, 'action'), ['edit', 'add'], true) ? 'active' : ''); ?>">
		<?php
			if ($this->params['action'] === 'add') {
				$title = __d('pages', 'Add page');
			} else {
				$title = __d('pages', 'Edit page');
			}
			if (! $disactive) {
				echo $this->NetCommonsHtml->link($title,
						array('action' => 'index', 'key' => Current::read('Room.id'), Current::read('Page.id')));
			} else {
				echo '<a>' . $title . '</a>';
			}
		?>
	</li>
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