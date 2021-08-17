<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://reichbaum.ru
 * @since      1.0.0
 *
 * @package    Rh_Consulting
 * @subpackage Rh_Consulting/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Rh_Consulting
 * @subpackage Rh_Consulting/admin
 * @author     Julia Reichbaum <reichbaumjulia@gmail.com>
 */
class Rh_Consulting_Admin {

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
   * @param      string    $plugin_name       The name of this plugin.
   * @param      string    $version    The version of this plugin.
   */
  public function __construct($plugin_name, $version) {

    $this->plugin_name = $plugin_name;
    $this->version = $version;
    add_action('add_meta_boxes', array($this, 'add_meta_box'));
    add_action('save_post', array($this, 'save_metabox'));
  }

  /**
   * Register the stylesheets for the admin area.
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

    wp_enqueue_style('bootstrap', plugin_dir_url(__FILE__) . 'css/bootstrap.min.css', array(), $this->version, 'all');
    wp_enqueue_style('bootstrap-datepicker-css', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css', array(), $this->version, 'all');
    wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/rh-consulting-admin.css', array(), $this->version, 'all');

  }

  /**
   * Register the JavaScript for the admin area.
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
    wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array(), $this->version, false);
    wp_enqueue_script('bootstrap-datepicker-js', 'https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js', array(), $this->version, false);

    wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/rh-consulting-admin.js', array('jquery'), $this->version, false);

  }

  /**
   * Register the administration menu for this plugin into the WordPress Dashboard menu.
   *
   * @since    1.0.0
   */
  public function add_rh_consulting_admin_menu() {
    /*
     * Add a settings page for this plugin to the Settings menu.
     *
     * NOTE:  Alternative menu locations are available via WordPress administration menu functions.
     *
     *        Administration Menus: http://codex.wordpress.org/Administration_Menus
     *
     */
    add_menu_page('Запись на консультацию', 'Консультации', 'manage_options', $this->plugin_name, array($this, 'display_rh_consulting_setup_page'), 'dashicons-format-chat', 5);

    add_submenu_page($this->plugin_name, 'Настройки', 'Настройки', 'manage_options', $this->plugin_name . '-settings', array($this, 'display_rh_consulting_setup_page'));
  }

  /**
   * Add settings action link to the plugins page.
   *
   * @since    1.0.0
   */
  public function add_action_links($links) {
    /*
     *  Documentation : https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
     */
    $settings_link = array('<a href="' . admin_url('options-general.php?page=' . $this->plugin_name) . '">' . __('Settings', $this->plugin_name) . '</a>');
    return array_merge($settings_link, $links);
  }

  /**
   * Render the settings page for this plugin.
   *
   * @since    1.0.0
   */
  public function display_rh_consulting_setup_page() {
    include_once 'partials/rh-consulting-admin-display.php';
  }

  /**
   *  Save the plugin options
   *
   *
   * @since    1.0.0
   */
  public function options_update() {
    register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
  }

  /**
   * Validate all options fields
   *
   * @since    1.0.0
   */
  public function validate($input) {
    // All checkboxes inputs
    $valid = array();

    // Test
    $valid['form_theme'] = (isset($input['form_theme']) && !empty($input['form_theme'])) ? 1 : 0;

    $valid['form_title'] = (isset($input['form_title']) && !empty($input['form_title'])) ? sanitize_text_field($input['form_title']) : '';
    $valid['form_title_en'] = (isset($input['form_title_en']) && !empty($input['form_title_en'])) ? sanitize_text_field($input['form_title_en']) : '';
    $valid['form_description'] = (isset($input['form_description']) && !empty($input['form_description'])) ? sanitize_text_field($input['form_description']) : '';
    $valid['form_description_en'] = (isset($input['form_description_en']) && !empty($input['form_description_en'])) ? sanitize_text_field($input['form_description_en']) : '';
    $valid['form_time'] = (isset($input['form_time']) && !empty($input['form_time'])) ? sanitize_text_field($input['form_time']) : '';
    $valid['form_time_en'] = (isset($input['form_time_en']) && !empty($input['form_time_en'])) ? sanitize_text_field($input['form_time_en']) : '';
    $valid['form_date_title'] = (isset($input['form_date_title']) && !empty($input['form_date_title'])) ? sanitize_text_field($input['form_date_title']) : '';
    $valid['form_date_title_en'] = (isset($input['form_date_title_en']) && !empty($input['form_date_title_en'])) ? sanitize_text_field($input['form_date_title_en']) : '';
    $valid['form_time_title'] = (isset($input['form_time_title']) && !empty($input['form_time_title'])) ? sanitize_text_field($input['form_time_title']) : '';
    $valid['form_time_title_en'] = (isset($input['form_time_title_en']) && !empty($input['form_time_title_en'])) ? sanitize_text_field($input['form_time_title_en']) : '';
    $valid['form_timezone_title'] = (isset($input['form_timezone_title']) && !empty($input['form_timezone_title'])) ? sanitize_text_field($input['form_timezone_title']) : '';
    $valid['form_timezone_title_en'] = (isset($input['form_timezone_title_en']) && !empty($input['form_timezone_title_en'])) ? sanitize_text_field($input['form_timezone_title_en']) : '';
    $valid['form_confirm'] = (isset($input['form_confirm']) && !empty($input['form_confirm'])) ? sanitize_text_field($input['form_confirm']) : '';
    $valid['form_confirm_en'] = (isset($input['form_confirm_en']) && !empty($input['form_confirm_en'])) ? sanitize_text_field($input['form_confirm_en']) : '';
    $valid['form_contact_id'] = (isset($input['form_contact_id']) && !empty($input['form_contact_id'])) ? sanitize_text_field($input['form_contact_id']) : '';
    $valid['form_contact_id_en'] = (isset($input['form_contact_id_en']) && !empty($input['form_contact_id_en'])) ? sanitize_text_field($input['form_contact_id_en']) : '';
    $valid['form_contact_title'] = (isset($input['form_contact_title']) && !empty($input['form_contact_title'])) ? sanitize_text_field($input['form_contact_title']) : '';
    $valid['form_contact_title_en'] = (isset($input['form_contact_title_en']) && !empty($input['form_contact_title_en'])) ? sanitize_text_field($input['form_contact_title_en']) : '';
    $valid['form_disabled_dates'] = (isset($input['form_disabled_dates']) && !empty($input['form_disabled_dates'])) ? sanitize_text_field($input['form_disabled_dates']) : '';

    if (isset($input['form_available_time'])) {
      $iter = 0;
      foreach ($input['form_available_time'] as $time) {
        $valid['form_available_time'][$iter]['time'] = (isset($time['time']) && !empty($time['time'])) ? sanitize_text_field($time['time']) : '';
        $valid['form_available_time'][$iter]['available'] = (isset($time['available']) && !empty($time['available'])) ? 1 : 0;
        $iter++;
      }
    }

    return $valid;
  }

  //Add Metabox for Appointments
  public function add_meta_box() {
    add_meta_box('appointments_meta', __('Consulting Data'), array($this, 'render_meta_box_content'), 'appointments', 'normal', 'high');
  }

  public function render_meta_box_content($post) {
    wp_nonce_field($this->plugin_name, 'rh_consulting_noncename');?>
<div id="appointments">
  <table class="table table-striped">
    <thead>
      <tr>
        <th class="left">Поле</th>
        <th>Значение</th>
      </tr>
    </thead>
    <tbody id="appointments_list" data-wp-lists="list:meta">
    <tr id="appointments_services">
        <td class="left">Услуги</td>
        <td><?php $services = get_post_meta($post->ID, 'cf_services', true);
    foreach ($services as $service) {echo '<p>' . $service . '</p>';}?></td>
      </tr>
      <tr id="appointments_date">
        <?php if (get_post_meta($post->ID, 'cf_date', true)) {
      $date = get_post_meta($post->ID, 'cf_date', true);
      $newDate = date("Y-m-d", strtotime($date));
    } else {
      $newDate = '';
    }
    ?>
        <td class="left">Дата консультации (дд.мм.гггг)</td>
        <td><input class="form-control" type="date" name="cf_date" value="<?php echo $newDate; ?>" /></td>
      </tr>
      <tr id="appointments_time">
        <td class="left">Время консультации (UTC-5)</td>
        <td><input class="form-control" type="text" name="cf_time"
            value="<?php echo get_post_meta($post->ID, 'cf_time', true); ?>" /></td>
      </tr>
      <tr id="appointments_usertime">
        <td class="left">Пользовательское время</td>
        <td><input class="form-control" type="text" name="cf_usertime"
            value="<?php echo get_post_meta($post->ID, 'cf_usertime', true); ?>" /></td>
      </tr>
      <tr id="appointments_timezone">
        <td class="left">Часовой пояс</td>
        <td><?php echo get_post_meta($post->ID, 'cf_timezone', true); ?></td>
      </tr>
      <tr id="appointments_name">
        <td class="left">Имя</td>
        <td><input class="form-control" type="text" name="cf_name"
            value="<?php echo get_post_meta($post->ID, 'cf_name', true); ?>" /></td>
      </tr>
      <tr id="appointments_mail">
        <td class="left">Email</td>
        <td><input class="form-control" type="text" name="cf_mail"
            value="<?php echo get_post_meta($post->ID, 'cf_mail', true); ?>" /></td>
      </tr>
      <tr id="appointments_phone">
        <td class="left">Телефон</td>
        <td><input class="form-control" type="text" name="cf_phone"
            value="<?php echo get_post_meta($post->ID, 'cf_phone', true); ?>" /></td>
      </tr>
      <tr id="appointments_messenger_choose">
        <td class="left">Мессенджер</td>
        <td><?php $messengers = get_post_meta($post->ID, 'cf_messenger_choose', true);
    foreach ($messengers as $messenger) {echo $messenger;}?></td>
      </tr>
      <tr id="appointments_messenger">
        <td class="left">Мессенджер Контакт</td>
        <td><?php echo get_post_meta($post->ID, 'cf_messenger', true); ?></td>
      </tr>
      <tr id="appointments_lang">
        <td class="left">Язык</td>
        <td><?php $langs = get_post_meta($post->ID, 'cf_lang', true);
    foreach ($langs as $lang) {echo $lang;}?></td>
      </tr>
    </tbody>
  </table>
</div>

<?php }

/**
 * Save new data from admin
 *
 * @param int $post_id ID поста, который сохраняется.
 */
  public function save_metabox($post_id) {

    if (!isset($_POST['rh_consulting_noncename'])) {
      return $post_id;
    }

    $nonce = $_POST['rh_consulting_noncename'];

    if (!wp_verify_nonce($nonce, $this->plugin_name)) {
      return $post_id;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
      return $post_id;
    }

    if ('page' == $_POST['post_type']) {

      if (!current_user_can('edit_page', $post_id)) {
        return $post_id;
      }

    } else {

      if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
      }
    }

    // Save data

    $cf_date = sanitize_text_field($_POST['cf_date']);
    update_post_meta($post_id, 'cf_date', $cf_date);
    $cf_time = sanitize_text_field($_POST['cf_time']);
    update_post_meta($post_id, 'cf_time', $cf_time);
    $cf_usertime = sanitize_text_field($_POST['cf_usertime']);
    update_post_meta($post_id, 'cf_usertime', $cf_usertime);
    $cf_timezone = sanitize_text_field($_POST['cf_timezone']);
    update_post_meta($post_id, 'cf_timezone', $cf_timezone);
    $cf_name = sanitize_text_field($_POST['cf_name']);
    update_post_meta($post_id, 'cf_name', $cf_name);
    $cf_mail = sanitize_text_field($_POST['cf_mail']);
    update_post_meta($post_id, 'cf_mail', $cf_mail);
    $cf_phone = sanitize_text_field($_POST['cf_phone']);
    update_post_meta($post_id, 'cf_phone', $cf_phone);
  }

}