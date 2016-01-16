<?php
/**
 * ページ設定のヘッダー(タイトル)Element
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->NetCommonsHtml->css('/control_panel/css/style.css');
?>

<h1>
	<?php echo __d('pages', 'Page Setting'); ?>
	<small>
		<?php echo sprintf(__d('pages', '(%s)'), $this->PagesEdit->roomName()); ?>
	</small>
</h1>
<hr>
