<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Carrinho</title>
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

if (isset($_POST['submit'])) 
{
	if (!empty($_SESSION['cart'])) 
	{
		#array associativo, guardar par key = (ID PRODUTO) e value = (QUANTIDADE DE CADA KEY(PRODUTO)) -> VER IMAGENS EM Ajudas.doc 
		foreach ($_POST['quantity'] as $key => $val) 
		{
			#echo $val;
			#echo $key;

			#se 0 quant remove a key(produto) do cart
			if ($val == 0) 
			{
				unset($_SESSION['cart'][$key]);
			} 
			else 
			{
				#se val != 0, entao a quantidade da key(produto) vai ser val(quantidade)
				$_SESSION['cart'][$key]['quantity'] = $val;
			}
		}
		echo "<script>Swal.fire('Sucesso!', 'Cart atualizado!', 'success');setTimeout(() => {window.location.href= ''}, 1500);</script>";
	}
}

#remover do cart uma key(produto) com a checkbox
if (isset($_POST['remove_code'])) 
{
	if (!empty($_SESSION['cart'])) 
	{	
		#$key = id do produto
		foreach ($_POST['remove_code'] as $key) 
		{
			
			#delete da bd tambem para não ficar lá, metodo de pagamento = NULL para não apagar outros registos já pagos no caso do id ser o mesmo
			$query = $con->prepare("DELETE FROM orders WHERE idprod = ? AND pagamento IS NULL");
			$query->bindValue(1, $key);
			$query->execute();
			unset($_SESSION['cart'][$key]);
			if ($query) 
			{
				echo "<script>Swal.fire('Info', 'A redirecionar para pagamento', 'info');setTimeout(() => {window.location.href=''}, 1500);</script>";
			}
			else
			echo "<script>Swal.fire('ERRO', 'Ocorreu um erro', 'error'); setTimeout(() => {window.location.href= ''}, 1500);</script>";
			
		}
		echo "<script>Swal.fire('Sucesso!', 'Cart atualizado!', 'success');setTimeout(() => {window.location.href= ''}, 1500);</script>";
	}
}


#criar historico/submeter de compras
if (isset($_POST['ordersubmit'])) 
{

	$idprod = $_SESSION['pid'];
	$quant = $_POST['quantity'];

	#pegar no array de id e no de quantidade, e criar associação id as $key => $value
	$item = array_combine($idprod, $quant);

	#percorremos o array item com os IDS e a quant de cada um e inserimos na bd
	foreach ($item as $ID => $quant) 
	{
		$query = $con->prepare("INSERT INTO orders(userId,idprod,quant) VALUES(?,?,?)");
		$query->bindValue(1, $_SESSION['id']);
		$query->bindValue(2, $ID);
		$query->bindValue(3, $quant);
		$query->execute();

		if ($query) 
		{
			echo "<script>Swal.fire('Info', 'A redirecionar para pagamento', 'info');setTimeout(() => {window.location.href='payment.php'}, 1500);</script>";
		}
		else
		echo "<script>Swal.fire('ERRO', 'Ocorreu um erro', 'error'); setTimeout(() => {window.location.href= ''}, 1500);</script>";
	}
}


#Atualizações
#Endereços faturação
if (isset($_POST['endupt'])) 
{
	$endS = $_POST['endS'];
	$endP = $_POST['endP'];
	$endC = $_POST['endC'];
	$endPin = $_POST['endPin'];

	$query = $con->prepare("UPDATE users SET endShip = ?, endPais = ?, endCid = ?, endPin = ? WHERE id= ?");
	$query->bindValue(1, $endS);
	$query->bindValue(2, $endP);
	$query->bindValue(3, $endC);
	$query->bindValue(4, $endPin);
	$query->bindValue(5, $_SESSION['id']);
	$query->execute();

	if ($query) 
		echo "<script>Swal.fire('Mudança', 'Endereço Atualizado', 'info'); setTimeout(() => {window.location.href= ''}, 1500);</script>";
	else
	echo "<script>Swal.fire('ERRO', 'Ocorreu um erro ao atualizar endereço', 'error'); setTimeout(() => {window.location.href= ''}, 1500);</script>";
}

#Endereços envio/shipping
if (isset($_POST['fatupt'])) 
{
	$fatend = $_POST['fatEnd'];
	$fatpais = $_POST['fatP'];
	$fatcid = $_POST['fatC'];
	$fatpin = $_POST['fatcodpin'];

	$query = $con->prepare("UPDATE users SET fatEndereco = ?, fatPais = ?, fatCid = ?, fatPin = ? WHERE id= ?");
	$query->bindValue(1, $fatend);
	$query->bindValue(2, $fatpais);
	$query->bindValue(3, $fatcid);
	$query->bindValue(4, $fatpin);
	$query->bindValue(5, $_SESSION['id']);
	$query->execute();

	if ($query) 
		echo "<script>Swal.fire('Mudança', 'Endereço Atualizado', 'info'); setTimeout(() => {window.location.href= ''}, 1500);</script>";
	else
	echo "<script>Swal.fire('ERRO', 'Ocorreu um erro ao atualizar endereço', 'error'); setTimeout(() => {window.location.href= ''}, 1500);</script>";
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
		<div class="container">
			<div class="row inner-bottom-sm">
				<div class="shopping-cart">
					<div class="col-md-12 col-sm-12 shopping-cart-table ">
						<div class="table-responsive">
							<form name="cart" method="post">

								<?php if (!empty($_SESSION['cart'])) { ?>
									<table class="table table-bordered">
										<thead>
											<tr>
												<th style="text-align: center" class="cart-remove item">Remover</th>
												<th style="text-align: center" class="cart-description item">Imagem</th>
												<th style="text-align: center" class="cart-product-name item">Nome Produto</th>
												<th style="text-align: center" class="cart-qty item">Quantidade</th>
												<th style="text-align: center" class="cart-sub-total item">Preço Unidade</th>
												<th style="text-align: center" class="cart-sub-total item">Shipping</th>
												<th style="text-align: center" class="cart-total last-item">Total</th>
											</tr>
										</thead>
										<tfoot>
											<tr>
												<td colspan="7">
													<!-- largura da barra inferior da tabela -->
													<div class="shopping-cart-btn">
														<input type="submit" name="submit" value="Atualizar Cart" class="btn btn-upper btn-primary pull-right outer-right-xs">
													</div>
												</td>
											</tr>
										</tfoot>
										<tbody>

											<?php
											
											#array que depois vai para SESSION
											$prodarr = array();

											
											$query = "SELECT * FROM products WHERE id IN(";

											#array associativo, guardar par key = (ID PRODUTO) e value = (QUANTIDADE DE CADA KEY(PRODUTO)) -> VER IMAGENS EM Ajudas.doc 
											foreach ($_SESSION['cart'] as $id => $value) 
											{
												#add id's a query .= |==| +=
												$query .= $id . ",";
											}

											#substr(string, inicio, fim(-1 = fim da string -1, por causa das aspas)) . addicionar resto string
											$query = substr($query, 0, -1) . ") ORDER BY id ASC";


											$query2 = $con->prepare($query);
											$query2->execute();


											$totalpreco = 0;
											$totalquant = 0;

											if (!empty($query2)) 
											{
												while ($row = $query2->fetch(PDO::FETCH_ASSOC)) 
												{
													#quantidade do item especifico no cart
													$quantity = $_SESSION['cart'][$row['id']]['quantity'];
													
													#quantidade * preco + shipping do item
													$subpreco = $_SESSION['cart'][$row['id']]['quantity'] * ($row['precoprod'] + $row['taxashipping']);

													$totalpreco += $subpreco;
													$totalquant += $quantity;

													#var session com quantidade total
													$_SESSION['quant'] = $totalquant;

													#push de cada id no array
													array_push($prodarr, $row['id']); ?>

													<tr>
																					<!--checkbox = array no caso de multiplos selecionados para id's -->
														<td class="remove-item"><input type="checkbox" name="remove_code[]" value="<?php echo htmlentities($row['id']); ?>" /></td>
														<td class="cart-image">
															<a class="entry-thumbnail"> <img src="productimages/<?php echo $row['imagem1']; ?>" alt="" width="114" height="146"> 	</a>
														</td>

														<td class="cart-product-name-info">															<!-- prodid para usar na query em baixo -->
															<h4 style="text-align: center" class='cart-product-description'><a href="product-details.php?pid=<?php echo htmlentities($prodid = $row['id']); ?>"><?php echo $row['nomeprod']; ?></a></h4>
															<div class="row">
																<div class="col-sm-4">
																</div>
																<div class="col-sm-8">
																	<?php
																	$query = $con->prepare("SELECT * FROM productreviews WHERE idprod = ?");
																	$query->bindValue(1, $prodid);
																	$query->execute();
																	$num = $query->rowCount(); { ?>
																			( <?php echo htmlentities($num); ?> Reviews )
																	<?php } ?>
																</div>
															</div>
														</td>

														<td class="cart-product-quantity">
															<div class="quant-input">
																<!-- setas de quantidade -->
																<div class="arrows">
																	<div class="arrow plus gradient"><span class="ir"><i class="icon fa fa-sort-asc"></i></span></div>
																	<div class="arrow minus gradient"><span class="ir"><i class="icon fa fa-sort-desc"></i></span></div>
																</div>
																<!-- quantidade do id na session, nome= quantity[ID] -->
																<input type="text" value="<?php echo $_SESSION['cart'][$row['id']]['quantity']; ?>" name="quantity[<?php echo $row['id']; ?>]">
															</div>
														</td>
														<!-- preco do produto -->
														<td class="cart-product-sub-total"><span class="cart-sub-total-price"><?php echo $row['precoprod'];?>€</span></td>
														<!-- preco shipping do produto -->
														<td class="cart-product-sub-total"><span class="cart-sub-total-price"><?php echo $row['taxashipping'];?>€</span></td>
														<!-- preco TOTAL -->
														<td class="cart-product-grand-total"><span class="cart-grand-total-price"><?php echo ($_SESSION['cart'][$row['id']]['quantity'] * $row['precoprod'] + $row['taxashipping']);?>€</span></td>
													</tr>

											<?php } 
											}

											#guardamos o array de id's nesta variavel session para usar no php
											$_SESSION['pid'] = $prodarr;
											?>
										</tbody>
									</table>
						</div>
					</div>

					<div class="col-md-4 col-sm-12 estimate-ship-tax">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>
										<span class="estimate-title">Envio / Shipping</span>
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<div class="form-group">
											<?php

											#buscar os valores do utilizador para preencher os campos de texto envio/shipping
											$query = $con->prepare("SELECT * FROM users WHERE id = ?");
											$query->bindValue(1, $_SESSION['id']);
											$query->execute();
											while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
											?>
														<div class="form-group">
															<label class="info-title">Shipping Endereço<span>*</span></label>
															<!-- maior caixa texto -->
															<textarea class="form-control unicase-form-control text-input" name="endS" required><?php echo $row['endShip']; ?></textarea>
														</div>

														<div class="form-group">
															<label class="info-title">Shipping Pais<span>*</span></label>
															<input type="text" class="form-control unicase-form-control text-input" id="endP" name="endP" required value="<?php echo $row['endPais']; ?>">
														</div>
														<div class="form-group">
															<label class="info-title">Shipping Cidade <span>*</span></label>
															<input type="text" class="form-control unicase-form-control text-input" id="endC" name="endC" required value="<?php echo $row['endCid']; ?>">
														</div>
														<div class="form-group">
															<label class="info-title">Shipping PIN <span>*</span></label>
															<input type="text" class="form-control unicase-form-control text-input" id="endPin" name="endPin" required value="<?php echo $row['endPin']; ?>">
														</div>

												<button type="submit" name="endupt" class="btn-upper btn btn-primary checkout-page-button">Atualizar</button>
											<?php } ?>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					
					<div class="col-md-4 col-sm-12 estimate-ship-tax">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>
										<span class="estimate-title">Faturação</span>
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<div class="form-group">
											<?php

											#buscar os valores do utilizador para preencher os campos de texto faturação
											$query = $con->prepare("SELECT * FROM users WHERE id = ?");
											$query->bindValue(1, $_SESSION['id']);
											$query->execute();
											while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
											?>

														<div class="form-group">
															<label class="info-title">Faturação Endereço<span>*</span></label>
															<!-- maior caixa texto -->
															<textarea class="form-control unicase-form-control text-input" name="fatEnd" required><?php echo $row['fatEndereco']; ?></textarea>
														</div>

														<div class="form-group">
															<label class="info-title">Faturação Pais<span>*</span></label>
															<input type="text" class="form-control unicase-form-control text-input" id="fatP" name="fatP" required value="<?php echo $row['fatPais']; ?>">
														</div>
														<div class="form-group">
															<label class="info-title">Faturação Cidade <span>*</span></label>
															<input type="text" class="form-control unicase-form-control text-input" id="fatC" name="fatC" required value="<?php echo $row['fatCid']; ?>">
														</div>
														<div class="form-group">
															<label class="info-title">Faturação PIN <span>*</span></label>
															<input type="text" class="form-control unicase-form-control text-input" id="fatcodpin" name="fatcodpin" required value="<?php echo $row['fatPin']; ?>">
														</div>

												<button type="submit" name="fatupt" class="btn-upper btn btn-primary checkout-page-button">Atualizar</button>
											<?php } ?>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>									
					
					<div class="col-md-4 col-sm-12 cart-shopping-total">
						<table class="table table-bordered">
							<thead>
								<tr>
									<th>
										<div class="cart-grand-total"> <!-- TOTAL, variavel session com o total -->
											Total<span class="inner-left-md"><?php echo $_SESSION['tp'] = "$totalpreco" ?>€</span>
										</div>
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<div class="cart-checkout-btn pull-right">
											<button type="submit" name="ordersubmit" class="btn btn-primary">Checkout/Pagamento</button>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					<?php } else { echo "<script>Swal.fire('Info', 'Cart está vazio', 'info');setTimeout(() => {window.location.href='index.php'}, 2000);</script>"; } ?>
					</div>
				</div>
			</div>
			</form>
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