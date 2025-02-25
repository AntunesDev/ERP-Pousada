<?php include BASE_PATH.'assets/root.php'; ?>
<?php

$template = array(
  'name'              => 'ModularInn',
  'version'           => '1.0.0',
  'author'            => 'Lucas A. & Vinícius S.',
  'robots'            => 'noindex, nofollow',
  'title'             => 'ModularInn',
  'description'       => 'ModularInn',
  'page_preloader'    => true,
  'header_navbar'     => 'navbar-inverse',
  'header'            => 'navbar-fixed-top',
  'layout'            => '',
  'sidebar'           => 'sidebar-visible-lg-mini',
  'cookies'           => '',
  'theme'             => 'amethyst', // '', 'classy', 'social', 'flat', 'amethyst', 'creme', 'passion'
  'header_link'       => 'ModularInn',
  'inc_sidebar'       => 'page_sidebar',
  'inc_sidebar_alt'   => 'page_sidebar_alt',
  'inc_header'        => 'page_header',
  'active_page'       => SELF_PATH.SELF_PAGE,
);

$session_username = $_SESSION["app_erp_pousada"]["user"]["data"]["usuario"] ?? '';
$session_grp_acesso = $_SESSION["app_erp_pousada"]["user"]["data"]["grupo_acessos"] ?? 3;

$primary_nav = array(
    array(
        'name'  => 'Painel Principal',
        'url'   => '',
        'icon'  => 'fa fa-home'
    ),
    array(
        'url'   => 'separator',
    )
);

if ($session_grp_acesso == 1 || $session_grp_acesso == 2)
{
    $cadastros = array(
        'name'  => 'Cadastros',
        'url'   => '',
        'icon'  => 'fa fa-pencil',
        'sub'   => array(
            array(
                'name' => 'Clientes',
                'url'  => 'Clientes'
            ),
            array(
                'name' => 'Produtos',
                'url'  => 'Produtos'
            ),
            array(
                'name' => 'Suítes',
                'url'  => 'Suites'
            ),
            array(
                'name' => 'Funcionários',
                'url'  => 'Funcionarios'
            )
        )
    );

    if ($session_grp_acesso == 1)
    {
        $cadastros["sub"][] = array(
            'name' => 'Usuários',
            'url'  => 'Usuarios'
        );
    }

    $primary_nav[] = $cadastros;
}

$diaAdia = array(
    'name'  => 'Dia a Dia',
    'url'   => '',
    'icon'  => 'fa fa-clipboard',
    'sub'   => array(
        array(
            'name' => 'Reservas',
            'url'  => 'Reservas'
        )
    )
);

$primary_nav[] = $diaAdia;