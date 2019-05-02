<div class="content-header">
        <div class="row">
            <div class="col-sm-6">
                <div class="header-section">
                    <h1>Dashboard</h1>
                </div>
            </div>
            <div class="col-sm-6 hidden-xs">
                <div class="header-section"></div>
            </div>
        </div>
    </div>
    <div class="block full">
        <div class="block-title">
            <h2>Block here</h2>
        </div>

        <pre style="border: 0; background-color: #CCC;">
          <?php
            print_r($_SESSION["app_erp_pousada"]);
          ?>
        </pre>
        
        <button id="alertaSuccess" type="button" name="button" class="btn btn-success">Boton</button>
        <button id="alertaError" type="button" name="button" class="btn btn-danger">Boton</button>
        <button id="alertaWarning" type="button" name="button" class="btn btn-warning">Boton</button>
        <button id="alertaModal" type="button" name="button" class="btn btn-primary">Boton</button>
        <button id="insert-mvc" type="button" name="button" class="btn btn-primary">Insert Post</button>

    </div>

    <div id="Modal" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Confirmação</h4>
      </div>
      <div class="modal-body">
        <p><h3>Orçamento gerado com Sucesso!<h3></p>
        <p>
        	<h4>
            	<strong>Vendedor:</strong>&nbsp; <span id="cVendedor"></span> &nbsp;&nbsp;
                <strong>Nota:</strong>&nbsp; <span id="cNota"></span> &nbsp;&nbsp;
                <strong>Orçamento:</strong>&nbsp; <span id="cOrcamento"></span>
            </h4>
        </p>
        <p><h4>Orçamento enviado para a impressora!<h4></p>
      </div>
      <!--<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>-->
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

    <!-- obligatory scripts to load -->
    <?php include BASE_PATH . 'assets/inc/page_footer.php'; ?>
    <?php include BASE_PATH . 'assets/inc/template_scripts.php'; ?>
    <!-- on demand scripts to load -->
    <script src="<?php echo BASE_URL?>assets/js/modulos/gral/checkSession.js"></script>
    <script src="<?php echo BASE_URL?>assets/js/modulos/gral/changeSegmentType.js"></script>
    <script src="<?php echo BASE_URL?>assets/js/pages/formsValidation.js"></script>
    <script src="<?php echo BASE_URL?>assets/js/pages/readyDashboard.js"></script>
    <script>//$(function(){ ReadyDashboard.init(); });</script>
    <script>$(function() { FormsValidation.init(); });</script>
    <script src="<?php echo BASE_URL?>assets/js/pages/sweetalert.min.js"></script>
    <script src="<?php echo BASE_URL?>assets/js/pages/jquery.inputmask.bundle.min.js"></script>
    <script src="<?php echo BASE_URL?>assets/js/pages/jquery.number.min.js"></script>
    <!-- module related script to load -->
    <script type="text/javascript">  var BASE_URL = '<?php echo BASE_URL; ?>'; </script>
    <script src="<?php echo BASE_URL?>assets/js/modulos/home/home.js"></script>
