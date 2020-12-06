<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ADMIN</title>
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

#(0 = não admin | 1 = admin) se não for admin 0 = para index
if ($_SESSION['admin'] < 1) 
    header('location:index.php');

//echo $_SESSION['admin']

#get para remover item ao clickar no icon
if(isset($_GET['del']))
{
    $query = $con->prepare("DELETE FROM products WHERE id = ? ");
    $query -> bindValue(1,$_GET['id']);
    $query->execute();
    $tst = $query->fetch(PDO::FETCH_ASSOC);
                  
    if ($query)  
       echo "<script>Swal.fire('Sucesso!', 'Produto removido com sucesso!', 'success');setTimeout(() => {window.location.href= 'admin.php'}, 1500);</script>";
    else 
       echo "<script>Swal.fire('Erro!', 'Ocorreu um erro', 'error');setTimeout(() => {window.location.href= ''}, 1500);</script>";
}

#post para inserir na bd
if (isset($_POST['submit']))
{
    $category = $_POST['category'];
    $subcat = $_POST['subcategory'];
    $nome = $_POST['nome'];
    $marca = $_POST['marca'];
    $preco = $_POST['preco'];
    $descri = $_POST['descri'];
    $ship = $_POST['shipping'];

    #imagens guardadas por causa do ENCTYPE do form
    $imagem1 = $_FILES["imagem1"]["name"];
    $imagem2 = $_FILES["imagem2"]["name"];
    $imagem3 = $_FILES["imagem3"]["name"];

    if(isset($_GET['id']))
    {
        $id = intval($_GET['id']);

        #inserção de tudo 
        $query = $con->prepare("UPDATE products SET category = ?, subcategory = ?, nomeprod = ?, marcaprod = ?, precoprod = ?, descprod = ?, taxashipping = ?  WHERE id = ?");
        $query->bindValue(1, $category);
        $query->bindValue(2, $subcat);
        $query->bindValue(3, $nome);
        $query->bindValue(4, $marca);
        $query->bindValue(5, $preco);
        $query->bindValue(6, $descri);
        $query->bindValue(7, $ship);
        $query->bindValue(8, $id);
        $query->execute();



        #mexer imagens que vem do post para productimages na dir do site assim depois o codigo faz tudo
        #verificar se o file esta la 
        if (is_uploaded_file($_FILES['imagem1']['tmp_name'])) 
        {
            move_uploaded_file($_FILES["imagem1"]['tmp_name'], "productimages/" . $_FILES["imagem1"]["name"]);
            $query = $con->prepare("UPDATE products SET imagem1 = ?  WHERE id = ?");
            $query->bindValue(1, $imagem1);
            $query->bindValue(2, $id);
            $query->execute();
        }

        if (is_uploaded_file($_FILES['imagem2']['tmp_name'])) 
        {
            move_uploaded_file($_FILES["imagem2"]['tmp_name'], "productimages/" . $_FILES["imagem2"]["name"]);
            $query = $con->prepare("UPDATE products SET imagem2 = ?  WHERE id = ?");
            $query->bindValue(1, $imagem2);
            $query->bindValue(2, $id);
            $query->execute();
        }

        if (is_uploaded_file($_FILES['imagem3']['tmp_name'])) 
        {
            move_uploaded_file($_FILES["imagem3"]['tmp_name'], "productimages/" . $_FILES["imagem3"]["name"]);
            $query = $con->prepare("UPDATE products SET imagem3 = ?  WHERE id = ?");
            $query->bindValue(1, $imagem3);
            $query->bindValue(2, $id);
            $query->execute();
        }
      
        if ($query) 
            echo "<script>Swal.fire('Sucesso!', 'Produto Editado com sucesso', 'success');setTimeout(() => {window.location.href= ''}, 1500);</script>";
        else 
            echo "<script>Swal.fire('Erro!', 'Ocorreu um erro ao editar', 'error');setTimeout(() => {window.location.href= ''}, 1500);</script>";


    }
    else
    {
            //id automatico para certificar que não vamos repetir
            $query = $con->prepare("SELECT MAX(id) as id FROM products");
            $query->execute();
            $tst = $query->fetch(PDO::FETCH_ASSOC);
            $newid = $tst['id'] + 1;
            #echo $newid;

            #mexer imagens que vem do post para productimages na dir do site assim depois o codigo faz tudo
            #verificar se o file esta la 
            if (is_uploaded_file($_FILES['imagem1']['tmp_name'])) 
            move_uploaded_file($_FILES["imagem1"]['tmp_name'], "productimages/" . $_FILES["imagem1"]["name"]);
               
            if (is_uploaded_file($_FILES['imagem2']['tmp_name'])) 
            move_uploaded_file($_FILES["imagem2"]['tmp_name'], "productimages/" . $_FILES["imagem2"]["name"]);

            if (is_uploaded_file($_FILES['imagem3']['tmp_name'])) 
            move_uploaded_file($_FILES["imagem3"]['tmp_name'], "productimages/" . $_FILES["imagem3"]["name"]);
                

            #inserção de tudo
            $query = $con->prepare("INSERT INTO products (id, category, subcategory, nomeprod, marcaprod, precoprod, descprod, imagem1, imagem2, imagem3, taxashipping)  VALUES( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $query->bindValue(1, $newid);
            $query->bindValue(2, $category);
            $query->bindValue(3, $subcat);
            $query->bindValue(4, $nome);
            $query->bindValue(5, $marca);
            $query->bindValue(6, $preco);
            $query->bindValue(7, $descri);
            $query->bindValue(8, $imagem1);
            $query->bindValue(9, $imagem2);
            $query->bindValue(10, $imagem3);
            $query->bindValue(11, $ship);
            $query->execute();

            if ($query) 
                echo "<script>Swal.fire('Sucesso!', 'Produto Inserido', 'success');setTimeout(() => {window.location.href= ''}, 1500);</script>";
            else 
                echo "<script>Swal.fire('Erro!', 'Ocorreu um erro', 'error');setTimeout(() => {window.location.href= ''}, 1500);</script>";
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

    <div class="body-content outer-top-bd">
        <div class="container">
            <div class="sign-in-page inner-bottom-sm">
                <div class="row">
                    <div class="col-md-6 col-sm-6 sign-in">
                        <h4 class="">ADMIN - INSERIR / EDITAR PRODUTOS </h4>
                                                                                <!-- enctype permite guardar cenas VER LINK IN AJUDAS.DOC-->
                        <form class="register-form outer-top-xs" method="post" enctype="multipart/form-data">

                            <!-- INSERIR -->

                                <!-- Escolha de categoria -->
                                <label class="control-label">Categoria</label>
                                <div class="form-group">
                                    <select name="category" class="form-control unicase-form-control text-input" required>

                                
                                    <?php 
                                    #CATEGORIA DO ITEM A SER EDITADO
                                        if(isset($_GET['id']))
                                        {

                                            $id = intval($_GET['id']);

                                            $query = $con->prepare("SELECT C.id AS cid, C.catName AS cname FROM products as P JOIN category AS C ON P.category = C.id  WHERE P.id=?");
                                            $query -> bindValue(1, $id);
                                            $query->execute();
                                            
                                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) { ?>

                                                <!-- buscar a categoria atual do item que desejamos alterar -->
                                                <option value="<?php echo $row['cid']; ?>"><?php echo $row['cname']; ?></option>


                                            <?php

                                            #resto das categorias
                                            $query2 = $con->prepare("SELECT * FROM category");
                                            $query2->execute();
                                            while ($row2 = $query2->fetch(PDO::FETCH_ASSOC)) 
                                            {
                                                if($row2['catName']==$row['cname'])
                                                    continue;
                                                else
                                                {
                                                ?>  

                                                <option value="<?php echo $row2['id'];?>"><?php echo $row2['catName'];?></option>

                                            <?php } } }
                                        }?>
    
                                        <?php 
                                        if(!isset($_GET['id']))
                                        {
                                            $query = $con->prepare("SELECT * from category");
                                            $query->execute();
                                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) 
                                            { ?>

                                                <option value="<?php echo $row['id']; ?>"><?php echo $row['catName']; ?></option>

                                            <?php } 
                                        }?>    
                                    </select>
                                </div>


                                <!-- Devia de ser especifico a categoria escolhida em cima arranjar depois se houver tempo -->
                                <label class="control-label">Sub Categoria</label>
                                <div class="form-group">
                                    <select name="subcategory" class="form-control unicase-form-control text-input" required>



                                    <?php 
                                    #CATEGORIA DO ITEM A SER EDITADO
                                        if(isset($_GET['id']))
                                        {

                                            $id = intval($_GET['id']);

                                            #produto em si que desejamos editar
                                            $query = $con->prepare("SELECT S.subcategory AS subcatname, S.id AS subid FROM products as P JOIN subcategory AS S ON P.subcategory = S.id  WHERE P.id=?");
                                            $query -> bindValue(1, $id);
                                            $query->execute();


                                                while ($row = $query->fetch(PDO::FETCH_ASSOC)) { ?>

                                                <!-- buscar a categoria atual do item que desejamos alterar -->
                                                <option value="<?php echo $row['subid']; ?>"><?php echo $row['subcatname']; ?></option>

                                                <?php
                                                    #resto das categorias
                                                    $query2 = $con->prepare("SELECT * FROM subcategory");
                                                    $query2->execute();
                                                    while ($row2 = $query2->fetch(PDO::FETCH_ASSOC)) 
                                                    {
                                                        if($row2['id']==$row['subid'])
                                                            continue;
                                                        else
                                                        {
                                                        ?>  

                                                        <option value="<?php echo $row2['id'];?>"><?php echo $row2['subcategory'];?></option>

                                                <?php } } }
                                        }

                                        if(!isset($_GET['id']))
                                        {
                                                $query = $con->prepare("SELECT * from subcategory");
                                                $query->execute();
                                                while ($row = $query->fetch(PDO::FETCH_ASSOC)) 
                                                { ?>

                                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['subcategory']; ?></option>
                                                    
                                            <?php } 
                                        }?>
                                    </select>
                                </div>
           


                            <?php 

                            #se get não posto textboxes como normal, sequalhar seria melhor ter feito outro php como normal mas quis me testar
                            if(!isset($_GET['id']))
                            { ?>
                                    <div class="control-group">
                                        <label class="control-label">Nome Produto</label>
                                            <input type="text" name="nome" class="form-control unicase-form-control text-input"  required>
                                    </div>

                                    <br> <br>
                                    <div class="control-group">
                                        <label class="control-label">Marca Produto</label>
                                            <input type="text" name="marca" class="form-control unicase-form-control text-input" required>
                                    </div>
                        
                                    <br> <br>
                                    <div class="control-group">
                                        <label class="control-label">Preço</label>
                                            <input type="text" name="preco" class="form-control unicase-form-control text-input" required>
                                    </div>

                                    <br> <br>
                                    <!-- PODE SER FORMATA EXEMPLO <ul><li> a </li><li>b<br></li><li>c</li></ul> -->
                                    <div class="control-group">
                                        <label class="control-label">Descrição do Produto PODE SER FORMATA EXEMPLO ul li etc..</label>
                                            <textarea name="descri" rows="4" class="form-control unicase-form-control text-input"> </textarea>
                                    </div>

                                    <br> <br>
                                    <div class="control-group">
                                        <label class="control-label" >Custo Shipping/Envio</label>
                                            <input type="text" name="shipping" class="form-control unicase-form-control text-input" required>
                                    </div>


                                    <br> <br>
                                    <!-- COLETAR IMAGENS, TYPE = "FILE" -> AJUDAS.DOCX-->
                                    <div class="control-group">
                                        <label class="control-label">IMAGEM 1</label>
                                            <input type="file" name="imagem1" id="imagem1" class="form-control unicase-form-control text-input" required>
                                    </div>

                                    <br> <br>
                                    <div class="control-group">
                                        <label class="control-label" >IMAGEM 2</label>
                                            <input type="file" name="imagem2" id="imagem2" class="form-control unicase-form-control text-input">
                                    </div>

                                    <br> <br>
                                    <div class="control-group">
                                        <label class="control-label" >IMAGEM 3</label>
                                            <input type="file" name="imagem3" id="imagem3" class="form-control unicase-form-control text-input">
                                    </div>

                                    <div class="control-group">
                                            <center>
                                            <br>
                                            <button type="submit" name="submit" class="btn-upper btn btn-primary checkout-page-button">INSERIR PRODUTO</button>
                                            </center>
                                    </div>
                                </div>
                            <?php } 


                            #com o id adicionamos os values agora
                            if(isset($_GET['id']))
                            { 
                                #produto em si que desejamos editar
                                $query = $con->prepare("SELECT * FROM products WHERE id=?");
                                $query -> bindValue(1, $id);
                                $query->execute();

                                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) { ?>

                                    <div class="control-group">
                                        <label class="control-label">Nome Produto</label>
                                            <input type="text" name="nome" class="form-control unicase-form-control text-input" value="<?php echo $row['nomeprod'] ?>"  required>
                                    </div>

                                    <br> <br>
                                    <div class="control-group">
                                        <label class="control-label">Marca Produto</label>
                                            <input type="text" name="marca" class="form-control unicase-form-control text-input" value="<?php echo $row['marcaprod'] ?>" required>
                                    </div>
                        
                                    <br> <br>
                                    <div class="control-group">
                                        <label class="control-label">Preço</label>
                                            <input type="text" name="preco" class="form-control unicase-form-control text-input" value="<?php echo $row['precoprod'] ?>" required>
                                    </div>

                                    <br> <br>
                                    <!-- PODE SER FORMATA EXEMPLO <ul><li> a </li><li>b<br></li><li>c</li></ul> -->
                                    <div class="control-group">
                                        <label class="control-label">Descrição do Produto PODE SER FORMATA EXEMPLO ul li etc..</label>
                                            <textarea name="descri" rows="4" class="form-control unicase-form-control text-input"> <?php echo $row['descprod'] ?> </textarea>
                                    </div>

                                    <br> <br>
                                    <div class="control-group">
                                        <label class="control-label" >Custo Shipping/Envio</label>
                                            <input type="text" name="shipping" class="form-control unicase-form-control text-input"  value="<?php echo $row['taxashipping'] ?>" required>
                                    </div>


                                    <!-- COLETAR IMAGENS, TYPE = "FILE" -> AJUDAS.DOCX
                                     AQUI COM O GET NÃO É OBRIGATORIO UMA IMAGEM-->
                                    <br> <br> <br> <br> 
                                    <div class="control-group">
                                        <label class="control-label">IMAGEM 1 ATUAL -></label>
                                            <!-- imagens default vindas do folder productimages na dir do site -->
                                            <img src="productimages/<?php echo htmlentities($row['imagem1']); ?>" width="150" height="150">
                                            <input type="file" name="imagem1" id="imagem1" class="form-control unicase-form-control text-input">
                                    </div>

                                    <br> <br> <br> <br> 
                                    <div class="control-group">
                                        <label class="control-label" >IMAGEM 2 ATUAL -></label>
                                         <!-- imagens default vindas do folder productimages na dir do site -->
                                        <img src="productimages/<?php echo htmlentities($row['imagem2']); ?>" width="150" height="150">
                                            <input type="file" name="imagem2" id="imagem2" class="form-control unicase-form-control text-input">
                                    </div>

                                    <br> <br> <br> <br> 
                                    <div class="control-group">
                                        <label class="control-label" >IMAGEM 3 ATUAL -></label>
                                         <!-- imagens default vindas do folder productimages na dir do site -->
                                        <img src="productimages/<?php echo htmlentities($row['imagem3']); ?>" width="150" height="150">
                                            <input type="file" name="imagem3" id="imagem3" class="form-control unicase-form-control text-input">
                                    </div>

                                    <div class="control-group">
                                            <center>
                                            <br>
                                            <button type="submit" name="submit" class="btn-upper btn btn-primary checkout-page-button">EDITAR PRODUTO</button>
                                            </center>
                                    </div>
                                </div>
                            <?php } } ?>
                    </form>
                                       
                            <!-- TABELA PARA APAGAR / EDITAR? -->
                            <div class="col-md-6 col-sm-6 create-new-account">
                                <h4 class="checkout-subtitle">ADMIN - APAGAR PRODUTO</h4>
                                <form class="register-form outer-top-xs" role="form" method="post" name="register">
                                    <table cellpadding="0" cellspacing="0" class="table table-bordered" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;">ID</th>
                                                <th style="text-align: center;"> Imagem</th>
                                                <th style="text-align: center;">Nome Produto</th>
                                                <th style="text-align: center;">Categoria </th>
                                                <th style="text-align: center;">Subcategoria</th>
                                                <th style="text-align: center;">Marca Produto</th>
                                                <th style="text-align: center;">Remover</th>
                                                <th style="text-align: center;">Editar</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php 
                                            #Select com joins das tabelas que precisamos, produtos,categoria e subcategoria para nomes e isso
                                            $query = $con->prepare("SELECT P.*, C.catName, S.subcategory FROM products AS P JOIN category AS C ON C.id=P.category JOIN subcategory AS S ON S.id=P.subcategory");
                                            $query->execute();
                                            
                                            #apresentação dos items na tabela
                                            if($query -> rowCount() > 0)
                                            while ($row = $query->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <tr>
                                                <td style="text-align: center;"><?php echo htmlentities($row['id']);?></td>
                                                <td class="cart-image">
														<a class="entry-thumbnail">
															<img src="productimages/<?php echo $row['imagem1']; ?>" alt="" width="50" height="50">
														</a>
													</td>
                                                <td style="text-align: center;"><?php echo htmlentities($row['nomeprod']);?></td>
                                                <td style="text-align: center;"><?php echo htmlentities($row['catName']);?></td>
                                                <td style="text-align: center;"> <?php echo htmlentities($row['subcategory']);?></td>
                                                <td style="text-align: center;"><?php echo htmlentities($row['marcaprod']);?></td>
                                                <td style="text-align: center;"><a href="admin.php?id=<?php echo $row['id']?>&del" onClick="return confirm('Deseja mesmo apagar o item?')"><i class="icon fa fa-trash"></i></a></td>
                                                <td style="text-align: center;"><a href="admin.php?id=<?php echo $row['id']?>" ><i class="icon fa fa-edit"></i></a></td>
                                            </tr>
                                        <?php } else { ?>
                                            <tr>
                                                <td style="text-align: center;"><?php echo htmlentities($cont);?></td>
                                                <td class="cart-image">
														<a class="entry-thumbnail">
															<img src="productimages/image 3.jpg" alt="" width="50" height="50">
														</a>
													</td>
                                                <td style="text-align: center;">Insira</td>
                                                <td style="text-align: center;">uns</td>
                                                <td style="text-align: center;"> produtos</td>
                                                <td style="text-align: center;">ao lado</td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>                                 
                                </form>
                          </div>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>
<?php include('includes/footer.php'); ?>