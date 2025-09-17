<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class IdNotaCadastroFinanceiro extends AbstractMigration
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
        $table = $this->table('cadastro_financeiro');
        $check_id_nota = $table->hasColumn('id_nota');

        if (!$check_id_nota) {
            $table->addColumn('id_nota', 'integer', [
                'default' => null
            ]);
            $table->save();
        }
    }

    public function down(): void
    {
        $table = $this->table('cadastro_financeiro');
        $table->removeColumn('id_nota');
        $table->save();
    }
}
