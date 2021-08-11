<?php
    include("../functions/common_functions.php");
    //Recebendo nome do produto
    if(isset($_POST['nome_produto']) && !empty($_POST['nome_produto'])){
        $nome=$_POST['nome_produto'];
    }
    //Recebendo código de barras
    if(isset($_POST['cod_barras']) && !empty($_POST['cod_barras'])){
        $cod_barras=$_POST['cod_barras'];
    }
    else{
        $cod_barras=null;
    }
    //Recebendo preco de venda
    if(isset($_POST['preco_venda']) && !empty($_POST['preco_venda'])){
        $preco_venda=$_POST['preco_venda'];
        $preco_venda=str_replace(',','.', $preco_venda);
    }
    //Recebendo unidade de medida
    if(isset($_POST['un_medida']) && !empty($_POST['un_medida'])){
        $un_medida=$_POST['un_medida'];
    }
    //Recebendo quantidade em estoque
    if(isset($_POST['quant_estoque']) && !empty($_POST['quant_estoque'])){
        $quant_estoque=$_POST['quant_estoque'];
        $quant_estoque=str_replace(',','.', $quant_estoque);
    }
    else{
        $quant_estoque=0;
    }
    if(empty($nome) || empty($preco_venda) || empty($un_medida)){
        header("Location: ../front/cadastra_produtos.php?message=1");
    }
    if($cod_barras==null){
        $sql=cadastra_produto_spl($nome, $preco_venda, $un_medida, $quant_estoque);
    }
    else{
        $sql=cadastra_produto_cod($cod_barras, $nome, $preco_venda, $un_medida, $quant_estoque);
    }
    if($sql == 0){
        header("Location: ../front/exibir_produtos.php?message=1");
    }
    else{
        header("Location: ../front/exibir_produtos.php?message=2");
    }
?>