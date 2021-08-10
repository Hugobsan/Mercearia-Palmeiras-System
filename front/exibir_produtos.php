<!doctype html>
<html lang="pt-br">
  <head>
    <title>Meus Produtos</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Global CSS -->
    <link rel="stylesheet" href="../css/global_css.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script> /* Confirmador de Saída */
      function confirmar(url){
        event.preventDefault();  
        var resposta = confirm("Deseja mesmo excluir esse produto?");
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
    <h1 class="text-center text-white titulo-produtos">Meus Produtos</h1>
    <div class="exibir-produtos border border-warning rounded col-8">
    <a href="cadastra_produtos.php"><button class="btn font-weight-bold btn-primary col-12 mb-20">Cadastrar Novo Produto</button></a>
      <form action="index.php" method="POST" class="mb-20">
        <h4><label for="produtos">Pesquisar Produtos</label></h4>
        <input type="text" class="col-11" name="nome_produto" id="produtos" autocomplete="off">
        <button class="btn border border-secondary" type="submit" name="pesquisa_nome"><img src="../imgs/pesquisar.png" class="img-button"></button>
      </form>
      <?php
        if(isset($_POST['pesquisa_nome']) && !empty($_POST['nome_produto'])){
          $nome=$_POST['nome_produto'];
          $sql=exibe_produto($nome);
        }
        else{
          $sql=exibe_produto_all();
        }
      ?>
      <table class="table scrollable table-striped">
      <thead>
          <tr class="bg-primary">
              <th style="width:50%;">Nome do produto</th>
              <th class="text-center">Preco de Venda</th>
              <th class="text-left">Quant. Em Estoque</th>
              <th>Ações</th>
          </tr>
      </thead>
      <tbody>
      <?php
      while($InfoProduto=mysqli_fetch_object($sql)){
            $id_produto = $InfoProduto->id_produto;
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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
<?php
if(isset($_GET['message'])){
    switch ($_GET['message']){
        case 1:
          echo '<script> alert("Produto cadastrado com sucesso!") </script>';
          break;
        case 2:
          echo '<script> alert("Ocorreu um erro interno ao tentar cadastrar o produto. Tente novamente!") </script>';
          break;
        case 3:
          echo '<script> alert("Produto atualizado com sucesso!") </script>';
          break;
        case 4:
          echo '<script> alert("Ocorreu um erro interno ao tentar atualizar o produto. Tente novamente!") </script>';
          break;
        case 5:
          echo '<script> alert("Produto excluído com sucesso!") </script>';
          break;
        case 6:
          echo '<script> alert("Ocorreu um erro interno ao tentar excluir o produto. Tente novamente!") </script>';
          break;
    }
}
?>