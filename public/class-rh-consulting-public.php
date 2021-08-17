<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://reichbaum.ru
 * @since      1.0.0
 *
 * @package    Rh_Consulting
 * @subpackage Rh_Consulting/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Rh_Consulting
 * @subpackage Rh_Consulting/public
 * @author     Julia Reichbaum <reichbaumjulia@gmail.com>
 */
class Rh_Consulting_Public {

  /**
   * The ID of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $plugin_name    The ID of this plugin.
   */
  private $plugin_name;

  /**
   * The version of this plugin.
   *
   * @since    1.0.0
   * @access   private
   * @var      string    $version    The current version of this plugin.
   */
  private $version;

  /**
   * Initialize the class and set its properties.
   *
   * @since    1.0.0
   * @param      string    $plugin_name       The name of the plugin.
   * @param      string    $version    The version of this plugin.
   */
  public function __construct($plugin_name, $version) {

    $this->plugin_name = $plugin_name;
    $this->version = $version;
    $this->plugin_options = get_option($this->plugin_name);

  }

  /**
   * Register the stylesheets for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_styles() {

    /**
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in Rh_Consulting_Loader as all of the hooks are defined
     * in that particular class.
     *
     * The Rh_Consulting_Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */

    wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/rh-consulting-public.css', array(), $this->version, 'all');

  }

  /**
   * Register the JavaScript for the public-facing side of the site.
   *
   * @since    1.0.0
   */
  public function enqueue_scripts() {

    /**
     * This function is provided for demonstration purposes only.
     *
     * An instance of this class should be passed to the run() function
     * defined in Rh_Consulting_Loader as all of the hooks are defined
     * in that particular class.
     *
     * The Rh_Consulting_Loader will then create the relationship
     * between the defined hooks and the functions defined in this
     * class.
     */

    wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/rh-consulting-public.js', array('jquery'), $this->version, true);

  }

  public function register_post_types() {
    register_post_type('appointments', [
      'label' => 'appointments',
      'labels' => [
        'name' => 'Запись',
      ],
      'publicly_queryable' => false,
      'exclude_from_search' => true,
      'show_ui' => true,
      'show_in_nav_menus' => false,
      'show_in_menu' => $this->plugin_name,
      'show_in_admin_bar' => false,
      'show_in_rest' => true,
      'menu_position' => 1,
      'hierarchical' => true,
      'supports' => ['title'], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
      'taxonomies' => [],
      'has_archive' => false,
      'rewrite' => true,
      'query_var' => true,
    ]);
  }

  public function appointments_admin_order( $wp_query ) {
    if ( is_admin() && !isset( $_GET['orderby'] ) ) {     
      // Get the post type from the query
      $post_type = $wp_query->query['post_type'];
      if ( in_array( $post_type, array('appointments') ) ) {
        $wp_query->set('orderby', 'date');
        $wp_query->set('order', 'DESC');
      }
    }
  }

  public function save_posted_data() {

    $submission = WPCF7_Submission::get_instance();
    if ($submission) {
      $posted_data = $submission->get_posted_data();
    }

    $args = array(
      'post_type' => 'appointments',
      'post_title' => wp_strip_all_tags($posted_data['cf_name']),
    );
    if (!empty($posted_data['cf_name']) && !empty($posted_data['cf_mail'])) {
      $post_id = wp_insert_post($args);
      if (!is_wp_error($post_id)) {
        if (isset($posted_data['cf_date'])) {
          $newDate = date("Y-m-d", strtotime($posted_data['cf_date']));
          update_post_meta($post_id, 'cf_date', $newDate);
          update_post_meta($post_id, 'cf_userdate', $posted_data['cf_date']);
        }
        if (isset($posted_data['cf_time'])) {
          update_post_meta($post_id, 'cf_time', $posted_data['cf_time']);
        }
        if (isset($posted_data['cf_usertime'])) {
          update_post_meta($post_id, 'cf_usertime', $posted_data['cf_usertime']);
        }
        if (isset($posted_data['cf_timezone'])) {
          update_post_meta($post_id, 'cf_timezone', $posted_data['cf_timezone']);
        }
        if (isset($posted_data['cf_name'])) {
          update_post_meta($post_id, 'cf_name', sanitize_text_field($posted_data['cf_name']));
        }
        if (isset($posted_data['cf_mail'])) {
          update_post_meta($post_id, 'cf_mail', $posted_data['cf_mail']);
        }
        if (isset($posted_data['cf_phone'])) {
          update_post_meta($post_id, 'cf_phone', $posted_data['cf_phone']);
        }
        if (isset($posted_data['cf_lang'])) {
          update_post_meta($post_id, 'cf_lang', $posted_data['cf_lang']);
        }
        if (isset($posted_data['cf_messenger_choose'])) {
          update_post_meta($post_id, 'cf_messenger_choose', $posted_data['cf_messenger_choose']);
        }
        if (isset($posted_data['cf_messenger'])) {
          update_post_meta($post_id, 'cf_messenger', sanitize_text_field($posted_data['cf_messenger']));
        }
        if (isset($posted_data['cf_services'])) {
          update_post_meta($post_id, 'cf_services', $posted_data['cf_services']);
        }
        return $posted_data;
      }
    }
  }

  public function rh_consulting_form_shortcode($atts) {
    $options = get_option($this->plugin_name);
    ob_start();
    include_once 'partials/rh-consulting-public-display.php';
    construct_shortcode($options, $atts);
    return ob_get_clean();
  }

}