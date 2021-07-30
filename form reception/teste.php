<?php 
require_once("../00 - BD/bd_conexao.php");
$cod="7890185681683";
$nome="Estilete 7'' 18mm Inox Tramontina";
$preco=4.99;
$un="un";
$quant=30;
$sql="INSERT INTO produto values(NULL, '$cod', '$nome', '$preco', '$un', '$quant')";
if ($con->query($sql) == TRUE) {
    fecharConexao($con);
    header("Location: result.php?success");
} else {
    fecharConexao($con);
    header("Location: result.php?erro");
}

?>
