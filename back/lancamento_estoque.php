<?php
    include("../functions/common_functions.php");
    //Recebendo o ID do produto
    if(isset($_POST['id_produto']) && !empty($_POST['id_produto'])){
        $id_produto=$_POST['id_produto'];
    }
    //Recebendo a quantidade
    if(isset($_POST['quant_recebida']) && !empty($_POST['quant_recebida'])){
        $quant_recebida=$_POST['quant_recebida'];
        $quant_recebida=str_replace(',','.', $quant_recebida);
    }
    //Recebendo o preco de custo
    if(isset($_POST['preco_custo']) && !empty($_POST['preco_custo'])){
        $preco_custo=$_POST['preco_custo'];
        $preco_custo=str_replace(',','.', $preco_custo);
    }
    if(empty($id_produto) || empty($quant_recebida) || empty($preco_custo)){
        header("Location: ../front/lancamento_estoque.php?message=1");
    }
    $sql=cadastra_lanc_estoque($id_produto, $quant_recebida, $preco_custo);
    if($sql == 0){
        header("Location: ../front/info_produto.php?message=1&id_produto=".$id_produto);
    }
    else{
        header("Location: ../front/info_produto.php?message=2&id_produto=".$id_produto);
    }
?>