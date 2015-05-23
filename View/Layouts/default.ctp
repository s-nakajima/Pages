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
<html lang="en" ng-app="NetCommonsApp">
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title><?php echo (isset($pageTitle) ? h($pageTitle) : ''); ?></title>

	<?php
		echo $this->fetch('meta');

		echo $this->element('NetCommons.common_css');
		echo $this->Html->css(array('style'),
			array('plugin' => false)
		);
		echo $this->fetch('css');

		echo $this->element('NetCommons.common_js');
		echo $this->fetch('script');
	?>
</head>

<body ng-controller="NetCommons.base">
	<?php echo $this->element('NetCommons.common_alert'); ?>

	<?php echo $this->element('NetCommons.common_header'); ?>

	<main class="container">
		<?php if ($this->Layout->hasContainer(Container::TYPE_HEADER)): ?>
			<!-- container-header -->
			<header id="container-header">
				<?php
					echo $this->element('Boxes.render_boxes',
						array('boxes' => $this->Layout->getBox(Container::TYPE_HEADER)));
				?>
			</header>
		<?php endif; ?>

		<div class="row">
			<?php if ($this->Layout->hasContainer(Container::TYPE_MAJOR)): ?>
				<!-- container-major -->
				<div id="container-major" class="<?php echo $this->Layout->getContainerSize(Container::TYPE_MAJOR); ?>">
					<?php
						echo $this->element('Boxes.render_boxes',
							array('boxes' => $this->Layout->getBox(Container::TYPE_MAJOR)));
					?>
				</div>
			<?php endif; ?>

			<!-- container-main -->
			<div id="container-main" class="<?php echo $this->Layout->getContainerSize(Container::TYPE_MAIN); ?>" role="main">
				<?php echo $this->fetch('content'); ?>
			</div>

			<?php if ($this->Layout->hasContainer(Container::TYPE_MINOR)): ?>
				<!-- container-minor  -->
				<div id="container-minor" class="<?php echo $this->Layout->getContainerSize(Container::TYPE_MINOR); ?>">
					<?php
						echo $this->element('Boxes.render_boxes',
							array('boxes' => $this->Layout->getBox(Container::TYPE_MINOR)));
					?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ($this->Layout->hasContainer(Container::TYPE_FOOTER)): ?>
			<!-- area-footer  -->
			<footer id="container-footer" role="contentinfo">
				<?php
					echo $this->element('Boxes.render_boxes',
						array('boxes' => $this->Layout->getBox(Container::TYPE_FOOTER)));
				?>
			</footer>
		<?php endif; ?>
	</main>

	<?php echo $this->element('NetCommons.common_footer'); ?>
</body>
</html>
