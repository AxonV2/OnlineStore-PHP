<div class="top-bar animate-dropdown">
	<div class="container">
		<div class="header-top-inner">
			<div class="cnt-account">
				<ul class="list-unstyled">
					
					<!-- CHECK DE ADMIN -->
					<?php if ($_SESSION['admin'] == TRUE) { ?>
						<li><a href="admin.php"><i class="icon fa fa-star"></i>ADMIN</a></li>
					<?php } ?>

					<!-- SE LOGGED IN NOME -->
					<?php if (strlen($_SESSION['login'])) { ?>
						<li><a href="#"><i class="icon fa fa-user"></i>Bem Vindo -<?php echo htmlentities($_SESSION['username']); ?></a></li>
					<?php } ?>

					<!-- EXTRAS -->
					<li><a href="my-account.php"><i class="icon fa fa-user"></i>Minha Conta</a></li>
					<li><a href="cart.php"><i class="icon fa fa-shopping-cart"></i>Carrinho</a></li>

					<!-- SE LOGGED IN OU N -->
					<?php if (strlen($_SESSION['login']) == 0) {   ?>
						<li><a href="login.php"><i class="icon fa fa-sign-in"></i>Login</a></li>
					<?php } else { ?>
						<li><a href="logout.php"><i class="icon fa fa-sign-out"></i>Logout</a></li>
					<?php } ?>
				</ul>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	</form>