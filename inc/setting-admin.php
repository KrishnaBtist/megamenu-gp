<?php

if(!defined('ABSPATH')){
    eixt();
}

function custom_mega_menu_post_type() {
    $labels = array(
        'name'               => __( 'Menu Blocks', IMCGPMEGAMENUPLUGINSLUG),
        'singular_name'      => __( 'Mega Menu', IMCGPMEGAMENUPLUGINSLUG),
        'menu_name'          => __( 'GP MegaMenu', IMCGPMEGAMENUPLUGINSLUG),
        'name_admin_bar'     => __( 'Mega Menu',  IMCGPMEGAMENUPLUGINSLUG),
        'add_new'            => __( 'Add New', IMCGPMEGAMENUPLUGINSLUG),
        'add_new_item'       => __( 'Add New Mega Menu', IMCGPMEGAMENUPLUGINSLUG),
        'new_item'           => __( 'New Mega Menu', IMCGPMEGAMENUPLUGINSLUG),
        'edit_item'          => __( 'Edit Mega Menu', IMCGPMEGAMENUPLUGINSLUG),
        'view_item'          => __( 'View Mega Menu', IMCGPMEGAMENUPLUGINSLUG),
        'all_items'          => __( 'Menu Blocks', IMCGPMEGAMENUPLUGINSLUG),
        'search_items'       => __( 'Search Mega Menus', IMCGPMEGAMENUPLUGINSLUG),
        'parent_item_colon'  => __( 'Parent Mega Menus:', IMCGPMEGAMENUPLUGINSLUG),
        'not_found'          => __( 'No mega menus found.', IMCGPMEGAMENUPLUGINSLUG),
        'not_found_in_trash' => __( 'No mega menus found in Trash.', IMCGPMEGAMENUPLUGINSLUG),
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'has_archive'         => true,
        'publicly_queryable'  => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'imc-mega-menu'),
        'capability_type'     => 'post',
        'hierarchical'        => false,
        'supports'            => array(
            'title',
            'editor',
            'thumbnail',
            'excerpt',
            'custom-fields',
            'page-attributes'
        ),
        'menu_position'       => 20,
        'menu_icon'           => 'dashicons-list-view',
        'show_in_rest'=>true
    );
    register_post_type('mega_menu', $args);

    register_post_type( 'mega_menu', $args );
}
add_action( 'init', 'custom_mega_menu_post_type' );

add_action('admin_menu', 'add_submenu_to_mega_menu');
 function add_submenu_to_mega_menu() {
    add_submenu_page(
        'edit.php?post_type=mega_menu',
        __('Settings', IMCGPMEGAMENUPLUGINSLUG),
        __('Settings', IMCGPMEGAMENUPLUGINSLUG),
        'manage_options',
        'customize.php?autofocus[panel]=mega_menu_settings_panel'
    );
 }
 add_action('customize_register', 'imc_mega_menu_customize');
 function imc_mega_menu_customize($wp_customize) {
     $wp_customize->add_panel('mega_menu_settings_panel', array(
         'title' => __('Mega Menu Settings', IMCGPMEGAMENUPLUGINSLUG),
         'capability' => 'edit_theme_options',
     ));
     $wp_customize->add_section('mega_menu_settings_section', array(
        'title' => __('Mega Menu Settings', IMCGPMEGAMENUPLUGINSLUG),
        'panel' => 'mega_menu_settings_panel',
    ));
     $wp_customize->add_setting('mega_menu_bg_color', array(
         'default' => '#ffffff',
         'sanitize_callback' => 'sanitize_hex_color',
     ));
     $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mega_menu_bg_color', array(
         'label' => __('Background Color', IMCGPMEGAMENUPLUGINSLUG),
         'section' => 'mega_menu_settings_section',
         'settings' => 'mega_menu_bg_color',
     )));
     $wp_customize->add_setting('imc_nav_bg_color', array(
         'default' => '#ffffff',
         'sanitize_callback' => 'sanitize_hex_color',
     ));
     $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'imc_nav_bg_color', array(
         'label' => __('Navigation Background Color - On Hover', IMCGPMEGAMENUPLUGINSLUG),
         'section' => 'mega_menu_settings_section',
         'settings' => 'imc_nav_bg_color',
     )));
    //  $wp_customize->add_setting('mega_menu_text_color', array(
    //      'default' => '#000000',
    //      'sanitize_callback' => 'sanitize_hex_color',
    //  ));
    //  $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'mega_menu_text_color', array(
    //      'label' => __('Text Color Mega Menu', IMCGPMEGAMENUPLUGINSLUG),
    //      'section' => 'mega_menu_settings_section',
    //      'settings' => 'mega_menu_text_color',
    //  )));
     // Add image setting
     $wp_customize->add_setting('imc_gp_logo');
     $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'imc_gp_logo', array(
         'label' => __('Logo - On Hover', IMCGPMEGAMENUPLUGINSLUG),
         'section' => 'mega_menu_settings_section',
         'settings' => 'imc_gp_logo',
     )));
     $wp_customize->add_setting('imc_gp_logo_retina');
     $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'imc_gp_logo_retina', array(
         'label' => __('Retina Logo - On Hover', IMCGPMEGAMENUPLUGINSLUG),
         'section' => 'mega_menu_settings_section',
         'settings' => 'imc_gp_logo_retina',
     )));

 }
 