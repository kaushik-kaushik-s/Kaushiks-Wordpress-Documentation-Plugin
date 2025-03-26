<?php
defined('ABSPATH') or die('No script kiddies please!');

class KaushikSannidhi_Documentation_Public {
    public function enqueue_styles() {
        wp_enqueue_style(
            'kaushik-sannidhi-docs-styles', 
            plugin_dir_url(__FILE__) . 'assets/css/documentation-styles.css', 
            [], 
            '1.0.0', 
            'all'
        );
    }

    public function enqueue_scripts() {
        wp_enqueue_script(
            'kaushik-sannidhi-docs-search', 
            plugin_dir_url(__FILE__) . 'assets/js/documentation-search.js', 
            ['jquery'], 
            '1.0.0', 
            true
        );

        wp_localize_script('kaushik-sannidhi-docs-search', 'docSearchParams', [
            'ajaxurl' => admin_url('admin-ajax.php')
        ]);
    }

    public function render_documentation_page() {
        $documentation_categories = get_terms([
            'taxonomy' => 'documentation_category',
            'hide_empty' => false
        ]);

        ob_start();
        ?>
        <div class="documentation-page">
            <div class="documentation-header">
                <h1>Documentation</h1>
                <?php echo do_shortcode('[documentation_search]'); ?>
            </div>

            <div class="documentation-categories">
                <?php foreach ($documentation_categories as $category): ?>
                    <div class="category-section">
                        <h2><?php echo esc_html($category->name); ?></h2>
                        <?php 
                        echo do_shortcode('[documentation_list category="' . $category->slug . '" posts_per_page="5"]');
                        ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}