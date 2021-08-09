<?php
/* --- FUNÇÕES DA TABELA PRODUTO --- */
// Função para cadastro de produtos com código de barras
function cadastra_produto_cod($cod_barras, $nome, $preco_venda, $unidade_medida, $quant_estoque){
    require_once("../00 - BD/bd_conexao.php");
    $sql="INSERT INTO produto values (null, '$cod_barras', '$nome', '$preco_venda', '$unidade_medida', '$quant_estoque');";
    $con->query($sql);
    fecharConexao($con);
}

// Função para cadastrar produtos que não tem código de barras
function cadastra_produto_spl($nome, $preco_venda, $unidade_medida, $quant_estoque){
    require_once("../00 - BD/bd_conexao.php");
    $sql="INSERT INTO produto values (null, null, '$nome', '$preco_venda', '$unidade_medida', '$quant_estoque');";
    $con->query($sql);
    fecharConexao($con);
}

//Função para alterar produtos com código de barras
function altera_produto_cod($id_produto, $cod_barras, $nome, $preco_venda, $unidade_medida, $quant_estoque){
    require_once("../00 - BD/bd_conexao.php");
    $sql="UPDATE produto SET cod_barras='$cod_barras', nome='$nome', preco_venda='$preco_venda', unidade_medida='$unidade_medida', quant_estoque='$quant_estoque' WHERE id_produto='$id_produto'; ";
    $con->query($sql);
    fecharConexao($con);
}

//Função para alterar produtos que não tem código de barras
function altera_produto_spl($id_produto, $nome, $preco_venda, $unidade_medida, $quant_estoque){
    require_once("../00 - BD/bd_conexao.php");
    $sql="UPDATE produto SET nome='$nome', preco_venda='$preco_venda', unidade_medida='$unidade_medida', quant_estoque='$quant_estoque' WHERE id_produto='$id_produto'; ";
    $con->query($sql);
    fecharConexao($con);
}

//Função para excluir produtos em geral
function exclui_produto($id_produto){
    require_once("../00 - BD/bd_conexao.php");
    $sql="DELETE FROM produto WHERE id_produto = '$id_produto';";
    $con->query($sql);
    fecharConexao($con);
}

//Função para exibir infomações básicas dos produtos
function exibe_produto($id_produto){
    require_once("../00 - BD/bd_conexao.php");
    $sql="SELECT nome, preco_venda, unidade_medida, quant_estoque FROM produto WHERE id_produto = '$id_produto'";
    $con->query($sql);
    fecharConexao($con);
}
/* --- FIM DAS FUNÇÕES DA TABELA PRODUTO --- */


/* --- FUNÇÕES DA TABELA VENDA E VENDA_PRODUTO --- */

//Função para cadastro de vendas diretas, sem cadastro em caderneta.
function cadastra_venda_drt($id_produto, $quant){
    require_once("../00 - BD/bd_conexao.php");
    $sql="insert into venda values (null, null, CURRENT_TIMESTAMP, '0');";
    $con->query($sql);
    $sql="insert into venda_produto values(null, (select max(id_venda) from venda),'$id_produto','$quant','1', $quant*(SELECT preco_venda FROM produto WHERE id_produto='$id_produto'));";
    $con->query($sql);
    $sql="update venda set finalizada=1 where finalizada=0;";
    $con->query($sql);
    $sql="update produto set quant_estoque=quant_estoque-'$quant' where id_produto = '$id_produto';";
    $con->query($sql);
    fecharConexao($con);
}

//Função para cadastro de vendas para clientes com caderneta.
function cadastra_venda_cad($id_produto, $quant, $id_caderneta){
    require_once("../00 - BD/bd_conexao.php");
    $sql="insert into venda values (null, '$id_caderneta', CURRENT_TIMESTAMP, '0');";
    $con->query($sql);
    $sql="insert into venda_produto values(null, (select max(id_venda) from venda),'$id_produto','$quant','0', $quant*(SELECT preco_venda FROM produto WHERE id_produto='$id_produto'));";
    $con->query($sql);
    $sql="update venda set finalizada=1 where finalizada=0;";
    $con->query($sql);
    $sql="update produto set quant_estoque=quant_estoque-'$quant' where id_produto = '$id_produto';";
    fecharConexao($con);
}
//Função para excluir vendas;
function exclui_venda($id_venda, $id_produto){
    require_once("../00 - BD/bd_conexao.php");
    $sql="DELETE FROM venda_produto WHERE id_venda='$id_venda' AND id_produto='$id_produto';";
    $con->query($sql);
    $sql="DELETE FROM venda WHERE id_venda='$id_venda' AND NOT EXISTS(SELECT id_produto FROM venda_produto WHERE id_venda='$id_venda');";
    $con->query($sql);
    fecharConexao($con);
}

/* --- FIM DE FUNÇÕES DA TABELA VENDA E VENDA_PRODUTO --- */


/* --- FUNÇÕES DA TABELA LANÇAMETO_ESTOQUE --- */

//Função para cadastro de lançamentos de produto no estoque.
function cadastra_lanc_estoque($id_produto, $quant_recebida, $preco_custo_un){
    require_once("../00 - BD/bd_conexao.php");
    $sql="insert into lancamento_estoque values(NULL, '$id_produto', '$quant_recebida', '$preco_custo_un', date(CURRENT_TIMESTAMP));";
    $con->query($sql);
    $sql="UPDATE produto SET quant_estoque=quant_estoque + '$quant_recebida' WHERE id_produto='$id_produto';";
    $con->query($sql);
    fecharConexao($con);
}

//Função para alterar lançamentos de produto no estoque.
function altera_lanc_estoque($id_lancamento, $quant_recebida, $preco_custo_un, $data_lancamento){
    require_once("../00 - BD/bd_conexao.php");
    $sql="UPDATE lancamento_estoque SET quant_recebida='$quant_recebida', preco_custo_un='$preco_custo_un', data_lancamento='$data_lancamento' WHERE id_lancamento='$id_lancamento';";
    $con->query($sql);
    $sql="UPDATE produto SET quant_estoque=quant_estoque + ('$quant_recebida'-(SELECT quant_recebida FROM lancamento_estoque WHERE id_lancamento='$id_lancamento')) WHERE id_produto = (SELECT id_produto FROM lancamento_estoque WHERE id_lancamento = '$id_lancamento');";
    $con->query($sql);
    fecharConexao($con);
}

//Função para excluir lançamentos de produto no estoque.
function exclui_lanc_estoque($id_lancamento){
    require_once("../00 - BD/bd_conexao.php");
    $sql="DELETE FROM lancamento_estoque WHERE id_lancamento='$id_lancamento';";
    $con->query($sql);
    $sql="UPDATE produto SET quant_estoque=quant_estoque-(SELECT quant_recebida FROM lancamento_estoque WHERE id_lancamento='$id_lancamento') WHERE id_produto = (SELECT id_produto FROM lancamento_estoque WHERE id_lancamento='$id_lancamento');";
    $con->query($sql);
    fecharConexao($con);
}

//Função para exibir todas as despesas
function exibe_lancamentos_all(){
    require_once("../00 - BD/bd_conexao.php");
    $sql = "SELECT nome as nome_despesa, descricao, quant, custo_un FROM despesa WHERE 0 ORDER BY id_despesa DESC";
    $con->query($sql);
    fecharConexao($con);
}

//Função para exibir lançamentos de estoque por dia específico
function exibe_lancamentos_data($data){
    require_once("../00 - BD/bd_conexao.php");
    $sql = "SELECT p.nome as l.nome_produto, l.quant_recebida, l.preco_custo_un, l.data_lancamento FROM lancamento_estoque as l, produto as p WHERE l.id_produto=p.id_produto AND data_lancamento = '$data' ORDER BY l.id_lancamento DESC";
    $con->query($sql);
    fecharConexao($con);
}

//Função para exibir lançamentos de estoque a partir de um período
function exibe_lancamentos_periodo($inicio, $fim){
    require_once("../00 - BD/bd_conexao.php");
    $sql = "SELECT p.nome as l.nome_produto, l.quant_recebida, l.preco_custo_un, l.data_lancamento FROM lancamento_estoque as l, produto as p WHERE l.id_produto=p.id_produto AND data_lancamento BETWEEN '$inicio' AND '$fim' ORDER BY l.id_lancamento DESC";
    $con->query($sql);
    fecharConexao($con);
}

/* --- FIM DAS FUNÇÕES DA TABELA LANÇAMETO_ESTOQUE --- */


/* --- INICIO DE FUNÇÕES DA TABELA CADERNETA --- */

//Função para criar uma nova caderneta.
function cria_caderneta($id_cliente){
    require_once("../00 - BD/bd_conexao.php");
    $sql="insert into caderneta values(NULL, '$id_cliente', date(CURRENT_TIMESTAMP), 'aberta')";
    $con->query($sql);
    fecharConexao($con);
}

//Função para fechar uma caderneta
function fecha_caderneta($id_cliente){
    require_once("../00 - BD/bd_conexao.php");
    $sql="UPDATE caderneta SET status_caderneta='fechada' WHERE id_cliente='$id_cliente' AND status_caderneta='aberta';";
    $con->query($sql);
    fecharConexao($con);
}

//Função para deletar caderneta
function exclui_caderneta($id_caderneta){
    require_once("../00 - BD/bd_conexao.php");
    $sql="DELETE FROM caderneta WHERE id_caderneta='$id_caderneta';";
    $con->query($sql);
    fecharConexao($con);
}

//Função para exibir dados das cadernetas
function exibe_cadernetas($id_cliente){
    require_once("../00 - BD/bd_conexao.php");
    $sql="SELECT id_caderneta, data_abertura, status_caderneta FROM caderneta WHERE id_cliente='$id_cliente';";
    $con->query($sql);
    fecharConexao($con);
}

//Função pra exibir caderneta específica
function exibe_dados_caderneta($id_caderneta){
    require_once("../00 - BD/bd_conexao.php");
    $sql="SELECT cli.nome as nome_cliente, cad.id_caderneta, cad.data_abertura, cad.status_caderneta FROM caderneta as cad, cliente as cli WHERE cli.id_cliente=(SELECT id_cliente FROM caderneta WHERE id_caderneta='$id_caderneta') AND id_caderneta='$id_caderneta';";
    $con->query($sql);
    fecharConexao($con);
}

//função para exibir total da caderneta informada
function total_caderneta($id_caderneta){
    require_once("../00 - BD/bd_conexao.php");
    $sql="SELECT SUM(p.preco_venda*vp.quant) AS total_venda FROM produto as p, venda_produto as vp, venda as v, caderneta as c WHERE p.id_produto=vp.id_produto AND vp.id_venda = v.id_venda AND v.id_caderneta = '$id_caderneta';";
    $con->query($sql);
    fecharConexao($con);
}

/* --- FIM DE FUNÇÕES DA TABELA CADERNETA --- */


/* --- INICIO DE FUNÇÕES DA TABELA CLIENTE --- */

//Função para cadastro de novo cliente.
function cadastra_cliente($cpf, $nome, $telefone, $num, $cidade, $rua, $bairro){
    require_once("../00 - BD/bd_conexao.php");
    $sql="insert into cliente values(NULL,'$cpf','$nome');";
    $con->query($sql);
    $sql="insert into telefone values((select max(id_cliente) from cliente), '$telefone');";
    $con->query($sql);
    $sql="insert into endereco values((select max(id_cliente) from cliente), '$num', '$rua', '$bairro', '$cidade');";
    $con->query($sql);
    fecharConexao($con);
}

//Função para cadastro de telefone.
function cadastra_telefone($id_cliente, $telefone){
    require_once("../00 - BD/bd_conexao.php");
    $sql="insert into telefone values('$id_cliente', '$telefone');";
    $con->query($sql);
    fecharConexao($con);
}

//Função para edição de dados de cliente.
function altera_cliente($id_cliente, $cpf, $nome, $num, $cidade, $rua, $bairro){
    require_once("../00 - BD/bd_conexao.php");
    $sql="UPDATE cliente SET cpf='$cpf', nome='$nome' where id_cliente='$id_cliente';
    UPDATE endereco SET num='$num', cidade='$cidade', rua='$rua', bairro='$bairro';";
    $con->query($sql);
    fecharConexao($con);
}


//Função para exclusão de telefone.
function exclui_telefone($id_cliente, $telefone){
    require_once("../00 - BD/bd_conexao.php");
    $sql="DELETE FROM telefone WHERE id_cliente='$id_cliente' AND telefone='$telefone';";
    $con->query($sql);
    fecharConexao($con);
}

//Função para exclusão de cliente.
function exclui_cliente($id_cliente){
    require_once("../00 - BD/bd_conexao.php");
    $sql="DELETE FROM cliente WHERE id_cliente='$id_cliente';";
    $con->query($sql);
    $sql="DELETE FROM endereco WHERE id_cliente='$id_cliente';";
    $con->query($sql);
    $sql="DELETE FROM telefone WHERE id_cliente='$id_cliente'";
    $con->query($sql);
    fecharConexao($con);
    }

//Função para recuperação de todos os clientes
function exibe_clientes_all(){
    require_once("../00 - BD/bd_conexao.php");
    $sql="SELECT cli.id_cliente, cli.nome as nome_cliente, cad.id_caderneta, cad.data_abertura, cad.status_caderneta, FROM cliente as cli, caderneta as cad WHERE cli.id_cliente=cad.id_cliente order by cli.nome ASC;";
    $con->query($sql);
    fecharConexao($con);
}

//Função para recuperar clientes com atraso
function exibe_clientes_atrasos(){
    require_once("../00 - BD/bd_conexao.php");
    $sql="SELECT id_cliente FROM caderneta WHERE status_caderneta='aberta' AND data_caderneta+30 days <= date(CURRENT_TIMESTAMP)';";
    $con->query($sql);
    fecharConexao($con);
}

//Função para recuperar clientes compatíveis com o nome pesquisado
function exibe_clinetes_src($id_cliente){
    require_once("../00 - BD/bd_conexao.php");
    $sql="SELECT cli.id_cliente, cli.nome as nome_cliente, cad.id_caderneta, cad.data_abertura, cad.status_caderneta, FROM cliente as cli, caderneta as cad WHERE cli.id_cliente=cad.id_cliente AND cli.id_cliente='$id_cliente' order by cli.nome ASC;";
    $con->query($sql);
    fecharConexao($con);
}

//Função para exibir nome dos Clientes na pesquisa
function exibe_nome_cliente(){
    require_once("../00 - BD/bd_conexao.php");
    $sql="SELECT nome, id_cliente FROM cliente ORDER BY nome ASC";
    $con->query($sql);
    fecharConexao($con);
}

//Função para exibir informações do cliente
function exibe_info_cliente($id_cliente){
    require_once("../00 - BD/bd_conexao.php");
    $sql="SELECT cli.nome as nome_cliente, cli.cpf, e.rua, e.num, e.bairro, e.cidade, t.telefone, cad.status_caderneta, cad.data_abertura  FROM cliente as cli, endereco as e, telefone as t, caderneta as cad WHERE cli.id_cliente = e.id_cliente AND cli.id_cliente=t.id_cliente AND cli.id_cliente=cad.id_cliente AND cad.id_caderneta=(SELECT max(id_caderneta) FROM caderneta) AND cli.id_cliente = '$id_cliente';";
    $con->query($sql);
    fecharConexao($con);
}

/* --- FIM DE FUNÇÕES DA TABELA CLIENTE --- */


/* --- INICIO DE FUNÇÕES DA TABELA DESPESA --- */

//Função para lançamento de despesas
function cadastra_despesa($custo_un, $descricao, $nome, $quant){
    require_once("../00 - BD/bd_conexao.php");
    $sql="insert into despesa values(NULL, '$custo_un', '$descricao', '$nome', date(CURRENT_TIMESTAMP),'$quant');";
    $con->query($sql);
    fecharConexao($con);
}

//Função para edição de despesas
function altera_despesa($id_despesa, $custo_un, $descricao, $nome, $quant){
    require_once("../00 - BD/bd_conexao.php");
    $sql="UPDATE despesa SET custo_un='$custo_un', descricao='$descricao', nome='$nome', quant='$quant' WHERE id_despesa='$id_despesa';";
    $con->query($sql);
    fecharConexao($con);
}

//Função para excluir despesas
function exclui_despesa($id_despesa){
    require_once("../00 - BD/bd_conexao.php");
    $sql="DELETE FROM despesa WHERE id_despesa='$id_despesa';";
    $con->query($sql);
    fecharConexao($con);
}

//Função para exibir todos os lançamentos de estoque
function exibe_despesas_all(){
    require_once("../00 - BD/bd_conexao.php");
    $sql = "SELECT p.nome as l.nome_produto, l.quant_recebida, l.preco_custo_un, l.data_lancamento FROM lancamento_estoque as l, produto as p WHERE l.id_produto=p.id_produto ORDER BY l.id_lancamento DESC";
    $con->query($sql);
    fecharConexao($con);
}

//Função para exibir despesa por dia específico
function exibe_despesa_data($data){
    require_once("../00 - BD/bd_conexao.php");
    $sql = "SELECT nome as nome_despesa, descricao, quant, custo_un FROM despesa WHERE data_despesa='$data' ORDER BY id_despesa DESC";
    $con->query($sql);
    fecharConexao($con);
}

//Função para exibir despesas a partir de um período
function exibe_despesa_periodo($inicio, $fim){
    require_once("../00 - BD/bd_conexao.php");
    $sql = "SELECT nome as nome_despesa, descricao, quant, custo_un FROM despesa WHERE data_despesa BETWEEN '$inicio' AND '$fim' ORDER BY id_despesa DESC";
    $con->query($sql);
    fecharConexao($con);
}

/* --- FIM DE FUNÇÕES DA TABELA DESPESA --- */


/* --- INICIO DE FUNÇÕES DA TABELA FECHAMENTO_CAIXA --- */

//Função para lançamento de fechamentos de caixa
function cadastra_caixa($valor){
    require_once("../00 - BD/bd_conexao.php");
    $sql="INSERT INTO fechamento_caixa VALUES(NULL,'$valor', CURRENT_TIMESTAMP)";
    $con->query($sql);
    fecharConexao($con);
} 

//Função para alterar fechamentos de caixa
function altera_caixa($id_fechamento, $valor, $data){
    require_once("../00 - BD/bd_conexao.php");
    $sql="UPDATE fechamento_caixa SET valor='$valor', data='$data' WHERE id_fechamento='$id_fechamento';";
    $con->query($sql);
    fecharConexao($con);
}

//Função para excluir fechamentos de caixa
function exclui_caixa($id_fechamento){
    require_once("../00 - BD/bd_conexao.php");
    $sql="DELETE FROM fechamento_caixa WHERE id_fechamento = '$id_fechamento';";
    $con->query($sql);
    fecharConexao($con);
}

//Função para exibir todos os fechamentos de caixa
function exibe_caixa(){
    require_once("../00 - BD/bd_conexao.php");
    $sql="SELECT valor, data WHERE 0 order by data DESC;";
    $con->query($sql);
    fecharConexao($con);
}

//Função para exibir fechamento de caixa em dia específico
function exibe_caixa_dia($data){
    require_once("../00 - BD/bd_conexao.php");
    $sql="SELECT valor, data WHERE data='$data';";
    $con->query($sql);
    fecharConexao($con);
}

//Função para exibir fechamento de caixa em período
function exibe_caixa_periodo($inicio, $fim){
    require_once("../00 - BD/bd_conexao.php");
    $sql="SELECT valor, data WHERE data BETWEEN '$inicio' and '$fim' ORDER BY data DESC;";
    $con->query($sql);
    fecharConexao($con);
}

/* --- FIM DE FUNÇÕES DA TABELA FECHAMENTO_CAIXA --- */

/* --- INICIO DE FUNÇÕES DE PESQUISA DE LUCROS --- */

//Função para pesquisar todos os lucros
function exibe_lucros(){
    require_once("../00 - BD/bd_conexao.php");
    $sql="SELECT SUM(p.preco_venda*v.quant)-SUM(l.preco_custo_un*l.quant_recebida) AS lucro_total FROM produto as p, venda_produto as v, lancamento_estoque as l WHERE p.id_produto=v.id_produto AND p.id_produto=l.id_produto";
    $con->query($sql);
    fecharConexao($con);
}

//Função para pesquisar os lucros a partir de uma data
function exibe_lucros_data($data){
    require_once("../00 - BD/bd_conexao.php");
    $sql="SELECT SUM(p.preco_venda*v.quant)-SUM(l.preco_custo_un*l.quant_recebida) AS lucro_total FROM produto as p, venda_produto as v, lancamento_estoque as l, venda as ven  WHERE p.id_produto=v.id_produto AND p.id_produto=l.id_produto AND ven.id_venda=v.id_venda AND date(ven.data)='$data' AND l.data_lancamento='$data';";
    $con->query($sql);
    fecharConexao($con);
}

//Função para pesquisar os lucros a partir de um período
function exibe_lucros_periodo($inicio, $fim){
    require_once("../00 - BD/bd_conexao.php");
    $sql="SELECT SUM(p.preco_venda*v.quant)-SUM(l.preco_custo_un*l.quant_recebida) AS lucro_total FROM produto as p, venda_produto as v, lancamento_estoque as l, venda as ven  WHERE p.id_produto=v.id_produto AND p.id_produto=l.id_produto AND ven.id_venda=v.id_venda AND date(ven.data) BETWEEN '$inicio' AND '$fim' AND l.data_lancamento BETWEEN '$inicio' and '$fim';";
    $con->query($sql);
    fecharConexao($con);
}

/* --- FIM DE FUNÇÕES DE PESQUISA DE LUCROS --- */

/* --- INICIO DE FUNÇÕES DE PESQUISA DE VENDAS --- */

//Função para mostrar vendas não finalizadas

//Função para mostrar todas as vendas
function exibir_vendas_all(){
    require_once("../00 - BD/bd_conexao.php");
    $sql="SELECT p.nome as nome_produto, v.data as data_venda, vp.quant, vp.valor_pago, (SELECT nome FROM cliente WHERE id_cliente = (SELECT id_cliente FROM caderneta WHERE id_caderneta=v.id_caderneta)) as nome_cliente FROM produto as p, cliente as cli, venda_produto as vp, venda as v, caderneta as cad WHERE p.id_produto = vp.id_produto and v.id_venda=vp.id_venda AND p.nome!='Valor Fixo' ORDER BY vp.id_venda_produto DESC;";
    $con->query($sql);
    fecharConexao($con);
}
//Função para mostrar todas as vendas fiado abertas
function exibir_vendas_all_fiado(){
    require_once("../00 - BD/bd_conexao.php");
    $sql="SELECT p.nome as nome_produto, v.data as data_venda, vp.quant, vp.valor_pago, (SELECT nome FROM cliente WHERE id_cliente = (SELECT id_cliente FROM caderneta WHERE id_caderneta=v.id_caderneta)) as nome_cliente FROM produto as p, cliente as cli, venda_produto as vp, venda as v, caderneta as cad WHERE p.id_produto = vp.id_produto and v.id_venda=vp.id_venda AND vp.pago=0 AND p.nome!='Valor Fixo' ORDER BY vp.id_venda_produto DESC;";
    $con->query($sql);
    fecharConexao($con);
}

//Função para pesquisa por nome do produto
function exibir_vendas_produto($id_produto){
    require_once("../00 - BD/bd_conexao.php");
    $sql="SELECT p.nome as nome_produto, v.data as data_venda, vp.quant, vp.valor_pago, (SELECT nome FROM cliente WHERE id_cliente = (SELECT id_cliente FROM caderneta WHERE id_caderneta=v.id_caderneta)) as nome_cliente FROM produto as p, cliente as cli, venda_produto as vp, venda as v, caderneta as cad WHERE p.id_produto = vp.id_produto and v.id_venda=vp.id_venda AND p.nome!='Valor Fixo' AND p.id_produto='$id_produto' ORDER BY vp.id_venda_produto DESC;";
    $con->query($sql);
    fecharConexao($con);
}

//Função para pesquisa por nome do produto para fiado abertas
function exibir_vendas_produto_fiado($id_produto){
    require_once("../00 - BD/bd_conexao.php");
    $sql="SELECT p.nome as nome_produto, v.data as data_venda, vp.quant, vp.valor_pago, (SELECT nome FROM cliente WHERE id_cliente = (SELECT id_cliente FROM caderneta WHERE id_caderneta=v.id_caderneta)) as nome_cliente FROM produto as p, cliente as cli, venda_produto as vp, venda as v, caderneta as cad WHERE p.id_produto = vp.id_produto and v.id_venda=vp.id_venda AND p.nome!='Valor Fixo' AND p.id_produto='$id_produto' AND vp.pago=0 ORDER BY vp.id_venda_produto DESC;";
    $con->query($sql);
    fecharConexao($con);
}

//Função para pesquisa por cliente
function exibir_vendas_cliente($id_cliente){
    require_once("../00 - BD/bd_conexao.php");
    $sql="SELECT p.nome as nome_produto, v.data as data_venda, vp.quant, vp.valor_pago, (SELECT nome FROM cliente WHERE id_cliente = (SELECT id_cliente FROM caderneta WHERE id_caderneta=v.id_caderneta)) as nome_cliente FROM produto as p, cliente as cli, venda_produto as vp, venda as v, caderneta as cad WHERE p.id_produto = vp.id_produto and v.id_venda=vp.id_venda AND p.nome!='Valor Fixo' AND (SELECT id_cliente FROM caderneta WHERE id_caderneta=v.id_caderneta)='$id_cliente' ORDER BY vp.id_venda_produto DESC;";
    $con->query($sql);
    fecharConexao($con);
}

//Função para pesquisa por cliente para vendas fiado abertas
function exibir_vendas_cliente_fiado(){
    require_once("../00 - BD/bd_conexao.php");
    $sql="SELECT p.nome as nome_produto, v.data as data_venda, vp.quant, vp.valor_pago, (SELECT nome FROM cliente WHERE id_cliente = (SELECT id_cliente FROM caderneta WHERE id_caderneta=v.id_caderneta)) as nome_cliente FROM produto as p, cliente as cli, venda_produto as vp, venda as v, caderneta as cad WHERE p.id_produto = vp.id_produto and v.id_venda=vp.id_venda AND p.nome!='Valor Fixo' AND (SELECT id_cliente FROM caderneta WHERE id_caderneta=v.id_caderneta)='$id_cliente' AND vp.pago=0 ORDER BY vp.id_venda_produto DESC;";
    $con->query($sql);
    fecharConexao($con);
}

//Função para pesquisa por data
function exibir_vendas_data($data){
    require_once("../00 - BD/bd_conexao.php");
    $sql="SELECT p.nome as nome_produto, v.data as data_venda, vp.quant, vp.valor_pago, (SELECT nome FROM cliente WHERE id_cliente = (SELECT id_cliente FROM caderneta WHERE id_caderneta=v.id_caderneta)) as nome_cliente FROM produto as p, cliente as cli, venda_produto as vp, venda as v, caderneta as cad WHERE p.id_produto = vp.id_produto and v.id_venda=vp.id_venda AND p.nome!='Valor Fixo' AND v.data='$data' ORDER BY vp.id_venda_produto DESC;";
    $con->query($sql);
    fecharConexao($con);
}

//Função para pesquisa por data para vendas fiado abertas
function exibir_vendas_data_fiado(){
    require_once("../00 - BD/bd_conexao.php");
    $sql="SELECT p.nome as nome_produto, v.data as data_venda, vp.quant, vp.valor_pago, (SELECT nome FROM cliente WHERE id_cliente = (SELECT id_cliente FROM caderneta WHERE id_caderneta=v.id_caderneta)) as nome_cliente FROM produto as p, cliente as cli, venda_produto as vp, venda as v, caderneta as cad WHERE p.id_produto = vp.id_produto and v.id_venda=vp.id_venda AND p.nome!='Valor Fixo' AND v.data='$data' AND vp.pago=0 ORDER BY vp.id_venda_produto DESC;";
    $con->query($sql);
    fecharConexao($con);
}

//Função para pesquisa por período
function exibir_vendas_periodo($inicio, $fim){
    require_once("../00 - BD/bd_conexao.php");
    $sql="SELECT p.nome as nome_produto, v.data as data_venda, vp.quant, vp.valor_pago, (SELECT nome FROM cliente WHERE id_cliente = (SELECT id_cliente FROM caderneta WHERE id_caderneta=v.id_caderneta)) as nome_cliente FROM produto as p, cliente as cli, venda_produto as vp, venda as v, caderneta as cad WHERE p.id_produto = vp.id_produto and v.id_venda=vp.id_venda AND p.nome!='Valor Fixo' AND v.data BETWEEN '$inicio' AND '$fim' ORDER BY vp.id_venda_produto DESC;";
    $con->query($sql);
    fecharConexao($con);
}

//Função para pesquisa por período para vendas fiado abertas
function exibir_vendas_periodo_fiado($inicio, $fim){
    require_once("../00 - BD/bd_conexao.php");
    $sql="SELECT p.nome as nome_produto, v.data as data_venda, vp.quant, vp.valor_pago, (SELECT nome FROM cliente WHERE id_cliente = (SELECT id_cliente FROM caderneta WHERE id_caderneta=v.id_caderneta)) as nome_cliente FROM produto as p, cliente as cli, venda_produto as vp, venda as v, caderneta as cad WHERE p.id_produto = vp.id_produto and v.id_venda=vp.id_venda AND p.nome!='Valor Fixo' AND v.data BETWEEN '$inicio' AND '$fim' AND vp.pago=0 ORDER BY vp.id_venda_produto DESC;";
    $con->query($sql);
    fecharConexao($con);
}

?>