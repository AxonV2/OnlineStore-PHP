<?php
session_start();
error_reporting(0);
include('includes/basededados.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title> Password Esquecida</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
	<!-- script para alerts php tem que estar depois? -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>

	<header class="header-style-1">
		<?php include('includes/top-header.php'); ?>
		<?php include('includes/main-header.php'); ?>
		<?php include('includes/menu-bar.php'); ?>
	</header>

	<div class="body-content outer-top-bd">
		<div class="container">
			<div class="sign-in-page inner-bottom-sm">
				<div class="row">
					<div class="col-md-6 col-sm-6 sign-in">
						<h4 class="">Recuperar Conta</h4>
						<form class="register-form outer-top-xs" name="register" method="post">
							<!-- span vermelho -->
							<span style="color:red;"></span>

							<!-- multiplos div para sep melhor -->
							<div class="form-group">
								<label class="info-title"> Endereço Email <span>*</span></label>
								<input type="email" name="email" class="form-control unicase-form-control text-input" required>
							</div>

							<div class="form-group">
								<label class="info-title">Contacto <span>*</span></label>
								<input type="text" class="form-control unicase-form-control text-input" id="contacto" name="contacto" maxlength="9" required>
							</div>

							<div class="form-group">
								<label class="info-title">Password <span>*</span></label>
								<input type="password" class="form-control unicase-form-control text-input" id="password" name="password" required>
							</div>

							<div class="form-group">
								<label class="info-title">Confirmar Password <span>*</span></label>
								<input type="password" class="form-control unicase-form-control text-input" id="confirmpassword" name="confirmpassword" required>
							</div>

							<button type="submit" class="btn-upper btn btn-primary checkout-page-button" name="change">Submeter</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include('includes/footer.php'); ?>
	</body>
</html>


<?php
#mudar PW
if (isset($_POST['change'])) 
{
	$email = $_POST['email'];
	$contacto = $_POST['contacto'];
	#md5 para encriptar
	$password = md5($_POST['password']);
	$confirmPW = md5($_POST['confirmpassword']);


	$query = $con->prepare("SELECT * FROM users WHERE email=? and contactno=?");
	$query->bindValue(1, $email, PDO::PARAM_STR);
	$query->bindValue(2, $contacto, PDO::PARAM_INT);
	$query->execute();
	$count = $query->fetch(PDO::FETCH_ASSOC);

	if ($password != $confirmPW) 
	{
		echo "<script>Swal.fire('Erro!', 'Password difere da confirmação PW!', 'error');setTimeout(() => {window.location.href= ''}, 1500);</script>";
	}
	else if ($count > 0) 
	{
		$query = $con->prepare("UPDATE users SET password=? WHERE email=? and contactno=? ");
		$query->bindValue(1, $password);
		$query->bindValue(2, $email, PDO::PARAM_STR);
		$query->bindValue(3, $contacto, PDO::PARAM_INT);
		$query->execute();
		$count = $query->fetch(PDO::FETCH_ASSOC);

		echo "<script>Swal.fire('Sucesso!', 'Password mudada com sucesso!', 'success');setTimeout(() => {window.location.href= ''}, 1500);</script>";
	} 
	else 
	{
		echo "<script>Swal.fire('Erro!', 'Email OU contacto invalido!', 'error');setTimeout(() => {window.location.href= ''}, 1500);</script>";
	}
}

?>