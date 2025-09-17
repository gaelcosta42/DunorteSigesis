<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Csosn extends AbstractMigration
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
        if (!$this->hasTable('conversao_csosn')) {
            $table = $this->table('conversao_csosn');
            $table->addColumn('csosn_cst', 'integer')
                ->addColumn('csosn', 'integer')
                ->addColumn('observacao', 'string', ['limit' => 255, 'null' => true])
                ->addColumn('inativo', 'integer', ['default' => 0])
                ->create();
        }
    }

    public function down(): void
    {
        if ($this->hasTable('conversao_csosn')) {
            $this->table('conversao_csosn')->drop()->save();
        }
    }
}
