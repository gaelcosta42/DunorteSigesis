<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Util\Literal;

class Migrations extends AbstractMigration
{
    
    public function up()
    {
		$this->execute("UPDATE tipo_pagamento_categoria SET categoria='TRANSFERENCIA / PIX' WHERE (id='6')");
	}
}
