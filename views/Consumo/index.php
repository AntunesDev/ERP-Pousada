<div class="content-header">
    <div class="row">
        <div class="col-sm-3">
            <div class="header-section text-center">
                <h1>Consumo</h1>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="header-section text-center">
                <button id="delete-btn" class="btn btn-danger pull-right"style="margin: 2px;">
                    <span class="fa fa-times"></span> <span class="hidden-xs">Excluir</span>
                </button>
                <button id="add-btn" class="btn btn-info pull-right"style="margin: 2px;">
                    <span class="fa fa-plus"></span> <span class="hidden-xs">Incluir / Alterar</span>
                </button>
                <button id="print-btn" class="display-none btn btn-success pull-right" style="margin: 2px;">
                    <span class="fa fa-print"></span> <span class="hidden-xs">Relatório</span>
                </button>
                <button id="voltar-btn" class="btn btn-warning pull-right"style="margin: 2px;">
                    <span class="fa fa-arrow-left"></span> <span class="hidden-xs">Voltar</span>
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
            <input type="hidden" name="cns_reserva" id="cns_reserva" value=0>
            <div class="block">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="cns_produto">Produto</label>
                    <div class="col-md-3">
                        <select name="cns_produto" id="cns_produto" class="form-control" required autocomplete="nope">
                        </select>
                    </div>
                    <label class="col-md-2 control-label" for="cns_valor">Valor</label>
                    <div class="col-md-3">
                        <input type="text" name="cns_valor" id="cns_valor" class="form-control" readonly required autocomplete="nope" value=0>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="cns_qtde">Qtde</label>
                    <div class="col-md-3">
                        <input type="number" name="cns_qtde" id="cns_qtde" class="form-control" required autocomplete="nope" value=0>
                    </div>
                    <label class="col-md-2 control-label" for="cns_valor_total">Valor Total</label>
                    <div class="col-md-3">
                        <input type="text" name="cns_valor_total" id="cns_valor_total" class="form-control" readonly required autocomplete="nope" value=0>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="block">
    <div class="block-section">
        <div class="table-responsive">
            <table id="consumo-datatable" class="table table-striped table-bordered table-vcenter" style="width: 100%;">
                <thead>
                    <tr>
                        <th class="text-center">Produto</th>
                        <th class="text-center">Descrição</th>
                        <th class="text-center">Valor</th>
                        <th class="text-center">Qtde</th>
                        <th class="text-center">Valor Total</th>
                        <th class="text-center">Momento</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<!-- obligatory scripts to load -->
<?php include BASE_PATH . 'assets/inc/page_footer.php'; ?>
<?php include BASE_PATH . 'assets/inc/template_scripts.php'; ?>
<script type="text/javascript">
    var BASE_URL = '<?php echo BASE_URL; ?>';
    var rsv_id = '<?php echo $rsv_id ?? 'null';?>'
</script>
<!-- on demand scripts to load -->
<script src="<?php echo BASE_URL?>assets/js/modulos/gral/checkSession.js"></script>
<script src="<?php echo BASE_URL?>assets/js/pages/sweetalert.min.js"></script>
<script src="<?php echo BASE_URL?>assets/js/pages/jquery.inputmask.bundle.min.js"></script>
<script src="<?php echo BASE_URL?>assets/js/pages/jquery.number.min.js"></script>
<script src="<?php echo BASE_URL?>assets/js/lang/pt/message.js"></script>
<script src="<?php echo BASE_URL?>assets/js/modulos/gral/Datatable.js"></script>
<script src="<?php echo BASE_URL?>assets/js/modulos/consumo/index.js"></script>