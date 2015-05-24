<?php
/**
 * Setting menu element.
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>

<div class="modal fade" id="page-setting" tabindex="-1" role="dialog" aria-labelledby="pageSettingLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<?php echo __d('pages', 'Page Setting'); ?>
			</div>

			<?php
				echo $this->Form->create('Page', array(
						//'id' => 'pagesAdd',
						'url' => array(
							'plugin' => 'pages',
							'controller' => 'pages',
							'action' => 'add'
						),
						'role' => 'form'
					));
				echo $this->Form->input('Page.parent_id', array('type' => 'hidden'));
				echo $this->Form->input(
					'Language.0.id',
					array(
						'type' => 'hidden',
						'value' => $page['language'][0]['id']
					));
				echo $this->Form->input(
					'Language.0.LanguagesPage.language_id',
					array(
						'type' => 'hidden',
						'value' => $page['language'][0]['languagesPage']['languageId']
					));
			?>
				<div class="modal-body" ng-controller="PluginController">
					<div class="form-group">
						<?php
							echo $this->Form->input(
								'Language.0.LanguagesPage.name',
								array(
									'label' => __d('pages', 'Page name'),
									'class' => 'form-control'
								));
						?>
					</div>
					<div class="form-group">
						<?php
							echo $this->Form->input(
								'Page.slug',
								array(
									'label' => __d('pages', 'Slug'),
									'class' => 'form-control'
								));
						?>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo __d('net_commons', 'Close') ?></button>
					<button type="submit" class="btn btn-primary"><?php echo __d('pages', 'Add') ?></button>
					<button type="submit" class="btn btn-primary"><?php echo __d('pages', 'Add and close') ?></button>
				</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
