<?php
session_start();
error_reporting(0);
include('includes/basededados.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Log-in | Registo</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="assets/css/main.css">
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
			<div class="sign-in-page inner-bottom-sm">
				<div class="row">
					<div class="col-md-6 col-sm-6 sign-in">
						<h4 class="">LOGIN</h4>
						<form class="register-form outer-top-xs" method="post">

							<!-- span vermelho -->
							<span style="color:red;">
							</span>

							<!-- login -->
							<div class="form-group">
								<label class="info-title"> Endereço Email <span>*</span></label>
								<input type="email" name="email" class="form-control unicase-form-control text-input" required>
							</div>

							<div class="form-group">
								<label class="info-title"> Password <span>*</span></label>
								<input type="password" name="password" class="form-control unicase-form-control text-input" required>
							</div>

							<div class="radio outer-xs">
								<a href="forgot-password.php" class="forgot-password pull-right">Password esquecida?</a>
							</div>
							<button type="submit" class="btn-upper btn btn-primary checkout-page-button" name="login">Login</button>
						</form>
					</div>


					<!-- registo -->
					<div class="col-md-6 col-sm-6 create-new-account">
						<h4 class="checkout-subtitle">Nova Conta</h4>
						<form class="register-form outer-top-xs" role="form" method="post" name="register">

							<div class="form-group">
								<label class="info-title">Nome Completo <span>*</span></label>
								<input type="text" class="form-control unicase-form-control text-input" id="fullname" name="fullname" required>
							</div>


							<div class="form-group">
								<label class="info-title">Endereço Email <span>*</span></label>
								<input type="email" class="form-control unicase-form-control text-input" id="email" name="emailid" required>
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

							<button type="submit" name="registo" class="btn-upper btn btn-primary checkout-page-button" id="registo">Registar</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>

</html>

<?php include('includes/footer.php');

if (isset($_POST['registo'])) {

	$nome = $_POST['fullname'];
	$email = $_POST['emailid'];
	$contacto = $_POST['contacto'];

	#md5 para encriptar
	$password = md5($_POST['password']);
	$confirmPW = md5($_POST['confirmpassword']);

	#$result =mysqli_query($con,"SELECT * FROM users WHERE email='$email'");
	#$count=mysqli_fetch_array($query);

	$query = $con->prepare("SELECT * FROM users Where email= ?");
	$query->bindValue(1, $email);
	$query->execute();
	$count = $query->rowCount();

	if ($count > 0) 
	{
		#echo '<script language="javascript">';
		#echo 'alert("Email ja em uso insira outro")';
		#echo '</script>';
		echo "<script>Swal.fire('Erro!', 'Email já em uso!', 'error');setTimeout(() => {window.location.href= ''}, 1500);</script>";
	} 
	else if ($password != $confirmPW)
	{
		#echo '<script language="javascript">';
		#echo 'alert("Confirmação de password errada")';
		#echo '</script>';
		echo "<script>Swal.fire('Erro!', 'Password e confirmação diferem!', 'error');setTimeout(() => {window.location.href= ''}, 1500);</script>";
	} 
	else 
	{
		#$query=mysqli_query($con,"INSERT INTO users(nome,email,contactno,password) VALUES('$nome','$email','$contacto','$password')");
		$query = $con->prepare("INSERT INTO users(name,email,contactno,password) VALUES(?,?,?,?)");

		$query->bindValue(1, $nome, PDO::PARAM_STR);
		$query->bindValue(2, $email, PDO::PARAM_STR);
		$query->bindValue(3, $contacto, PDO::PARAM_INT);
		$query->bindValue(4, $password);
		$query->execute();
		if ($query) 
		{
			echo "<script>Swal.fire('Sucesso!', 'Registo com sucesso!', 'success');setTimeout(() => {window.location.href= ''}, 1500);</script>";
		} 
		else 
		{
			echo "<script>Swal.fire('Erro!', 'Login falhou!', 'error');setTimeout(() => {window.location.href= ''}, 1500);</script>";
		}
	}
}

if (isset($_POST['login'])) 
{
	$email = $_POST['email'];
	#md5 para encriptar e comparar
	$password = md5($_POST['password']);

	#$query=mysqli_query($con,"SELECT * FROM users WHERE email='$email' and password='$password'");
	#$count=mysqli_fetch_array($query);

	$query = $con->prepare("SELECT * FROM users WHERE email= ? and password= ?");
	$query->bindValue(1, $email);
	$query->bindValue(2, $password);
	$query->execute();
	$ses = $query->fetch(PDO::FETCH_ASSOC);

	if ($ses > 0) 
	{
		#definir sessão/guardar email
		$_SESSION['login'] = $_POST['email'];

		#id do utilizador e o seu nome da base de dados e para utilizar noutros lados
		$_SESSION['id'] = $ses['id'];
		$_SESSION['username'] = $ses['name'];
		$_SESSION['admin'] = $ses['admin'];

		echo "<script>Swal.fire('Sucesso!', 'Login com sucesso!', 'success'); setTimeout(() => {window.location.href= 'index.php'}, 1500);</script>";
	} 
	else 
	{
		echo "<script>Swal.fire('Erro!', 'Login falhou!', 'error');</script>";
	}
} ?>