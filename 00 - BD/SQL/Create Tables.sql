DROP TABLE IF EXISTS produto;
CREATE TABLE produto(
    id_produto int(10) NOT NULL AUTO_INCREMENT,
    cod_barras varchar(30) NULL UNIQUE,
    nome varchar(80) NOT NULL UNIQUE,
    preco_venda decimal(12,2) NOT NULL DEFAULT 0,
    unidade_medida varchar(2) NOT NULL DEFAULT 'un',
    quant_estoque decimal(12,3) NULL DEFAULT 0,
    
    PRIMARY KEY (id_produto)
);

DROP TABLE IF EXISTS lancamento_estoque;
CREATE TABLE lancamento_estoque(
    id_lancamento int(10) NOT NULL AUTO_INCREMENT,
    id_produto int(10) NOT NULL,
    quant_recebida decimal(12,3) NOT NULL,
    preco_custo_un decimal(12,2) NOT NULL,
    data_lancamento DATE NOT NULL,
    
    PRIMARY KEY (id_lancamento),
    FOREIGN KEY(id_produto) references produto(id_produto)
);

DROP TABLE IF EXISTS cliente;
CREATE TABLE cliente(
    id_cliente int(10) NOT NULL AUTO_INCREMENT,
    cpf varchar(14) NULL,
    nome varchar(80) NOT NULL,

    PRIMARY KEY (id_cliente)
);

DROP TABLE IF EXISTS telefone;
CREATE TABLE telefone(
    id_cliente int(10) NOT NULL,
    telefone varchar(16) NOT NULL,

    PRIMARY KEY (id_cliente,telefone),
    FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente)
);

DROP TABLE IF EXISTS endereco;
CREATE TABLE endereco(
    id_cliente int(10) NOT NULL,
    num int(10) null,
    rua varchar(80) null,
    bairro varchar(80) null,
    cidade varchar(80) null,

    PRIMARY KEY (id_cliente),
    FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente)
);

DROP TABLE IF EXISTS caderneta;
CREATE TABLE caderneta(
    id_caderneta int(10) NOT NULL AUTO_INCREMENT,
    id_cliente int(10) NOT NULL,
    data_abertura DATE NOT NULL,
    status_caderneta varchar(12) NOT NULL DEFAULT 'aberta',

    PRIMARY KEY (id_caderneta),
    FOREIGN KEY (id_cliente) REFERENCES cliente(id_cliente)
);

DROP TABLE IF EXISTS venda;
CREATE TABLE venda(
    id_venda int(10) NOT NULL AUTO_INCREMENT,
    id_caderneta int(10) NULL,
    data DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    finalizada BOOLEAN NOT NULL DEFAULT 0,

    PRIMARY KEY (id_venda),
    FOREIGN KEY (id_caderneta) REFERENCES caderneta(id_caderneta)
);

DROP TABLE IF EXISTS venda_produto;
CREATE TABLE venda_produto(
    id_venda int(10) NOT NULL,
    id_produto int(10) NOT NULL,
    quant decimal(12,3) NOT NULL DEFAULT 0,
    pago BOOLEAN NOT NULL DEFAULT 0, 

    PRIMARY KEY (id_venda, id_produto),
    FOREIGN KEY (id_venda) REFERENCES venda(id_venda),
    FOREIGN KEY (id_produto) REFERENCES produto(id_produto)
);

DROP TABLE IF EXISTS despesa;
CREATE TABLE despesa(
    id_despesa INT(10) NOT NULL AUTO_INCREMENT,
    custo_un decimal(12,2) NOT NULL DEFAULT 0,
    descricao varchar(144) NULL,
    nome varchar(30) NULL,
    quant decimal(12,3) NOT NULL DEFAULT 0,

    PRIMARY KEY (id_despesa)
);

DROP TABLE IF EXISTS fechamento_caixa;
CREATE TABLE fechamento_caixa(
    id_fechamento INT(10) NOT NULL AUTO_INCREMENT,
    valor decimal(12,2) NOT NULL DEFAULT 0,
    data DATE NOT NULL,

    PRIMARY KEY (id_fechamento)
);