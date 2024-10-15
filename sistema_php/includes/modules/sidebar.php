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
				<li>
					<a href="./vista_menu_opciones.php" class="nav-link">
						<i class="fa-solid fa-house"></i>
						<p>INICIO</p>
					</a>
				</li>
				<li>
					<a href="./vista_reporte_ingresos.php" class="nav-link">
						<i class="fa-solid fa-table-columns"></i>&nbsp;
						<i class="fa-solid fa-money-bill-trend-up"></i>
						<p>REPORTE DE INGRESOS</p>
					</a>
				</li>
				<li>
					<a href="./vista_reporte_gastos.php" class="nav-link">
						<i class="fa-solid fa-table-columns"></i>&nbsp;
						<i class="fa-solid fa-receipt"></i>
						<p>REPORTE DE GASTOS</p>
					</a>
				</li>
				<li>
					<a href="./vista_presupuestos.php" class="nav-link">
						<i class="fa-solid fa-money-check-dollar"></i>
						<p>PRESUPUESTOS</p>
					</a>
				</li>
				<li>
					<a href="./vista_cuentas.php" class="nav-link">
						<i class="fa-solid fa-wallet"></i>
						<p>CUENTAS</p><!-- propias -->
					</a>
				</li>
				<li>
					<a href="./vista_movimientos_cuentas.php" class="nav-link">
						<i class="fa-solid fa-money-bill-transfer"></i>
						<p>MOVIMIENTOS PROPIOS</p>
					</a>
				</li>
				<li>
					<a href="./vista_categorias.php" class="nav-link">
						<i class="fa-solid fa-tags"></i>
						<p>CATEGORÍAS</p><!-- para ingresos y gastos, es la tabla, desde aqui se agregan o asi-->
					</a>
				</li>
				<li>
					<a href="./cerrar_sesion.php" class="nav-link">
						<i class="fa-solid fa-arrow-right-from-bracket"></i>
						<p>SALIR</p>
					</a>
				</li>
			</ul>
		</nav>
	</div>
</aside>