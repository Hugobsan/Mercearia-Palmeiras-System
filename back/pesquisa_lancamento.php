<?php
include("../functions/common_functions.php");
$id_produto=$_POST['id_produto'];
if(isset($_POST['inicio']) && !empty($_POST['inicio'])){
    $inicio=$_POST['inicio'];
}
if(isset($_POST['final']) && !empty($_POST['final'])){
    $final=$_POST['final'];
}
if(empty($inicio) && empty($final)){
    $sql=exibe_lancamentos_all();
    header("Location: ../front/info_produto?id_produto=".$id_produto."&sql=".$sql);
}

?>