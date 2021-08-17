<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://reichbaum.ru
 * @since      1.0.0
 *
 * @package    Rh_Consulting
 * @subpackage Rh_Consulting/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div id="consulting_form" class="wrap">

  <h2><?php echo esc_html(get_admin_page_title()); ?></h2>
  <p>Форму можно добавлять через Block Lab, а также с помощью шорткодов. Стиль, ID и Title формы CF7 по умолчанию
    берется из настроек, но можно перезаписать через атрибут шорткода.</p>
  <p>Шорткод без параметров: [rh_consulting_form], с параметрами: [rh_consulting_form style="blue/gray" form_id="2076"
    form_title="Contact Form"]</p>

    <?php
 
  // echo do_shortcode('[gc_list_view hook_secret_key="hogehoge"]');
  // echo do_shortcode('[gc_get_gc_date_time hook_secret_key="hogehoge"]');
  ?>



  <form method="post" name="rh_consulting_options" action="options.php">

    <?php
//Grab all options

$options = get_option($this->plugin_name);

$form_theme = $options['form_theme'];
$form_title = $options['form_title'];
$form_title_en = $options['form_title_en'];
$form_description = $options['form_description'];
$form_description_en = $options['form_description_en'];
$form_time = $options['form_time'];
$form_time_en = $options['form_time_en'];
$form_date_title = $options['form_date_title'];
$form_date_title_en = $options['form_date_title_en'];
$form_time_title = $options['form_time_title'];
$form_time_title_en = $options['form_time_title_en'];
$form_timezone_title = $options['form_timezone_title'];
$form_timezone_title_en = $options['form_timezone_title_en'];
$form_confirm = $options['form_confirm'];
$form_confirm_en = $options['form_confirm_en'];
$form_contact_id = $options['form_contact_id'];
$form_contact_id_en = $options['form_contact_id_en'];
$form_contact_title = $options['form_contact_title'];
$form_contact_title_en = $options['form_contact_title_en'];
if (isset($options['form_disabled_dates'])) {
  $form_disabled_dates = $options['form_disabled_dates'];
} else {
  $form_disabled_dates = [];
}

$form_available_time = $options['form_available_time'];

$available_times = [
  ['time' => '10.00', 'available' => 1],
  ['time' => '11.00', 'available' => 1],
  ['time' => '12.00', 'available' => 1],
  ['time' => '13.00', 'available' => 1],
  ['time' => '14.00', 'available' => 1],
  ['time' => '15.00', 'available' => 1],
  ['time' => '16.00', 'available' => 1],
];

$i = 0;
foreach ($available_times as $time) {
  if (isset($form_available_time[$i]['available'])) {
    $available_times[$i]['available'] = $form_available_time[$i]['available'];
  } else {
    $available_times[$i]['available'] = 0;
  }

  $i++;
}

?>


    <?php
settings_fields($this->plugin_name);
do_settings_sections($this->plugin_name);
?>

    <div class="settings-block">
      <div class="container">
        <h3>Недоступные для записи дни</h3>
        <input name="<?php echo $this->plugin_name; ?>[form_disabled_dates]" id="multidatepicker" type="text"
          class="form-control" placeholder="yyyy-mm-dd, yyyy-mm-dd" value="<?php echo $form_disabled_dates; ?>">
      </div>
    </div>

    <table class="widefat settings-block">
      <thead>
        <tr>
          <th class="row-title">Поле</th>
          <th class="row-title">Значение</th>
          <th class="row-title">Значение (en)</th>
        </tr>
      </thead>
      <tbody>

        <tr class="alternate">
          <td class="row-title"><label
              id="<?php echo $this->plugin_name; ?>-form-title"><?php esc_attr_e('Title', $this->plugin_name);?></label>
          </td>
          <td><input class="form-control" type="text" aria-labelledby="<?php echo $this->plugin_name; ?>-form-title"
              name="<?php echo $this->plugin_name; ?>[form_title]" value="<?php echo $form_title; ?>" /></td>
          <td><input class="form-control" type="text" aria-labelledby="<?php echo $this->plugin_name; ?>-form-title"
              name="<?php echo $this->plugin_name; ?>[form_title_en]" value="<?php echo $form_title_en; ?>" /></td>
        </tr>

        <tr>
          <td class="row-title"><label for="<?php echo $this->plugin_name; ?>-form-description">
              <?php esc_attr_e('Description', $this->plugin_name);?></label>
          </td>
          <td><textarea rows="4" class="form-control"
              aria-labelledby="<?php echo $this->plugin_name; ?>-form-description"
              name="<?php echo $this->plugin_name; ?>[form_description]" /><?php echo $form_description; ?></textarea>
          </td>
          <td><textarea rows="4" class="form-control"
              aria-labelledby="<?php echo $this->plugin_name; ?>-form-description"
              name="<?php echo $this->plugin_name; ?>[form_description_en]" /><?php echo $form_description_en; ?></textarea>
          </td>
        </tr>

        <tr class="alternate">
          <td class="row-title"><label
              id="<?php echo $this->plugin_name; ?>-form-time"><?php esc_attr_e('Time limit', $this->plugin_name);?></label>
          </td>
          <td><input class="form-control" type="text" aria-labelledby="<?php echo $this->plugin_name; ?>-form-time"
              name="<?php echo $this->plugin_name; ?>[form_time]" value="<?php echo $form_time; ?>" /></td>
          <td><input class="form-control" type="text" aria-labelledby="<?php echo $this->plugin_name; ?>-form-time"
              name="<?php echo $this->plugin_name; ?>[form_time_en]" value="<?php echo $form_time_en; ?>" /></td>
        </tr>
        <tr>
          <td class="row-title"><label
              id="<?php echo $this->plugin_name; ?>-form-date-title"><?php esc_attr_e('Date title', $this->plugin_name);?></label>
          </td>
          <td><input class="form-control" type="text"
              aria-labelledby="<?php echo $this->plugin_name; ?>-form-date-title"
              name="<?php echo $this->plugin_name; ?>[form_date_title]" value="<?php echo $form_date_title; ?>" /></td>
          <td><input class="form-control" type="text"
              aria-labelledby="<?php echo $this->plugin_name; ?>-form-date-title"
              name="<?php echo $this->plugin_name; ?>[form_date_title_en]" value="<?php echo $form_date_title_en; ?>" />
          </td>
        </tr>
        <tr class="alternate">
          <td class="row-title"><label
              id="<?php echo $this->plugin_name; ?>-form-time-title"><?php esc_attr_e('Time title', $this->plugin_name);?></label>
          </td>
          <td><input class="form-control" type="text"
              aria-labelledby="<?php echo $this->plugin_name; ?>-form-time-title"
              name="<?php echo $this->plugin_name; ?>[form_time_title]" value="<?php echo $form_time_title; ?>" /></td>
          <td><input class="form-control" type="text"
              aria-labelledby="<?php echo $this->plugin_name; ?>-form-time-title"
              name="<?php echo $this->plugin_name; ?>[form_time_title_en]" value="<?php echo $form_time_title_en; ?>" />
          </td>
        </tr>
        <tr>
          <td class="row-title"><label
              id="<?php echo $this->plugin_name; ?>-form-timezone-title"><?php esc_attr_e('Timezone title', $this->plugin_name);?></label>
          </td>
          <td><input class="form-control" type="text"
              aria-labelledby="<?php echo $this->plugin_name; ?>-form-timezone-title"
              name="<?php echo $this->plugin_name; ?>[form_timezone_title]"
              value="<?php echo $form_timezone_title; ?>" /></td>
          <td><input class="form-control" type="text"
              aria-labelledby="<?php echo $this->plugin_name; ?>-form-timezone-title"
              name="<?php echo $this->plugin_name; ?>[form_timezone_title_en]"
              value="<?php echo $form_timezone_title_en; ?>" /></td>
        </tr>
        <tr class="alternate">
          <td class="row-title"><label
              id="<?php echo $this->plugin_name; ?>-form-confirm"><?php esc_attr_e('Confirm text', $this->plugin_name);?></label>
          </td>
          <td><input class="form-control" type="text" aria-labelledby="<?php echo $this->plugin_name; ?>-form-confirm"
              name="<?php echo $this->plugin_name; ?>[form_confirm]" value="<?php echo $form_confirm; ?>" /></td>
          <td><input class="form-control" type="text" aria-labelledby="<?php echo $this->plugin_name; ?>-form-confirm"
              name="<?php echo $this->plugin_name; ?>[form_confirm_en]" value="<?php echo $form_confirm_en; ?>" /></td>
        </tr>
        <tr>
          <td class="row-title"><label
              id="<?php echo $this->plugin_name; ?>-form-contact-id"><?php esc_attr_e('Contact Form ID', $this->plugin_name);?></label>
          </td>
          <td><input class="form-control" type="text"
              aria-labelledby="<?php echo $this->plugin_name; ?>-form-contact-id"
              name="<?php echo $this->plugin_name; ?>[form_contact_id]" value="<?php echo $form_contact_id; ?>" /></td>
          <td><input class="form-control" type="text"
              aria-labelledby="<?php echo $this->plugin_name; ?>-form-contact-id"
              name="<?php echo $this->plugin_name; ?>[form_contact_id_en]" value="<?php echo $form_contact_id_en; ?>" />
          </td>
        </tr>
        <tr class="alternate">
          <td class="row-title"><label
              id="<?php echo $this->plugin_name; ?>-form_contact_title"><?php esc_attr_e('Contact Form Title', $this->plugin_name);?></label>
          </td>
          <td><input class="form-control" type="text"
              aria-labelledby="<?php echo $this->plugin_name; ?>-form_contact_title"
              name="<?php echo $this->plugin_name; ?>[form_contact_title]" value="<?php echo $form_contact_title; ?>" />
          </td>
          <td><input class="form-control" type="text"
              aria-labelledby="<?php echo $this->plugin_name; ?>-form_contact_title"
              name="<?php echo $this->plugin_name; ?>[form_contact_title_en]"
              value="<?php echo $form_contact_title_en; ?>" /></td>
        </tr>
        <tr>
          <td class="row-title">Available time
          </td>
          <td colspan="2"><?php $iter = 0;
foreach ($available_times as $time) {
  $time_name = $this->plugin_name . '[form_available_time][' . $iter . '][time]';
  $time_av = $this->plugin_name . '[form_available_time][' . $iter . '][available]';
  ?>
            <label for="<?php echo $this->plugin_name; ?>-form-available-time">
              <input type="hidden" name="<?php echo $time_name; ?>" value="<?php echo $time['time']; ?>" />
              <input type="checkbox" name="<?php echo $time_av; ?>" value="1" <?php checked($time['available'], 1);?> />
              <span><?php echo $time['time']; ?></span>
            </label>
            <?php $iter++;}?></td>
          <td>
          </td>
        </tr>
        <tr class="alternate">
          <td class="row-title"><label
              for="<?php echo $this->plugin_name; ?>-form-theme"><span><?php esc_attr_e('Blue background', $this->plugin_name);?></span></label>
          </td>
          <td colspan="2"><input type="checkbox" id="<?php echo $this->plugin_name; ?>-form-theme"
              name="<?php echo $this->plugin_name; ?>[form_theme]" value="1" <?php checked($form_theme, 1);?> /></td>
        </tr>


      </tbody>
    </table>


    <?php submit_button('Сохранить изменения', 'primary', 'submit', true);?>

  </form>

</div>