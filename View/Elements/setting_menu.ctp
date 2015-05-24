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

<?php echo $this->Html->script('/components/jqueryui/ui/jquery-ui.js', false); ?>
<?php echo $this->Html->css('/components/jqueryui/themes/overcast/jquery-ui.min.css', false); ?>

<div id="settingMenu"  class="panel-body btn-group-vertical" title="Setting menu">
	<button type="button" class="btn btn-default" ng-click="changePluginSetting()" ng-disabled="true">
		<?php echo __d('pages', 'Plugin')?>
	</button>
	<button type="button" class="btn btn-default" ng-click="changeLayoutSetting()" ng-disabled="true">
		<?php echo __d('pages', 'Layout')?>
	</button>
	<button type="button" class="btn btn-default" data-toggle="modal" data-target="#pageSetting">
		<?php echo __d('pages', 'Page')?>
	</button>
	<button type="button" class="btn btn-default" ng-disabled="true">
		<?php echo $this->Html->link(__d('pages', 'Setting mode off'), $path) ?>
	</button>
</div>

<div class="modal fade" id="pageSetting" tabindex="-1" role="dialog" aria-labelledby="pageSettingLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<?php echo __d('pages', 'Page Setting'); ?>
			</div>

			<?php
				echo $this->Form->create(
					'Page',
					array(
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

<script>
$('#settingMenu').dialog({
	closeOnEscape: false,
	width: "170px",
	position: {
		my: "right-30 center",
		at: "right center",
		of: window,
		collision: 'none'
	},
	open: function( event, ui ) {
		var titleBar = $("#settingMenu").prev(".ui-dialog-titlebar");
		titleBar.removeClass("ui-widget-header");
		titleBar.addClass("panel-heading");
		titleBar.parent().removeClass("ui-widget-content");
		titleBar.parent().addClass("panel panel-info");
		titleBar.children(".ui-dialog-titlebar-close").hide();
	}
});
</script>
