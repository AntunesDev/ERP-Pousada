<?php
    include BASE_PATH . 'assets/inc/config.php';
    include BASE_PATH . 'assets/inc/template_start.php';
?>
<img src="<?php echo BASE_URL?>assets/img/background.jpg" alt="Full Background" class="full-bg full-bg-bottom animation-pulseSlow" style="filter: blur(1.5px); opacity:0.2;">
<div id="error-container">
    <div class="row text-center">
        <div class="col-md-6 col-md-offset-3">
            <h1 class="text-light animation-fadeInQuick"><strong>Você não deveria estar aqui...</strong></h1>
            <h3 class="text-muted animation-fadeInQuickInv"><em>A página desejada não foi encontrada.</em></h3>
        </div>
        <div class="col-md-4 col-md-offset-4">
            <a href="javascript:history.back()" class="btn btn-effect-ripple btn-default"><i class="fa fa-arrow-left"></i> Retornar</a>
        </div>
    </div>
</div>
<?php include BASE_PATH. 'assets/inc/template_end.php'; ?>