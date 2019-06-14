<div class="content-header">
    <div class="row">
        <div class="col-sm-3">
            <div class="header-section text-center">
                <h1>Reservas</h1>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="header-section text-center">
                <button id="delete-btn" class="btn btn-danger pull-right"style="margin: 2px;">
                    <span class="fa fa-times"></span> <span class="hidden-xs">Excluir</span>
                </button>
                <button id="limpar-btn" class="btn btn-warning pull-right"style="margin: 2px;">
                    <span class="fa fa-arrow-up"></span> <span class="hidden-xs">Limpar</span>
                </button>
                <button id="add-btn" class="btn btn-info pull-right"style="margin: 2px;">
                    <span class="fa fa-plus"></span> <span class="hidden-xs">Incluir / Alterar</span>
                </button>
                <button id="print-btn" class="btn btn-success pull-right" style="margin: 2px;">
                    <span class="fa fa-print"></span> <span class="hidden-xs">Relatório</span>
                </button>
                <button id="consumo-btn" class="btn btn-warning pull-right" style="margin: 2px;">
                    <span class="fa fa-pencil"></span> <span class="hidden-xs">Consumo</span>
                </button>
                <button id="fechar-btn" class="btn btn-info pull-right" style="margin: 2px;">
                    <span class="fa fa-money"></span> <span class="hidden-xs">Fechar Conta</span>
                </button>
            </div>
        </div>
    </div>
</div>
<div class="block">
    <div class="block-title">
        <h2>Entrada de Dados</h2>
    </div>
    <div class="block-section">
        <form id='cadastro-form' class="form-horizontal" onsubmit="return false;">
            <input type="hidden" name="rsv_id" id="rsv_id" value=0>
            <div class="block">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="rsv_data_entrada">Data de Entrada</label>
                    <div class="col-md-3">
                        <input type="text" name="rsv_data_entrada" id="rsv_data_entrada" class="form-control" required autocomplete="nope">
                    </div>
                    <label class="col-md-2 control-label" for="rsv_data_saida">Data de Saída</label>
                    <div class="col-md-3">
                        <input type="email" name="rsv_data_saida" id="rsv_data_saida" class="form-control" required autocomplete="nope">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="rsv_status">Estado</label>
                    <div class="col-md-3">
                        <input type="text" name="rsv_status" id="rsv_status" class="form-control" required autocomplete="nope">
                    </div>
                    <label class="col-md-2 control-label" for="rsv_cliente">Cliente</label>
                    <div class="col-md-3">
                        <input type="text" name="rsv_cliente" id="rsv_cliente" class="form-control" required autocomplete="nope">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="rsv_suite">Suite</label>
                    <div class="col-md-3">
                        <input type="text" name="rsv_suite" id="rsv_suite" class="form-control" required autocomplete="nope">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="block">
    <div class="block-section">
        <div class="table-responsive">
            <table id="cliente-datatable" class="table table-striped table-bordered table-vcenter" style="width: 100%;">
                <thead>
                    <tr>
                        <th class="text-center">Identificador</th>
                        <th class="text-center">Data de Entrada</th>
                        <th class="text-center">Data de Saída</th>
                        <th class="text-center">Suíte</th>
                        <th class="text-center">Estado</th>
                        <th class="text-center">Cliente</th>
                        <th class="text-center">Funcionário</th>
                        <th class="text-center">Valor Total</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- obligatory scripts to load -->
<?php include BASE_PATH . 'assets/inc/page_footer.php'; ?>
<?php include BASE_PATH . 'assets/inc/template_scripts.php'; ?>
<script type="text/javascript"> var BASE_URL = '<?php echo BASE_URL; ?>';</script>
<!-- on demand scripts to load -->
<script src="<?php echo BASE_URL?>assets/js/modulos/gral/checkSession.js"></script>
<script src="<?php echo BASE_URL?>assets/js/pages/sweetalert.min.js"></script>
<script src="<?php echo BASE_URL?>assets/js/pages/jquery.inputmask.bundle.min.js"></script>
<script src="<?php echo BASE_URL?>assets/js/pages/jquery.number.min.js"></script>
<script src="<?php echo BASE_URL?>assets/js/lang/pt/message.js"></script>
<script src="<?php echo BASE_URL?>assets/js/modulos/gral/Datatable.js"></script>
