<div class="content-header">
    <div class="row">
        <div class="col-sm-3">
            <div class="header-section text-center">
                <h1>Clientes</h1>
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
            <input type="hidden" name="cli_id" id="cli_id" value=0>
            <div class="block">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="cli_nome">Nome</label>
                    <div class="col-md-3">
                        <input type="text" name="cli_nome" id="cli_nome" class="form-control" required autocomplete="nope">
                    </div>
                    <label class="col-md-2 control-label" for="cli_email">Email</label>
                    <div class="col-md-5">
                        <input type="email" name="cli_email" id="cli_email" class="form-control" required autocomplete="nope">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="cli_rg">RG</label>
                    <div class="col-md-3">
                        <input type="text" name="cli_rg" id="cli_rg" class="form-control" required autocomplete="nope">
                        <span class="help-block">Apenas números</span>
                    </div>
                    <label class="col-md-2 control-label" for="cli_cpf">CPF</label>
                    <div class="col-md-3">
                        <input type="text" name="cli_cpf" id="cli_cpf" class="form-control" required autocomplete="nope">
                        <span class="help-block">Apenas números</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="cli_telefone">Telefone</label>
                    <div class="col-md-3">
                        <input type="tel" name="cli_telefone" id="cli_telefone" class="form-control" required autocomplete="nope">
                        <span class="help-block">Apenas números</span>
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
                        <th class="text-center">Nome</th>
                        <th class="text-center">RG</th>
                        <th class="text-center">CPF</th>
                        <th class="text-center">Telefone</th>
                        <th class="text-center">E-mail</th>
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
<script src="<?php echo BASE_URL?>assets/js/modulos/clientes/cadastro.js"></script>