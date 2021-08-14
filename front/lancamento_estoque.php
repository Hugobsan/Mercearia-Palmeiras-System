<!doctype html>
<html lang="pt-br">
  <head>
    <title>Lançamento de Estoque</title>
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
    if(isset($_GET['id_lancamento'])){
      $id_lancamento=$_GET['id_lancamento'];
      include_once("../functions/common_functions.php");
      $sql=get_lancamento_by_id($id_lancamento);
      $infoLancamento=mysqli_fetch_object($sql);
      $id_produto=$infoLancamento->id_produto;
      $quant=$infoLancamento->quant_recebida;
      $preco_custo=$infoLancamento->preco_custo_un;
      $data_lancamento=$infoLancamento->data_lancamento;
      ?>
      <h1 class="text-center text-white">Alteração de Lançamento</h1>
    <form method="POST" class="col-6 form-produtos border border-warning rounded" action="../back/atualiza_lancamento.php?id_lancamento=<?php if(isset($_GET['id_produto'])){$id_produto=$_GET['id_produto'];echo $id_lancamento.'&id_produto='.$id_produto;}else{echo $id_lancamento;}?>">
        <label for="nome">ID Produto*</label><br>
        <input type="text" class="form-control" name="id_produto" id="nome" readonly=true autocomplete="off" required value="<?php echo $id_produto; ?>">
        <label for="quant_recebida">Quantidade Recebida*</label><br>
        <input type="number" step="any" class="form-control" name="quant_recebida" id="quant_recebida" autocomplete="off" value="<?php echo $quant; ?>"><br>
        <label for="preco_custo">Preço Unitário de Custo*</label><br>
        <input type="number"  step="any" class="form-control" name="preco_custo" id="preco_custo" autocomplete="off" required value="<?php echo $preco_custo; ?>"><br>
        <label for="data">Data de Lançamento*</label><br>
        <input type="date" class="form-control" name="data_lancamento" id="data" autocomplete="off" required value="<?php echo $data_lancamento; ?>"><br>
        <button class="btn btn-primary form-control" type="submit" name="btn_enviar"><b>Atualizar Informações<b></button>
    </form>
      <?php
    }
    else{
    ?>

    <h1 class="text-center text-white">Lançamento de Estoque</h1>
    <form method="POST" class="col-6 form-produtos border border-warning rounded" action="../back/lancamento_estoque.php">
        <label for="nome">ID Produto*</label><br>
        <input type="text" list="produtos" class="form-control" name="id_produto" id="nome" autocomplete="off" required>
        <datalist id="produtos">
          <?php
          require_once("../00 - BD/bd_conexao.php");
          $sql3 = "SELECT id_produto, nome FROM produto ORDER BY nome ASC";
          $result3 = $con->query($sql3) or die("Erro ao se conectar com o Banco de Dados. Tente novamente em alguns minutos...");
          while($prodDados = mysqli_fetch_object($result3)){
            $nomeProd=$prodDados->nome;
            $id_produto=$prodDados->id_produto;
            ?>
            <option value="<?php echo $id_produto;?>">
                <?php echo $nomeProd;?>
            </option> 
            <?php
          }
          ?>
          </datalist><br />
        <label for="quant_recebida">Quantidade Recebida*</label><br>
        <input type="number" step="any" class="form-control" name="quant_recebida" id="quant_recebida" autocomplete="off"><br>
        <label for="preco_custo">Preço Unitário de Custo*</label><br>
        <input type="number"  step="any" class="form-control" name="preco_custo" id="preco_custo" autocomplete="off" required><br>
        <button class="btn btn-primary form-control" type="submit" name="btn_enviar"><b>Cadastrar<b></button>
    </form>
    <?php } ?>
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
            echo '<script> alert("Preencha todos os campos obrigatórios antes de enviar o formulário") </script>';
            break;
    }
}
?>