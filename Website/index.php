<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>100Parar.Lda</title>
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/css/main.css">
	<link rel="stylesheet" href="assets/css/owl.carousel.css">
	<link rel="stylesheet" href="assets/css/owl.transitions.css">
	<link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
	<link rel="stylesheet" href="assets/css/font-awesome.min.css">
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
	<!-- Head aqui por causa deste script para alerts -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.29.2/sweetalert2.all.js"></script>
</head>
</html>

<?php
session_start();
error_reporting(0);
include('includes/basededados.php');

#gets do url
if (isset($_GET['id'])) 
{
	#id do item a addicionar
	$id = intval($_GET['id']);

	#no login = para index
	if (strlen($_SESSION['login']) == 0) 
	{
	header('location:login.php');
	}
	#se o item ja estiver la adiciona quant
	else if (isset($_SESSION['cart'][$id])) 
	{
		$_SESSION['cart'][$id]['quantity']++;
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
			$query2 = $query->fetch(PDO::FETCH_ASSOC);
			$_SESSION['cart'][$query2['id']] = array("quantity" => 1, "price" => $query2['precoprod']);
		}
	}
	echo "<script>Swal.fire('Adicionado!', 'Produto adicionado ao carrinho', 'success'); setTimeout(() => {window.location.href='index.php'}, 1500);</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<body class="cnt-home">
	<header class="header-style-1">
		<?php include('includes/top-header.php'); ?>
		<?php include('includes/main-header.php'); ?>
		<?php include('includes/menu-bar.php'); ?>
	</header>

	<div class="body-content outer-top-xs" id="top-banner-and-menu">
		<div class="container">
			<div class="furniture-container homepage-container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-3 sidebar">
						<?php include('includes/side-menu.php'); ?>
					</div>
					<div class="col-xs-12 col-sm-12 col-md-9 homebanner-holder">
						<div id="hero" class="homepage-slider3">
							<div id="owl-main" class="owl-carousel owl-inner-nav owl-ui-sm">
								<!-- SLIDER, um loop aqui? -->
								<div class="full-width-slider">
									<div class="item" style="background-image: url(images/slider1.png);">
									</div>
								</div>
								<div class="full-width-slider">
									<div class="item full-width-slider" style="background-image: url(images/slider2.png);">
									</div>
								</div>
								<div class="full-width-slider">
									<div class="item full-width-slider" style="background-image: url(images/slider3.png);">
									</div>
								</div>
								<div class="full-width-slider">
									<div class="item full-width-slider" style="background-image: url(images/slider4.png);">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="product-tabs-slider" class="scroll-tabs inner-bottom-vs wow fadeInUp">
					<div class="more-info-tab clearfix">
						<h3 class="new-product-title pull-left">Produtos</h3>
					</div>
					<div class="tab-content outer-top-xs">
						<div class="tab-pane in active">
							<div class="product-slider">									<!-- quant items no index -->
								<div class="owl-carousel home-owl-carousel custom-carousel owl-theme" data-item="5">

									<?php
									#display dos produtos limit 10 por causa do load das imagens
									$query = $con->prepare("SELECT * FROM products ORDER BY rand() LIMIT 10");
									$query->execute();
									while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
									?>
										<div class="item item-carousel">
											<div class="products">
												<div class="product">
													<div class="product-image">
														<div class="image">
															<!-- Criar link e ir buscar a imagem a productimages/nomeimagem(bd) -->
															<a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>">
																<img src="productimages/ <?php echo htmlentities($row['imagem1']); ?>" data-echo="productimages/<?php echo htmlentities($row['imagem1']); ?>" width="180" height="300" alt=""></a>
														</div>
													</div>

													<!-- ID/NOME/PREÇO do item da bd -->
													<div class="product-info text-left">
														<h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['nomeprod']); ?></a></h3>
														<div class="description"></div>

														<div class="product-price">
															<span class="price">
																<?php echo htmlentities($row['precoprod']);?>€ </span>
														</div>
													</div>
												<!-- para check em cima no GET E ID-->
												<div class="action"><a href="index.php?page=product&id=<?php echo $row['id']; ?>" class="lnk btn btn-primary">Add. Carrinho</a></div>
												</div>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Pequeno 1 -->
				<div class="sections prod-slider-small outer-top-small">
					<div class="row">
						<div class="col-md-6"> 
							<section class="section">
								<h3 class="section-title">Teles</h3>
								<div class="owl-carousel homepage-owl-carousel custom-carousel outer-top-xs owl-theme" data-item="2">
									<?php

									#display dos produtos da cat outros, subcat telemoveis
									$query = $con->prepare("SELECT * FROM products WHERE category=5 and subcategory=4 ORDER BY rand() LIMIT 5");
									$query->execute();
									while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
									?>
										<div class="item item-carousel">
											<div class="products">
												<div class="product">
													<div class="product-image">
														<div class="image">
															<!-- Criar link e ir buscar a imagem a productimages/nomeimagem(bd) -->
															<a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><img src="productimages/<?php echo htmlentities($row['imagem1']); ?>" data-echo="productimages/<?php echo htmlentities($row['imagem1']); ?>" width="180" height="300"></a>
														</div>
													</div>

													<!-- ID/NOME/PREÇO do item da bd -->
													<div class="product-info text-left">
														<h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['nomeprod']); ?></a></h3>
														<div class="description"></div>

														<div class="product-price">
															<span class="price">
																<?php echo htmlentities($row['precoprod']);?>€ </span>
														</div>
													</div>
													<!-- para check em cima no GET E ID-->
													<div class="action"><a href="index.php?page=product&id=<?php echo $row['id']; ?>" class="lnk btn btn-primary">Add. Carrinho</a></div>
												</div>
											</div>
										</div>
									<?php } ?>
								</div>
							</section>
						</div>

						<!-- Pequeno 2 -->
						<div class="col-md-6">
							<section class="section">
								<h3 class="section-title">PC's</h3>
								<div class="owl-carousel homepage-owl-carousel custom-carousel outer-top-xs owl-theme" data-item="2">
									<?php

									#display dos produtos da cat pre-builts, subcat pcs
									$query = $con->prepare("SELECT * FROM products WHERE category=4 and subcategory=6 ORDER BY rand() LIMIT 5");
									$query->execute();
									while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
									?>
										<div class="item item-carousel">
											<div class="products">

												<!-- Criar link e ir buscar a imagem a productimages/nomeimagem(bd) -->
												<div class="product">
													<div class="product-image">
														<div class="image">
															<a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><img src="productimages/<?php echo htmlentities($row['imagem1']); ?>" data-echo="productimages/<?php echo htmlentities($row['imagem1']); ?>" width="300" height="300"></a>
														</div>
													</div>

													<!-- ID/NOME/PREÇO do item da bd -->
													<div class="product-info text-left">
														<h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['nomeprod']); ?></a></h3>
														<div class="description"></div>

														<div class="product-price">
															<span class="price">
																<?php echo htmlentities($row['precoprod']);?>€ </span>
														</div>
													</div>
													<!-- para check em cima no GET E ID-->
													<div class="action"><a href="index.php?page=product&id=<?php echo $row['id']; ?>" class="lnk btn btn-primary">Add. Carrinho</a></div>
												</div>
											</div>
										</div>
									<?php } ?>
								</div>
							</section>
						</div>
					</div>
				</div>

				<!-- Grande TESTE -->
										
				<br><br><br><br><br>
				<div id="product-tabs-slider" class="scroll-tabs inner-bottom-vs wow fadeInUp">
					<div class="more-info-tab clearfix">
						<h3 class="new-product-title pull-left">Teste GPU/Outros/Processadores</h3>
					</div>
						<div class="tab-content outer-top-xs">
							<div class="tab-pane in active">
								<div class="product-slider">									<!-- quant items no index -->
									<div class="owl-carousel home-owl-carousel custom-carousel owl-theme" data-item="5">

									<?php
									#display dos produtos gpu, outros e processadores
									$query = $con->prepare("SELECT * FROM products WHERE category = 2 or category = 5 or category = 1 ORDER BY rand() LIMIT 10");
									$query->execute();
									while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
									?>
										<div class="item item-carousel">
											<div class="products">
												<div class="product">
													<div class="product-image">
														<div class="image">
															<!-- Criar link e ir buscar a imagem a productimages/nomeimagem(bd) -->
															<a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>">
																<img src="productimages/<?php echo htmlentities($row['imagem1']); ?>" data-echo="productimages/<?php echo htmlentities($row['imagem1']); ?>" width="180" height="300" alt=""></a>
														</div>
													</div>

													<!-- ID/NOME/PREÇO do item da bd -->
													<div class="product-info text-left">
														<h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['nomeprod']); ?></a></h3>
														<div class="description"></div>

														<div class="product-price">
															<span class="price">
																<?php echo htmlentities($row['precoprod']);?>€ </span>
														</div>
													</div>
													<!-- para check em cima no GET E ID-->
													<div class="action"><a href="index.php?page=product&id=<?php echo $row['id']; ?>" class="lnk btn btn-primary">Add. Carrinho</a></div>
												</div>
											</div>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
		</div>
		<?php include('includes/footer.php'); ?>
</body>
</html>