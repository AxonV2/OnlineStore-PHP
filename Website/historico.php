<?php
session_start();
error_reporting(0);
include('includes/basededados.php');

#no login = para index
if (strlen($_SESSION['login']) == 0) 
{
	header('location:login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Histórico</title>
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/main.css">
		<link rel="stylesheet" href="assets/css/owl.carousel.css">
		<link rel="stylesheet" href="assets/css/owl.transitions.css">
		<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>
	</head>


	<body class="cnt-home">
		<header class="header-style-1">
			<?php include('includes/top-header.php'); ?>
			<?php include('includes/main-header.php'); ?>
			<?php include('includes/menu-bar.php'); ?>
		</header>

		<div class="body-content outer-top-xs">
			<div class="container">
				<div class="row inner-bottom-sm">
					<div class="shopping-cart">
						<div class="col-md-12 col-sm-12 shopping-cart-table ">
							<div class="table-responsive">
								<form name="cart" method="post">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th class="cart-remove item">Num</th>
												<th class="cart-description item">Imagem</th>
												<th class="cart-product-name item">Nome Produto</th>
												<th class="cart-qty item">Quantidade</th>
												<th class="cart-sub-total item">Preço Unidade</th>
												<th class="cart-sub-total item">Shipping</th>
												<th class="cart-total last-item">Total</th>
												<th class="cart-total item">Metodo Pagamento</th>
												<th class="cart-description item">Data de Compra</th>
											</tr>
										</thead>
										<tbody>

											<?php

											#join de orders e products para poder apresentar tudo necessário para o historico
											$query = $con->prepare("SELECT P.imagem1 as img, P.nomeprod as pnome, O.idprod as ordpid, O.quant as quant, P.precoprod as preco, P.taxashipping as shipping, O.pagamento as metpag, O.odata as odate FROM orders as O JOIN products as P on O.idprod=P.id WHERE O.userId=?");
											$query->bindValue(1, $_SESSION['id']);
											$query->execute();
											
											#contador de items para historico
											$num = 1;

											while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
											?>
												<tr>
													<td><?php echo $num; ?></td>
													<td class="cart-image">
														<a class="entry-thumbnail" href="detail.html">
															<img src="productimages/<?php echo $row['img']; ?>" alt="" width="84" height="146">
														</a>
													</td>
													<td class="cart-product-name-info">
														<h4 class='cart-product-description'><a href="product-details.php?pid=<?php echo $row['ordpid']; ?>">
																<?php echo $row['pnome']; ?></a></h4>
													</td>
													<td class="cart-product-quantity">
														<?php echo $quant = $row['quant']; ?>
													</td>
													<td class="cart-product-sub-total"><?php echo $preco = $row['preco']; ?>€</td>
													<td class="cart-product-sub-total"><?php echo $shipping = $row['shipping']; ?>€</td>
													<td class="cart-product-grand-total"><?php echo (($quant * $preco) + $shipping); ?>€</td>
													<td class="cart-product-sub-total"><?php echo $row['metpag']; ?> </td>
													<td class="cart-product-sub-total"><?php echo $row['odate']; ?> </td>
												<?php $num++;
											} ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div> 
			</form>
			</div>
			<?php include('includes/footer.php'); ?>
			<script src="assets/js/jquery-1.11.1.min.js"></script>
			<script src="assets/js/bootstrap.min.js"></script>
			<script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
			<script src="assets/js/owl.carousel.min.js"></script>
			<script src="assets/js/echo.min.js"></script>
			<script src="assets/js/jquery.easing-1.3.min.js"></script>
			<script src="assets/js/bootstrap-slider.min.js"></script>
			<script src="assets/js/bootstrap-select.min.js"></script>
			<script src="assets/js/wow.min.js"></script>
			<script src="assets/js/scripts.js"></script>
	</body>
	</html>