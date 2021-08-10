<?php
    include("../functions/common_functions.php");
    //Recebendo id do produto
    $id_produto=$_GET['id_produto'];
    $sql=exclui_produto($id_produto);
    if($sql == 0){
        header("Location: ../front/exibir_produtos.php?message=5");
    }
    else{
        header("Location: ../front/exibir_produtos.php?message=6");
    }
?>