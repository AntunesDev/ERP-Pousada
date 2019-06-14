<div class="content-header">
    <div class="row">
        <div class="col-sm-3">
            <div class="header-section text-center">
                <h1>Funcionários</h1>
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
            <input type="hidden" name="fnc_id" id="fnc_id" value=0>
            <div class="block">
                <div class="form-group">
                    <label class="col-md-2 control-label" for="fnc_nome">Nome</label>
                    <div class="col-md-3">
                        <input type="text" name="fnc_nome" id="fnc_nome" class="form-control" required autocomplete="nope">
                    </div>
                    <label class="col-md-2 control-label" for="fnc_email">Email</label>
                    <div class="col-md-5">
                        <input type="email" name="fnc_email" id="fnc_email" class="form-control" required autocomplete="nope">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="fnc_rg">RG</label>
                    <div class="col-md-3">
                        <input type="text" name="fnc_rg" id="fnc_rg" class="form-control" required autocomplete="nope">
                    </div>
                    <label class="col-md-2 control-label" for="fnc_cpf">CPF</label>
                    <div class="col-md-3">
                        <input type="text" name="fnc_cpf" id="fnc_cpf" class="form-control" required autocomplete="nope">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="fnc_telefone">Telefone</label>
                    <div class="col-md-3">
                        <input type="tel" name="fnc_telefone" id="fnc_telefone" class="form-control" required autocomplete="nope">
                    </div>
                    <label class="col-md-2 control-label" for="fnc_cep">CEP</label>
                    <div class="col-md-3">
                        <input type="tel" name="fnc_cep" id="fnc_cep" class="form-control" required autocomplete="nope">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="fnc_endereco">Endereço</label>
                    <div class="col-md-3">
                        <input type="tel" name="fnc_endereco" id="fnc_endereco" class="form-control" required autocomplete="nope">
                    </div>
                    <label class="col-md-2 control-label" for="fnc_cidade">Cidade</label>
                    <div class="col-md-3">
                        <input type="tel" name="fnc_cidade" id="fnc_cidade" class="form-control" required autocomplete="nope">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-2 control-label" for="fnc_funcao">Função</label>
                    <div class="col-md-3">
                        <input type="tel" name="fnc_funcao" id="fnc_funcao" class="form-control" required autocomplete="nope">
                    </div>
                    <label class="col-md-2 control-label" for="fnc_salario">Salário</label>
                    <div class="col-md-3">
                        <input type="tel" name="fnc_salario" id="fnc_salario" class="form-control" required autocomplete="nope">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-3 control-label" for="fnc_usario">Usuário</label>
                    <div class="col-md-4">
                        <select type="text" id="fnc_usario" name="fnc_usario" class="form-control">
                            <option value="">Selecionar</option>
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
            <table id="funcionario-datatable" class="table table-striped table-bordered table-vcenter" style="width: 100%;">
                <thead>
                    <tr>
                        <th class="text-center">Identificador</th>
                        <th class="text-center">Nome</th>
                        <th class="text-center">RG</th>
                        <th class="text-center">CPF</th>
                        <th class="text-center">Telefone</th>
                        <th class="text-center">E-mail</th>
                        <th class="text-center">CEP</th>
                        <th class="text-center">Endereço</th>
                        <th class="text-center">Cidade</th>
                        <th class="text-center">Função</th>
                        <th class="text-center">Salário</th>
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
<script src="<?php echo BASE_URL?>assets/js/modulos/funcionarios/cadastro.js"></script>