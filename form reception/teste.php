<!doctype html>
<html lang="pt-br">
  <head>
    <title>Teste</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body{
            background-image: linear-gradient(to bottom right, #171466, #5752f7);
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
        }
        tbody{
            background-color: white;
        }
        .centralizar{
            margin: 10px auto;
        }  
    </style>
</head>
  <body>
    
<?php 
include("../functions/common_functions.php");
$select_function = false;
$nome_tbl_titulo="Vendas";
$sql=finalizar_venda();
if($select_function == false && $sql==0){
    echo '<script> alert("Operação Realizada com Sucesso!")</script>';
}
else if($select_function == false && $sql!=0){
    echo '<script> alert("Ocorreu um erro ao tentar realizar a operação no Banco de Dados!")</script>';
}
if($select_function == true){
?>
<h1 class="text-center text-white">Exibindo <?php echo $nome_tbl_titulo; ?></h1>
<table class="table centralizar table-striped col-6">
    <thead>
        <tr class="bg-primary">
            <th>Nome do produto</th>
            <th class="text-center">Preco de Venda</th>
            <th class="text-left">Quant. Em Estoque</th>
        </tr>
    </thead>
    <tbody>
    <?php
    $sql=exibe_produto_all();
    //mysqli_fetch_object() vai transformar o resultado da consulta sql retornado pela função em objeto para que os dados possam ser recuperados
        while($InfoProduto=mysqli_fetch_object($sql)){
            $nome = $InfoProduto->nome;
            $preco_venda = $InfoProduto->preco_venda;
            $preco_venda=number_format($preco_venda, 2, ',','');
            $un = $InfoProduto->unidade_medida;
            $quant=number_format($InfoProduto->quant_estoque, 3, ',','');
        
    ?>
    <tr>
        <td> <?php echo $nome;?> </td>
        <td class="text-center">R$ <?php echo $preco_venda;?> </td>
        <td> <?php echo $quant.' '.$un;?></td>
    </tr>
    <?php
        }//Fecha While
    ?>
    </tbody>
</table>
<?php } //Fecha if ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>