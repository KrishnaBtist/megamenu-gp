<?php
//Plugin Name: IMC GP MegaMenu
//Description: IMC GeneratePress Mega Menu expands standard menus, enabling multi-column dropdowns. 
//Author: InterMEDIA Communications 
//Author URI: mailto:dev@imcnet.it 


if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

define( 'IMCGPMEGAMENUPLUGINNAME', 'IMC GP MegaMenu');
define( 'IMCGPMEGAMENUPLUGINSLUG', 'gp-megamenu');
define( 'IMCGPMEGAMENUPLUGINVERSION', time());
require_once('inc/functions.php');
require_once('inc/enqueue.php');
require_once('inc/setting-admin.php');

function generatePressRequiredNotice() {
    $theme = wp_get_theme('generatepress');
	if ( !$theme->exists() && current_user_can( 'activate_plugins' ) ) :
        deactivate_plugins(plugin_basename(__FILE__));
       ?>
            <div class="notice notice-error is-dismissible">
                <p><?php _e( IMCGPMEGAMENUPLUGINNAME .' plugin requires the GeneratePress theme to be installed and active.', IMCGPMEGAMENUPLUGINVERSION); ?></p>
            </div>
        <?php
	endif;
}
add_action( 'admin_notices', 'generatePressRequiredNotice' );
