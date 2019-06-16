<div class="content-header">
    <div class="row">
        <div class="col-sm-3">
            <div class="header-section text-center">
                <h1>Reservas</h1>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="header-section text-center">
                <button id="cancelar-btn" class="btn btn-danger pull-right"style="margin: 2px;">
                    <span class="fa fa-times"></span> <span class="hidden-xs">Cancelar</span>
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
            <input type="hidden" name="rsv_status" id="rsv_status" value=0>
            <div class="block">
                <div class="form-group">
                    <label class="col-md-2 col-md-offset-2 control-label" for="rsv_datas">Período</label>
                    <div class="col-md-6">
                        <div class="input-group input-daterange" data-date-format="dd/mm/yyyy">
                            <input type="text" id="rsv_data_entrada" name="rsv_data_entrada" class="form-control" placeholder="De">
                            <span class="input-group-addon"><i class="fa fa-chevron-right"></i></span>
                            <input type="text" id="rsv_data_saida" name="rsv_data_saida" class="form-control" placeholder="Até">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="rsv_cliente">Cliente</label>
                    <div class="col-md-3">
                        <select name="rsv_cliente" id="rsv_cliente" class="form-control" required autocomplete="nope">
                            <option value="">Selecione um cliente...</option>
                        </select>
                    </div>
                    <label class="col-md-2 control-label" for="rsv_suite">Suite</label>
                    <div class="col-md-3">
                        <select name="rsv_suite" id="rsv_suite" class="form-control" required readonly autocomplete="nope">
                            <option value=0>Selecione uma suíte...</option>
                        </select>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="block">
    <div class="block-section">
        <div class="table-responsive">
            <table id="reservas-datatable" class="table table-striped table-bordered table-vcenter" style="width: 100%;">
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
<script src="<?php echo BASE_URL?>assets/js/modulos/reservas/index.js"></script>

