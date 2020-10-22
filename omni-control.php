<?php

/*
    OMNI CONTROL FOR WORDPRESS

    Plugin Name:            Omni Control
    Plugin URI:             https://github.com/demetris/omni-control
    Description:            A collection of tweaks for WordPress
    Version:                0.3.2
    Author:                 Demetris Kikizas
    Author URI:             https://kikizas.com/
    Licence:                GPL-2.0
    License URI:            https://opensource.org/licenses/GPL-2.0
    GitHub Plugin URI:      https://github.com/demetris/omni-control
*/

namespace OmniCtrl;

/**
 *
 *  Set constants
 *
 */
defined('OMNICTRL_VERSION') || define('OMNICTRL_VERSION', '0.3.0');

/**
 *
 *  Get required files
 *
 */
require dirname(__FILE__) . '/omni-control-settings.php';

/**
 *
 *
 *
 */
register_activation_hook(__FILE__, 'OmniCtrl\set_activation_hook');

/**
 *
 *  Creates transient data during activation
 *
 *  @since 0.1.0
 *
 */
function set_activation_hook() {
    set_transient('omnictrl-activation-notice', true, 10);
}

/**
 *
 *  Displays admin notice on activation if transient data is there
 *
 *  @since 0.1.0
 *  @wp-action admin_notices
 *
 */
function admin_notices_activation() {
    if (get_transient('omnictrl-activation-notice')) {
        $text = __('Omni Control settings', 'omni-control');
        $href = admin_url('options-general.php?page=omni-control');
        $link = '<a style="text-decoration: none" href="' . $href . '">' . $text . '</a>';

        echo '<div class="updated notice is-dismissible">';
        echo '<p>' . sprintf(__('Please, visit the %s to set your preferences.', 'omni-control'), $link) . '</p>';
        echo '</div>';

        /**
         *
         *   Deletes transient data created on activation
         *
         */
        delete_transient('omnictrl-activation-notice');
    }
}
add_action('admin_notices', 'OmniCtrl\admin_notices_activation');

/**
 *
 *  @since 0.1.0
 *  @wp-action admin_enqueue_scripts
 *
 */
function enqueue_admin_assets() {
    if (get_current_screen()->id !== 'settings_page_omni-control') {
        return;
    }

    wp_enqueue_script('omni-control-admin', plugin_dir_url(__FILE__) . 'assets/js/main.js', ['jquery'], OMNICTRL_VERSION, true);
    wp_enqueue_style('omni-control-admin', plugin_dir_url(__FILE__) . 'assets/css/main.css', [], OMNICTRL_VERSION);
}
add_action('admin_enqueue_scripts', 'OmniCtrl\enqueue_admin_assets');

/**
 *
 *  Retrieve and store plugin settings from database
 *
 */
$options = get_option('omnictrl');

/**
 *
 *  Appends link to settings screen by filtering the plugin’s action links array
 *
 *  @since 0.1.0
 *  @wp-filter plugin_action_links_
 *
 */
function add_action_links(array $links): array {
    $link = [
        '<a href="' . admin_url('options-general.php?page=omni-control') . '">' . __('Settings', 'omni-control') . '</a>'
    ];

    return array_merge($links, $link);
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'OmniCtrl\add_action_links');

/**
 *
 *  Disable smilies
 *
 */
if (!empty($options['disable-smilies'])) {
    add_filter('option_use_smilies', '__return_false');
}

/**
 *
 *  Disable wptexturize()
 *
 */
if (!empty($options['disable-wptexturize'])) {
    add_filter('run_wptexturize', '__return_false');
}

/**
 *
 *  Disable visual editor
 *
 */
if (!empty($options['disable-visual-editor'])) {
    add_filter('user_can_richedit', '__return_false');
}

/**
 *
 *  Disable pingbacks completely
 *
 */
if (!empty($options['disable-pings'])) {
    add_filter('pings_open', '__return_false');
}

/**
 *
 *  Remove WordPress.org link from meta widget
 *
 */
if (!empty($options['remove-meta-widget-wordpress-link'])) {
    add_filter('widget_meta_poweredby', '__return_empty_string');
}

/**
 *
 *  Reverse document title parts
 *
 */
if (!empty($options['reverse-document-title-parts'])) {
    /**
     *
     *  Moves site name to start of document title
     *
     *  The + (Union) operator returns the right-hand array appended to the left-hand array.
     *  For keys that exist in both arrays, the elements from the left-hand array will be used,
     *  and the matching elements from the right-hand array will be ignored.
     *
     *  @since 0.1.0
     *  @link http://php.net/manual/en/language.operators.array.php
     *  @wp-filter document_title_parts
     *
     */
    function reverse_document_title_parts(array $title): array {
        $sitename = '';

        if (isset($title['site'])) {
            $sitename = $title['site'];
        }

        return ['site' => $sitename] + $title;
    }
    add_filter('document_title_parts', 'OmniCtrl\reverse_document_title_parts');
}

/**
 *
 *  Remove type from script and style elements
 *
 */
if (!empty($options['remove-doc-script-style-type'])) {
    /**
     *
     *  @since 0.1.5
     *  @since 0.3.0 Do nothing if there is nothing to remove
     *  @wp-filter style_loader_tag
     *
     */
    function remove_script_type(string $html): string {
        if (get_theme_support('html5') && isset(array_flip(get_theme_support('html5')[0])['script'])) {
            return $html;
        }

        $html = str_replace("type='text/javascript' ", '', $html);
        $html = str_replace(' type="text/javascript"', '', $html);

        return $html;
    }
    add_filter('script_loader_tag', 'OmniCtrl\remove_script_type');

    /**
     *
     *  @since 0.1.5
     *  @since 0.3.0 Do nothing if there is nothing to remove
     *  @wp-filter script_loader_tag
     *
     */
    function remove_style_type(string $html): string {
        if (get_theme_support('html5') && isset(array_flip(get_theme_support('html5')[0])['style'])) {
            return $html;
        }

        return str_replace("type='text/css' ", '', $html);
    }
    add_filter('style_loader_tag', 'OmniCtrl\remove_style_type');
}

/**
 *
 *
 *
 */
if (!empty($options['remove-doc-head-rsd-link'])) {
    remove_action('wp_head', 'rsd_link');
}

/**
 *
 *
 *
 */
if (!empty($options['remove-doc-head-wlw-manifest-link'])) {
    remove_action('wp_head', 'wlwmanifest_link');
}

/**
 *
 *
 *
 */
if (!empty($options['remove-doc-head-rest-api-link'])) {
    remove_action('wp_head', 'rest_output_link_wp_head', 10);
}

/**
 *
 *
 *
 */
if (!empty($options['remove-doc-head-shortlink'])) {
    remove_action('wp_head', 'wp_shortlink_wp_head', 10);
}

/**
 *
 *
 *
 */
if (!empty($options['remove-doc-head-prev-next-rel-links'])) {
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
}

/**
 *
 *  Remove canonical link from document HEAD
 *
 */
if (!empty($options['remove-doc-head-canonical-link'])) {
    remove_action('wp_head', 'rel_canonical');
}

/**
 *
 *  Remove WordPress version from document HEAD
 *
 */
if (!empty($options['remove-doc-head-wordpress-version'])) {
    remove_action('wp_head', 'wp_generator');
}

/**
 *
 *
 *
 */
if (!empty($options['remove-dashicons'])) {
    /**
     *
     *  @since 0.1.9
     *  @wp-action wp_print_styles
     *
     */
    function remove_dashicons() {
        if (!is_user_logged_in()) {
            wp_deregister_style('dashicons');
        }
    }
    add_action('wp_print_styles', 'OmniCtrl\remove_dashicons', 99);
}

/**
 *
 *  Remove Gutenberg CSS
 *
 */
if (!empty($options['remove-gutenberg-css'])) {
    /**
     *
     *  @since 0.2.1
     *  @wp-action wp_print_styles
     *
     */
    function remove_gutenberg_css() {
        wp_dequeue_style('wp-block-library');
    }
    add_action('wp_print_styles', 'OmniCtrl\remove_gutenberg_css', 100);
}

/**
 *
 *  Remove jQuery Migrate
 *
 */
if (!empty($options['remove-jquery-migrate'])) {
    /**
     *
     *  Removes the jQuery Migrate script from the jQuery bundle
     *
     *  @since 0.1.0
     *  @wp-action wp_default_scripts
     *  @param WP_Scripts $scripts WP_Scripts object.
     *
     */
    function remove_jquery_migrate(\WP_Scripts $scripts) {
        if (isset($scripts->registered['jquery'])) {
            $script = $scripts->registered['jquery'];

            if ($script->deps) {
                $script->deps = array_diff($script->deps, ['jquery-migrate']);
            }
        }
    }
    add_action('wp_default_scripts', 'OmniCtrl\remove_jquery_migrate');
}

/**
 *
 *
 *
 */
if (!empty($options['remove-css-js-query-strings'])) {
    /**
     *
     *  @since 0.1.0
     *  @wp-filter script_loader_src
     *  @wp-filter style_loader_src
     *
     */
    function remove_query_string(string $src): string {
        return add_query_arg('ver', null, $src);
    }
    add_filter('script_loader_src', 'OmniCtrl\remove_query_string', 15, 1);
    add_filter('style_loader_src', 'OmniCtrl\remove_query_string', 15, 1);
}

/**
 *
 *  Remove shortlink from HTTP headers
 *
 */
if (!empty($options['remove-http-headers-shortlink'])) {
    remove_action('template_redirect', 'wp_shortlink_header', 11);
}

/**
 *
 *  Remove REST API link from HTTP headers
 *
 */
if (!empty($options['remove-http-headers-rest-api-link'])) {
    remove_action('template_redirect', 'rest_output_link_header', 11, 0);
}

/**
 *
 *  Disable update/maintenance nag for non-admins
 *
 */
if (!empty($options['disable-update-maintenance-nag'])) {
    /**
     *
     *  @since 0.1.6
     *  @wp-action wp_head
     *
     */
    function disable_update_maintenance_nag() {
        if (!current_user_can('update_core')) {
            remove_action('admin_notices', 'update_nag', 3);
            remove_action('admin_notices', 'maintenance_nag', 10);
        }
    }
    add_action('admin_head', 'OmniCtrl\disable_update_maintenance_nag', 1);
}

/**
 *
 *  Remove help tabs from dashboard
 *
 */
if (!empty($options['remove-help-tabs'])) {
    /**
     *
     *  @since 0.1.0
     *  @wp-action admin_head
     *
     */
    function remove_help_tabs() {
        $screen = get_current_screen();

        if ($screen) {
            $screen->remove_help_tabs();
        }
    }
    add_action('admin_head', 'OmniCtrl\remove_help_tabs');
}

/**
 *
 *  Remove message from dashboard footer
 *
 */
if (!empty($options['remove-admin-footer-message'])) {
    add_filter('admin_footer_text', '__return_empty_string');
}

/**
 *
 *  Remove WordPress version from dashboard footer
 *
 */
if (!empty($options['remove-admin-footer-version'])) {
    add_filter('update_footer', '__return_empty_string', 11);
}

/**
 *
 *  Remove WordPress menu from admin bar
 *
 */
if (!empty($options['remove-adminbar-wp-menu'])) {
    /**
     *
     *  @since 0.1.0
     *  @wp-action admin_bar_menu
     *
     */
    function remove_adminbar_wp_menu(\WP_Admin_Bar $adminbar): void {
        $adminbar->remove_node('wp-logo');
    }
    add_action('admin_bar_menu', 'OmniCtrl\remove_adminbar_wp_menu', 99);
}

/**
 *
 *  Remove Customize link from admin bar
 *
 */
if (!empty($options['remove-adminbar-customize'])) {
    /**
     *
     *  @since 0.1.4
     *  @wp-action admin_bar_menu
     *
     */
    function remove_adminbar_customize(\WP_Admin_Bar $adminbar): void {
        $adminbar->remove_node('customize');
    }
    add_action('admin_bar_menu', 'OmniCtrl\remove_adminbar_customize', 99);
}

/**
 *
 *  Remove Howdy
 *
 */
if (!empty($options['remove-howdy'])) {
    /**
     *
     *  @since 0.1.0
     *  @wp-filter admin_bar_menu
     *
     */
    function remove_howdy($adminbar) {
        $node = $adminbar->get_node('my-account');
        $text = str_replace('Howdy, ', '', $node->title);

        $adminbar->add_node([
            'id' => 'my-account',
            'title' => $text,
        ]);
    }
    add_filter('admin_bar_menu', 'OmniCtrl\remove_howdy', 25);
}

/**
 *
 *  Remove UpdraftPlus menu from admin bar
 *
 */
if (!empty($options['remove-adminbar-updraftplus'])) {
    define('UPDRAFTPLUS_ADMINBAR_DISABLE', true);
}
