<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Cfop extends AbstractMigration
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
        if (!$this->hasTable('conversao_cfop')) {
            $table = $this->table('conversao_cfop');
            $table->addColumn('cfop_fornecedor', 'integer')
                ->addColumn('cfop_entrada', 'integer')
                ->addColumn('cfop_saida', 'integer')
                ->addColumn('observacao', 'string', ['limit' => 255, 'null' => true])
                ->addColumn('inativo', 'integer', ['default' => 0])
                ->create();
        }
    }

    public function down(): void
    {
        if ($this->hasTable('conversao_cfop')) {
            $this->table('conversao_cfop')->drop()->save();
        }
    }
}
