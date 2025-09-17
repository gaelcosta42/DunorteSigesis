<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CalibragemBalanca extends AbstractMigration
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
        $table = $this->table('empresa');
        $calibragem_balanca = $table->hasColumn('calibragem_balanca');

        if (!$calibragem_balanca) {
            $table->addColumn('calibragem_balanca', 'integer', [
                'default' => 1
            ]);
            $table->save();
        }
    }

    public function down(): void
    {
        $table = $this->table('empresa');
        $table->removeColumn('calibragem_balanca');
        $table->save();
    }
}
