<?php
require_once("00 - BD/bd_conexao.php");

// Função para cadastro de produtos
function cadastra_produto($cod_barras, $nome, $preco_venda, $unidade_medida, $quant_estoque){
    $sql="insert into produto values (null, '$cod_barras', '$nome', '$preco_venda', '$unidade_medida', '$quant_estoque');";
    if ($con->query($sql) == TRUE) {
        fecharConexao($con);
        header("");
    } else {
        fecharConexao($con);
        header("");
    }
}
//Função para cadastro de vendas diretas, sem cadastro em caderneta.
function venda_direta($id_produto, $quant){
    $sql="insert into venda values (null, null, CURRENT_TIMESTAMP, '0');
    SET @id_venda = (select max(id_venda) from venda);
    insert into venda_produto values(@id_venda,'$id_produto','$quant','1');
    update venda set finalizada=1 where finalizada=0;
    update produto set quant_estoque=quant_estoque-'$quant' where id_produto = '$id_produto';";

    if ($con->query($sql) == TRUE) {
        fecharConexao($con);
        header("");
    } else {
        fecharConexao($con);
        header("");
    }
}
//Função para cadastro de vendas para clientes com caderneta.
function venda_caderneta($id_produto, $quant, $id_caderneta){
    $sql="insert into venda values (null, '$id_caderneta', CURRENT_TIMESTAMP, '0');
    SET @id_venda = (select max(id_venda) from venda);
    insert into venda_produto values(@id_venda,'$id_produto','$quant','0');
    update venda set finalizada=1 where finalizada=0;
    update produto set quant_estoque=quant_estoque-'$quant' where id_produto = '$id_produto';";

    if ($con->query($sql) == TRUE) {
        fecharConexao($con);
        header("");
    } else {
        fecharConexao($con);
        header("");
    }
}
//Função para cadastro de lançamentos de produto no estoque.
function lancamento_estoque($id_produto, $quant_recebida, $preco_custo_un){
    $sql="insert into lancamento_estoque values(NULL, '$id_produto', '$quant_recebida', '$preco_custo_un', date(CURRENT_TIMESTAMP));";

    if ($con->query($sql) == TRUE) {
        fecharConexao($con);
        header("");
    } else {
        fecharConexao($con);
        header("");
    }
}
//Função para criar uma nova caderneta.
function cria_caderneta($id_cliente){
    $sql="insert into caderneta values(NULL, '$id_cliente', CURRENT_TIMESTAMP, NULL)";
    if ($con->query($sql) == TRUE) {
        fecharConexao($con);
        header("");
    } else {
        fecharConexao($con);
        header("");
    }
}
//Função para cadastro de novo cliente.
function cadastra_cliente($cpf, $nome, $telefone, $num, $cidade, $rua, $bairro){
    $sql="insert into cliente values(NULL,'$cpf','$nome');
    @id_cliente=(select max(id_cliente) from cliente);
    insert into telefone values(@id_cliente, '$telefone');
    insert into endereco values(@id_cliente, '$num', '$rua', '$bairro', '$cidade');
    ";
    
    if ($con->query($sql) == TRUE) {
        fecharConexao($con);
        header("");
    } else {
        fecharConexao($con);
        header("");
    }
}
//Função para lançamento de despesas
function cadastra_despesa($custo_un, $descricao, $nome, $quant){
    $sql="insert into despesa values(NULL, '$custo_un', '$descricao', '$nome', '$quant');";

    if ($con->query($sql) == TRUE) {
        fecharConexao($con);
        header("");
    } else {
        fecharConexao($con);
        header("");
    }
}
//Função para lançamento de fechamentos de caixa
function fecha_caixa($valor){
    $sql="insert into fechamento_caixa values(NULL,'$valor', CURRENT_TIMESTAMP)";

    if ($con->query($sql) == TRUE) {
        fecharConexao($con);
        header("");
    } else {
        fecharConexao($con);
        header("");
    }
} 
?>