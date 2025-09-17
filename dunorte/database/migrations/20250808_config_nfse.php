<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

final class ConfigNfse extends AbstractMigration
{
    
    public function up()
    {
		$this->execute("ALTER TABLE empresa ADD COLUMN codigomunicipal VARCHAR(45) NOT NULL AFTER nfc, ADD COLUMN descricaoservico TEXT NOT NULL AFTER codigomunicipal, ADD COLUMN cnae VARCHAR(10) NOT NULL AFTER descricaoservico");
		$this->execute("ALTER TABLE empresa ADD COLUMN nfse TINYINT(4) NOT NULL AFTER nfc");
		$this->execute("ALTER TABLE nota_fiscal ADD COLUMN valor_csll DECIMAL(11,3) NOT NULL AFTER valor_cofins_st, ADD COLUMN valor_ir DECIMAL(11,3) NOT NULL AFTER valor_csll, ADD COLUMN valor_servico DECIMAL(11,3) NOT NULL AFTER valor_outro");
		$this->execute("ALTER TABLE nota_fiscal ADD COLUMN link_nota_emissor TEXT NOT NULL AFTER link_download_xml");
		$this->execute("ALTER TABLE nota_fiscal ADD COLUMN valor_inss DECIMAL(11,3) NOT NULL AFTER valor_ir");
		
	}
	
}
