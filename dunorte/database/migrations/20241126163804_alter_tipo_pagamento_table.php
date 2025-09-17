<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

final class AlterTipoPagamentoTable extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('tipo_pagamento');
        $primeiroVencimentoCheck = $table->hasColumn('primeiro_vencimento');
        if (!$primeiroVencimentoCheck) {
            $table->addColumn('primeiro_vencimento', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'after' => 'avista']);
        }
        if (!$primeiroVencimentoCheck) {
            $table->save();
        }
    }
    public function down(): void
    {
        $table = $this->table('tipo_pagamento');
        $table->removeColumn('primeiro_vencimento');
        $table->save();
    }
}
