<?php
include BASE_PATH . 'assets/inc/config.php';
include BASE_PATH . 'assets/inc/template_start.php';
include BASE_PATH . 'assets/inc/page_head.php'; ?>

<!-- Page content -->
<div id="page-content" style="min-height: 334px;">

<?php $this->loadViewInTemplate($viewName, $viewData); ?>

</div>
<!-- END Page Content -->

<!-- here will be included all javascript code -->

<?php include BASE_PATH. 'assets/inc/template_end.php'; ?>
