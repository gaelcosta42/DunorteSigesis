<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="module" src="./modulos/ecomd/js/ecomd.js"></script>

<div class="page-content">
    <div class="container">
        <!-- INICIO DO ROW TABELA -->
        <div class="row aba" id="div-produtos">
            <div class="col-md-12">
                <!-- INICIO TABELA -->
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-tags font-sigesis-cor-1"></i>
                            <span class="font-sigesis-cor-1">Painel de Controle E-Commerce</span>
                        </div>
                        <div class="actions btn-set"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 mr-2">
                            <button class="btn sigesis-cor-1 active">Produtos</button>
                        </div>
                        <div class="col-md-2">
                            <button class="btn" id="div-pedidos-btn">Pedidos</button>
                        </div>
                    </div>

                    <div class="portlet-body">
                        <div class="row">
                            <div class="note note-warning">
                                <h4 class="block">ATENÇÃO</h4>
                                <p>O gerenciamento dos produtos que e sua configuração no e-commerce acontecerão através dessa opção.</p>
                            </div>
                        </div>
                    </div>

                    <div class="portlet-body">

                        <div class="tabela tabela-produto">

                            <div class="row mb-3" style="display: flex;justify-content: space-around;margin-right: 1.5em;margin-bottom: 1em;">
                                <div class="col-md-10">
                                    <button id="adicionar-todos" style="margin-right: 15px;" class="btn">Adicionar todos</button>
                                    <button id="atualizar-todos" class="btn">Atualizar todos</button>
                                </div>
                                <div class="col">
                                    <input type="text" class="searchbar" id="pesquisa-dinamica-call" placeholder="Pesquise...">
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table id="dynamic-table-produto">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nome</th>
                                            <th width="60px;">Medida</th>
                                            <th>Valida Estoque</th>
                                            <th>Estoque</th>
                                            <th width="70px">Valor</th>
                                            <th>Opções</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>
                <!-- FINAL TABELA -->
            </div>
        </div>
        <!-- FINAL DO ROW TABELA -->

        <div class="row aba" id="div-pedidos" style="display: none;">
            <div class="col-md-12">
                <!-- INICIO TABELA -->
                <div class="portlet light">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-file-text-o font-sigesis-cor-1"></i>
                            <span class="font-sigesis-cor-1">Pedidos E-Commerce</span>
                        </div>
                        <div class="actions btn-set"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-2 mr-2">
                            <button class="btn" id="div-produtos-btn">Produtos</button>
                        </div>
                        <div class="col-md-2">
                            <button class="btn sigesis-cor-1 active">Pedidos</button>
                        </div>
                    </div>

                    <div class="portlet-body">
                        <div class="row">
                            <div class="note note-warning">
                                <h4 class="block">ATENÇÃO</h4>
                                <p>Até o dado momento essa opção é somente um exemplo.</p>
                            </div>
                        </div>
                    </div>

                    <div class="portlet-body">
                        <div class="table-responsive" style="display: none;">
                            <table id="dynamic-table-vend">
                                <thead>
                                    <tr>
                                        <th>Vendedor</th>
                                        <th>Cliente</th>
                                        <th width="60px;">Venda</th>
                                        <th>Pagamento</th>
                                        <th width="70px">Valor</th>
                                        <th>Parcela paga</th>
                                        <!-- <th width="60px">Ajuda de custo</th> -->
                                        <th>Comissão</th>
                                        <th>Vencimento</th>
                                        <th>Vencimento comissão</th>
                                        <th>Opções</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
                <!-- FINAL TABELA -->
            </div>
        </div>

        <div class="alerta" id="modulo_indisponivel" style="display: none;">

            <div class="col-md-12">
                <div class="portlet light">
                    <div class="portlet-body">
                        <div class="row">
                            <div class="note note-warning">
                                <h4 class="block">ATENÇÃO</h4>
                                <p>Atenção, o módulo não está habilitado para seu acesso.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>