<?php add_action('wp_ajax_getgooglecalendar', 'get_google_calendar');
add_action('wp_ajax_nopriv_getgooglecalendar', 'get_google_calendar');

function get_google_calendar() {
  if (isset($_POST['specialists'])) {
    $calid = $_POST['specialists'];
    echo do_shortcode('[gc_list_view g_id="' . $calid . '"]');
  }
}
