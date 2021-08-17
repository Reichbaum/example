<?php function construct_shortcode($options, $atts) {

$atts = shortcode_atts( [
  'style' => '',
  'form_id' => '',
  'form_title' => ''
], $atts );

$current_lang = get_bloginfo("language");
if ($current_lang == 'ru-RU') {
  $form_title = $options['form_title'];
  $form_description = $options['form_description'];
  $form_time = $options['form_time'];
  $form_date_title = $options['form_date_title'];
  $form_time_title = $options['form_time_title'];
  $form_timezone_title = $options['form_timezone_title'];
  $form_confirm = $options['form_confirm'];
  $form_contact_id = $options['form_contact_id'];
  $form_contact_title = $options['form_contact_title'];
} else {
  $form_title = $options['form_title_en'];
  $form_description = $options['form_description_en'];
  $form_time = $options['form_time_en'];
  $form_date_title = $options['form_date_title_en'];
  $form_time_title = $options['form_time_title_en'];
  $form_timezone_title = $options['form_timezone_title_en'];
  $form_confirm = $options['form_confirm_en'];
  $form_contact_id = $options['form_contact_id_en'];
  $form_contact_title = $options['form_contact_title_en'];
}
$form_available_times = $options['form_available_time'];
$form_disabled_dates = $options['form_disabled_dates'];

$appointment_args = array(
  'numberposts' => 10,
  'post_type' => 'appointments',
  'post_status' => array('publish', 'draft'),
  'meta_query' => array(
    array(
      'key' => 'cf_date',
      'value' => date("Y-m-d"),
      'compare' => '>=',
      'type' => 'DATE',
    ),
  ),
  'orderby' => 'meta_value',
  'order' => "ASC",
);

$latest_appointments = get_posts($appointment_args);

if (isset($latest_appointments) && !empty($latest_appointments)) { $prev_date = '';
$busy_days = array();
$disabled_dates = array();

  foreach ($latest_appointments as $post) {
    $date_array = get_post_meta($post->ID, 'cf_date');
    $time_array = get_post_meta($post->ID, 'cf_time');
    $date = $date_array[0];
    $time = $time_array[0];
    if ($date === $prev_date) {
      $busy_days[$date]['time'][] = $time;
    } else {
      $prev_date = $date;
      $busy_days[$date]['date'] = $date;
      $busy_days[$date]['time'][] = $time;
    }
  }

  $disabled_dates_array = explode(',', $form_disabled_dates);

  foreach ($disabled_dates_array as $date) {
    $formattedDate = date_format(date_create($date), 'Y-m-d');
    $disabled_dates[$formattedDate]['date'] = $formattedDate;
    $disabled_dates[$formattedDate]['time'][] = 'NA';
  }

  $result_dates = array_merge($disabled_dates, $busy_days);
  
}

$json = json_encode($result_dates);
$style = '';

// Attributes
if ($options['form_theme'] || $atts['style'] == 'blue') {
  $style = 'blue-area-1';
} 
if ($atts['style'] == 'gray') {
  $style = '';
}

if ($atts['form_id'] && $atts['form_title']) {
  $form_contact_id = $atts['form_id'];
  $form_contact_title = $atts['form_title'];
}

$out = '<div class="consulting-form ' . $style . ' py-zb"';
$out .= 'id="consulting-section"><div class="bg1"></div><div class="bg2"></div>';
$out .= '<div class="container"><div class="row"><div class="col-lg-7 col-md-6 left-content">';
$out .= '<h2><?php echo $form_title; ?></h2>
<p class="duration">';
  $out .= '<i class="far fa-clock time-icon"></i>' . $form_time . '</p>';
$out .= '<p>' . $form_description . '</p>';
$out .= '<div class="selected_date_time">';
  $out .= '<label>' . $form_date_title . '<input type="hidden" name="consulting_date" id="date_consulting_input"><span
      id="date_consulting"></span></label>';
  $out .= '<label>' . $form_time_title . '<input type="hidden" name="consulting_date" id="time_consulting_input"><span
      id="time_consulting"></span></label>';
  $out .= '<label>' . $form_timezone_title . '<input type="hidden" name="consulting_timezone"
      id="timezone_consulting_input"><span id="current_timezone"></span></label>';
  $out .= '</div>';
$out .= '<button id="consulting_confirm" onclick="confirmShowForm()" class="btn rounded-pill btn-super-primary"
  style="display: none">' . $form_confirm . '</button>';
$out .= '</div>';
$out .= '<div class="col-lg-5 col-md-6 right-content">';
  $out .= '<div id="calender"></div>';
  $out .= '<div id="timeline" style="display: none"><i class="fas fa-reply icon-back"
      onclick="goBackToCalender()"></i>';
    $out .= '<div class="available-time">';
      foreach ($form_available_times as $time) {
      $out .= '<p class="time-item" onclick="timeChanged(this)" data-time="' . $time['time'] . '">' . $time['time'] . '
      </p>';
      }
      $out .= '</div>';
    $out .= '<select id="time_zone" class="time-zone" onchange="timezoneChanged()">';

      $timezones = timezone_list();
      foreach ($timezones as $key => $value) {
      $out .= '<option class="time_zone_option" value="' . $key . '">' . $value . '</option>';
      }
      $out .= '</select></div>';
  $out .= '<div id="consulting_form_show" style="display: none;">';
    $out .= '<i class="fas fa-reply icon-back" onclick="goBackToTimeline()"></i>';
    $out .= do_shortcode('[contact-form-7 id="' . $form_contact_id . '" title="' . $form_contact_title . '"]');
    $out .= '</div>
</div>
</div>
</div>
</div>';
$out .= '<script>
var input = document.querySelector("#cf_phone"),
  output = document.querySelector("#output");
var iti = window.intlTelInput(input, {
  nationalMode: true,
  initialCountry: "us",
  placeholderNumberType: "FIXED_LINE"
});
if ($json) {
  var busyDays = \'' . $json . '\';
  busyDays = JSON.parse(busyDays);
};
</script>';
echo $out;
}