<?php 
require_once("../00 - BD/bd_conexao.php");
include("../functions/common_functions.php");
//$sql="INSERT INTO produto values (null, null, 'Cenoura', '4.20', 'kg', '36.250');";

$sql=exclui_produto(6);
if ($con->query($sql) == TRUE) {
    fecharConexao($con);
    echo '<script> alert("Sucesso!") </script>';
} else {
    fecharConexao($con);
    echo '<script> alert("Erro!") </script>';
}

?>
