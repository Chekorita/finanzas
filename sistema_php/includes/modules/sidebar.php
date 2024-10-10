<aside class="app-sidebar bg-body-secondary shadow">
	<div class="sidebar-brand">
		<a href="./index.php" class="brand-link">
			<img src="<?php echo ICONS.NOMBRE_LOGOS; ?>LIGHT.png" alt="LOGO" class="brand-image">
		</a>
	</div>
	<div class="sidebar-wrapper">
		<nav class="mt-2">
			<ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
				<li class="nav-header">OPCIONES DISPONIBLES</li>
				<?php echo obtener_opciones_sidebar(); ?>
			</ul>
		</nav>
	</div>
</aside>