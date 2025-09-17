<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateConfiguracaoVendaLoteTable extends AbstractMigration
{
    public function up(): void
    {
        $this->execute("ALTER TABLE vendas ADD COLUMN venda_agrupada INT(11) NOT NULL AFTER pago");
        $this->execute("ALTER TABLE vendas ADD COLUMN venda_agrupamento TINYINT(4) NOT NULL AFTER venda_agrupada");
    }

    public function down(): void
    {
    }
}
