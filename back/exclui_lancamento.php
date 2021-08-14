<?php
    include("../functions/common_functions.php");

    $id_lancamento=$_GET['id_lancamento'];

    $sql=exclui_lanc_estoque($id_lancamento);

    if(isset($_GET['id_produto'])){
        $id_produto=$_GET['id_produto'];
        if($sql==0){
            header("Location: ../front/info_produto.php?message=3&id_produto=".$id_produto);
        }
        else{
            header("Location: ../front/info_produto.php?message=4&id_produto=".$id_produto); 
        }
    }
    else{
        if($sql==0){
            header("Location: ../front/consultas.php?message=3");
        }
        else{
            header("Location: ../front/consultas.php?message=4"); 
        }
    }

?>