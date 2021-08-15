<!doctype html>
<html lang="pt-br">
  <head>
    <title>Clientes</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Global CSS -->
    <link rel="stylesheet" href="../css/global_css.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <script> /* Confirmador de Saída */
      function confirmar(url){
        event.preventDefault();  
        var resposta = confirm("Deseja mesmo excluir esse cliente?");
        if (resposta == true){
          window.location.href = url;
        }
    }
    </script>
  </head>
  <body>
    <?php include_once("menu.php");
    include_once("../functions/common_functions.php");
    ?>
    <h1 class="text-center text-white titulo-produtos">Clientes</h1>
    <div class="exibir-produtos border border-warning rounded col-8">
    <a href="cadastra_clientes.php"><button class="btn font-weight-bold btn-primary col-12 mb-20">Cadastrar Novo Cliente</button></a>
      <form action="exibir_clientes.php" method="POST" class="mb-20">
        <h4><label for="produtos">Pesquisar Clientes</label></h4>
        <input type="text" class="col-11" name="nome_produto" id="produtos" autocomplete="off">
        <button class="btn border border-secondary" type="submit" name="pesquisa_nome"><img src="../imgs/pesquisar.png" class="img-button"></button>
      </form>
      <?php
        if(isset($_POST['pesquisa_nome']) && !empty($_POST['nome_cliente'])){
          $nome=$_POST['nome_cliente'];
          $sql=exibe_clientes_by_nome($nome);
        }
        else{
          $sql=exibe_clientes_all();
        }
      ?>
      <table class="table scrollable table-striped col-12">
      <thead style="width:100%">
          <tr class="bg-primary">
              <th class="col-6">Cliente</th>
              <th class="text-center col-2">Status Caderneta</th>
              <th class="text-left col-2">Total Caderneta</th>
              <th class="col-2">Ações</th>
          </tr>
      </thead>
      <tbody>
      <?php
      while($infoCliente=mysqli_fetch_object($sql)){
            $nome = $infoCliente->nome_cliente;
            $status_caderneta = $infoCliente->status_caderneta;
            $data_abertura = $infoCliente->data_abertura;
            $id_caderneta = $infoCliente->id_caderneta;
            $preco_venda=number_format($preco_venda, 2, ',','');
            $un = $InfoProduto->unidade_medida;
            if($un=='un'){
              $value=0;
            }
            else{
              $value=3;
            }
            $quant=number_format($InfoProduto->quant_estoque, $value, ',','');
    ?>
    <tr class="resultado">
        <td> <?php echo $nome;?> </td>
        <td class="text-center">R$ <?php echo $preco_venda;?> </td>
        <td> <?php echo $quant.' '.$un;?></td>
        <td>
          <div class="d-flex">
            <a href="info_produto.php?id_produto=<?php echo $id_produto;?>"><img src="../imgs/info.png" class="img-button"></a>
            <a href="cadastra_produtos.php?id_produto=<?php echo $id_produto;?>"><img src="../imgs/editar.png" class="img-button"></a>
            <a href="../back/exclui_produto.php?id_produto=<?php echo $id_produto;?>" onclick="confirmar('../back/exclui_produto.php?id_produto=<?php echo $id_produto;?>')"><img src="../imgs/excluir.png" alt="Excluir" class="img-button"></a>
          </div>
        </td>
    </tr>
    <?php
        }//Fecha While
    ?>
    </tbody>
    </table>
    </div>
    
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="../js/jquery-3.3.1.slim.min.js"></script>
    <script src="../js/jquery.mask.min.js"></script>
    <script src="../js/popper.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>
<?php
if(isset($_GET['message'])){
    switch ($_GET['message']){
        case 1:
          echo '<script> alert("Cliente cadastrado com sucesso!") </script>';
          break;
        case 2:
          echo '<script> alert("Ocorreu um erro interno ao tentar cadastrar o cliente. Tente novamente!") </script>';
          break;
    }
}
?>