<?php
session_start();
error_reporting(0);
include('includes/basededados.php');

#no login = para index
if (strlen($_SESSION['login']) == 0) {
	header('location:index.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Minha Conta</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/owl.carousel.css">
	<link rel="stylesheet" href="assets/css/owl.transitions.css">
	<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<!-- script para alerts php tem que estar depois? -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>
</head>

<body class="cnt-home">
	<header class="header-style-1">
		<?php include('includes/top-header.php'); ?>
		<?php include('includes/main-header.php'); ?>
		<?php include('includes/menu-bar.php'); ?>
	</header>

	<div class="body-content outer-top-bd">
		<div class="container">
			<div class="checkout-box inner-bottom-sm">
				<div class="row">
					<div class="col-md-8">
						<div class="panel-group checkout-steps" id="accordion">
							<div class="panel panel-default checkout-step-01">
								<div class="panel-heading">
									<h4 class="unicase-checkout-title">
										<a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
											<span>1</span>Faturação
										</a>
									</h4>
								</div>
								<div id="collapseOne" class="panel-collapse collapse in">
									<div class="panel-body">
										<div class="row">
											<div class="col-md-12 col-sm-12 already-registered-login">
												<span style="color:red;"></span>

												<?php
												#valores para preencher as caixas do perfil 
												$query = $con->prepare("SELECT * FROM users WHERE id=?");
												#do login -> var Session
												$query->bindValue(1, $_SESSION['id']);
												$query->execute();
												while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
												?>

													<form class="register-form" role="form" method="post">
														<div class="form-group">
															<label class="info-title">Endereço Faturação<span>*</span></label>
															<!-- maior caixa texto -->
															<textarea class="form-control unicase-form-control text-input" name="fatEnd" required><?php echo $row['fatEndereco']; ?></textarea>
														</div>

														<div class="form-group">
															<label class="info-title">Endereço Pais<span>*</span></label>
															<input type="text" class="form-control unicase-form-control text-input" id="fatP" name="fatP" required value="<?php echo $row['fatPais']; ?>">
														</div>
														<div class="form-group">
															<label class="info-title">Endereço Cidade <span>*</span></label>
															<input type="text" class="form-control unicase-form-control text-input" id="fatC" name="fatC" required value="<?php echo $row['fatCid']; ?>">
														</div>
														<div class="form-group">
															<label class="info-title">Endereço PIN <span>*</span></label>
															<input type="text" class="form-control unicase-form-control text-input" id="fatcodpin" name="fatcodpin" required value="<?php echo $row['fatPin']; ?>">
														</div>
														<button type="submit" name="update" class="btn-upper btn btn-primary checkout-page-button">Atualizar</button>
													</form>
												<?php } ?>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="panel panel-default checkout-step-02">
								<div class="panel-heading">
									<h4 class="unicase-checkout-title">
										<a data-toggle="collapse" class="collapsed" data-parent="#accordion" href="#collapseTwo">
											<span>2</span>Envio / Shipping
										</a>
									</h4>
								</div>
								<div id="collapseTwo" class="panel-collapse collapse">
									<div class="panel-body">
										<?php
										#valores para preencher as caixas do perfil 
										$query = $con->prepare("SELECT * FROM users WHERE id=?");
										#do login -> var Session
										$query->bindValue(1, $_SESSION['id']);
										$query->execute();
										while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
										?>
											<form class="register-form" role="form" method="post">
												<div class="form-group">
													<label class="info-title">Endereço Envio<span style="color:red;">*</span></label>
													<!-- maior caixa texto -->
													<textarea class="form-control unicase-form-control text-input" name=" endshipping" required><?php echo $row['endShip']; ?></textarea>
												</div>

												<div class="form-group">
													<label class="info-title">Pais Envio <span style="color:red;">*</span></label>
													<input type="text" class="form-control unicase-form-control text-input" id="endpais" name="endpais" required value="<?php echo $row['endPais']; ?>">
												</div>
												<div class="form-group">
													<label class="info-title">Cidade Envio <span style="color:red;">*</span></label>
													<input type="text" class="form-control unicase-form-control text-input" id="endcid" name="endcid" required value="<?php echo $row['endCid']; ?>">
												</div>
												<div class="form-group">
													<label class="info-title">Envio PIN <span style="color:red;">*</span></label>
													<input type="text" class="form-control unicase-form-control text-input" id="endpin" name="endpin" required value="<?php echo $row['endPin']; ?>">
												</div>
												<button type="submit" name="shipupdate" class="btn-upper btn btn-primary checkout-page-button">Update</button>
											</form>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php include('includes/myaccount-sidebar.php'); ?>
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


<?php
#php aqui por causa do script em cima para custom alerts

#Atualizações

#Endereços faturação
if (isset($_POST['update']))
{
	$baddress = $_POST['fatEnd'];
	$bstate = $_POST['fatP'];
	$bcity = $_POST['fatC'];
	$bpincode = $_POST['fatcodpin'];

	$query = $con->prepare("UPDATE users SET fatEndereco = ?, fatPais = ?, fatCid = ?, fatPin = ? WHERE id= ?");
	$query->bindValue(1, $baddress);
	$query->bindValue(2, $bstate);
	$query->bindValue(3, $bcity);
	$query->bindValue(4, $bpincode);
	$query->bindValue(5, $_SESSION['id']);
	$query->execute();

	if ($query) 
	{
		echo "<script>Swal.fire('Mudança', 'Endereço Atualizado', 'info'); setTimeout(() => {window.location.href= 'enderecos.php'}, 1500);</script>";
	}
	echo "<script>Swal.fire('ERRO', 'Ocorreu um erro ao atualizar endereço', 'error'); setTimeout(() => {window.location.href= 'enderecos.php'}, 1500);</script>";
}


#Endereços envio/shipping
if (isset($_POST['shipupdate'])) 
{
	$saddress = $_POST['endshipping'];
	$sstate = $_POST['endpais'];
	$scity = $_POST['endcid'];
	$spincode = $_POST['endpin'];

	$query = $con->prepare("UPDATE users SET endShip = ?, endPais = ?, endCid = ?, endPin = ? WHERE id= ?");
	$query->bindValue(1, $saddress);
	$query->bindValue(2, $sstate);
	$query->bindValue(3, $scity);
	$query->bindValue(4, $spincode);
	$query->bindValue(5, $_SESSION['id']);
	$query->execute();

	if ($query) 
	{
		echo "<script>Swal.fire('Mudança', 'Endereço Atualizado', 'info'); setTimeout(() => {window.location.href= 'enderecos.php'}, 1500);</script>";
	}
	echo "<script>Swal.fire('ERRO', 'Ocorreu um erro ao atualizar endereço', 'error'); setTimeout(() => {window.location.href= 'enderecos.php'}, 1500);</script>";
}
?>