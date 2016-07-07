<?php
/**
 * レイアウト変更画面 View
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Shohei Nakajima <nakajimashouhei@gmail.com>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

echo $this->NetCommonsHtml->script('/pages/js/pages.js');
?>

<div class="control-panel">
	<article>
		<?php echo $this->element('PagesEdit/header'); ?>
		<?php echo $this->element('PagesEdit/tabs'); ?>

		<div class="panel panel-default">

			<?php echo $this->NetCommonsForm->create('EditLayout', array('type' => 'put',
					'url' => $this->NetCommonsHtml->url(array('key' => Current::read('Room.id'), Current::read('Page.id')))
				)); ?>

				<?php if ($layouts = $this->PagesEdit->getLayouts()) : ?>
					<div class="panel-body">
						<div class="clearfix"
							ng-controller="PagesLayoutController"
							ng-init="initialize(<?php echo (int)$this->PageLayout->hasContainer(Container::TYPE_HEADER, true) . ', ' .
											(int)$this->PageLayout->hasContainer(Container::TYPE_MAJOR, true) . ', ' .
											(int)$this->PageLayout->hasContainer(Container::TYPE_MINOR, true) . ', ' .
											(int)$this->PageLayout->hasContainer(Container::TYPE_FOOTER, true); ?>)">

							<?php echo $this->NetCommonsForm->hidden('Page.id', array(
									'value' => Current::read('Page.id'),
								)); ?>
							<?php echo $this->NetCommonsForm->hidden('ChildPage.id'); ?>

							<?php foreach (array(Container::TYPE_HEADER, Container::TYPE_MAJOR, Container::TYPE_MINOR, Container::TYPE_FOOTER) as $containerType) : ?>
								<?php echo $this->NetCommonsForm->hidden('ContainersPage.' . $containerType . '.id'); ?>
								<?php echo $this->NetCommonsForm->hidden('ContainersPage.' . $containerType . '.page_id', array(
										'value' => Current::read('Page.id'),
									)); ?>
								<?php echo $this->NetCommonsForm->hidden('ContainersPage.' . $containerType . '.container_id'); ?>
								<?php echo $this->NetCommonsForm->hidden('ContainersPage.' . $containerType . '.is_configured', array('value' => true)); ?>

								<?php
									if ($containerType === Container::TYPE_HEADER) {
										$ngValue = 'header';
									} elseif ($containerType === Container::TYPE_MAJOR) {
										$ngValue = 'major';
									} elseif ($containerType === Container::TYPE_MINOR) {
										$ngValue = 'minor';
									} elseif ($containerType === Container::TYPE_FOOTER) {
										$ngValue = 'footer';
									}
								?>
								<?php echo $this->NetCommonsForm->hidden('ContainersPage.' . $containerType . '.is_published', array(
										'ng-value' => $ngValue,
									)); ?>
								<?php $this->NetCommonsForm->unlockField('ContainersPage.' . $containerType . '.is_published'); ?>
							<?php endforeach; ?>

							<?php foreach ($layouts as $layout) : ?>
								<a href="" class="pull-left page-edit-layout"
									ng-class="{'bg-primary': (currentLayout === '<?php echo $layout; ?>')}"
									ng-click="selectLayout(<?php echo (int)substr($layout, 0, 1) . ', ' .
										(int)substr($layout, 2, 1) . ', ' .
										(int)substr($layout, 4, 1) . ', ' .
										(int)substr($layout, 6, 1); ?>)">

									<?php echo $this->Html->image('Pages.layouts/' . $layout, array('class' => 'img-thumbnail')); ?>
								</a>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

				<div class="panel-footer text-center">
					<?php echo $this->Button->cancelAndSave(__d('net_commons', 'Cancel'), __d('net_commons', 'OK'),
							$this->NetCommonsHtml->url(array('action' => 'index', Current::read('Room.id')))); ?>
				</div>

			<?php echo $this->NetCommonsForm->end(); ?>
		</div>
	</article>
</div>

