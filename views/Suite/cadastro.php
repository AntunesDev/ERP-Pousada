<div class="content-header">
    <div class="row">
        <div class="col-sm-3">
            <div class="header-section text-center">
                <h1>Suites</h1>
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
                <button id="print-btn" class="display-none btn btn-success pull-right" style="margin: 2px;">
                    <span class="fa fa-print"></span> <span class="hidden-xs">Relatório</span>
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
            <input type="hidden" name="ste_id" id="ste_id" value=0>
            <div class="block">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="ste_tipo">Descrição</label>
                    <div class="col-md-3">
                        <input type="text" name="ste_tipo" id="ste_tipo" class="form-control" required autocomplete="nope">
                    </div>
                    <label class="col-md-2 control-label" for="ste_valor">Valor</label>
                    <div class="col-md-3">
                        <input type="text" name="ste_valor" id="ste_valor" class="form-control" required autocomplete="nope">
                        <span class="help-block">Apenas números e pontos/vírgulas</span>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="block">
    <div class="block-section">
        <div class="table-responsive">
            <table id="suite-datatable" class="table table-striped table-bordered table-vcenter" style="width: 100%;">
                <thead>
                    <tr>
                        <th class="text-center">Identificador</th>
                        <th class="text-center">Tipo</th>
                        <th class="text-center">Valor</th>
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
<!-- module related script to load -->
<script src="<?php echo BASE_URL?>assets/js/modulos/suites/cadastro.js"></script>
