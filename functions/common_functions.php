<?php
/* --- FUNÇÕES DA TABELA PRODUTO --- */

// Função para cadastro de produtos com código de barras
function cadastra_produto_cod($cod_barras, $nome, $preco_venda, $unidade_medida, $quant_estoque){
    $sql="INSERT INTO produto values (null, '$cod_barras', '$nome', '$preco_venda', '$unidade_medida', '$quant_estoque');";
    return $sql;
}

// Função para cadastrar produtos que não tem código de barras
function cadastra_produto_spl($nome, $preco_venda, $unidade_medida, $quant_estoque){
    $sql="INSERT INTO produto values (null, null, '$nome', '$preco_venda', '$unidade_medida', '$quant_estoque');";
    return $sql;
}

//Função para alterar produtos com código de barras
function altera_produto_cod($id_produto, $cod_barras, $nome, $preco_venda, $unidade_medida, $quant_estoque){
    $sql="UPDATE produto SET cod_barras='$cod_barras', nome='$nome', preco_venda='$preco_venda', unidade_medida='$unidade_medida', quant_estoque='$quant_estoque' WHERE id_produto='$id_produto'; ";
    return $sql;
}

//Função para alterar produtos que não tem código de barras
function altera_produto_spl($id_produto, $nome, $preco_venda, $unidade_medida, $quant_estoque){
    $sql="UPDATE produto SET nome='$nome', preco_venda='$preco_venda', unidade_medida='$unidade_medida', quant_estoque='$quant_estoque' WHERE id_produto='$id_produto'; ";
    return $sql;
}

//Função para excluir produtos em geral
function exclui_produto($id_produto){
    $sql="DELETE FROM produto WHERE id_produto = '$id_produto';";
    return $sql;
}

/* --- FIM DAS FUNÇÕES DA TABELA PRODUTO --- */


/* --- FUNÇÕES DA TABELA VENDA E VENDA_PRODUTO --- */

//Função para cadastro de vendas diretas, sem cadastro em caderneta.
function cadastra_venda_drt($id_produto, $quant){
    $sql="insert into venda values (null, null, CURRENT_TIMESTAMP, '0');
    SET @id_venda = (select max(id_venda) from venda);
    insert into venda_produto values(@id_venda,'$id_produto','$quant','1');
    update venda set finalizada=1 where finalizada=0;
    update produto set quant_estoque=quant_estoque-'$quant' where id_produto = '$id_produto';";

    return $sql;
}

//Função para cadastro de vendas para clientes com caderneta.
function cadastra_venda_cad($id_produto, $quant, $id_caderneta){
    $sql="insert into venda values (null, '$id_caderneta', CURRENT_TIMESTAMP, '0');
    SET @id_venda = (select max(id_venda) from venda);
    insert into venda_produto values(@id_venda,'$id_produto','$quant','0');
    update venda set finalizada=1 where finalizada=0;
    update produto set quant_estoque=quant_estoque-'$quant' where id_produto = '$id_produto';";

    return $sql;
}

//Função para alterar vendas já cadastradas
function altera_venda($id_venda, $id_produto, $data, $quant){
    $sql="UPDATE venda SET data='$data' WHERE id_venda='$id_venda';
    UPDATE venda_produto SET quant='$quant' WHERE id_venda='$id_venda' AND id_produto='$id_produto';";

    return $sql;
}

//Função para excluir vendas;
function exclui_venda($id_venda, $id_produto){
    $sql="DELETE FROM venda_produto WHERE id_venda='$id_venda' AND id_produto='$id_produto';
    DELETE FROM venda WHERE id_venda='$id_venda' AND NOT EXISTS(SELECT id_produto FROM venda_produto WHERE id_venda='$id_venda');";

    return $sql;
}

/* --- FIM DE FUNÇÕES DA TABELA VENDA E VENDA_PRODUTO --- */


/* --- FUNÇÕES DA TABELA LANÇAMETO_ESTOQUE --- */

//Função para cadastro de lançamentos de produto no estoque.
function cadastra_lanc_estoque($id_produto, $quant_recebida, $preco_custo_un){
    $sql="insert into lancamento_estoque values(NULL, '$id_produto', '$quant_recebida', '$preco_custo_un', date(CURRENT_TIMESTAMP));
    UPDATE produto SET quant_estoque=quant_estoque + '$quant_recebida' WHERE id_produto='$id_produto';";

    return $sql;
}

//Função para alterar lançamentos de produto no estoque.
function altera_lanc_estoque($id_lancamento, $quant_recebida, $preco_custo_un, $data_lancamento){
    $sql="SET @OLD_Quant = (SELECT quant_recebida FROM lancamento_estoque WHERE id_lancamento='$id_lancamento');
    SET @NEW_Quant = '$quant_recebida'-@OLD_Quant;
    UPDATE lancamento_estoque SET quant_recebida='$quant_recebida', preco_custo_un='$preco_custo_un', data_lancamento='$data_lancamento' WHERE id_lancamento='$id_lancamento';
    UPDATE produto SET quant_estoque=quant_estoque + @NEW_Quant WHERE id_produto = (SELECT id_produto FROM lancamento_estoque WHERE id_lancamento = '$id_lancamento');";

    return $sql;
}

//Função para excluir lançamentos de produto no estoque.
function exclui_lanc_estoque($id_lancamento){
    $sql="SET @OLD_Quant = (SELECT quant_recebida FROM lancamento_estoque WHERE id_lancamento='$id_lancamento');
    SET @id_produto = (SELECT id_produto FROM lancamento_estoque WHERE id_lancamento='$id_lancamento');
    DELETE FROM lancamento_estoque WHERE id_lancamento='$id_lancamento';
    UPDATE produto SET quant_estoque=quant_estoque-@OLD_Quant WHERE id_produto = @id_produto;
    ";

    return $sql;
}

/* --- FIM DAS FUNÇÕES DA TABELA LANÇAMETO_ESTOQUE --- */


/* --- INICIO DE FUNÇÕES DA TABELA CADERNETA --- */

//Função para criar uma nova caderneta.
function cria_caderneta($id_cliente){
    $sql="insert into caderneta values(NULL, '$id_cliente', date(CURRENT_TIMESTAMP), NULL)";
    
    return $sql;
}

//Função para fechar uma caderneta
function fecha_caderneta($id_cliente){
    $sql="UPDATE caderneta SET status_caderneta='fechada' WHERE id_cliente='$id_cliente' AND status_caderneta='aberta';";

    return $sql;
}

//Função para deletar caderneta
function exclui_caderneta($id_caderneta){
    $sql="DELETE FROM caderneta WHERE id_caderneta='$id_caderneta';";

    return $sql;
}

/* --- FIM DE FUNÇÕES DA TABELA CADERNETA --- */


/* --- INICIO DE FUNÇÕES DA TABELA CLIENTE--- */

//Função para cadastro de novo cliente.
function cadastra_cliente($cpf, $nome, $telefone, $num, $cidade, $rua, $bairro){
    $sql="insert into cliente values(NULL,'$cpf','$nome');
    @id_cliente=(select max(id_cliente) from cliente);
    insert into telefone values(@id_cliente, '$telefone');
    insert into endereco values(@id_cliente, '$num', '$rua', '$bairro', '$cidade');
    ";
    
    return $sql;
}

//Função para cadastro de telefone.
function cadastra_telefone($id_cliente, $telefone){
    $sql="insert into telefone values('$id_cliente', '$telefone');";

    return $sql;
}

//Função para edição de dados de cliente.
function altera_cliente($id_cliente, $cpf, $nome, $num, $cidade, $rua, $bairro){
    $sql="UPDATE cliente SET cpf='$cpf', nome='$nome' where id_cliente='$id_cliente';
    UPDATE endereco SET num='$num', cidade='$cidade', rua='$rua', bairro='$bairro';";

    return $sql;
}


//Função para exclusão de telefone.
function exclui_telefone($id_cliente, $telefone){
    $sql="DELETE FROM telefone WHERE id_cliente='$id_cliente' AND telefone='$telefone';";

    return $sql;
}

//Função para exclusão de cliente.
function exclui_cliente($id_cliente){
    $sql="DELETE FROM cliente WHERE id_cliente='$id_cliente';
    DELETE FROM endereco WHERE id_cliente='$id_cliente';
    DELETE FROM telefone WHERE id_cliente='$id_cliente'";

    return $sql;
}

/* --- FIM DE FUNÇÕES DA TABELA CLIENTE--- */

//Função para lançamento de despesas
function cadastra_despesa($custo_un, $descricao, $nome, $quant){
    $sql="insert into despesa values(NULL, '$custo_un', '$descricao', '$nome', '$quant');";

    return $sql;
}
//Função para lançamento de fechamentos de caixa
function fecha_caixa($valor){
    $sql="insert into fechamento_caixa values(NULL,'$valor', CURRENT_TIMESTAMP)";

    return $sql;
} 
?>