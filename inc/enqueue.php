<?php

defined('ABSPATH') || exit;
function pluginScripts(){    
    wp_enqueue_media();
    wp_enqueue_script('jquery');
    wp_enqueue_style(IMCGPMEGAMENUPLUGINSLUG.'_FrontStyle', plugin_dir_url(__DIR__).'inc/css/frontstyle.css','',IMCGPMEGAMENUPLUGINVERSION);
    wp_enqueue_script(IMCGPMEGAMENUPLUGINSLUG.'_FrontScript', plugin_dir_url(__DIR__).'inc/js/front-scripts.js','',IMCGPMEGAMENUPLUGINVERSION);
    $header_background_color = get_theme_mod('imc_nav_bg_color');
    $imcgpGenerateSetting   =  get_option('generate_settings');
    if( $imcgpGenerateSetting && isset($imcgpGenerateSetting['nav_dropdown_type']))
    {
        $imcgpmenu_nav_dropdown_type = $imcgpGenerateSetting['nav_dropdown_type'];
    }
    $arraymenu = 
    array(
        'imcgpmenu_headerBackgroundColor'   =>$header_background_color,
        'imcgpmenu_nav_dropdown_type'       =>$imcgpmenu_nav_dropdown_type,
    );
    wp_localize_script(IMCGPMEGAMENUPLUGINSLUG.'_FrontScript', 'imc_menu_object', $arraymenu);
}
add_action( 'wp_enqueue_scripts', 'pluginScripts');

function pluginAdminScripts(){    
    wp_enqueue_media();
    wp_enqueue_style(IMCGPMEGAMENUPLUGINSLUG.'_AdminStyle', plugin_dir_url(__DIR__).'inc/css/adminstyle.css','',IMCGPMEGAMENUPLUGINVERSION);
    wp_enqueue_script(IMCGPMEGAMENUPLUGINSLUG.'_AdminScript', plugin_dir_url(__DIR__).'inc/js/admin-scripts.js','',IMCGPMEGAMENUPLUGINVERSION);
}
add_action( 'admin_enqueue_scripts', 'pluginAdminScripts');
function add_custom_body_class($classes) {
    $classes[] = 'imc_gp_megamenu';
    return $classes;
}
add_filter('body_class', 'add_custom_body_class');

