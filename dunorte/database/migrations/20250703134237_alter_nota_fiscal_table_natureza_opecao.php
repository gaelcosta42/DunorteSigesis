<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AlterNotaFiscalTableNaturezaOpecao extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('nota_fiscal');
        $check_natureza_operacao = $table->hasColumn('natureza_operacao');

        if (!$check_natureza_operacao) {
            $table->addColumn('natureza_operacao', 'string', ['limit' => 500, 'null' => true, 'after' => 'cfop']);
            $table->save();
        }
    }

    public function down(): void
    {
        $table = $this->table('nota_fiscal');
        $table->removeColumn('natureza_operacao');
        $table->save();
    }
}