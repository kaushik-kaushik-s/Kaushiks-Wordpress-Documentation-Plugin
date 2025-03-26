<?php
defined('ABSPATH') or die('No script kiddies please!');

class KaushikSannidhi_Documentation_Search {
    public function __construct() {
        add_action('pre_get_posts', [$this, 'custom_documentation_search']);
        add_shortcode('documentation_search', [$this, 'documentation_search_shortcode']);
    }

    public function custom_documentation_search($query) {
        if ($query->is_search() && $query->is_main_query()) {
            $query->set('post_type', ['documentation', 'post']);
        }
    }

    public function documentation_search_shortcode($atts) {
        ob_start();
        ?>
        <div class="documentation-search-container">
            <form role="search" method="get" class="documentation-search-form" action="<?php echo esc_url(home_url('/')); ?>">
                <input type="search" class="documentation-search-field" 
                       placeholder="Search Documentation" 
                       value="<?php echo get_search_query(); ?>" 
                       name="s" 
                       title="Search for:" />
                <input type="hidden" name="post_type[]" value="documentation" />
                <button type="submit" class="documentation-search-submit">Search</button>
            </form>
        </div>
        <?php
        return ob_get_clean();
    }
}