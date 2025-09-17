<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

final class CreateConfiguracaoPagamentoTable extends AbstractMigration
{
    public function up(): void
    {
        if (!$this->hasTable('configuracao_pagamento')) {
            $table = $this->table('configuracao_pagamento');
            $table->addColumn('client_id', 'string', ['limit' => 100, 'null' => true])
                ->addColumn('chave_pix', 'string', ['limit' => 100, 'null' => true])
                ->addColumn('permite_alterar_valor', 'integer', ['default' => 3600])
                ->addColumn('expiracao', 'integer', ['limit' => MysqlAdapter::INT_TINY])
                ->create();
        }
    }

    public function down(): void
    {
        if ($this->hasTable('configuracao_pagamento')) {
            $this->table('configuracao_pagamento')->drop()->save();
        }
    }
}
