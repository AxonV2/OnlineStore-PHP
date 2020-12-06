<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Detalhes de Produto</title>
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

$quantval = 1;

#gets do url
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

#id do produto do get/url
$pid = intval($_GET['pid']);


#reviews
if (isset($_POST['submit'])) 
{
	$qual = $_POST['quality'];
	$preco = $_POST['price'];
	$value = $_POST['value'];
	$nome = $_POST['name'];
	$sum = $_POST['summary'];
	$desc = $_POST['review'];

	$query = $con->prepare("INSERT into productreviews (idprod,quality,price,value,nome,summary,review) VALUES(?,?,?,?,?,?,?)");
	$query->bindValue(1, $pid);
	$query->bindValue(2, $qual);
	$query->bindValue(3, $preco);
	$query->bindValue(4, $value);
	$query->bindValue(5, $nome);
	$query->bindValue(6, $sum);
	$query->bindValue(7, $desc);
	$query->execute();

	if ($query)
		echo "<script>Swal.fire('Adicionado!', 'Review postada!', 'success'); setTimeout(() => {window.location.href=''}, 1500);</script>";
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
			<div class='row single-product outer-bottom-sm '>
				<div class='col-md-3 sidebar'>
					<div class="sidebar-widget-body m-t-10">
						<?php include('includes/side-menu.php'); ?>


						<div class="sidebar-widget hot-deals wow fadeInUp">
							<h3 class="section-title">Outros</h3>
							<div class="owl-carousel sidebar-carousel custom-carousel owl-theme outer-top-xs">

								<?php
								#5 items a sorte para o pequeno widget ao lado
								$query = $con->prepare("SELECT * FROM products ORDER BY rand() limit 5");
								$query->execute();
								while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
								?>

									<div class="item">
										<div class="products">
											<div class="hot-deal-wrapper">
												<div class="image">					<!-- imagem da bd -->
													<img src="productimages/<?php echo htmlentities($row['imagem1']); ?>" width="200" height="350" alt="">
												</div>
											</div>			<!-- id, nome, preço-->
											<div class="product-info text-left m-t-20">
												<h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['nomeprod']); ?></a></h3>
												<div class="product-price">
													<span class="price">
														<?php echo htmlentities($row['precoprod']); ?>€
													</span>
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
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<?php


				#info do produto especifico
				$query = $con->prepare("SELECT * FROM products WHERE id=?");
				$query->bindValue(1, $pid);
				$query->execute();

				while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
				?>
					<div class='col-md-9'>
						<div class="row  wow fadeInUp">
							<div class="col-xs-12 col-sm-6 col-md-5 gallery-holder">
								<div class="product-item-holder size-big single-product-gallery small-gallery">
									<div id="owl-single-product">
										<!-- imagens e slides -->
										<div class="single-product-gallery-item" id="slide1">
											<a data-title="Gallery" href="productimages/<?php echo htmlentities($row['imagem1']); ?>">
												<img class="img" alt="" data-echo="productimages/<?php echo htmlentities($row['imagem1']); ?>" width="300" height="400" />
											</a>
										</div>

										<div class="single-product-gallery-item" id="slide2">
											<a data-title="Gallery" href="productimages/<?php echo htmlentities($row['imagem2']); ?>">
												<img class="img" alt=""  data-echo="productimages/<?php echo htmlentities($row['imagem2']); ?>" width="300" height="400" />
											</a>
										</div>

										<div class="single-product-gallery-item" id="slide3">
											<a data-title="Gallery" href="productimages/<?php echo htmlentities($row['imagem3']); ?>">
												<img class="img" alt="" data-echo="productimages/<?php echo htmlentities($row['imagem3']); ?>" width="300" height="400" />
											</a>
										</div>
									</div>

									<div class="single-product-gallery-thumbs gallery-thumbs">
										<!-- thumbnails em baixo de imagem -->
										<div id="owl-single-product-thumbnails">
											<div class="item">							<!-- muda esta owl-single em cima -->
												<a class="horizontal-thumb" data-target="#owl-single-product" data-slide="1" href="#slide1">
													<img class="img" width="85" alt="80"  data-echo="productimages/<?php echo htmlentities($row['imagem1']); ?>" />
												</a>
											</div>
											<!-- IF AQUI DEPOIS NO CASO DE NÃO EXISTIR -->
											<?php if(!empty($row['imagem2'])) { ?>
											<div class="item">
												<a class="horizontal-thumb" data-target="#owl-single-product" data-slide="2" href="#slide2">
													<img class="img" width="85" alt="80" data-echo="productimages/<?php echo htmlentities($row['imagem2']); ?>" />
												</a>
											</div>
											<?php } ?>
											<?php if(!empty($row['imagem3'])) {  ?>
											<div class="item">
												<a class="horizontal-thumb" data-target="#owl-single-product" data-slide="3" href="#slide3">
													<img class="img" width="85" alt="80"  data-echo="productimages/<?php echo htmlentities($row['imagem3']); ?>" />
												</a>
											</div>
											<?php } ?>
										</div>
									</div>
								</div>
							</div>
							<div class='col-sm-6 col-md-7 product-info-block'>
								<div class="product-info">
									<!-- titulo nome prod -->
									<center>
									<h1 class="name"><?php echo htmlentities($row['nomeprod']); ?></h1>
									</center>
									<?php
									#ir buscar as reviews a bd
									$query = $con->prepare("SELECT * FROM productreviews WHERE idprod=?");
									$query->bindValue(1, $pid);
									$query->execute();

									$num = $query->rowCount(); { ?>

										<div class="product-info">
											<center>
											<a class="lnk">(<?php echo htmlentities($num); ?> Reviews)</a>
											</center>
										</div>
									<?php } ?>

									<div class="stock-container info-container m-t-10">
										<div class="row">
											<div class="col-sm-3">
												<div class="stock-box">
													<span class="label">Marca </span>
												</div>
											</div>
											<div class="col-sm-9">
												<div class="stock-box">						<!-- marca da companhia -->
													<span class="value"><?php echo htmlentities($row['marcaprod']); ?></span>
												</div>
											</div>
										</div>
									</div>

									<div class="stock-container info-container m-t-10">
										<div class="row">
											<div class="col-sm-3">
												<div class="stock-box">
													<span class="label">Custo Envio </span>
												</div>
											</div>
											<div class="col-sm-9">
												<div class="stock-box">
													<span class="value">
														<?php if ($row['taxashipping'] == 0) 
																{
																	echo "Envio Grátis";
																} 
																else 
																{						#custo envio/shipping
																	echo htmlentities($row['taxashipping']) . "€";
																} ?></span>
												</div>
											</div>
										</div>
									</div>

									<div class="price-container info-container m-t-20">
										<div class="row">
											<div class="product-info">
												<div class="price-box">
													<center>									<!-- preço -->
													<span class="price"><?php echo htmlentities($row['precoprod']); ?></span>€
													</center>
																		
													<div class="price-box">
													<center>
														<a href="product-details.php?page=product&id=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fa fa-shopping-cart inner-right-vs"></i> Add. Carrinho</a>
													</center>

													<!-- arranjar se houver tempo-->
													<div class="product-social-link m-t-20 text-right">
													<span class="social-label">Partilhar teste</span>
													<div class="social-icons">
													<ul class="list-inline">
													<li><a class="fa fa-facebook" href="http://facebook.com"></a></li>
													<li><a class="fa fa-twitter" href="https://twitter.com/home"></a></li>
													<li><a class="fa fa-linkedin" href="https://www.linkedin.com/"></a></li>
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>				
				</div>
			</div>
		</div>
						<div class="product-tabs inner-bottom-xs  wow fadeInUp">
							<div class="row">
								<div class="col-sm-3">
									<!-- escolha tabela -->
									<ul id="product-tabs" class="nav nav-tabs nav-tab-cell">
										<li class="active"><a data-toggle="tab" href="#description">Descrição</a></li>
										<li><a data-toggle="tab" href="#review">Review</a></li>
									</ul>
								</div>
								<div class="col-sm-9">
									<div class="tab-content">
										<div id="description" class="tab-pane in active">
											<div class="product-tab">	<!-- descrição do item na bd mesmo para ser unico ao item -->
												<p class="text"><?php echo $row['descprod']; ?></p>
											</div>
										</div>
										<div id="review" class="tab-pane">
											<div class="product-tab">
												<div class="product-reviews">
													<h4 class="title">Reviews de Clientes</h4>

													<?php

													#buscar reviews do item
													$query = $con->prepare("SELECT * FROM productreviews WHERE idprod=?");
													$query->bindValue(1, $pid);
													$query->execute();

													while ($rvw = $query->fetch(PDO::FETCH_ASSOC)) {
													?>

														<div class="reviews" style="border: solid 1px #000; padding-left: 2% ">
															<div class="review">
																<div class="review-title"><span class="summary"><?php echo htmlentities($rvw['summary']); ?></span> <span class="date"><i class="fa fa-calendar"></i><span><?php echo htmlentities($rvw['reviewDate']); ?></span></span></div>
																<div class="text">"<?php echo htmlentities($rvw['review']); ?>"</div>
																<br>									<!-- num estrelas -->
																<div class="text"><b>Qualidade -</b> <?php echo htmlentities($rvw['quality']); ?> Star(s)</div>
																<div class="text"><b>Preço -</b> <?php echo htmlentities($rvw['price']); ?> Star(s)</div>
																<div class="text"><b>Value da Compra -</b> <?php echo htmlentities($rvw['value']); ?> Star(s)</div>
																<div class="author m-t-15"><i class="fa fa-pencil-square-o"></i> <span class="name"><?php echo htmlentities($rvw['nome']); ?></span></div>
															</div>
														</div>
													<?php } ?>
												</div>


												<!-- deixar uma review -->
												<form role="form" class="cnt-form" name="review" method="post">
													<div class="product-add-review">
														<h4 class="title">Deixe uma review!</h4>
														<div class="review-table">
															<div class="table-responsive">
																<table class="table table-bordered">
																	<thead>
																		<tr>
																			<th class="cell-label">&nbsp;</th>
																			<th>1 Star</th>
																			<th>2 Stars</th>
																			<th>3 Stars</th>
																			<th>4 Stars</th>
																			<th>5 Stars</th>
																		</tr>
																	</thead>
																	<tbody>
																		<tr>
																			<td class="cell-label">Qualidade</td>
																			<td><input type="radio" name="quality" class="radio" value="1"></td>
																			<td><input type="radio" name="quality" class="radio" value="2"></td>
																			<td><input type="radio" name="quality" class="radio" value="3"></td>
																			<td><input type="radio" name="quality" class="radio" value="4"></td>
																			<td><input type="radio" name="quality" class="radio" value="5"></td>
																		</tr>
																		<tr>
																			<td class="cell-label">Preço</td>
																			<td><input type="radio" name="price" class="radio" value="1"></td>
																			<td><input type="radio" name="price" class="radio" value="2"></td>
																			<td><input type="radio" name="price" class="radio" value="3"></td>
																			<td><input type="radio" name="price" class="radio" value="4"></td>
																			<td><input type="radio" name="price" class="radio" value="5"></td>
																		</tr>
																		<tr>
																			<td class="cell-label">Value</td>
																			<td><input type="radio" name="value" class="radio" value="1"></td>
																			<td><input type="radio" name="value" class="radio" value="2"></td>
																			<td><input type="radio" name="value" class="radio" value="3"></td>
																			<td><input type="radio" name="value" class="radio" value="4"></td>
																			<td><input type="radio" name="value" class="radio" value="5"></td>
																		</tr>
																	</tbody>
																</table>
															</div>
														</div>

														<div class="review-form">
															<div class="form-container">
																<div class="row">
																	<div class="col-sm-6">
																		<div class="form-group">
																			<label> Nome <span class="astk">*</span></label>
																			<input type="text" class="form-control txt" id="exampleInputName" placeholder="" name="name" required>
																		</div>
																		<div class="form-group">
																			<label> Resumo <span class="astk">*</span></label>
																			<input type="text" class="form-control txt" id="exampleInputSummary" placeholder="" name="summary" required>
																		</div>
																	</div>

																	<div class="col-md-6">
																		<div class="form-group">
																			<label> Review <span class="astk">*</span></label>
																			<textarea class="form-control txt txt-review" id="exampleInputReview" rows="4" placeholder="" name="review" required></textarea>
																		</div>
																	</div>
																</div>

																<div class="action text-right">
																	<button name="submit" class="btn btn-primary btn-upper">Submeter Review</button>
																</div>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

	<?php 
	#cat e subcat do item principal para usar em baixo nos relacionados
	$cid = $row['category'];
	$subcid = $row['subcategory'];
	#fecha while em cima
	}?>
	
	<section class="section featured-product wow fadeInUp">
		<h3 class="section-title">Produtos Relacionados </h3>
		<div class="owl-carousel home-owl-carousel upsell-product custom-carousel owl-theme outer-top-xs">

			<?php
			#Preencher com produtos relacionados
			$query = $con->prepare("SELECT * FROM products WHERE subcategory=? AND category=?");
			$query->bindValue(1, $subcid);
			$query->bindValue(2, $cid);
			$query->execute();

			while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
			?>
				<div class="item item-carousel">
					<div class="products">
						<div class="product">
							<div class="product-image">
								<div class="image">						<!-- imagem -->
									<a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><img data-echo="productimages/<?php echo htmlentities($row['imagem1']); ?>" width="150" height="240" alt=""></a>
								</div>
							</div>

							<div class="product-info text-left">				<!-- id, nome, preço-->
								<h3 class="name"><a href="product-details.php?pid=<?php echo htmlentities($row['id']); ?>"><?php echo htmlentities($row['nomeprod']); ?></a></h3>
								<div class="description"></div>

								<div class="product-price">
									<span class="price">
										<?php echo htmlentities($row['precoprod']); ?>€ </span>
								</div>

								<div class="add-cart-button btn-group">				<!-- id para cart -->
									<a href="category.php?page=product&id=<?php echo $row['id']; ?>">
									<button class="btn btn-primary" type="button">Add. Carrinho</button></a>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</section>
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