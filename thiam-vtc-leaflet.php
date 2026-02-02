<?php
/**
 * Plugin Name: Thiam VTC Leaflet Route
 * Description: Leaflet map with address autocomplete (Nominatim) + routing (OSRM) and price per km.
 * Version: 1.0.0
 * Author: Thiam VTC
 */

if ( ! defined('ABSPATH') ) {
  exit;
}

function thiam_vtc_register_reservations() {
  register_post_type('thiam_reservation', [
    'labels' => [
      'name' => 'Reservations',
      'singular_name' => 'Reservation',
    ],
    'public' => false,
    'show_ui' => true,
    'show_in_menu' => true,
    'supports' => ['title', 'author'],
    'capability_type' => 'post',
  ]);
}
add_action('init', 'thiam_vtc_register_reservations');

function thiam_vtc_enqueue_leaflet_assets() {
  static $done = false;
  if ( $done ) {
    return;
  }
  $done = true;

  wp_enqueue_style(
    'thiam-leaflet',
    'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
    [],
    '1.9.4'
  );

  wp_enqueue_script(
    'thiam-leaflet',
    'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
    [],
    '1.9.4',
    true
  );

  $css = "
.thiam-route{display:grid;grid-template-columns:1.1fr .7fr;gap:24px;align-items:start}
.thiam-route__map{min-height:520px;border-radius:14px;overflow:hidden;border:1px solid #e6e1df}
.thiam-route__panel{background:#f7f2ee;border:1px solid #efe7e3;border-radius:16px;padding:20px;display:grid;gap:10px}
.thiam-route__label{font-size:14px;color:#4b3d3b}
.thiam-route__field{position:relative}
.thiam-route__field input,.thiam-route__panel select,.thiam-route__panel input[type=time]{width:100%;display:flex;align-items:center;gap:10px;align-self:stretch;height:59px;padding:8px 24px 8px 8px;border:1px solid #e3d9d2;border-radius:16px;background:var(--DB-Primary,#f9f4ef);color:var(--DB-Secondary,#141414);font-family:\"Satoshi\",sans-serif;font-size:20px;font-style:normal;font-weight:500;line-height:normal}
.thiam-route__suggestions{position:absolute;left:0;right:0;top:100%;z-index:10;background:#fff;border:1px solid #e3d9d2;border-radius:10px;margin-top:6px;display:none;max-height:180px;overflow:auto}
.thiam-route__suggestions button{display:block;width:100%;text-align:left;padding:8px 10px;border:0;background:#fff;cursor:pointer}
.thiam-route__suggestions button:hover{background:#f5f1ee}
.thiam-route__total{display:flex;justify-content:space-between;align-items:center;margin-top:6px}
.thiam-route__cta{margin-top:6px;background:#3c0f1b;color:#fff;border:0;padding:12px 16px;border-radius:999px;cursor:pointer}
.thiam-route__meta{font-size:13px;color:#5b4f4a}
.thiam-route__confirm{background:#f7f2ee;border:1px solid #efe7e3;border-radius:16px;padding:28px;display:grid;gap:12px;align-content:start}
.thiam-route__confirm[hidden]{display:none}
.thiam-route__confirm-icon{width:72px;height:72px;border-radius:50%;border:3px solid #3c0f1b;color:#3c0f1b;display:grid;place-items:center;font-size:36px;margin-bottom:6px}
.thiam-route__confirm-title{margin:0;font-size:20px;color:#1f1a17}
.thiam-route__confirm-text{margin:0;font-size:14px;color:#5b4f4a;line-height:1.4}
.thiam-airport__map-wrap{display:grid;gap:10px}
.thiam-airport__tabs{display:flex;gap:12px}
.thiam-airport__tab{min-width:140px;height:42px;padding:0 18px;border-radius:12px;border:1px solid #e3d9d2;background:#f1eeeb;color:#2b2320;font-weight:600;cursor:pointer}
.thiam-airport__tab.is-active{background:#3c0f1b;color:#fff;border-color:#3c0f1b}
.thiam-airport .thiam-route__map{height:520px}
@media (max-width: 900px){.thiam-route{grid-template-columns:1fr}.thiam-route__map{min-height:360px}}
";
  wp_add_inline_style('thiam-leaflet', $css);

  $config = [
    'pricePerKm' => 2.5,
    'nominatim' => 'https://nominatim.openstreetmap.org/search',
    'osrm' => 'https://router.project-osrm.org/route/v1/driving/',
    'reservationsUrl' => home_url('/reservations/'),
    'ajaxUrl' => admin_url('admin-ajax.php'),
    'nonce' => wp_create_nonce('thiam_vtc_reservation'),
    'isLoggedIn' => is_user_logged_in(),
    'loginUrl' => home_url('/s-identifier/'),
  ];
  wp_add_inline_script('thiam-leaflet', 'window.THIA_ROUTE_CONFIG=' . wp_json_encode($config) . ';', 'before');
}

function thiam_vtc_create_reservation() {
  if ( ! is_user_logged_in() ) {
    wp_send_json_error('Connexion requise.');
  }
  if ( ! isset($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'thiam_vtc_reservation') ) {
    wp_send_json_error('Requete invalide.');
  }

  $start_address = isset($_POST['start_address']) ? sanitize_text_field(wp_unslash($_POST['start_address'])) : '';
  $end_address = isset($_POST['end_address']) ? sanitize_text_field(wp_unslash($_POST['end_address'])) : '';
  $depart_time = isset($_POST['depart_time']) ? sanitize_text_field(wp_unslash($_POST['depart_time'])) : '';
  $passengers = isset($_POST['passengers']) ? absint($_POST['passengers']) : 1;
  $distance_km = isset($_POST['distance_km']) ? floatval($_POST['distance_km']) : 0;
  $duration_sec = isset($_POST['duration_sec']) ? absint($_POST['duration_sec']) : 0;
  $price_eur = isset($_POST['price_eur']) ? floatval($_POST['price_eur']) : 0;
  $service_type = isset($_POST['service_type']) ? sanitize_text_field(wp_unslash($_POST['service_type'])) : 'ville';
  $airport_name = isset($_POST['airport_name']) ? sanitize_text_field(wp_unslash($_POST['airport_name'])) : '';
  $flight_number = isset($_POST['flight_number']) ? sanitize_text_field(wp_unslash($_POST['flight_number'])) : '';
  $airport_mode = isset($_POST['airport_mode']) ? sanitize_text_field(wp_unslash($_POST['airport_mode'])) : '';

  if ( empty($start_address) || empty($end_address) || empty($depart_time) ) {
    wp_send_json_error('Champs manquants.');
  }

  $time_parts = explode(':', $depart_time);
  if ( count($time_parts) < 2 ) {
    wp_send_json_error('Heure invalide.');
  }

  $tz = wp_timezone();
  $now = new DateTimeImmutable('now', $tz);
  $date_str = $now->format('Y-m-d');
  $departure_dt = DateTimeImmutable::createFromFormat('Y-m-d H:i', $date_str . ' ' . $depart_time, $tz);
  if ( ! $departure_dt ) {
    wp_send_json_error('Heure invalide.');
  }
  if ( $departure_dt < $now ) {
    $departure_dt = $departure_dt->modify('+1 day');
  }
  $arrival_dt = $duration_sec ? $departure_dt->modify('+' . $duration_sec . ' seconds') : $departure_dt;

  $post_id = wp_insert_post([
    'post_type' => 'thiam_reservation',
    'post_status' => 'publish',
    'post_title' => 'Reservation ' . $now->format('Y-m-d H:i'),
    'post_author' => get_current_user_id(),
  ], true);

  if ( is_wp_error($post_id) ) {
    wp_send_json_error('Erreur lors de la creation.');
  }

  update_post_meta($post_id, 'thiam_start_address', $start_address);
  update_post_meta($post_id, 'thiam_end_address', $end_address);
  update_post_meta($post_id, 'thiam_depart_time', $departure_dt->format('H:i'));
  update_post_meta($post_id, 'thiam_arrival_time', $arrival_dt->format('H:i'));
  update_post_meta($post_id, 'thiam_depart_ts', $departure_dt->getTimestamp());
  update_post_meta($post_id, 'thiam_arrival_ts', $arrival_dt->getTimestamp());
  update_post_meta($post_id, 'thiam_passengers', $passengers);
  update_post_meta($post_id, 'thiam_distance_km', $distance_km);
  update_post_meta($post_id, 'thiam_duration_sec', $duration_sec);
  update_post_meta($post_id, 'thiam_price_eur', $price_eur);
  update_post_meta($post_id, 'thiam_status', 'en_cours');
  update_post_meta($post_id, 'thiam_service_type', $service_type);
  update_post_meta($post_id, 'thiam_airport_name', $airport_name);
  update_post_meta($post_id, 'thiam_flight_number', $flight_number);
  update_post_meta($post_id, 'thiam_airport_mode', $airport_mode);

  $user = wp_get_current_user();
  $client_email = $user && $user->user_email ? $user->user_email : '';
  $admin_email = get_option('admin_email');
  $common_lines = [
    'Reservation confirme.',
    'Depart: ' . $start_address,
    'Arrivee: ' . $end_address,
    'Heure de depart: ' . $departure_dt->format('H:i'),
    'Heure d\'arrivee: ' . $arrival_dt->format('H:i'),
    'Passagers: ' . $passengers,
    'Distance (km): ' . number_format($distance_km, 2),
    'Prix (EUR): ' . number_format($price_eur, 2),
  ];
  $message = implode("\n", $common_lines);
  if ( $client_email ) {
    wp_mail($client_email, 'Confirmation de votre reservation VTC', $message);
  }
  if ( $admin_email ) {
    wp_mail($admin_email, 'Nouvelle reservation VTC', $message);
  }

  wp_send_json_success(['id' => $post_id]);
}
add_action('wp_ajax_thiam_vtc_create_reservation', 'thiam_vtc_create_reservation');

function thiam_vtc_cancel_reservation() {
  if ( ! is_user_logged_in() ) {
    wp_send_json_error('Connexion requise.');
  }
  if ( ! isset($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'thiam_vtc_reservation') ) {
    wp_send_json_error('Requete invalide.');
  }
  $reservation_id = isset($_POST['reservation_id']) ? absint($_POST['reservation_id']) : 0;
  if ( ! $reservation_id ) {
    wp_send_json_error('Reservation invalide.');
  }
  $post = get_post($reservation_id);
  if ( ! $post || $post->post_type !== 'thiam_reservation' || (int) $post->post_author !== get_current_user_id() ) {
    wp_send_json_error('Acces refuse.');
  }
  wp_trash_post($reservation_id);
  wp_send_json_success();
}
add_action('wp_ajax_thiam_vtc_cancel_reservation', 'thiam_vtc_cancel_reservation');

require_once __DIR__ . '/thiam-vtc-leaflet-city.php';
require_once __DIR__ . '/thiam-vtc-leaflet-airport.php';
