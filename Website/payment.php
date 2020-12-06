<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Pagamento</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/owl.carousel.css">
	<link rel="stylesheet" href="assets/css/owl.transitions.css">
	<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>
</head>
</html>


<?php
session_start();
error_reporting(0);
include('includes/basededados.php');

#no login = para index
if (strlen($_SESSION['login']) == 0) {

	header('location:login.php');
}

if (isset($_POST['submit'])) 
{
	#update do metodo de pagamento de todos os items do cart, pagamento null para atualizar todos
	$query = $con->prepare("UPDATE orders SET pagamento = ? WHERE userId = ? AND pagamento is null");
	$query->bindValue(1, $_POST['pagamento']);
	$query->bindValue(2, $_SESSION['id']);
	$query->execute();

	#unset da variavel cart para limpar
	unset($_SESSION['cart']);
	
	header('location:historico.php');
}
?>

<!DOCTYPE html>
<body class="cnt-home">
	<header class="header-style-1">
		<?php include('includes/top-header.php'); ?>
		<?php include('includes/main-header.php'); ?>
		<?php include('includes/menu-bar.php'); ?>
	</header>

	<div class="body-content outer-top-bd">
		<div class="container">
			<div class="checkout-box faq-page inner-bottom-sm">
				<div class="row">
					<div class="col-md-12">
						<h2>Metodo de Pagamento</h2>
						<div class="panel-group checkout-steps" id="accordion">
							<div class="panel panel-default checkout-step-01">
								<div class="panel-heading">
									<h4 class="unicase-checkout-title">
										<a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
											Selecionar Metodo de Pagamento
										</a>
									</h4>
								</div>
								<div id="collapseOne" class="panel-collapse collapse in">
									<div class="panel-body">
										<form name="payment" method="post">
											<center>
											<input type="radio" name="pagamento" value="Credito/Debito" checked="checked"> Credito/Debito
											<input type="radio" name="pagamento" value="Pagamento por Telemóvel"> Pagamento por Telemóvel
											<input type="radio" name="pagamento" value="Transferência"> Transferência
											<input type="radio" name="pagamento" value="Cartão Pre-Pago"> Cartão Pre-Pago
											<br /><br />
											<input type="submit" value="Confirmar" name="submit" class="btn btn-primary">
											</center>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
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


