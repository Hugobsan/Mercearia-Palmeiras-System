<!doctype html>
<html lang="pt-br">
  <head>
    <title>Cadastro de Clientes</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Global CSS -->
    <link rel="stylesheet" href="../css/global_css.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
  </head>
  <body>
    <?php include_once("menu.php");
    require_once("../00 - BD/bd_conexao.php");
    if(isset($_GET['id_produto'])){
    include_once("../functions/common_functions.php");
      $id_produto=$_GET['id_produto'];
      $sql=exibe_produto_completo($id_produto);
      $sql=$con->query($sql);
      $infoProduto=mysqli_fetch_object($sql);
      $nome_produto=$infoProduto->nome;
      if(isset($infoProduto->cod_barras)){
        $cod_barras=$infoProduto->cod_barras;
      }
      $preco_venda=$infoProduto->preco_venda;
      $unidade_medida=$infoProduto->unidade_medida;
      $quantidade_estoque=$infoProduto->quant_estoque;
      ?>
      <h1 class="text-center text-white">Atualização de Dados de Produto</h1>
      <form method="POST" class="col-8 form-produtos border border-warning rounded" action="../back/atualiza_produtos.php">
          <input type="hidden" name="id_produto" value="<?php echo $id_produto;?>">
          <label for="nome">Nome do Produto*</label><br>
          <input type="text" class="form-control" name="nome_produto" id="nome" autocomplete="off" required value="<?php echo $nome_produto;?>"><br>
          <label for="cod_barras">Código de Barras</label><br>
          <input type="number" class="form-control" name="cod_barras" id="cod_barras" autocomplete="off" readonly="true" value="<?php if(isset($cod_barras))echo $cod_barras;?>"><br>
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
          <button class="btn btn-primary form-control" type="submit" name="btn_enviar"><b>Atualizar Dados<b></button>
      </form>
    <?php
    }
    else{
      ?>
      <h1 class="text-center text-white">Cadastro de Clientes</h1>
      <form method="POST" class="col-8 form-produtos border border-warning rounded" action="../back/cadastra_clientes.php">
        <fieldset>
        <legend>Informações do Cliente</legend>
            <label for="nome">Nome do Cliente*</label><br>
            <input type="text" class="form-control" name="nome_cliente" id="nome" autocomplete="off" required><br>
            <label for="cpf">CPF ou CNPJ</label><br>
            <input type="text" class="form-control" name="cpf" id="cpf" autocomplete="off"><br>
            <label for="telefone">Telefone</label><br>
            <input type="text" class="form-control" name="telefone" id="telefone" autocomplete="off"><br>
        </fieldset>
        <fieldset>
            <legend>Informações de Endereço do Cliente</legend>
        </fieldset>
            <label for="rua">Rua</label><br>
            <input type="text" class="form-control" name="rua" id="rua" autocomplete="off"><br>
            <label for="num">Número</label><br>
            <input type="number" class="form-control" name="numero" class="col-5" id="num"  autocomplete="off"><br>
            <label for="bairro">Bairro</label><br>
            <input type="text" class="form-control" name="bairro" id="bairro" autocomplete="off"><br>
            <label for="cidade">Cidade</label><br>
            <input type="text" class="form-control" name="cidade" id="cidade" autocomplete="off"><br>
          <br><br>
          <button class="btn btn-primary form-control" type="submit" name="btn_enviar"><b>Cadastrar<b></button>
      </form>
      <?php
    }
    ?>
    
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
            echo '<script> alert("") </script>';
            break;
    }
}
?>