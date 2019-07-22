<?php
include BASE_PATH . 'assets/inc/config.php';
include BASE_PATH . 'assets/inc/template_start.php';
?>
<img src="<?php echo BASE_URL?>assets/img/background.jpg" class="full-bg animation-pulseSlow" style="filter: blur(1.5px); opacity:0.7;">
<div id="login-container">
    <h1 class="h2 text-light text-center push-top-bottom animation-slideDown">
        <i class="fa fa-bed"></i> Modular<strong>Inn</strong>
    </h1>

    <div class="block animation-fadeInQuickInv">
        <form id="form-login" action="<?php echo BASE_URL?>login/login" method="post" class="form-horizontal">
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        <input type="text" id="login-user" name="login-user" class="form-control" placeholder="Usuário">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-12">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        <input type="password" id="login-password" name="login-password" class="form-control" placeholder="Senha">
                    </div>
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
    </div>
    <footer class="text-center animation-pullUp">
        <small><span id="year-copy"></span> &copy; <a href="#" target="_blank"><?php echo $template['name'] . ' ' . $template['version']; ?></a></small>
    </footer>
</div>

<?php include BASE_PATH . 'assets/inc/template_scripts.php'; ?>
<script src="<?php echo BASE_URL?>assets/js/pages/readyLogin.js"></script>
<script>$(function(){ ReadyLogin.init(); });</script>
