<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class AlterTableEmpresaBoletosJuros extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('empresa');

		$codigo_juros = $table->hasColumn('codigo_juros');
		$dias_juros = $table->hasColumn('dias_juros');
		$valor_juros = $table->hasColumn('valor_juros');
		$codigo_multa = $table->hasColumn('codigo_multa');
		$dias_multa = $table->hasColumn('dias_multa');
		$valor_multa = $table->hasColumn('valor_multa');
		$codigo_protesto = $table->hasColumn('codigo_protesto');
		$dias_protesto = $table->hasColumn('dias_protesto');
		$usuario_edicao_boleto = $table->hasColumn('usuario_edicao_boleto');
		$data_edicao_boleto = $table->hasColumn('data_edicao_boleto');
		
		if (!$codigo_juros) $table->addColumn('codigo_juros', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'after' => 'boleto_instrucoes4']);
        if (!$dias_juros) $table->addColumn('dias_juros', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'after' => 'codigo_juros']);
        if (!$valor_juros) $table->addColumn('valor_juros', 'decimal', ['precision' => 11, 'scale' => 3, 'after' => 'dias_juros']);
        if (!$codigo_multa) $table->addColumn('codigo_multa', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'after' => 'valor_juros']);
        if (!$dias_multa) $table->addColumn('dias_multa', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'after' => 'codigo_multa']);
        if (!$valor_multa) $table->addColumn('valor_multa', 'decimal', ['precision' => 11, 'scale' => 3, 'after' => 'dias_multa']);
        if (!$codigo_protesto) $table->addColumn('codigo_protesto', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'after' => 'valor_multa']);
        if (!$dias_protesto) $table->addColumn('dias_protesto', 'integer', ['limit' => MysqlAdapter::INT_TINY, 'after' => 'codigo_protesto']);
        if (!$usuario_edicao_boleto) $table->addColumn('usuario_edicao_boleto', 'string', ['limit'=> 20, 'after' => 'dias_protesto']);
        if (!$data_edicao_boleto) $table->addColumn('data_edicao_boleto', 'datetime', ['after' => 'usuario_edicao_boleto', 'null' => true]);
		
        $table->save();
    }

    public function down(): void
    {
        $table = $this->table('empresa');
        $table->removeColumn('codigo_juros');
        $table->removeColumn('dias_juros');
        $table->removeColumn('valor_juros');
        $table->removeColumn('codigo_multa');
        $table->removeColumn('dias_multa');
        $table->removeColumn('valor_multa');
        $table->removeColumn('codigo_protesto');
        $table->removeColumn('dias_protesto');
        $table->removeColumn('usuario_edicao_boleto');
        $table->removeColumn('data_edicao_boleto');
        $table->save();
    }
}
