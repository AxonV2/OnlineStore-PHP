<div class="side-menu animate-dropdown outer-bottom-xs">
    <div class="head"><i class="icon fa fa-align-justify fa-fw"></i> Categorias</div>
    <nav class="yamm megamenu-horizontal" role="navigation">
        <ul class="nav">
            <li class="dropdown menu-item">
                <?php
                $query = $con->prepare("SELECT id,catName FROM category");
                $query->execute();
                while ($lin = $query->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <!-- link para cada categoria especifica, mostra o seu nome da bd -->
                    <a href="category.php?cid=<?php echo $lin['id']; ?>" class="dropdown-toggle"><i class="icon fa fa-desktop fa-fw"></i>
                        <?php echo $lin['catName']; ?></a>
                <?php } ?>
            </li>
        </ul>
    </nav>
</div>