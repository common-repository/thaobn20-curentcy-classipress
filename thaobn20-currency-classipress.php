<?php
/*
Plugin Name: Add Currency For Classipress theme
Plugin URI: https://www.buingocthao.com
Description: Add more currency for Classipress Theme.
Version: 1.0.1
Author: thaobn20
Author URI: https://www.buingocthao.com
License: GPL2
Text Domain: thaobn20-curentcy-classipress
Domain Path: /languages
Tested: Classipress 3.5.7 WP 4.6.1
*/

/**
 * Load the localization files.
 *
 * @since 1.4.0
 *
 * Note: the first-loaded translation file overrides any following ones if the same translation is present.
 *
 * Locales found in (unless WP_LANG_DIR is defined differently in wp-config.php:
 *   - wp-content/languages/appthemes-updater/appthemes-updater-LOCALE.mo
 *   - wp-content/languages/plugins/appthemes-updater-LOCALE.mo
 */
function thaobn20_load_textdomain() {

	$domain = 'thaobn20-curentcy-classipress';

	// Load the locale (e.g. de_DE) based on the WordPress site language set (wp-admin => Settings => General).
	$locale = apply_filters( 'plugin_locale', get_locale(), $domain );

	// Load any custom .mo file first, if it's found.
	load_textdomain( $domain, WP_LANG_DIR . '/' . $domain . '/' . $domain . '-' . $locale . '.mo' );

	// Load the plugin's .mo file if it's found and no custom .mo file exists.
	load_plugin_textdomain( $domain, false, plugin_basename( dirname( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'thaobn20_load_textdomain' );




// Adds actions
add_action('admin_menu', 'thaobn20_add_menu');
add_action('admin_init', 'thaobn20_reg_function' );

//register of default values in plugin activation
register_activation_hook( __FILE__, 'thaobn20_activate' );

//add menu
function thaobn20_add_menu() {
    $page = add_options_page('Add Currency Classipress', 'Add Currency Classipress', 'administrator', 'thaobn20_menu', 'thaobn20_menu_function');
}
//create group of variables
function thaobn20_reg_function() {
	register_setting( 'thaobn20-settings-group', 'thaobn20_name' );
	register_setting( 'thaobn20-settings-group', 'thaobn20_symbol' );
	register_setting( 'thaobn20-settings-group', 'thaobn20_APP_Currencies' );
}
//add default value to variables
function thaobn20_activate() {
	add_option('thaobn20_name','Việt Nam Đồng');
	add_option('thaobn20_symbol','vnđ');
	add_option('thaobn20_APP_Currencies','VNĐ');
}
function thaobn20_menu_function() {
?>
<div class="wrap">
<h2><?php _e( 'Add Currency Classipress', 'thaobn20-curentcy-classipress' ); ?></h2>

<form method="post" action="options.php">
    <?php settings_fields( 'thaobn20-settings-group' ); ?>
    <table class="form-table">	
	           	<tr valign="top">
        <th scope="row"><?php _e( 'The name of Currency', 'thaobn20-curentcy-classipress' );?></th>
        <td>
        <label>
        <input type="text" name="thaobn20_name" id="thaobn20_name" size="20" value="<?php echo get_option('thaobn20_name'); ?>" />
        </label>
        </tr>
		
		<tr valign="top">
        <th scope="row"><?php _e( 'The symbol', 'thaobn20-curentcy-classipress' ); ?></th>
        <td>
        <label>
        <input type="text" name="thaobn20_symbol" id="thaobn20_symbol" size="7" value="<?php echo get_option('thaobn20_symbol'); ?>" />
        </label>
        </tr>
		
		<tr valign="top">
        <th scope="row"><?php _e( 'Code Country Currency', 'thaobn20-curentcy-classipress' );?></th>
        <td>
        <label>
        <input type="text" name="thaobn20_APP_Currencies" id="thaobn20_APP_Currencies" size="7" value="<?php echo get_option('thaobn20_APP_Currencies'); ?>" />
        </label>
        </tr>
		</table>

    <p class="submit">
    <input type="submit" class="button-primary" value="<?php esc_attr_e( 'Save changes', 'thaobn20-curentcy-classipress' ); ?>" />
    </p>
</form>	
<?php	
}
add_action( 'init', 'thaobn_add_currency' );
function thaobn_add_currency(){
 $t_name = get_option('thaobn20_name');
 $t_symbol = get_option('thaobn20_symbol'); 
 $t_Currencies = get_option('thaobn20_APP_Currencies'); 
    // Give your currency a name and symbol
    $args = array(
       'name' => $t_name,
       'symbol' => $t_symbol
    );
    
    APP_Currencies::add_currency( $t_Currencies, $args );
 
}
?>