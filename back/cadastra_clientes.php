<?php
    include("../functions/common_functions.php");
    if(isset($_POST['nome_cliente']) && !empty($_POST['nome_cliente'])){
        $nome=$_POST['nome_cliente'];
    }
    if(isset($_POST['cpf']) && !empty($_POST['cpf'])){
        $cpf=$_POST['cpf'];
    }
    else{
        $cpf=NULL;
    }
    if(isset($_POST['telefone']) && !empty($_POST['telefone'])){
        $telefone=$_POST['telefone'];
    }
    else{
        $telefone='0';
    }
    if(isset($_POST['rua']) && !empty($_POST['rua'])){
        $rua=$_POST['rua'];
    }
    else{
        $rua=NULL;
    }
    if(isset($_POST['numero']) && !empty($_POST['numero'])){
        $numero=$_POST['numero'];
    }
    else{
        $numero=0;
    }
    if(isset($_POST['bairro']) && !empty($_POST['bairro'])){
        $bairro=$_POST['bairro'];
    }
    else{
        $bairro=NULL;
    }
    if(isset($_POST['cidade']) && !empty($_POST['cidade'])){
        $cidade=NULL;
    }
    else{
        $cidade=NULL;
    }
    $sql=cadastra_cliente($cpf, $nome, $telefone, $numero, $cidade, $rua, $bairro,);
    if($sql == 0){
        header("Location: ../front/exibir_clientes.php?message=1");
    }
    else{
        header("Location: ../front/exibir_clientes.php?message=2");
    }
    
?>