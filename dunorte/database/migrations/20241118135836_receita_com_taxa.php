<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class ReceitaComTaxa extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up(): void
    {
        $table = $this->table('receita');
        $check_valorTaxado = $table->hasColumn('valorTaxado');

        if (!$check_valorTaxado) {
            $table->addColumn('valorTaxado', 'decimal', ['precision' => 11, 'scale' => 3]);
            $table->save();
        }
    }

    public function down(): void
    {
        $table = $this->table('receita');
        $table->removeColumn('valorTaxado');
        $table->save();
    }
}
