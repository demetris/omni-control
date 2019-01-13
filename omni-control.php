<?php

/*
    OMNI CONTROL FOR WORDPRESS

    Plugin Name:            Omni Control
    Plugin URI:             https://bitbucket.org/demetris/omni-control
    Description:            An assortment of tweaks for WordPress
    Version:                0.2.4
    Author:                 Demetris kikizas
    Author URI:             https://kikizas.com/
    Licence:                GPL-2.0
    License URI:            https://opensource.org/licenses/GPL-2.0
    GitHub Plugin URI:      https://github.com/demetris/omni-control
*/


/*
|
|   Gets required files
|
*/
require dirname(__FILE__) . '/omni-control-settings.php';

/*
|
|
|
*/
register_activation_hook(__FILE__, 'omnictrl_register_activation_hook');

/*
|
|   Creates transient data during activation
|
|   @since 0.0.1
|
*/
function omnictrl_register_activation_hook() {
    set_transient('omnictrl-activation-notice', true, 10);
}

/*
|
|   Displays admin notice on activation if transient data is there
|
|   @since 0.0.1
|   @wp-action admin_notices
|
*/
function omnictrl_admin_notices_activation() {
    if (get_transient('omnictrl-activation-notice')) {
        $text = __('Omni Control settings', 'omni-control');
        $href = admin_url('options-general.php?page=omni-control');
        $link = '<a style="text-decoration: none" href="' . $href . '">' . $text . '</a>';

        echo '<div class="updated notice is-dismissible">' . "\n";
        echo '<p>' . sprintf(__('Please, visit the %s to set your preferences.', 'omni-control'), $link) . '</p>' . "\n";
        echo '</div>' . "\n";

        /*
        |   Deletes transient data created on activation
        */
        delete_transient('omnictrl-activation-notice');
    }
}
add_action('admin_notices', 'omnictrl_admin_notices_activation');

/*
|
|   @wp-action admin_enqueue_scripts
|
*/
function omnictrl_enqueue_admin_css_js() {
    if (get_current_screen()->id != 'settings_page_omni-control') {
        return;
    }

    wp_enqueue_script('omni-control', plugin_dir_url(__FILE__) . 'assets/js/main.js', ['jquery'], null, true);
}
add_action('admin_enqueue_scripts', 'omnictrl_enqueue_admin_css_js');

/*
|
|   Retrieves and stores plugin settings from database
|
*/
$options = get_option('omnictrl');

/*
|
|   Appends link to settings screen by filtering the plugin’s action links array
|
|   @since 0.0.1
|   @wp-filter plugin_action_links_
|
*/
function omnictrl_plugin_action_links($links) {
    $name = __('Settings', 'omni-control');
    $href = admin_url('options-general.php?page=omni-control');
    $link = ['<a href="' . $href . '">' . $name . '</a>'];

    return array_merge($links, $link);
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'omnictrl_plugin_action_links');

if (!empty($options['disable-smilies'])) {
    add_filter('option_use_smilies', '__return_false');
}

if (!empty($options['disable-visual-editor'])) {
    add_filter('user_can_richedit', '__return_false');
}

if (!empty($options['reverse-document-title-parts'])) {
    /*
    |
    |   Moves site name to start of document title
    |
    |   The + (Union) operator returns the right-hand array appended to the left-hand array.
    |   For keys that exist in both arrays, the elements from the left-hand array will be used,
    |   and the matching elements from the right-hand array will be ignored.
    |
    |   @since 0.0.1
    |   @link http://php.net/manual/en/language.operators.array.php
    |   @wp-filter document_title_parts
    |   @return array
    |
    */
    function omnictrl_document_title_parts_reverse($title) {
        $sitename = '';

        if (isset($title['site'])) {
            $sitename = $title['site'];
        }

        return ['site' => $sitename] + $title;
    }
    add_filter('document_title_parts', 'omnictrl_document_title_parts_reverse');
}

if (!empty($options['remove-doc-css-js-type'])) {
    /*
    |
    |   @since 0.1.5
    |   @wp-filter style_loader_tag
    |
    */
    function omnictrl_remove_css_type($html) {
        return str_replace("type='text/css' ", '', $html);
    }
    add_filter('style_loader_tag', 'omnictrl_remove_css_type');

    /*
    |
    |   @since 0.1.5
    |   @wp-filter script_loader_tag
    |
    */
    function omnictrl_remove_js_type($html) {
        return str_replace("type='text/javascript' ", '', $html);
        return str_replace(' type="text/javascript"', '', $html);
    }
    add_filter('script_loader_tag', 'omnictrl_remove_js_type');
}

if (!empty($options['remove-doc-head-rsd-link'])) {
    remove_action('wp_head', 'rsd_link');
}

if (!empty($options['remove-doc-head-wlw-manifest-link'])) {
    remove_action('wp_head', 'wlwmanifest_link');
}

if (!empty($options['remove-doc-head-shortlink'])) {
    remove_action('wp_head', 'wp_shortlink_wp_head', 10);
}

if (!empty($options['remove-doc-head-wordpress-version'])) {
    remove_action('wp_head', 'wp_generator');
}

if (!empty($options['remove-dashicons'])) {
    /*
    |
    |   @since 0.1.9
    |   @wp-action wp_print_styles
    |
    */
    function omnictrl_remove_dashicons() {
        if (!is_user_logged_in()) {
            wp_deregister_style('dashicons');
        }
    }
    add_action('wp_print_styles', 'omnictrl_remove_dashicons', 99);
}

if (!empty($options['remove-gutenberg-css'])) {
    /*
    |
    |   @since 0.2.1
    |   @wp-action wp_print_styles
    |
    */
    function omnictrl_remove_gutenberg_css() {
        wp_dequeue_style('wp-block-library');
    }
    add_action('wp_print_styles', 'omnictrl_remove_gutenberg_css', 100);
}

if (!empty($options['remove-jquery-migrate'])) {
    /*
    |
    |   Removes the jQuery Migrate script from the jQuery bundle
    |
    |   @since 0.0.1
    |   @wp-action wp_default_scripts
    |   @param WP_Scripts $scripts WP_Scripts object.
    |
    */
    function omnictrl_remove_jquery_migrate($scripts) {
        if (isset($scripts->registered['jquery'])) {
            $script = $scripts->registered['jquery'];

            if ($script->deps) {
                $script->deps = array_diff($script->deps, ['jquery-migrate']);
            }
        }
    }
    add_action('wp_default_scripts', 'omnictrl_remove_jquery_migrate');
}

if (!empty($options['remove-css-js-query-strings'])) {
    /*
    |
    |   @since 0.0.1
    |   @wp-filter script_loader_src
    |   @wp-filter style_loader_src
    |
    */
    function omnictrl_remove_query_string($src) {
        return add_query_arg('ver', null, $src);
    }
    add_filter('script_loader_src', 'omnictrl_remove_query_string', 15, 1);
    add_filter('style_loader_src', 'omnictrl_remove_query_string', 15, 1);
}

if (!empty($options['remove-http-headers-shortlink'])) {
    remove_action('template_redirect', 'wp_shortlink_header', 11);
}

if (!empty($options['remove-update-maintenance-nag'])) {
    /*
    |
    |   @since 0.1.6
    |   @wp-action admin_head
    |
    */
    function omnictrl_remove_update_maintenance_nag() {
        if (!current_user_can('update_core')) {
            remove_action('admin_notices', 'update_nag', 3);
            remove_action('admin_notices', 'maintenance_nag', 10);
        }
    }
    add_action('admin_head', 'omnictrl_remove_update_maintenance_nag', 1);
}

if (!empty($options['remove-help-tabs'])) {
    /*
    |
    |   @wp-action admin_head
    |
    */
    function omnictrl_remove_help_tabs() {
        $screen = get_current_screen();
        $screen->remove_help_tabs();
    }
    add_action('admin_head', 'omnictrl_remove_help_tabs');
}

if (!empty($options['remove-admin-footer-message'])) {
    add_filter('admin_footer_text', '__return_empty_string');
}

if (!empty($options['remove-admin-footer-version'])) {
    add_filter('update_footer', '__return_empty_string', 11);
}

if (!empty($options['remove-wp-toolbar-wp-menu'])) {
    /*
    |
    |   @since 0.0.1
    |
    |   @wp-action admin_bar_menu
    |
    */
    function omnictrl_wp_toolbar_remove_wp_logo($wptb) {
        $wptb->remove_node('wp-logo');
    }
    add_action('admin_bar_menu', 'omnictrl_wp_toolbar_remove_wp_logo', 99);
}

if (!empty($options['remove-wp-toolbar-customize'])) {
    /*
    |
    |   @since 0.1.3
    |
    |   @wp-action admin_bar_menu
    |
    */
    function omnictrl_wp_toolbar_remove_customize($wptb) {
        $wptb->remove_node('customize');
    }
    add_action('admin_bar_menu', 'omnictrl_wp_toolbar_remove_customize', 99);
}

if (!empty($options['remove-howdy'])) {
    /*
    |
    |   @wp-filter admin_bar_menu
    |
    */
    function omnictrl_remove_howdy($wptb) {
        $node = $wptb->get_node('my-account');
        $text = str_replace('Howdy, ', '', $node->title);

        $wptb->add_node([
            'id' => 'my-account',
            'title' => $text,
        ]);
    }
    add_filter('admin_bar_menu', 'omnictrl_remove_howdy', 25);
}

if (!empty($options['remove-wp-toolbar-updraftplus'])) {
    /*
    |
    |   @since 0.1.7
    |
    */
    define('UPDRAFTPLUS_ADMINBAR_DISABLE', true);
}
