<!doctype html>
<html lang="pt-br">
  <head>
    <title>Cadastro de Produto</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Global CSS -->
    <link rel="stylesheet" href="../css/global_css.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <?php include_once("menu.php");
    if(isset($_GET['id_produto'])){
    include_once("../functions/common_functions.php");
      $id_produto=$_GET['id_produto'];
      $sql=exibe_produto_completo($id_produto);
      $infoProduto=mysqli_fetch_object($sql);
      $nome_produto=$infoProduto->nome;
      $cod_barras=$infoProduto->cod_barras;
      $preco_venda=$infoProduto->preco_venda;
      $unidade_medida=$infoProduto->unidade_medida;
      $quantidade_estoque=$infoProduto->quant_estoque;
      ?>
      <h1 class="text-center text-white">Atualização de Dados de Produto</h1>
      <form method="POST" class="col-8 form-produtos border border-warning rounded" action="../form reception/atualiza_produtos.php">
          <input type="hidden" name="id_produto" value="<?php echo $id_produto;?>">
          <label for="nome">Nome do Produto*</label><br>
          <input type="text" class="form-control" name="nome_produto" id="nome" autocomplete="off" required value="<?php echo $nome_produto;?>"><br>
          <label for="cod_barras">Código de Barras</label><br>
          <input type="number" class="form-control" name="cod_barras" id="cod_barras" autocomplete="off" readonly="true" value="<?php echo $cod_barras;?>"><br>
          <label for="preco_venda">Preço de Venda*</label><br>
          <input type="number"  step="any" class="form-control" name="preco_venda" id="preco_venda" autocomplete="off" required value="<?php echo $preco_venda;?>"><br>
          <label for="un">Unidade de Medida*</label><br>
          <select name="un_medida" class="col-5" id="un" required>
            <option value="un"<?php if($unidade_medida=='un'){echo 'selected';}?>>Unidade</option>
            <option value="kg"<?php if($unidade_medida=='kg'){echo 'selected';}?>>Peso</option>
          </select>
          <br><br>
          <label for="quant">Quantidade em Estoque</label><br>
          <input type="number" step="any" class="form-control" name="quant_estoque" id="quant" autocomplete="off" value="<?php echo $quantidade_estoque;?>"><br>
          <button class="btn btn-primary form-control" type="submit" name="btn_enviar"><b>Cadastrar<b></button>
      </form>
    <?php
    }
    else{
      ?>
      <h1 class="text-center text-white">Cadastro de Produto</h1>
      <form method="POST" class="col-8 form-produtos border border-warning rounded" action="../form reception/cadastra_produtos.php">
          <label for="nome">Nome do Produto*</label><br>
          <input type="text" class="form-control" name="nome_produto" id="nome" autocomplete="off" required><br>
          <label for="cod_barras">Código de Barras</label><br>
          <input type="number" class="form-control" name="cod_barras" id="cod_barras" autocomplete="off"><br>
          <label for="preco_venda">Preço de Venda*</label><br>
          <input type="number"  step="any" class="form-control" name="preco_venda" id="preco_venda" autocomplete="off" required><br>
          <label for="un">Unidade de Medida*</label><br>
          <select name="un_medida" class="col-5" id="un" required>
            <option value="un" selected>Unidade</option>
            <option value="kg">Peso</option>
          </select>
          <br><br>
          <label for="quant">Quantidade em Estoque</label><br>
          <input type="number" step="any" class="form-control" name="quant_estoque" id="quant" autocomplete="off"><br>
          <button class="btn btn-primary form-control" type="submit" name="btn_enviar"><b>Cadastrar<b></button>
      </form>
      <?php
    }
    ?>
    
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
            echo '<script> alert("Preencha todos os campos obrigatórios antes de enviar o formulário") </script>';
            break;
    }
}
?>