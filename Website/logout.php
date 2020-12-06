
<!DOCTYPE html>
 <html lang="en">
	<head>
    <meta charset="utf-8">
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
		<link rel="stylesheet" href="assets/css/main.css">
		<link rel="stylesheet" href="assets/css/font-awesome.min.css">
			<!-- Head aqui por causa deste script para alerts -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>
	</head>
</html>

<?php
session_start();
echo "<script>Swal.fire('Informação', 'Logged out com sucesso!', 'info'); setTimeout(() => {window.location.href= 'index.php'}, 700);</script>";
session_unset();
?>