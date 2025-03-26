<?php
defined('ABSPATH') or die('No script kiddies please!');

class KaushikSannidhi_Documentation_Admin {
    public function add_documentation_menu() {
        add_menu_page(
            'Documentation Settings',
            'Documentation',
            'manage_options',
            'kaushik-sannidhi-docs-settings',
            [$this, 'render_settings_page'],
            'dashicons-book-alt',
            22
        );

        add_submenu_page(
            'kaushik-sannidhi-docs-settings',
            'Documentation Customization',
            'Customize',
            'manage_options',
            'kaushik-sannidhi-docs-customize',
            [$this, 'render_customization_page']
        );
    }

    public function register_settings() {
        register_setting('kaushik_sannidhi_docs_settings', 'documentation_display_options');

        add_settings_section(
            'documentation_display_section',
            'Documentation Display Settings',
            [$this, 'display_section_callback'],
            'kaushik-sannidhi-docs-settings'
        );

        add_settings_field(
            'show_sidebar_toc',
            'Show Table of Contents',
            [$this, 'show_sidebar_toc_callback'],
            'kaushik-sannidhi-docs-settings',
            'documentation_display_section'
        );
    }

    public function display_section_callback() {
        echo '<p>Configure how documentation is displayed across your site.</p>';
    }

    public function show_sidebar_toc_callback() {
        $options = get_option('documentation_display_options');
        $checked = isset($options['show_sidebar_toc']) ? checked($options['show_sidebar_toc'], 1, false) : '';
        echo '<input type="checkbox" id="show_sidebar_toc" name="documentation_display_options[show_sidebar_toc]" value="1"' . $checked . ' />';
        echo '<label for="show_sidebar_toc">Enable table of contents in documentation sidebar</label>';
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1>Kaushik Sannidhi Documentation Plugin</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('kaushik_sannidhi_docs_settings');
                do_settings_sections('kaushik-sannidhi-docs-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }

    public function render_customization_page() {
        ?>
        <div class="wrap">
            <h1>Documentation Customization</h1>
            <p>Additional customization options will be added here.</p>
        </div>
        <?php
    }
}