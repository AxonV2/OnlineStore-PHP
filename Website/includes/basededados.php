<?php
define('DB_Host','localhost');
define('DB_User','root');
define('DB_Pass' ,'');
define('DB_Nome', '100parar');
define('DB_Port', '3306');

$ligacao = "mysql:host=".DB_Host.";dbname=".DB_Nome.";port=".DB_Port.";charset=utf8";

try
{
    #EXEMPLO mysqli_connect($host,$user,$password,$database,$port,$socket)
    //$con = mysqli_connect(DB_Host,DB_User,DB_Pass,DB_Nome);

    $con = new PDO($ligacao, DB_User, DB_Pass);
    //echo "Db sucesso";
}
catch(PDOException $ex) 
{
    echo "Db Erro: ".$ex->getMessage();
}
