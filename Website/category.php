<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Categoria</title>
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

#ID de Cat
$cid = intval($_GET['cid']);

#gets do url
if (isset($_GET['id'])) 
{
	#id do item a addicionar
	$id = intval($_GET['id']);

	#se o item ja estiver la adiciona quant
	if (isset($_SESSION['cart'][$id]))
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
			$query2 = $query->fetch(PDO::FETCH_ASSOC);
			#set do item no cart
			$_SESSION['cart'][$query2['id']] = array("quantity" => 1, "price" => $query2['precoprod']);
		}
	}
	echo "<script>Swal.fire('Adicionado!', 'Produto adicionado ao carrinho', 'success'); setTimeout(() => {window.location.href='category.php?cid=$cid'}, 1500);</script>";
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
					<?php include('includes/side-menu.php');
						#para não mostrar 2a caixa de subcategorias se categoria não tiver subcategorias
						$query = $con->prepare("SELECT * FROM subcategory WHERE categoryid=?");
						$query->bindValue(1, $cid);
						$query->execute();
						$count=$query ->rowCount();
						if($count > 0) 
						{?>

					<div class="sidebar-module-container">
						<div class="sidebar-filter">
							<div class="side-menu animate-dropdown outer-bottom-xs">
								<div class="side-menu animate-dropdown outer-bottom-xs">
									<div class="head"><i class="icon fa fa-align-justify fa-fw"></i>Sub Categorias</div>
									<nav class="yamm megamenu-horizontal" role="navigation">
										<ul class="nav">
											<li class="dropdown menu-item">
												<?php
												#side Menu com as subcategorias
												$query = $con->prepare("SELECT * FROM subcategory where categoryid=?");
												$query->bindValue(1, $cid);
												$query->execute();
												while ($row = $query->fetch(PDO::FETCH_ASSOC)) 
												{?>													<!-- mandar o id da categoria tambem para usar no php da sub categoria -->
													<a href="sub-category.php?scid=<?php echo $row['id']; ?>&cid=<?php echo $row['categoryid']; ?>" class="dropdown-toggle"><i class="icon fa fa-desktop fa-fw"></i>
													<?php echo $row['subcategory']; ?></a>
												<?php } ?>
											</li>
										</ul>
									</nav>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>

				</div>
				<div class='col-md-9'>
					<div id="category" class="category-carousel hidden-xs">
						<div class="item">
							<div class="image">
								<img src="images/cat.jpg" alt="" class="img-responsive">
							</div>
							<div class="container-fluid">
								<div class="caption vertical-top text-left">
									<div class="big-text">
										<br/>
									</div>
									<?php
									#Nome cat para debaixo da imagem
									$query = $con->prepare("SELECT catName FROM category where id=?");
									$query->bindValue(1, $cid);
									$query->execute();
									while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
									?>
										<div class="excerpt hidden-sm hidden-md">
											<?php echo htmlentities($row['catName']); ?>
										</div>
									<?php } ?>
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
										#Produtos todos da cat
										$query = $con->prepare("SELECT * FROM products where category=?");
										$query->bindValue(1, $cid);
										$query->execute();
										$num = $query->rowCount();
										if ($num > 0) 
										{
											while ($row = $query->fetch(PDO::FETCH_ASSOC)) { ?>
												<div class="col-sm-6 col-md-4 wow fadeInUp">
													<div class="products">
														<div class="product">
															<div class="product-image">
																<div class="image">
																	<!-- link imagem -->
																	<a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>">
																		<img src="" data-echo="productimages/
																	<?php echo htmlentities($row['imagem1']); ?>" alt="" width="200" height="300"></a>
																</div>
															</div>

															<div class="product-info text-left">
																<!-- link nome -->
																<h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['nomeprod']); ?></a></h3>
																<div class="description"></div>
																<div class="product-price">
																	<span class="price">
																		<?php echo htmlentities($row['precoprod']); ?>€ </span>
																</div>
															</div>
															<div class="cart clearfix animate-effect">
																<!-- para check em cima no GET E ID-->
																<div class="action">
																	<ul class="list-unstyled">
																		<li class="add-cart-button btn-group">
																			<a href="category.php?page=product&id=<?php echo $row['id']; ?>">
																				<button class="btn btn-primary" type="button">Add. Carrinho</button></a>
																		</li>
																	</ul>
																</div>
															</div>
														</div>
													</div>
												</div>
											<?php }
										} 
										else 
										{ ?>
											<div class="col-sm-6 col-md-4 wow fadeInUp">
												<h3>Não existem produtos</h3>
											</div>
										<?php } ?>
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