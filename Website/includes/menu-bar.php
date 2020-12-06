<div class="header-nav animate-dropdown">
    <div class="container">
        <div class="yamm navbar navbar-default" role="navigation">
            <div class="nav-bg-class">
                <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse">
                    <div class="nav-outer">
                        <ul class="nav navbar-nav">
                            <?php
                            $host  = $_SERVER['HTTP_HOST'];
                            $dir  = $_SERVER['PHP_SELF'];

                            #se tivermos no index tornar index active
                            if (basename("http://$host$dir") == 'index.php') { ?>
                                <li class="active dropdown yamm-fw">
                                <?php } else { ?>
                                <li class="dropdown yamm">
                                <?php } ?>
                                <a href="index.php" data-hover="dropdown" class="dropdown-toggle">Index</a>
                                </li>

                                <?php
                                $query = $con->prepare("SELECT id,catName FROM category");
                                $query->execute();
                                while ($col = $query->fetch(PDO::FETCH_ASSOC)) {
                                    #valor cid do URL para verificar e tornar active
                                    if (intval($_GET['cid']) == $col['id']) { ?>
                                        <li class="active dropdown yamm-fw">
                                        <?php } 
                                        else 
                                        { ?>
                                        <li class="dropdown yamm">
                                        <?php } ?>
                                        <!-- Cria um link para pagina especifica categoria com id especifico -->
                                        <a href="category.php?cid=<?php echo $col['id']; ?>">
                                            <!-- Nomes de categoria para a tabela -->
                                            <?php echo $col['catName']; ?></a>
                                        </li>
                                    <?php } ?>
                            </ul>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>