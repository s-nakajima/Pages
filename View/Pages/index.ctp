<?php 
/**
 * Pages template.
 *
 * @copyright Copyright 2014, NetCommons Project
 * @author Kohei Teraguchi <kteraguchi@netcommons.org>
 * @since 3.0.0.0
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 */
?>

<!-- Fixed navbar 別のプラグインとして実装することになる予定 -->
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">NetCommons3 Base</a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
			<li class="active"><a href="#">Home</a></li>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
				<ul class="dropdown-menu">
				<li><a href="#">Action</a></li>
				<li><a href="#">Another action</a></li>
				<li><a href="#">Something else here</a></li>
				<li class="divider"></li>
				<li class="dropdown-header">Nav header</li>
				<li><a href="#">Separated link</a></li>
				<li><a href="#">One more separated link</a></li>
				</ul>
			</li>
			</ul>
		</div>
	</div>
</div>

<?php if (!empty($containers[Configure::read('Containers.type.header')])): ?>
	<!-- container-header -->
	<header id="container-header">
		<?php echo $this->requestAction(
						'containers/containers/index/' . $containers[Configure::read('Containers.type.header')]['id'],
						array('return')); ?>
	</header>
<?php endif; ?>

<div class="container">

	<?php if (!empty($containers[Configure::read('Containers.type.major')])): ?>
		<!-- container-major -->
		<div id="container-major" class="col-sm-3">
			<?php echo $this->requestAction(
							'containers/containers/index/' . $containers[Configure::read('Containers.type.major')]['id'],
							array('return')); ?>
		</div>
	<?php endif; ?>

	<!-- container-main -->
	<div id="container-main" class="col-sm-6" role="main">
		<?php echo $this->requestAction(
						'containers/containers/index/' . $containers[Configure::read('Containers.type.main')]['id'],
						array('return')); ?>
	</div>
	
	<?php if (!empty($containers[Configure::read('Containers.type.minor')])): ?>
		<!-- container-minor  -->
		<div id="container-minor" class="col-sm-3">
			<?php echo $this->requestAction(
							'containers/containers/index/' . $containers[Configure::read('Containers.type.minor')]['id'],
							array('return')); ?>
	</div>
	<?php endif; ?>

</div>

<?php if (!empty($containers[Configure::read('Containers.type.footer')])): ?>
	<!-- area-footer  -->
	<footer id="container-footer" role="contentinfo">
		<?php echo $this->requestAction(
							'containers/containers/index/' . $containers[Configure::read('Containers.type.footer')]['id'],
							array('return')); ?>
	</footer>
<?php endif;
