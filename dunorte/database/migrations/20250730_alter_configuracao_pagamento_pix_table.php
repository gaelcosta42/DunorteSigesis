<?php
declare(strict_types=1);

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

final class AlterConfiguracaoPagamentoPixTable extends AbstractMigration
{
    public function up(): void
    {
        $table = $this->table('configuracao_pagamento');

        $nome_pagamento = $table->hasColumn('nome_pagamento');
        $descricao_pagamento = $table->hasColumn('descricao_pagamento');
        $url_autenticacao = $table->hasColumn('url_autenticacao');
        $url_pix = $table->hasColumn('url_pix');
        $caminho_cert_publico = $table->hasColumn('caminho_cert_publico');
        $caminho_cert_privado = $table->hasColumn('caminho_cert_privado');
        $senha_cert = $table->hasColumn('senha_cert');
        $titular = $table->hasColumn('titular');
        $cid_titular = $table->hasColumn('cid_titular');

        if (!$nome_pagamento) $table->addColumn('nome_pagamento','string', ['limit'=> 100, 'after' => 'id']);
		if (!$descricao_pagamento) $table->addColumn('descricao_pagamento','string', ['limit'=> 100, 'after' => 'nome_pagamento']);		
		if (!$url_autenticacao) $table->addColumn('url_autenticacao','string', ['limit'=> 500, 'after' => 'expiracao']);
        if (!$url_pix) $table->addColumn('url_pix','string', ['limit'=> 500, 'after' => 'url_autenticacao']);
        if (!$caminho_cert_publico) $table->addColumn('caminho_cert_publico','string', ['limit'=> 256, 'after' => 'url_pix']);
        if (!$caminho_cert_privado) $table->addColumn('caminho_cert_privado','string', ['limit'=> 256, 'after' => 'caminho_cert_publico']);
        if (!$senha_cert) $table->addColumn('senha_cert','string', ['limit'=> 256, 'after' => 'caminho_cert_privado']);
        if (!$titular) $table->addColumn('titular','string', ['limit'=> 256, 'after' => 'senha_cert']);
        if (!$cid_titular) $table->addColumn('cid_titular','string', ['limit'=> 256, 'after' => 'titular']);

        $table->save();
    }

    public function down(): void
    {
        $table = $this->table('nome_pagamento');
        $table = $this->table('descricao_pagamento');
        $table = $this->table('configuracao_pagamento');
        $table->removeColumn('url_autenticacao');
        $table->removeColumn('url_pix');
        $table->removeColumn('caminho_cert_publico');
        $table->removeColumn('caminho_cert_privado');
        $table->removeColumn('senha_cert');
        $table->removeColumn('titular');
        $table->removeColumn('cid_titular');       
        $table->save();
    }
}