<?php
    /*
     * Plugin Name: OS General
     * Description: Online Shop - Core
     * Version: 1.0
     * Author: Andrew Savetchuk
     * Author URI: http://savetchuk.com/
     */

    // Disable WP Updates
    add_filter('pre_site_transient_update_core',create_function('$a', "return null;"));
    wp_clear_scheduled_hook('wp_version_check');

    remove_action('load-update-core.php', 'wp_update_plugins');
    add_filter('pre_site_transient_update_plugins', create_function('$a', "return null;"));
    wp_clear_scheduled_hook('wp_update_plugins');

    remove_action('load-update-core.php','wp_update_themes');
    add_filter('pre_site_transient_update_themes',create_function('$a', "return null;"));
    wp_clear_scheduled_hook('wp_update_themes');

    // Remove menu items
    function remove_menus(){
        remove_menu_page('themes.php');
        remove_menu_page('tools.php');
        remove_menu_page('plugins.php');
        remove_submenu_page('index.php', 'update-core.php');
        remove_submenu_page('index.php', 'index.php');
        remove_submenu_page('options-general.php', 'options-permalink.php');
        remove_submenu_page('options-general.php', 'options-reading.php');
        remove_submenu_page('options-general.php', 'options-writing.php');
        remove_submenu_page('options-general.php', 'options-media.php');
        // remove_submenu_page('themes.php', 'themes.php');
        // remove_submenu_page('themes.php', 'theme-editor.php');
        // global $submenu;
        // unset($submenu['themes.php'][6]);
    }
    add_action('admin_init', 'remove_menus');

    // Remove WP logo
    function logo_admin_bar_remove() {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('wp-logo');
    }
    add_action('wp_before_admin_bar_render', 'logo_admin_bar_remove', 0);

    // Remove Welcome Panel
    remove_action('welcome_panel', 'wp_welcome_panel');

    // Remove Dashboard News Widget
    function remove_dashboard_meta() {
        remove_meta_box('dashboard_primary', 'dashboard', 'normal');
        remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    }
    add_action('admin_init', 'remove_dashboard_meta');

    // Remove Dashboard Footer
    if (!function_exists('dashboard_footer')){
        function dashboard_footer() {
            echo '&nbsp;';
            remove_filter('update_footer', 'core_update_footer');
        }
    }
    add_filter('admin_footer_text', 'dashboard_footer');

    // Add some CSS
    function custom_admin_head(){
        echo '<style>#wp-version-message, #wp-admin-bar-site-name-default, #contextual-help-link-wrap, .avatar-settings {display: none !important;}</style>';
    }
    add_action('admin_head', 'custom_admin_head');

?>
