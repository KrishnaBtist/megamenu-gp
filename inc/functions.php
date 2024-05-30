<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
function imc_gp_megamenu_dropdown_to_nav_menu($item_id, $item, $depth, $args) {
    $mega_menu_posts = get_posts(array(
        'post_type' => 'mega_menu',
        'numberposts' => -1,
    ));
    if ($mega_menu_posts) 
    {
        $selected_mega_menu = get_post_meta($item_id, '_imc_gp_megamenu_menu_item_mega_menu', true);
        ?>
        <div class="field-mega-menu item-type-imc-mega-menu field-item">
            <label for="edit-imc_gp_megamenu_menu_item_mega_menu-<?php echo $item_id; ?>">
                <?php _e('Select Mega Menu:', IMCGPMEGAMENUPLUGINSLUG); ?>
                <select id="edit-imc_gp_megamenu_menu_item_mega_menu-<?php echo $item_id; ?>" class="widefat code edit-menu-item-custom" name="imc_gp_megamenu_menu_item_mega_menu[<?php echo $item_id; ?>]">
                    <option value=""><?php _e('Select Mega Menu',IMCGPMEGAMENUPLUGINSLUG); ?></option>
                    <?php foreach ($mega_menu_posts as $post) : ?>
                        <option value="<?php echo esc_attr($post->ID); ?>" <?php selected($selected_mega_menu, $post->ID); ?>><?php echo esc_html($post->post_title); ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
        </div>
        <?php
    }
}
add_action('wp_nav_menu_item_custom_fields', 'imc_gp_megamenu_dropdown_to_nav_menu', 10, 4);
function save_imc_gp_megamenu_dropdown_to_nav_menu($menu_id, $menu_item_db_id, $menu_item_args) {
    if (isset($_REQUEST['imc_gp_megamenu_menu_item_mega_menu'][$menu_item_db_id])) {
        $mega_menu_id = sanitize_text_field($_REQUEST['imc_gp_megamenu_menu_item_mega_menu'][$menu_item_db_id]);
        update_post_meta($menu_item_db_id, '_imc_gp_megamenu_menu_item_mega_menu', $mega_menu_id);
    }
}
add_action('wp_update_nav_menu_item', 'save_imc_gp_megamenu_dropdown_to_nav_menu', 10, 3);

add_filter('wp_nav_menu_objects', function ($items, $args) {

    $icons ='<span role="presentation" class="dropdown-menu-toggle imc_gp_arrow" tabindex="0" aria-expanded="false" aria-label="Open Sub-Menu">'.generate_get_svg_icon( 'arrow' ).'</span>';
    foreach ($items as $item) {
        $menu_item_id = $item->ID;
        $menu_item_mega_menu_id = get_post_meta($menu_item_id, '_imc_gp_megamenu_menu_item_mega_menu', true); // POST ID
        if ($menu_item_mega_menu_id) {
            $post = get_post($menu_item_mega_menu_id);
            $backgroundColor =  esc_attr(get_theme_mod('mega_menu_bg_color'));
            $styleBg = '';
            if($backgroundColor){
                $styleBg = 'background-color: '.$backgroundColor.'';
            }
            if ($post) {
                $mega_menu_content = get_post_field('post_content', $menu_item_mega_menu_id);
                $mega_menu_content = apply_filters('the_content', $mega_menu_content);
                $mega_menu_content = '<ul class="sub-menu imc-gp-mega-menu-wrapper"><li class=""><div class="" style="'.$styleBg.'">' . $mega_menu_content . '</div></li></ul>';
                $item->title .= ''.$icons.'</a>' . $mega_menu_content;
            }
        }
    }
    return $items;
}, 10, 2);

function add_wp_menu_class_to_li($classes, $item, $args) {
    if (property_exists($item, 'ID')) {
        $menu_item_id = $item->ID;
        if (get_post_meta($menu_item_id, '_imc_gp_megamenu_menu_item_mega_menu', true)) {

            
            $imcClasschilddren = 'menu-item-has-children';
            if(togetnavdropdownmenu() == 'click'){
                $imcClasschilddren = 'menu-item-has-children-click';
            }
            if(togetnavdropdownmenu() == 'click-arrow'){
                $imcClasschilddren = 'menu-item-has-children-click-arrow';
            }

            $classes[] = 'imc_gp_mega_menu_item '.$imcClasschilddren;
        }
    }
    return $classes;
}

add_filter('nav_menu_css_class', 'add_wp_menu_class_to_li', 10, 3);

add_action('template_redirect', 'remove_header_footer_on_mega_menu');
function remove_header_footer_on_mega_menu() {
    if (is_singular('mega_menu')) {
        remove_action('generate_header', 'generate_construct_header');
        remove_action('generate_footer', 'generate_construct_footer');
        remove_action('generate_sidebar', 'generate_construct_sidebar');
        remove_action('generate_sidebar', 'generate_right_sidebar');
    }
}

add_filter( 'generate_sidebar_layout','imc_mega_menu_sidebar_layout' );
function imc_mega_menu_sidebar_layout( $layout )
{
 	if (is_singular('mega_menu')) 
 	 	return 'no-sidebar';
    return $layout;

}
add_filter('generate_logo_output', function ($output, $logo_url, $html) {
    $new_logo_url = get_theme_mod('imc_gp_logo');
    $logo_retina_url = get_theme_mod('imc_gp_logo_retina');
    $newImg = '';
    $html = preg_replace('/\s+src="[^"]*"/', '', $html);
    $html = preg_replace('/\s+srcset="[^"]*"/', '', $html);

    preg_match('/width="(\d+)"/', $output, $width_match);
    preg_match('/height="(\d+)"/', $output, $height_match);

    // Get the values
    $width = isset($width_match[1]) ? $width_match[1] : 'unknown';
    $height = isset($height_match[1]) ? $height_match[1] : 'unknown';
    
    if ($new_logo_url || $logo_retina_url) {
        $newImg = sprintf('<img %s srcset="%s 1x, %s 2x" width="'.$width.'" height="'.$height.'">',
            $html,
            esc_url($new_logo_url),
            esc_url($logo_retina_url)
        );
    }
    $newImgWithAdditionalClass = preg_replace('/class="([^"]+)"/', 'class="$1 imcgpmenuLogo"', $newImg);
    $position = strrpos($output, '</a>');
    if ($position !== false) {
        $output = substr_replace($output, $newImgWithAdditionalClass, $position, 0);
    }
    return $output;
}, 10, 3);

add_filter('generate_sticky_navigation_logo_output', function ($output) {


    if (!function_exists('generate_menu_plus_get_defaults')) {
        return $output;
    }
    preg_match('/width="(\d+)"/', $output, $width_match);
    preg_match('/height="(\d+)"/', $output, $height_match);
    $width = isset($width_match[1]) ? $width_match[1] : '';
    $height = isset($height_match[1]) ? $height_match[1] : '';

    $imcgpSticky         =  get_option('generate_menu_plus_settings');
    if($imcgpSticky && isset($imcgpSticky['sticky_menu']))
    {
        $new_logo_url    = get_theme_mod('imc_gp_logo');
        $logo_retina_url = get_theme_mod('imc_gp_logo_retina');
        $newImg = '';
        if ($new_logo_url || $logo_retina_url) {
            $newImg = sprintf(
                '<img src="%s" alt="" srcset="%s 1x, %s 2x" class="is-logo-image imcgpmenuLogo" width="'.$width.'" height="'.$height.'">',
                esc_url($new_logo_url),
                esc_url($new_logo_url),
                esc_url($logo_retina_url)
            );
        }
        $position = strrpos($output, '</a>');
        if ($position !== false) {
            $output = substr_replace($output, $newImg, $position, 0);
        }
        return $output;
    }
});

function togetnavdropdownmenu(){
    $imcgpNavDrop = '';
    $imcgpGenerateSetting =  get_option('generate_settings');
    if( $imcgpGenerateSetting && isset($imcgpGenerateSetting['nav_dropdown_type']))
    {
        $imcgpNavDrop  =  $imcgpGenerateSetting['nav_dropdown_type'];
    }
    return $imcgpNavDrop;
}


