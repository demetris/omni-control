<?php

/**
 *
 *
 *  @since 0.1.0
 *
 *
 */

namespace OmniCtrl;

/**
 *
 *
 *  @since 0.1.0
 *  @wp-action admin_menu
 *
 *
 */
function admin_menu() {
    add_options_page(
        __('Omni Control Settings', 'omni-control'),
        __('Omni Control', 'omni-control'),
        'manage_options',
        'omni-control',
        'OmniCtrl\options_page'
    );
}
add_action('admin_menu', 'OmniCtrl\admin_menu');

/**
 *
 *
 *  @since 0.1.0
 *
 *
 */
function options_page(): void {
    echo '<div class="wrap">' . "\n";

    echo '<h2>' . __('Omni Control', 'omni-control') . '</h2>' . "\n";

    echo '<div class="select-unselect-all">';
    submit_button(__('Select All', 'omni-control'), 'secondary', 'omnictrl-select-all', false);
    submit_button(__('Deselect All', 'omni-control'), 'secondary', 'omnictrl-unselect-all', false);
    echo '</div>';

    echo '<form action="options.php" method="post">' . "\n";
    settings_fields('omnictrl');
    do_settings_sections('omnictrl');
    submit_button();
    echo '</form>' . "\n";

    echo '</div>' . "\n";
}

/**
 *
 *
 *  @since 0.1.0
 *  @wp-action admin_init
 *
 *
 */
function settings_init() {
    register_setting('omnictrl', 'omnictrl');

    #
    #   Settings: Miscellaneous
    #

    add_settings_section(
        'omnictrl-misc',
        __('Miscellaneous', 'omni-control'),
        null,
        'omnictrl'
    );

    add_settings_field(
        'disable-smilies',
        __('Disable smilies', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-misc',
        [
            'field' => 'disable-smilies',
            'label_for' => 'omnictrl[disable-smilies]'
        ]
    );

    add_settings_field(
        'disable-visual-editor',
        __('Disable visual editor', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-misc',
        [
            'field' => 'disable-visual-editor',
            'label_for' => 'omnictrl[disable-visual-editor]'
        ]
    );

    add_settings_field(
        'disable-pings',
        __('Disable pings completely', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-misc',
        [
            'field' => 'disable-pings',
            'label_for' => 'omnictrl[disable-pings]'
        ]
    );

    add_settings_field(
        'remove-meta-widget-wordpress-link',
        __('Remove WordPress.org link from meta widget', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-misc',
        [
            'field' => 'remove-meta-widget-wordpress-link',
            'label_for' => 'omnictrl[remove-meta-widget-wordpress-link]'
        ]
    );

    add_settings_field(
        'reverse-document-title-parts',
        __('Reverse the parts of the document title', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-misc',
        [
            'field' => 'reverse-document-title-parts',
            'label_for' => 'omnictrl[reverse-document-title-parts]'
        ]
    );

    #
    #   Settings: HTML document
    #

    add_settings_section(
        'omnictrl-html-doc',
        __('HTML document', 'omni-control'),
        null,
        'omnictrl'
    );

    add_settings_field(
        'remove-doc-css-js-type',
        __('Remove type from CSS and JavaScript resources', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-html-doc',
        [
            'field' => 'remove-doc-css-js-type',
            'label_for' => 'omnictrl[remove-doc-css-js-type]'
        ]
    );

    #
    #   Settings: HTML document head
    #

    add_settings_section(
        'omnictrl-html-doc-head',
        __('HTML document HEAD', 'omni-control'),
        null,
        'omnictrl'
    );

    add_settings_field(
        'remove-doc-head-rsd-link',
        __('Remove RSD link', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-html-doc-head',
        [
            'field' => 'remove-doc-head-rsd-link',
            'label_for' => 'omnictrl[remove-doc-head-rsd-link]'
        ]
    );

    add_settings_field(
        'remove-doc-head-wlw-manifest-link',
        __('Remove WLW manifest link', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-html-doc-head',
        [
            'field' => 'remove-doc-head-wlw-manifest-link',
            'label_for' => 'omnictrl[remove-doc-head-wlw-manifest-link]'
        ]
    );

    add_settings_field(
        'remove-doc-head-rest-api-link',
        __('Remove REST API link', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-html-doc-head',
        [
            'field' => 'remove-doc-head-rest-api-link',
            'label_for' => 'omnictrl[remove-doc-head-rest-api-link]'
        ]
    );

    add_settings_field(
        'remove-doc-head-shortlink',
        __('Remove shortlink', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-html-doc-head',
        [
            'field' => 'remove-doc-head-shortlink',
            'label_for' => 'omnictrl[remove-doc-head-shortlink]'
        ]
    );

    add_settings_field(
        'remove-doc-head-prev-next-rel-links',
        __('Remove prev/next rel links', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-html-doc-head',
        [
            'field' => 'remove-doc-head-prev-next-rel-links',
            'label_for' => 'omnictrl[remove-doc-head-prev-next-rel-links]'
        ]
    );

    add_settings_field(
        'remove-doc-head-canonical-link',
        __('Remove canonical link', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-html-doc-head',
        [
            'field' => 'remove-doc-head-canonical-link',
            'label_for' => 'omnictrl[remove-doc-head-canonical-link]'
        ]
    );

    add_settings_field(
        'remove-doc-head-wordpress-version',
        __('Remove WordPress version', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-html-doc-head',
        [
            'field' => 'remove-doc-head-wordpress-version',
            'label_for' => 'omnictrl[remove-doc-head-wordpress-version]'
        ]
    );

    #
    #   Settings: Performance
    #

    add_settings_section(
        'omnictrl-perf',
        __('Performance', 'omni-control'),
        null,
        'omnictrl'
    );

    add_settings_field(
        'remove-dashicons',
        __('Remove Dashicons CSS for visitors', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-perf',
        [
            'field' => 'remove-dashicons',
            'label_for' => 'omnictrl[remove-dashicons]'
        ]
    );

    add_settings_field(
        'remove-gutenberg-css',
        __('Remove Gutenberg CSS', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-perf',
        [
            'field' => 'remove-gutenberg-css',
            'label_for' => 'omnictrl[remove-gutenberg-css]'
        ]
    );

    add_settings_field(
        'remove-jquery-migrate',
        __('Remove jQuery Migrate', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-perf',
        [
            'field' => 'remove-jquery-migrate',
            'label_for' => 'omnictrl[remove-jquery-migrate]'
        ]
    );

    add_settings_field(
        'remove-css-js-query-strings',
        __('Remove query string from static resources', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-perf',
        [
            'field' => 'remove-css-js-query-strings',
            'label_for' => 'omnictrl[remove-css-js-query-strings]'
        ]
    );

    #
    #   Settings: HTTP response headers
    #

    add_settings_section(
        'omnictrl-http-headers',
        __('HTTP response headers', 'omni-control'),
        null,
        'omnictrl'
    );

    add_settings_field(
        'remove-http-headers-shortlink',
        __('Remove shortlink', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-http-headers',
        [
            'field' => 'remove-http-headers-shortlink',
            'label_for' => 'omnictrl[remove-http-headers-shortlink]'
        ]
    );

    add_settings_field(
        'remove-http-headers-rest-api-link',
        __('Remove REST API link', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-http-headers',
        [
            'field' => 'remove-http-headers-rest-api-link',
            'label_for' => 'omnictrl[remove-http-headers-rest-api-link]'
        ]
    );

    #
    #   Settings: Administration area
    #

    add_settings_section(
        'omnictrl-admin',
        __('Administration area', 'omni-control'),
        null,
        'omnictrl'
    );

    add_settings_field(
        'remove-update-maintenance-nag',
        __('Remove update/maintenance nag for non-admins', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-admin',
        [
            'field' => 'remove-update-maintenance-nag',
            'label_for' => 'omnictrl[remove-update-maintenance-nag]'
        ]
    );

    add_settings_field(
        'remove-help-tabs',
        __('Remove help tabs', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-admin',
        [
            'field' => 'remove-help-tabs',
            'label_for' => 'omnictrl[remove-help-tabs]'
        ]
    );

    add_settings_field(
        'remove-admin-footer-message',
        __('Remove message from footer', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-admin',
        [
            'field' => 'remove-admin-footer-message',
            'label_for' => 'omnictrl[remove-admin-footer-message]'
        ]
    );

    add_settings_field(
        'remove-admin-footer-version',
        __('Remove version from footer', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-admin',
        [
            'field' => 'remove-admin-footer-version',
            'label_for' => 'omnictrl[remove-admin-footer-version]'
        ]
    );

    #
    #   Settings: WP Toolbar
    #

    add_settings_section(
        'omnictrl-wp-toolbar',
        __('WP Toolbar', 'omni-control'),
        null,
        'omnictrl'
    );

    add_settings_field(
        'remove-wp-toolbar-wp-menu',
        __('Remove WordPress menu', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-wp-toolbar',
        [
            'field' => 'remove-wp-toolbar-wp-menu',
            'label_for' => 'omnictrl[remove-wp-toolbar-wp-menu]'
        ]
    );

    add_settings_field(
        'remove-wp-toolbar-customize',
        __('Remove Customize link', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-wp-toolbar',
        [
            'field' => 'remove-wp-toolbar-customize',
            'label_for' => 'omnictrl[remove-wp-toolbar-customize]'
        ]
    );

    add_settings_field(
        'remove-howdy',
        __('Remove <em>Howdy</em>', 'omni-control'),
        'OmniCtrl\render_checkbox',
        'omnictrl',
        'omnictrl-wp-toolbar',
        [
            'field' => 'remove-howdy',
            'label_for' => 'omnictrl[remove-howdy]'
        ]
    );

    if (class_exists('UpdraftPlus')) {
        add_settings_field(
            'remove-wp-toolbar-updraftplus',
            __('Remove UpdraftPlus menu', 'omni-control'),
            'OmniCtrl\render_checkbox',
            'omnictrl',
            'omnictrl-wp-toolbar',
            [
                'field' => 'remove-wp-toolbar-updraftplus',
                'label_for' => 'omnictrl[remove-wp-toolbar-updraftplus]'
            ]
        );
    }
}
add_action('admin_init', 'OmniCtrl\settings_init');

/**
 *
 *
 *  @since 0.1.0
 *
 *
 */
function render_checkbox($args): void {
    $options    = get_option('omnictrl');
    $field      = $args['field'];
    $name       = 'omnictrl[' . $field . ']';
    $retrieved  = isset($options[$field])? 1: 0;

    printf(
        '<input class="omnictrl-checkbox" type="checkbox" id="%1$s" name="%1$s" %2$s value="1"/>',
        $name,
        checked($retrieved, 1, 0)
    );
}
