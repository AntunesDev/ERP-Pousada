<div class="content-header">
    <div class="row">
        <div class="col-sm-3">
            <div class="header-section text-center">
                <h1>Usuários</h1>
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
            <input type="hidden" name="usr_id" id="usr_id" value=0>
            <div class="block">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="usr_name">Login</label>
                    <div class="col-md-3">
                        <input type="text" name="usr_name" id="usr_name" class="form-control" required autocomplete="nope">
                    </div>
                    <label class="col-md-2 col-md-offset-2 control-label" for="usr_senha">Senha</label>
                    <div class="col-md-3">
                        <input type="password" name="usr_senha" id="usr_senha" class="form-control" required autocomplete="nope">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 col-md-offset-6 control-label" for="usr_grupo">Grupo de Acesso</label>
                    <div class="col-md-4">
                        <select id="usr_grupo" name="usr_grupo" class="form-control" required autocomplete="nope"></select>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="block">
    <div class="block-section">
        <div class="table-responsive">
            <table id="usuario-datatable" class="table table-striped table-bordered table-vcenter" style="width: 100%;">
                <thead>
                    <tr>
                        <th class="text-center">Identificador</th>
                        <th class="text-center">Login</th>
                        <th class="text-center">Grupo de Acessos</th>
                        <th class="text-center">Nome</th>
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
<script src="<?php echo BASE_URL?>assets/js/modulos/usuario/cadastro.js"></script>
