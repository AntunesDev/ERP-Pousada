<header class="navbar<?php if ($template['header_navbar']) { echo ' ' . $template['header_navbar']; } ?><?php if ($template['header']) { echo ' '. $template['header']; } ?>">
    <ul class="nav navbar-nav-custom">
        <li>
            <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');this.blur();">
                <i class="fa fa-ellipsis-v fa-fw animation-fadeInRight" id="sidebar-toggle-mini"></i>
                <i class="fa fa-bars fa-fw animation-fadeInRight" id="sidebar-toggle-full"></i>
            </a>
        </li>
    </ul>
    <ul class="nav navbar-nav-custom pull-right">
        <li class="dropdown">
            <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                <img src="<?php echo BASE_URL?>assets/img/placeholders/avatars/avatar.png" alt="avatar">
            </a>
            <ul class="dropdown-menu dropdown-menu-right">
                <li class="dropdown-header">
                    Usuário: <strong><?php echo ucfirst($session_username)?></strong>
                </li>
                <li>
                    <a href="<?php echo BASE_URL?>login/logout">
                        <i class="fa fa-power-off fa-fw pull-right"></i>
                        Sair
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</header>