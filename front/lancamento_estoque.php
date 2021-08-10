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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <?php include_once("menu.php");?>
    <h1 class="text-center text-white">Lançamento de Estoque</h1>
    <form method="POST" class="col-6 form-produtos border border-warning rounded" action="../form reception/lancamento_estoque.php">
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
        <label for="preco_custo">Preço Unitário de Custo</label><br>
        <input type="number"  step="any" class="form-control" name="preco_custo" id="preco_custo" autocomplete="off" required><br>
        <button class="btn btn-primary form-control" type="submit" name="btn_enviar"><b>Cadastrar<b></button>
    </form>
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