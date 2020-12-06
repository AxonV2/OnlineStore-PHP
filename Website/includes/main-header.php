<?php

if (isset($_Get['action'])) {
	if (!empty($_SESSION['cart'])) 
	{
		#array associativo, guardar par key = (ID PRODUTO) e value = (QUANTIDADE DE CADA KEY(PRODUTO)) -> VER IMAGENS EM Ajudas.doc 
		foreach ($_POST['quantity'] as $key => $val)
		{
			#echo $val;
			#echo $key;
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
	}
}
?>
<div class="main-header">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
				<div class="logo">
					<a href="index.php">
						<h2>100Parar.Lda</h2>
					</a>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 top-search-holder">
				<div class="search-area">
					<!-- manda para o search-result.php com o post -->
					<form name="search" method="post" action="search-result.php">
						<div class="control-group">
							<input class="search-field" placeholder="Procura" name="product" required />
							<button class="search-button" type="submit" name="search"></button>
						</div>
					</form>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-3 animate-dropdown top-cart-row">
				<?php
				if (!empty($_SESSION['cart'])) {
				?>
					<div class="dropdown dropdown-cart">
						<a href="#" class="dropdown-toggle lnk-cart" data-toggle="dropdown">
							<div class="items-cart-inner">
								<div class="total-price-basket">
									<span class="lbl">Carrinho -</span>
									<span class="total-price">
										<span class="value"><?php echo $_SESSION['tp']; ?></span>
										<span class="sign">€</span>
									</span>
								</div>
								<div class="basket">
									<i class="glyphicon glyphicon-shopping-cart"></i>
								</div>
							</div>
						</a>
						<ul class="dropdown-menu">

							<?php
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
									$_SESSION['quant'] = $totalquant; ?>

									<li>
										<div class="cart-item product-summary">
											<div class="row">
												<div class="col-xs-4">
													<div class="image">
														<!-- no cart link para pagina do item com imagem da bd -->
														<a href="product-details.php?pid=<?php echo $row['id']; ?>"> <img src="productimages/<?php echo $row['imagem1']; ?>" width="35" height="50" alt=""></a>
													</div>
												</div>
												<div class="col-xs-7">

													<h3 class="name"><a href="product-details.php?pid=<?php echo $row['id']; ?>"><?php echo $row['nomeprod']; ?></a></h3>
													<!-- produto + preço shipping * quant -->
													<div class="price"> <?php echo ($row['precoprod'] + $row['taxashipping']);?>*<?php echo $_SESSION['cart'][$row['id']]['quantity']; ?>€ </div>
												</div>
											</div>
										</div>
								<?php }
							} ?>
								<div class="clearfix"></div>
								<hr>
								<div class="clearfix cart-total">
									<div class="pull-right">
										<span class="text">Total:</span><span class='price'> <?php echo $_SESSION['tp'] = "$totalpreco" ?>€</span>
									</div>
									<div class="clearfix"></div>
									<a href="cart.php" class="btn btn-upper btn-primary btn-block m-t-20">Carrinho</a>
								</div>
									</li>
						</ul>
					</div>
				<?php } else { ?>
					<div class="dropdown dropdown-cart">
						<a href="#" class="dropdown-toggle lnk-cart" data-toggle="dropdown">
							<div class="items-cart-inner">
								<div class="total-price-basket">
									<span class="lbl">Carrinho</span>
								</div>
								<div class="basket">
									<i class="glyphicon glyphicon-shopping-cart"></i>
								</div>
							</div>
						</a>
						<ul class="dropdown-menu">
								<div class="cart-item product-summary">
									<div class="row">
										<div class="col-xs-12">
											<center>
												Carrinho Vazio
											</center>
										</div>
									</div>
								</div>
						</ul>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>