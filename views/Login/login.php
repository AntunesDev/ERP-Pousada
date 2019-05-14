<?php
include BASE_PATH . 'assets/inc/config.php';
include BASE_PATH . 'assets/inc/template_start.php';
?>
<!-- Login Container -->
<div id="login-container">
    <!-- Login Header -->
    <h1 class="h2 text-light text-center push-top-bottom animation-slideDown">
        <i class="fa fa-cube"></i> <strong>Sistema ERP</strong>
    </h1>
    <!-- END Login Header -->

    <!-- Login Block -->
    <div class="block animation-fadeInQuickInv">
        <!-- Login Form -->
        <form id="form-login" action="<?php echo BASE_URL?>login/login" method="post" class="form-horizontal">
            <div class="form-group">
                <div class="col-xs-12">
                    <input type="text" id="login-user" name="login-user" class="form-control" placeholder="Usuario..">
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <input type="password" id="login-password" name="login-password" class="form-control" placeholder="Senha..">
                </div>
            </div>
            <?php if(isset($erros)) : ?>
              <div class="form-group">
                <div class="col-sm-6 col-lg-12">
                  <div class="alert alert-danger">
                    <?php foreach ($erros as $key => $value) : ?>
                      <?php echo $value; ?>
                    <?php endforeach; ?>
                  </div>
                </div>
              </div>
            <?php endif; ?>

            <div class="form-group form-actions">
                <div class="col-xs-12 text-right">
                    <button type="submit" class="btn btn-effect-ripple btn-sm btn-primary"><i class="fa fa-check"></i> Entrar</button>
                </div>
            </div>
        </form>
        <!-- END Login Form -->
    </div>
    <!-- END Login Block -->

    <!-- Footer -->
    <footer class="text-muted text-center animation-pullUp">
        <small><span id="year-copy"></span> &copy; <a href="#" target="_blank"><?php echo $template['name'] . ' ' . $template['version']; ?></a></small>
    </footer>
    <!-- END Footer -->
</div>
<!-- END Login Container -->

<?php include BASE_PATH . 'assets/inc/template_scripts.php'; ?>
<!-- <script type="text/javascript"> //location.reload(true); </script> -->
<!-- Load and execute javascript code used only in this page -->
<script src="<?php echo BASE_URL?>assets/js/pages/readyLogin.js"></script>
<script>$(function(){ ReadyLogin.init(); });</script>
