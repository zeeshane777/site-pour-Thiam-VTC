<?php
/**
 * Functions du thÃƒÆ’Ã‚Â¨me Thiam VTC
 */

function thiam_asset_url($path) {
  $path = ltrim($path, '/');
  $asset_path  = get_template_directory() . '/asset/' . $path;
  $assets_path = get_template_directory() . '/assets/' . $path;

  if ( file_exists($asset_path) ) {
    return get_template_directory_uri() . '/asset/' . $path;
  }

  if ( file_exists($assets_path) ) {
    return get_template_directory_uri() . '/assets/' . $path;
  }

  return get_template_directory_uri() . '/asset/' . $path;
}

function thiam_google_oauth_config() {
  $client_id = defined('THIAM_GOOGLE_CLIENT_ID') ? THIAM_GOOGLE_CLIENT_ID : get_option('thiam_google_client_id');
  $client_secret = defined('THIAM_GOOGLE_CLIENT_SECRET') ? THIAM_GOOGLE_CLIENT_SECRET : get_option('thiam_google_client_secret');
  $redirect_uri = add_query_arg('thiam_google_auth', '1', home_url('/'));

  return [
    'client_id' => $client_id,
    'client_secret' => $client_secret,
    'redirect_uri' => $redirect_uri,
  ];
}

function thiam_google_login_url() {
  $config = thiam_google_oauth_config();
  if ( empty($config['client_id']) || empty($config['redirect_uri']) ) {
    return '#';
  }

  $state = wp_generate_password(16, false);
  set_transient('thiam_google_oauth_state_' . $state, 1, 10 * MINUTE_IN_SECONDS);

  $params = [
    'client_id' => $config['client_id'],
    'redirect_uri' => $config['redirect_uri'],
    'response_type' => 'code',
    'scope' => 'openid email profile',
    'state' => $state,
    'access_type' => 'online',
    'prompt' => 'select_account',
  ];

  return 'https://accounts.google.com/o/oauth2/v2/auth?' . http_build_query($params, '', '&', PHP_QUERY_RFC3986);
}

add_filter('query_vars', function ($vars) {
  $vars[] = 'thiam_google_auth';
  return $vars;
});

add_action('template_redirect', function () {
  if ( ! get_query_var('thiam_google_auth') ) {
    return;
  }

  if ( isset($_GET['error']) ) {
    wp_safe_redirect( add_query_arg('google_login', 'failed', home_url('/s-identifier/')) );
    exit;
  }

  if ( empty($_GET['code']) || empty($_GET['state']) ) {
    wp_safe_redirect( add_query_arg('google_login', 'invalid', home_url('/s-identifier/')) );
    exit;
  }

  $state = sanitize_text_field( wp_unslash($_GET['state']) );
  $state_key = 'thiam_google_oauth_state_' . $state;
  if ( ! get_transient($state_key) ) {
    wp_safe_redirect( add_query_arg('google_login', 'state', home_url('/s-identifier/')) );
    exit;
  }
  delete_transient($state_key);

  $config = thiam_google_oauth_config();
  if ( empty($config['client_id']) || empty($config['client_secret']) ) {
    wp_safe_redirect( add_query_arg('google_login', 'config', home_url('/s-identifier/')) );
    exit;
  }

  $code = sanitize_text_field( wp_unslash($_GET['code']) );
  $token_response = wp_remote_post('https://oauth2.googleapis.com/token', [
    'timeout' => 15,
    'headers' => [
      'Content-Type' => 'application/x-www-form-urlencoded',
    ],
    'body' => [
      'client_id' => $config['client_id'],
      'client_secret' => $config['client_secret'],
      'code' => $code,
      'redirect_uri' => $config['redirect_uri'],
      'grant_type' => 'authorization_code',
    ],
  ]);

  if ( is_wp_error($token_response) ) {
    wp_safe_redirect( add_query_arg('google_login', 'token', home_url('/s-identifier/')) );
    exit;
  }

  $token_data = json_decode( wp_remote_retrieve_body($token_response), true );
  $access_token = isset($token_data['access_token']) ? $token_data['access_token'] : '';
  if ( empty($access_token) ) {
    wp_safe_redirect( add_query_arg('google_login', 'token', home_url('/s-identifier/')) );
    exit;
  }

  $user_info_response = wp_remote_get('https://openidconnect.googleapis.com/v1/userinfo', [
    'timeout' => 15,
    'headers' => [
      'Authorization' => 'Bearer ' . $access_token,
    ],
  ]);

  if ( is_wp_error($user_info_response) ) {
    wp_safe_redirect( add_query_arg('google_login', 'userinfo', home_url('/s-identifier/')) );
    exit;
  }

  $user_info = json_decode( wp_remote_retrieve_body($user_info_response), true );
  $email = isset($user_info['email']) ? sanitize_email($user_info['email']) : '';
  if ( empty($email) ) {
    wp_safe_redirect( add_query_arg('google_login', 'email', home_url('/s-identifier/')) );
    exit;
  }

  $user = get_user_by('email', $email);
  if ( ! $user ) {
    $base_username = sanitize_user( current( explode('@', $email) ), true );
    $username = $base_username;
    $counter = 1;
    while ( username_exists($username) ) {
      $username = $base_username . $counter;
      $counter++;
    }

    $new_user_id = wp_insert_user([
      'user_login' => $username,
      'user_pass' => wp_generate_password(20, true),
      'user_email' => $email,
      'first_name' => isset($user_info['given_name']) ? sanitize_text_field($user_info['given_name']) : '',
      'last_name' => isset($user_info['family_name']) ? sanitize_text_field($user_info['family_name']) : '',
      'display_name' => isset($user_info['name']) ? sanitize_text_field($user_info['name']) : $username,
      'role' => 'subscriber',
    ]);

    if ( is_wp_error($new_user_id) ) {
      wp_safe_redirect( add_query_arg('google_login', 'create', home_url('/s-identifier/')) );
      exit;
    }

    $user = get_user_by('id', $new_user_id);
    update_user_meta($new_user_id, 'thiam_google_sub', isset($user_info['sub']) ? sanitize_text_field($user_info['sub']) : '');
  }

  wp_set_current_user($user->ID);
  wp_set_auth_cookie($user->ID, true, is_ssl());
  do_action('wp_login', $user->user_login, $user);

  wp_safe_redirect( home_url('/mon-compte/') );
  exit;
});

/* ===== Assets ===== */
function thiam_vtc_assets() {

  // Police principale (homepage + sections)
  wp_enqueue_style(
    'thiam-urbanist',
    'https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;600&display=swap',
    [],
    null
  );

  // CSS principal du thÃƒÆ’Ã‚Â¨me
  wp_enqueue_style(
    'thiam-style',
    get_stylesheet_uri(),
    ['thiam-urbanist'],
    filemtime(get_stylesheet_directory() . '/style.css')
  );
  wp_enqueue_style(
    'thiam-header',
    get_template_directory_uri() . '/header.css',
    ['thiam-style'],
    filemtime(get_template_directory() . '/header.css')
  );
  wp_enqueue_style(
    'thiam-footer',
    get_template_directory_uri() . '/footer.css',
    ['thiam-header'],
    filemtime(get_template_directory() . '/footer.css')
  );

  // JS principal du thÃƒÆ’Ã‚Â¨me
  wp_enqueue_script(
    'thiam-js',
    get_template_directory_uri() . '/js/main.js',
    [],
    filemtime(get_template_directory() . '/js/main.js'),
    true
  );

  // ===== Pages Auth : login / inscription =====
  if ( is_page('s-identifier') || is_page('inscription') || is_page('mon-compte') ) {

    // Page login
    if ( is_page('s-identifier') ) {
      wp_enqueue_style(
        'thiam-login',
        get_template_directory_uri() . '/page-s-identifier.css',
        ['thiam-urbanist'],
        '1.0'
      );
      // JS login (charge seulement si le fichier existe)
      $login_js_rel = '/asset/js/page-login.js';
      $login_js_abs = get_template_directory() . $login_js_rel;
      $login_js_rel_fallback = '/assets/js/page-login.js';
      $login_js_abs_fallback = get_template_directory() . $login_js_rel_fallback;
      if ( file_exists($login_js_abs) ) {
        wp_enqueue_script(
          'thiam-login',
          get_template_directory_uri() . $login_js_rel,
          [],
          '1.0',
          true
        );
      } elseif ( file_exists($login_js_abs_fallback) ) {
        wp_enqueue_script(
          'thiam-login',
          get_template_directory_uri() . $login_js_rel_fallback,
          [],
          '1.0',
          true
        );
      }
    }

    // Page inscription
    if ( is_page('inscription') ) {
      wp_enqueue_style(
        'thiam-inscription',
        get_template_directory_uri() . '/page-inscription.css',
        ['thiam-urbanist'],
        '1.0'
      );
    }

    // Page mon compte
    if ( is_page('mon-compte') ) {
      wp_enqueue_style(
        'thiam-account',
        get_template_directory_uri() . '/page-mon-compte.css',
        ['thiam-urbanist'],
        '1.0'
      );
    }
  }
}
add_action('wp_enqueue_scripts', 'thiam_vtc_assets');
// Auto-logout after 1 minute.
add_filter('auth_cookie_expiration', function ($expiration) {
  return 10 * MINUTE_IN_SECONDS;
});

// Hide "Mon compte" from the primary menu.
add_filter('wp_nav_menu_objects', function ($items, $args) {
  if ( empty($args->theme_location) || $args->theme_location !== 'primary' ) {
    return $items;
  }

  $hidden_slugs = [
    'mon-compte',
    'nos-services',
    'depose-aeroport',
    'trajet-en-ville',
    'parcours-touristique',
  ];

  foreach ($items as $index => $item) {
    if ( isset($item->object, $item->object_id) && $item->object === 'page' ) {
      $slug = get_post_field('post_name', $item->object_id);
      if ( in_array($slug, $hidden_slugs, true) ) {
        unset($items[$index]);
      }
    }
  }

  return $items;
}, 10, 2);


/* ===== Setup du thÃƒÆ’Ã‚Â¨me ===== */
add_action('after_setup_theme', function () {

  // Gestion du titre <title>
  add_theme_support('title-tag');

  // Logo personnalisÃƒÆ’Ã‚Â© (maquette)
  add_theme_support('custom-logo', [
    'height'      => 60,
    'width'       => 160,
    'flex-height' => true,
    'flex-width'  => true,
  ]);

  // Menu principal
  register_nav_menus([
    'primary' => 'Menu principal',
  ]);
});

add_filter('template_include', function ($template) {
  if ( is_page('depose-aeroport') ) {
    $custom = get_template_directory() . '/page-depose-aeroport.php';
    if ( file_exists($custom) ) {
      return $custom;
    }
  }
  if ( is_page('trajet-en-ville') ) {
    $custom = get_template_directory() . '/page-trajet-en-ville.php';
    if ( file_exists($custom) ) {
      return $custom;
    }
  }
  if ( is_page('parcours-touristique') ) {
    $custom = get_template_directory() . '/page-parcours-touristique.php';
    if ( file_exists($custom) ) {
      return $custom;
    }
  }
  if ( is_page('reservation-aeroport') ) {
    $custom = get_template_directory() . '/page-reservation-aeroport.php';
    if ( file_exists($custom) ) {
      return $custom;
    }
  }
  if ( is_page(['reservations', 'reservation', 'Vos reservations', 'R�servations', 'Reservations']) ) {
    $custom = get_template_directory() . '/page-reservations.php';
    if ( file_exists($custom) ) {
      return $custom;
    }
  }
  return $template;
}, 50);


// Force reservation template as fallback if another filter overrides template_include.
add_filter('template_include', function ($template) {
  if ( is_page('reservation-aeroport') ) {
    $custom = get_template_directory() . '/page-reservation-aeroport.php';
    if ( file_exists($custom) ) {
      return $custom;
    }
  }
  return $template;
}, 999);