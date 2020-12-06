
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Resultados Procura</title>
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

#% - The percent sign represents zero, one, or multiple characters
#_ - The underscore represents a single character

#o que esta na barra de procura vai procurar esse texto em qualquer lado por causa dos %
$find = "%{$_POST['product']}%";

if (isset($_GET['id']))
 {
	#id do item a addicionar
	$id = intval($_GET['id']);

	#se o item ja estiver la adiciona quant
	if (isset($_SESSION['cart'][$id])) 
	{
									#+ VAR QUANTIDADE?
		$_SESSION['cart'][$id]['quantity']++;
		echo "<script>Swal.fire('Adicionado!', 'Produto adicionado ao carrinho', 'success'); setTimeout(() => {window.location.href='index.php'}, 1500);</script>";
	} 
	else 
	{

		$query = $con->prepare("SELECT * FROM products WHERE id=?");
		$query->bindValue(1, $id);
		$query->execute();
		$count = $query->rowCount();

		if ($count > 0)
		{
			#set do item no cart
			$query2 = $query->fetch(PDO::FETCH_ASSOC);			#+ VAR QUANTIDADE
			$_SESSION['cart'][$query2['id']] = array("quantity" => 1, "price" => $query2['precoprod']);
		}
		echo "<script>Swal.fire('Adicionado!', 'Produto adicionado ao carrinho', 'success'); setTimeout(() => {window.location.href='index.php'}, 1500);</script>";
	}
}

?>

<!DOCTYPE html>

<body class="cnt-home">
	<header class="header-style-1">
		<?php include('includes/top-header.php'); ?>
		<?php include('includes/main-header.php'); ?>
		<?php include('includes/menu-bar.php'); ?>
	</header>

	<div class="body-content outer-top-xs">
		<div class='container'>
			<div class='row outer-bottom-sm'>
				<div class='col-md-3 sidebar'>
					<?php include('includes/side-menu.php'); ?>
					<div class="sidebar-module-container">
						<div class="sidebar-filter">
						</div>
					</div>
				</div>
				<div class='col-md-9'>
					<div id="category" class="category-carousel hidden-xs">
						<div class="item">
							<div class="image">
								<img src="images/proc.jpg" alt="" class="img-responsive">
							</div>
							<div class="container-fluid">
								<div class="caption vertical-top text-left">
									<div class="big-text">
										<br />
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="search-result-container">
						<div id="myTabContent" class="tab-content">
							<div class="tab-pane active " id="grid-container">
								<div class="category-product  inner-top-vs">
									<div class="row">

										<?php

										#procura por texto inserido na barra todos os produtos
										$query = $con->prepare("SELECT * FROM products WHERE nomeprod like ?");
										$query->bindValue(1, $find);
										$query->execute();
										$num = $query->rowCount();


										if ($num > 0) 
										{
											while ($row = $query->fetch(PDO::FETCH_ASSOC)) 
											{ ?>
												<div class="col-sm-6 col-md-4 wow fadeInUp">
													<div class="products">
														<div class="product">
															<div class="product-image">
																<div class="image">						<!-- imagem da bd -->
																	<a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><img data-echo="productimages/<?php echo htmlentities($row['imagem1']); ?>" alt="" width="200" height="300"></a>
																</div>
															</div>
															<div class="product-info text-left">				<!-- id, nome, preço-->
																<h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['nomeprod']); ?></a></h3>
																<div class="description"></div>

																<div class="product-price">
																	<span class="price">
																		<?php echo htmlentities($row['precoprod']); ?>€ </span>
																</div>
															</div>

													<div class="cart clearfix animate-effect">
														<div class="action">
															<div class="add-cart-button btn-group">				<!-- id para cart -->
																<a href="category.php?page=product&id=<?php echo $row['id']; ?>">
																	<button class="btn btn-primary" type="button">Add. Carrinho</button></a>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										<?php }
										} 
										else 
											echo "<script>Swal.fire('Nada encontrado!', 'Não foram encontrados produtos', 'info'); setTimeout(() => {window.location.href='index.php'}, 1500);</script>";?>
									</div>
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