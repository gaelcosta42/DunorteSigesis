<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

class Migrations extends AbstractMigration
{
    
    public function up()
    {
		$this->execute("CREATE OR REPLACE ALGORITHM = UNDEFINED 
						SQL SECURITY DEFINER VIEW inventario AS
						SELECT p.id AS id, p.nome AS nome, p.ncm AS ncm, i.codigonota AS codigonota, p.unidade AS unidade, p.grade AS grade,
						SUM((CASE WHEN (n.operacao = 1) THEN i.quantidade ELSE (i.quantidade * -(1)) END)) AS quantidade,
						p.valor_custo AS valor_unitario, (p.estoque * p.valor_custo) AS valor_total, n.id_empresa AS id_empresa, n.operacao AS operacao,
						YEAR(n.data_entrada) AS ano
						FROM ((nota_fiscal_itens i LEFT JOIN nota_fiscal n ON ((n.id = i.id_nota))) LEFT JOIN produto p ON ((p.id = i.id_produto)))
						WHERE ((n.modelo = 2) AND (n.inativo = 0) AND (i.inativo = 0))
						GROUP BY CONCAT(p.id, YEAR(n.data_entrada)) 
						UNION 
						SELECT p.id AS id, p.nome AS nome, p.ncm AS ncm, '' AS codigonota, p.unidade AS unidade, p.grade AS grade,
						(SUM(cv.quantidade) * -(1)) AS quantidade, 
						cv.valor AS valor_unitario, cv.valor_total AS valor_total, v.id_empresa AS id_empresa, 2 AS operacao,
						YEAR(v.data_emissao) AS ano
						FROM ((cadastro_vendas cv LEFT JOIN vendas v ON ((v.id = cv.id_venda))) LEFT JOIN produto p ON ((p.id = cv.id_produto)))
						WHERE ((v.fiscal = 1) AND (v.inativo = 0))
						GROUP BY CONCAT(p.id, YEAR(v.data_emissao))");
	}
}
