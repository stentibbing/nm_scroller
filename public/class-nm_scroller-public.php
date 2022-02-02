<?php

/**
 * The public-facing functionality of the plugin.
 */
class Nm_scroller_Public
{

    /**
     * The ID of this plugin.
     */
    private $plugin_name;
    
    /**
     * The version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     */
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     */
    public function enqueue_styles()
    {
        wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/nm_scroller-public.css', array(), $this->version, 'all');
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     */
    public function enqueue_scripts()
    {
        wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/nm_scroller-public.js', array( 'jquery' ), $this->version, false);
        wp_enqueue_script('jquery_color', plugin_dir_url(__FILE__) . 'js/jquery-color.js', array( 'jquery' ), $this->version, false);
    }

    /**
     * Register shortcode to display scroller
     */
    public function add_shortcodes()
    {
        add_shortcode('nm_scroller', array($this, 'render_scroller_pages'));
    }

    /**
     * Check if scroller pages have wp_bakery styles as meta
     * and add these as inline styles to existing css
     */
    public function add_inline_styles()
    {
        $inline_css = "";
        $args = array(
            'post_type' => 'scroller',
            'nopaging' => true,
        );
        foreach (get_posts($args) as $page) {
            if (array_key_exists('_wpb_shortcodes_custom_css', get_post_meta($page->ID))) {
                foreach (get_post_meta($page->ID)['_wpb_shortcodes_custom_css'] as $custom_style) {
                    $inline_css .= $custom_style;
                }
            }
        }
        if (!empty($inline_css)) {
            wp_add_inline_style($this->plugin_name, $inline_css);
        }
    }

    /**
     * Render scroller pages
     */
    public function render_scroller_pages()
    {
        $args = array(
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'post_type' => 'scroller',
            'nopaging' => true,
        );
        $scroller_pages = get_posts($args);
        
        return require plugin_dir_path(__FILE__) . '/partials/nm_scroller-public-view.php';
    }
}
