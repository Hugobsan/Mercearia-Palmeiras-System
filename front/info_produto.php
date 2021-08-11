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
    $sql=exibe_produto_completo($id_produto); 
    $infoProduto=mysqli_fetch_object($sql);
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

      <form action="info_produto.php" method="POST" class="mb-20 form-lancamentos text-center">
        <h4><label for="lancamentos">Pesquisar Lançamentos</label></h4>
        <input type="hidden" name="id_produto"value="<?php echo $id_produto?>">
        <input type="date" class="col-7" name="inicio" id="lacamentos" autocomplete="off">
        <input type="date" class="col-7" name="final" autocomplete="off"><br>
        <button class="btn btn-warning col-7" type="submit" name="pesquisa_lancamento"><img src="../imgs/pesquisar.png" class="img-button"></button>
      </form>
      <?php
      if(isset($_POST['pesquisa_lancamento'])){
        $id_produto=$_POST['id_produto'];
          if(isset($_POST['inicio']) && !empty($_POST['inicio'])){
              $inicio=$_POST['inicio'];
          }
          if(isset($_POST['final']) && !empty($_POST['final'])){
              $final=$_POST['final'];
          }
          if(empty($inicio) && empty($final)){
            $sql=exibe_lancamentos_all();
          }
          else if(!empty($inicio)&&empty($final)){
            $sql=exibe_lancamentos_data($inicio);
          }
        ?>
        <table class="table scrollable table-striped">
              <thead>
                  <tr class="bg-primary">
                      <th style="width:50%;">Nome do produto</th>
                      <th class="text-center">Data de Lançamento</th>
                      <th class="text-left">Quant. Recebida</th>
                      <th class="text-left">Preço de Custo</th>
                      <th>Ações</th>
                  </tr>
              </thead>
              <tbody>
              <?php
              while($infoLancamento=mysqli_fetch_object($sql)){
                    $id_lancamento= $infoLancamento->id_lancamento;
                    $nome_produto = $infoLancamento->nome_produto;
                    $data_lancamento = $infoLancamento->data_lancamento;
                    $timestamp = strtotime($data_lancamento);
                    $data_lancamento = date("d-m-Y", $timestamp);
                    if($un=='un'){
                      $value=0;
                    }
                    else{
                      $value=3;
                    }
                    $quant_recebida=number_format($infoLancamento->quant_recebida, $value, ',','');
                    $preco_custo=number_format($infoLancamento->preco_custo_un, 2, ',','');
              ?>
              <tr>
                  <td> <?php echo $nome_produto;?> </td>
                  <td class="text-center"><?php echo $data_lancamento;?> </td>
                  <td> <?php echo $quant_recebida.' '.$un;?></td>
                  <td>R$ <?php echo $preco_custo;?></td>
                  <td>
                    <div class="d-flex">
                      <a href="lancamento_estoque.php?id_lancamento=<?php echo $id_lancamento;?>"><img src="../imgs/editar.png" class="img-button"></a>
                      <a href="../back/exclui_lancamento.php?id_lancamento=<?php echo $id_lancamento;?>" onclick="confirmar('../back/exclui_produto.php?id_produto=<?php echo $id_produto;?>')"><img src="../imgs/excluir.png" alt="Excluir" class="img-button"></a>
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
    }
}
?>