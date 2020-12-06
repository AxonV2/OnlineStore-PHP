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
	<!-- Head aqui por causa deste script para alerts -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>
</head>
</html>

<?php
session_start();
error_reporting(0);
include('includes/basededados.php');

#no login = para index
if (strlen($_SESSION['login']) == 0) 
{
	header('location:login.php');
}

if (isset($_POST['update'])) 
{
	#$_SESSION['login'] = email antigo, vem do login.php
	$oldEmail = $_SESSION['login'];
	$name = $_POST['name'];
	$contactno = $_POST['contactno'];
	$newEmail = $_POST['nEmail'];

	#se email novo = antigo, não mudar email
	if($newEmail === $oldEmail)
	{
		$query = $con->prepare("UPDATE users SET name=?, contactno = ? WHERE id= ?");
		$query->bindValue(1, $name, PDO::PARAM_STR);
		$query->bindValue(2, $contactno);
		$query->bindValue(3, $_SESSION['id']);
		$query->execute();
		if ($query) 
		{
			$_SESSION['username'] = $name;
			echo "<script>Swal.fire('Sucesso!', 'Alterações efetuadas com sucesso!', 'success');setTimeout(() => {window.location.href= ''}, 1500);</script>";
		}
	}
	else
	{
		#verificar se novo email ja existe
		$query = $con->prepare("SELECT * FROM users WHERE email= ?");
		$query->bindValue(1, $newEmail);
		$query->execute();
		$count = $query->rowCount();

		#se não existir passa para a query UPDATE
		if($count < 1)
		{
			$query2 = $con->prepare("UPDATE users SET email = ?, name=?, contactno = ? WHERE id= ?");
			$query2->bindValue(1, $newEmail);
			$query2->bindValue(2, $name, PDO::PARAM_STR);
			$query2->bindValue(3, $contactno);
			$query2->bindValue(4, $_SESSION['id']);
			$query2->execute();
			if ($query2) 
			{
				$_SESSION['username'] = $name;
				$_SESSION['login'] = $newEmail;
				echo "<script>Swal.fire('Sucesso!', 'Alterações efetuadas com sucesso!', 'success');setTimeout(() => {window.location.href= ''}, 1500);</script>";
			}
			else
			echo "<script>Swal.fire('ERRO', 'Aconteceu algo errado', 'error');setTimeout(() => {window.location.href= ''}, 1500);</script>";
		}
		else
		echo "<script>Swal.fire('ERRO', 'Email já em uso insira outro', 'error');setTimeout(() => {window.location.href= ''}, 1500);</script>";
	}

}

if (isset($_POST['submit'])) 
{
	#md5 para encriptar
	$passAtual = md5($_POST['passA']);
	$passNova = md5($_POST['passN']);
	$passConfirma = md5($_POST['passConf']);

		$query = $con->prepare("UPDATE users set password =? WHERE(id=? AND password = ?)");
		$query->bindValue(1, $passNova);
		$query->bindValue(2, $_SESSION['id']);
		$query->bindValue(3, $passAtual);
		$query->execute();
		$count = $query->rowCount();

		if($passNova != $passConfirma)
		{
			echo "<script>Swal.fire('ERRO', 'Password nova difere da confirmação', 'error');setTimeout(() => {window.location.href= ''}, 1500);</script>";
		}
		else if($count > 0)
		{
			echo "<script>Swal.fire('Sucesso!', 'Password alterada com sucesso!', 'success');setTimeout(() => {window.location.href= ''}, 1500);</script>";
		}
		else 
			echo "<script>Swal.fire('ERRO', 'Password atual errada', 'error');setTimeout(() => {window.location.href= ''}, 1500);</script>";
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
			<div class="checkout-box inner-bottom-sm">
				<div class="row">
					<div class="col-md-8">
						<div class="panel-group checkout-steps" id="accordion">
							<div class="panel panel-default checkout-step-01">
								<div class="panel-heading">
									<h4 class="unicase-checkout-title">
										<a data-toggle="collapse" class="" data-parent="#accordion" href="#collapseOne">
											<span>1</span>Perfil
										</a>
									</h4>
								</div>
								<div id="collapseOne" class="panel-collapse collapse in">
									<div class="panel-body">
										<div class="row">
											<h4>Informação Pessoal</h4>
											<div class="col-md-12 col-sm-12 already-registered-login">

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
															<label class="info-title">Nome<span>*</span></label>
															<input type="text" class="form-control unicase-form-control text-input" id="name" name="name" value="<?php echo $row['name']; ?>" required>
														</div>

														<div class="form-group">
															<label class="info-title">Endereço Email <span>*</span></label>
															<input type="email" class="form-control unicase-form-control text-input" id="nEmail" name="nEmail" value="<?php echo $row['email']; ?>" required>
														</div>
														<div class="form-group">
															<label class="info-title">Contacto <span>*</span></label>
															<input type="text" class="form-control unicase-form-control text-input" id="contactno" name="contactno" value="<?php echo $row['contactno']; ?>" required maxlength="9">
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
											<span>2</span>Alterar Password
										</a>
									</h4>
								</div>
								<div id="collapseTwo" class="panel-collapse collapse">
									<div class="panel-body">
										<form class="register-form" role="form" method="post">

											<div class="form-group">
												<label class="info-title">Password Atual<span>*</span></label>
												<input type="password" class="form-control unicase-form-control text-input" id="passA" name="passA" placeholder="••••••••••••" required>
											</div>

											<div class="form-group">
												<label class="info-title">Nova Password <span>*</span></label>
												<input type="password" class="form-control unicase-form-control text-input" id="passN" name="passN" placeholder="••••••••••••" required>
											</div>

											<div class="form-group">
												<label class="info-title">Confirmar Password <span>*</span></label>
												<input type="password" class="form-control unicase-form-control text-input" id="passConf" name="passConf" placeholder="••••••••••••" required>
											</div>
											<button type="submit" name="submit" class="btn-upper btn btn-primary checkout-page-button">Atualizar</button>
										</form>
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
