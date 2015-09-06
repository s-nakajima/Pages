<?php
/**
 * Pages template.
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@commonsnet.org>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>
<?php $cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework'); ?>
<!DOCTYPE html>
<html lang="<?php echo Configure::read('Config.language') ?>" ng-app="NetCommonsApp">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title><?php echo (isset($pageTitle) ? h($pageTitle) : ''); ?></title>

		<?php
			echo $this->fetch('meta');

			echo $this->element('NetCommons.common_css');
			echo $this->fetch('css');

			echo $this->element('NetCommons.common_js');
			echo $this->fetch('script');
		?>
	</head>

	<body class="modal-open" ng-controller="NetCommons.base">
		<?php echo $this->Session->flash(); ?>

		<?php echo $this->element('NetCommons.common_header'); ?>

		<main class="<?php echo $this->PageLayout->getContainerFluid(); ?>">
			<?php echo $this->element('Pages.page_header'); ?>

			<div class="row">
				<!-- container-main -->
				<div role="main" id="container-main" class="<?php echo $this->PageLayout->getContainerSize(Container::TYPE_MAIN); ?>">
					<?php if ($this->request->params['plugin'] === 'pages') : ?>
						<?php echo $this->fetch('content'); ?>
					<?php else : ?>
						<?php echo $this->element('Frames.frame', array(
								'frame' => $this->PageLayout->frame,
								'view' => $this->fetch('content')
							)); ?>
					<?php endif; ?>
				</div>

				<?php echo $this->element('Pages.page_major'); ?>

				<?php echo $this->element('Pages.page_minor'); ?>
			</div>

			<?php echo $this->element('Pages.page_footer'); ?>
		</main>

		<?php echo $this->element('NetCommons.common_footer'); ?>

		<div class="modal-backdrop fade in"></div>
	</body>
</html>
