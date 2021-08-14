<!doctype html>
<html lang="ptbr">
  <head>
    <title>Informações do Produto</title>
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
        var resposta = confirm("Deseja mesmo excluir esse produto?");
        if (resposta == true){
          window.location.href = url;
        }
    }
    </script>
    </head>
  <body>
  <?php include_once("menu.php");?>
  <div class="info-produto border border-warning col-7">
    <h1 class="text-dark"> Informações do Produto </h1>
    <?php
    $id_produto=$_GET['id_produto'];
    include_once("../functions/common_functions.php");
    require_once("../00 - BD/bd_conexao.php");
    $sql=exibe_produto_completo($id_produto); 
    $sql=$con->query($sql);//Dando o comando SQL retornado pela função acima;
    $infoProduto=mysqli_fetch_object($sql);//Transformando o resultado do comando SQL em objeto;
    $nome_produto=$infoProduto->nome;
    $preco_venda=$infoProduto->preco_venda;
    $preco_venda=number_format($preco_venda, 2, ',','');
    $unidade_medida=$infoProduto->unidade_medida;
    if($unidade_medida=='un'){
      $value=0;
    }
    else{
      $value=3;
    }
    $quant=number_format($infoProduto->quant_estoque, $value, ',','');
    ?>
    <b>ID do Produto:</b> <?php echo $id_produto; ?><br>
    <b>Nome do Produto:</b> <?php echo $nome_produto; ?><br>
    <b>Preço de Venda:</b> R$ <?php echo $preco_venda;?><br>
    <b>Quantidade em Estoque: <span class="text-success"><?php echo $quant.' '.$unidade_medida;?></span><br></b>
    <div class="row">
      <div class="col"><a href="cadastra_produtos.php?id_produto=<?php echo $id_produto;?>"><img src="../imgs/editar.png"></a><br>Editar Dados</div>
      <div class="col"><a href="../back/exclui_produto.php?id_produto=<?php echo $id_produto;?>" onclick="confirmar('../back/exclui_produto.php?id_produto=<?php echo $id_produto;?>')"><img src="../imgs/excluir.png" alt="Excluir"></a><br>Excluir Produto</div>
    </div>
  </div>
  <div class="exibir-lancamentos border border-warning rounded col-8">

      <form action="info_produto.php?id_produto=<?php echo $id_produto;?>" method="POST" class="mb-20 form-lancamentos text-center">
        <h4>Pesquisar Lançamentos</h4>
        <label for="inicio">Data de Inicio</label><br>
        <input type="date" class="col-7" name="inicio" id="inicio" autocomplete="off"><br>
        <label for="final">Data Final</label><br>
        <input type="date" class="col-7" name="final" id="final" autocomplete="off"><br>
        <button class="btn btn-warning col-7" type="submit" name="pesquisa_lancamento"><img src="../imgs/pesquisar.png" class="img-button"></button>
      </form>
      <?php
      if(isset($_POST['pesquisa_lancamento'])){
          if(isset($_POST['inicio']) && !empty($_POST['inicio'])){
              $inicio=$_POST['inicio'];
          }
          if(isset($_POST['final']) && !empty($_POST['final'])){
              $final=$_POST['final'];
          }
          if(empty($inicio) && empty($final)){
            $sql=exibe_lancamentos_all_prod($id_produto);//pegando string do comando SQL
            $sql=$con->query($sql);//dando o comando SQL
          }
          else if(!empty($inicio)&&empty($final)){
            $sql=exibe_lancamentos_data_prod($id_produto, $inicio);//pegando string do comando SQL
            $sql=$con->query($sql);//dando o comando SQL
          }
          else if(!empty($inicio)&&!empty($final)){
            $sql=exibe_lancamentos_periodo_prod($id_produto, $inicio, $final);//pegando string do comando SQL
            $sql=$con->query($sql);//dando o comando SQL
          }
          else if(empty($inicio)&&!empty($final)){
            $sql=exibe_lancamentos_data_prod($id_produto, $final);//pegando string do comando SQL
            $sql=$con->query($sql);//dando o comando SQL
          }
        ?>
        <table class="table scrollable table-striped">
              <thead>
                  <tr class="bg-primary">
                      <th>Nome do produto</th>
                      <th class="text-center">Data de Lançamento</th>
                      <th class="text-left">Quant. Recebida</th>
                      <th class="text-left">Preço de Custo</th>
                      <th class="text-left">Custo Total</th>
                      <th>Ações</th>
                  </tr>
              </thead>
              <tbody>
              <?php
              while($infoLancamento=mysqli_fetch_object($sql)){
                    $id_lancamento= $infoLancamento->id_lancamento;
                    $nome_produto_lanc=$infoLancamento->nome_produto;
                    $data_lancamento = $infoLancamento->data_lancamento;
                    $timestamp = strtotime($data_lancamento);
                    $data_lancamento = date("d-m-Y", $timestamp);
                    if($unidade_medida=='un'){
                      $value=0;
                    }
                    else{
                      $value=3;
                    }
                    $quant_recebida=number_format($infoLancamento->quant_recebida, $value, ',','');
                    $preco_custo=number_format($infoLancamento->preco_custo_un, 2, ',','');
                    $total_lancamento = $infoLancamento->quant_recebida *  $infoLancamento->preco_custo_un;
                    $total_lancamento = number_format($total_lancamento, 2, ',','');
              ?>
              <tr class="resultado">
                  <td> <?php echo $nome_produto_lanc;?> </td>
                  <td class="text-center"><?php echo $data_lancamento;?> </td>
                  <td> <?php echo $quant_recebida.' '.$unidade_medida;?></td>
                  <td>R$ <?php echo $preco_custo;?></td>
                  <td>R$ <?php echo $total_lancamento;?></td>
                  <td>
                    <div class="d-flex">
                      <a href="lancamento_estoque.php?id_lancamento=<?php echo $id_lancamento;?>&id_produto=<?php echo $id_produto;?>"><img src="../imgs/editar.png" class="img-button"></a>
                      <a href="../back/exclui_lancamento.php?id_lancamento=<?php echo $id_lancamento;?>&id_produto=<?php echo $id_produto;?>" onclick="confirmar('../back/exclui_lancamento.php?id_lancamento=<?php echo $id_lancamento;?>&id_produto=<?php echo $id_produto;?>')"><img src="../imgs/excluir.png" alt="Excluir" class="img-button"></a>
                    </div>
                  </td>
              </tr>
              <?php
                  }}//Fecha While
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
          echo '<script> alert("Estoque lançado com sucesso!") </script>';
          break;
        case 2:
          echo '<script> alert("Ocorreu um erro interno ao tentar lançar o estoque. Tente novamente!") </script>';
          break;
        case 3:
          echo '<script> alert("Lançamento excluído com sucesso") </script>';
          break;
        case 4:
          echo '<script> alert("Ocorreu um erro interno ao tentar excluir o lançamento. Tente novamente!") </script>';
          break;
        case 5:
          echo '<script> alert("Lançamento alterado com sucesso!") </script>';
          break;
        case 6:
          echo '<script> alert("Ocorreu um erro interno ao tentar alterar o lançamento. Tente novamente!") </script>';
          break;
    }
}
?>