<?php if ($_SESSION["app_erp_pousada"]["user"]["data"]["grupo_acessos"] != 3) { ?>
<!-- First Row -->
<div class="row">
  <!-- Simple Stats Widgets -->
  <div class="col-sm-6 col-lg-4">
    <a href="javascript:void(0)" class="widget">
      <div class="widget-content widget-content-mini text-right clearfix">
        <div class="widget-icon pull-left themed-background">
          <i class="gi gi-cardio text-light-op"></i>
        </div>
        <h2 class="widget-heading h3">
          <strong><span data-toggle="counter" data-to="2835"></span></strong>
        </h2>
        <span class="text-muted">RESERVAS NO ÚLTIMO MÊS</span>
      </div>
    </a>
  </div>
  <div class="col-sm-6 col-lg-4">
    <a href="javascript:void(0)" class="widget">
      <div class="widget-content widget-content-mini text-right clearfix">
        <div class="widget-icon pull-left themed-background-success">
          <i class="gi gi-user text-light-op"></i>
        </div>
        <h2 class="widget-heading h3 text-success">
          <strong>+ <span data-toggle="counter" data-to="2862"></span></strong>
        </h2>
        <span class="text-muted">HÓSPEDES HOJE</span>
      </div>
    </a>
  </div>
  <div class="col-sm-6 col-lg-4">
    <a href="javascript:void(0)" class="widget">
      <div class="widget-content widget-content-mini text-right clearfix">
        <div class="widget-icon pull-left themed-background-warning">
          <i class="gi gi-cutlery text-light-op"></i>
        </div>
        <h2 class="widget-heading h3 text-warning">
          <strong>+ <span data-toggle="counter" data-to="75"></span></strong>
        </h2>
        <span class="text-muted">PRODUTOS VENDIDOS</span>
      </div>
    </a>
  </div>
  <!-- END Simple Stats Widgets -->
</div>
<!-- END First Row -->

<!-- Second Row -->
<div class="row">
  <div class="col-sm-6 col-lg-8" id="chartCol">
    <!-- Chart Widget -->
    <div class="widget">
      <div class="widget-content border-bottom">
        <span class="pull-right text-muted">2019</span>
        Dados de um ano
      </div>
      <div class="widget-content border-bottom themed-background-muted">
        <!-- Flot Charts (initialized in js/pages/readyDashboard.js), for more examples you can check out http://www.flotcharts.org/ -->
        <div id="chart-classic-dash" style="height: 393px;"></div>
      </div>
      <div class="widget-content widget-content-full">
        <div class="row text-center">
          <div class="col-xs-4 push-inner-top-bottom border-right">
            <h3 class="widget-heading"><i class="gi gi-wallet text-dark push-bit"></i> <br><small>R$ 41.000,00</small></h3>
          </div>
          <div class="col-xs-4 push-inner-top-bottom">
            <h3 class="widget-heading"><i class="gi gi-cardio text-dark push-bit"></i> <br><small>17.000 Reservas</small></h3>
          </div>
          <div class="col-xs-4 push-inner-top-bottom border-left">
            <h3 class="widget-heading"><i class="gi gi-cutlery text-dark push-bit"></i> <br><small>3.000+ Produtos Consumidos</small></h3>
          </div>
        </div>
      </div>
    </div>
    <!-- END Chart Widget -->
  </div>
  <div class="col-sm-4" id="statsCol">
    <!-- Statistics Widget -->
    <div class="widget">
      <div class="widget-content border-bottom">
        <span class="pull-right text-muted"><i class="fa fa-check"></i></span>
        Movimentação da Semana
      </div>
      <div class="widget-content border-bottom themed-background-muted text-center">
        <span id="widget-dashchart-sales">12,15,14,18,16,15,16,17</span>
      </div>
      <div class="widget-content widget-content-full-top-bottom border-bottom">
        <div class="row text-center">
          <div class="col-xs-4 push-inner-top-bottom border-right">
            <h3 class="widget-heading"><i class="gi gi-book_open text-dark push"></i> <br><small>123 Reservas</small></h3>
          </div>
          <div class="col-xs-4 push-inner-top-bottom">
            <h3 class="widget-heading"><i class="gi gi-user_add text-dark push"></i> <br><small>+10% Clientes</small></h3>
          </div>
          <div class="col-xs-4 push-inner-top-bottom border-left">
            <h3 class="widget-heading"><i class="gi gi-cutlery text-dark push"></i> <br><small>10 Produtos Consumidos</small></h3>
          </div>
        </div>
      </div>
    </div>
    <!-- END Statistics Widget -->
  </div>
</div>
<!-- END Second Row -->
<?php } ?>
<!-- obligatory scripts to load -->
<?php include BASE_PATH . 'assets/inc/page_footer.php'; ?>
<?php include BASE_PATH . 'assets/inc/template_scripts.php'; ?>
<script src="<?php echo BASE_URL ?>assets/js/modulos/gral/checkSession.js"></script>
<!-- on demand scripts to load -->
<script src="<?php echo BASE_URL ?>assets/js/pages/sweetalert.min.js"></script>

<?php if ($_SESSION["app_erp_pousada"]["user"]["data"]["grupo_acessos"] != 3) { ?>
<script type="text/javascript">
  var BASE_URL = '<?php echo BASE_URL; ?>';
</script>
<script src="<?php echo BASE_URL ?>assets/js/pages/readyDashboard.js"></script>
<script>
  $(function() {
    ReadyDashboard.init();
  });
</script>
<script src="<?php echo BASE_URL ?>assets/js/modulos/home/home.js"></script>
<?php } ?>