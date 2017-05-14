<!doctype html>

<!--[if lt IE 7]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8 lt-ie7"><![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9 lt-ie8"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html <?php language_attributes(); ?> class="no-js lt-ie9"><![endif]-->
<!--[if gt IE 8]><!--> <html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->

<head>
    <meta charset="utf-8">

    <?php // force Internet Explorer to use the latest rendering engine available ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title><?php wp_title('-'); ?></title>

    <meta name="HandheldFriendly" content="True">
    <meta name="MobileOptimized" content="320">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>

    <!--  Social Media  -->
    <meta property="og:type" content="website">
    <meta property="og:locale" content="pt_BR">
    <meta property="og:url" content="<?php echo get_site_url(); ?>">
    <meta property="og:site_name" content="">
    <meta property="og:image" content="<?php echo get_template_directory_uri(); ?>/dist/img/compartilhamento.png">
    <meta property="og:title" content="">
    <meta property="og:description" content="">
    <meta name="description" content="">

    <?php // wordpress head functions ?>
    <?php wp_head(); ?>
    <?php // end of wordpress head ?>


    <?php // drop Google Analytics Here ?>

    <?php // end analytics ?>

</head>

<body>

<script src="<?php echo get_template_directory_uri() .'/dist/js/queryloader2.min.js'; ?>"></script>
<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', function() {
        QueryLoader2(document.querySelector("body"), {
            barColor: "#efefef",
            backgroundColor: "#111",
            percentage: true,
            barHeight: 1,
            minimumTime: 200,
            fadeOutTime: 1000
        });
    });
</script>

<header class="header">
    <div class="logo">
        <a href="<?php echo site_url(); ?>">
            <img class="img-responsive" src="<?php echo get_template_directory_uri() .'/dist/img/logo.jpg'; ?>" alt="Logo">
        </a>
    </div>

    <a class="hamburger-menu">
        <span></span>
        <span></span>
        <span></span>
    </a>

    <nav class="menu">
        <?php
        $args_nav = array(
            'menu'            => 'id',
            'menu_class'      => 'menu-items',
            'echo'            => true,
            'fallback_cb'     => 'wp_page_menu',
            'items_wrap'      => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            'depth'           => 0,
        );

        wp_nav_menu( $args_nav );
        ?>
    </nav>
</header>