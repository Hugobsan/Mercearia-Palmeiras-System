
insert into venda values (null, null, CURRENT_TIMESTAMP, '0');
SET @id_venda = (select max(id_venda) from venda);
SET @id_produto = 1;
insert into venda_produto values(@id_venda,@id_produto,'1','1');
update venda set finalizada=1 where finalizada=0;
update produto set quant_estoque=quant_estoque-(select quant from venda_produto where id_venda=@id_venda and id_produto=@id_produto);