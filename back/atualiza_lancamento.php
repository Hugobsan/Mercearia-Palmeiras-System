<?php
    include("../functions/common_functions.php");
    $id_lancamento=$_GET['id_lancamento'];
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
    //Recebendo a data
    if(isset($_POST['data_lancamento']) && !empty($_POST['data_lancamento'])){
        $data_lancamento=$_POST['data_lancamento'];
    }
    $sql=altera_lanc_estoque($id_lancamento, $quant_recebida, $preco_custo, $data_lancamento);
    if(isset($_GET['id_produto'])){
        $id_produto=$_GET['id_produto'];
        if($sql == 0){
            header("Location: ../front/info_produto.php?message=5&id_produto=".$id_produto);
        }
        else{
            header("Location: ../front/info_produto.php?message=6&id_produto=".$id_produto);
        }
    }
    else{
        if($sql == 0){
            header("Location: ../front/despesas.php?message=1");
        }
        else{
            header("Location: ../front/despesas.php?message=2");
        }
    }
?>