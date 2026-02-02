<?php
/**
 * Template Name: Mon compte
 */

get_header();

$login_page = get_page_by_path('s-identifier');
$login_url  = $login_page ? get_permalink($login_page) : home_url('/s-identifier/');

if ( ! is_user_logged_in() ) {
  wp_safe_redirect($login_url);
  exit;
}

$user = wp_get_current_user();
$first_name = $user->first_name ? $user->first_name : $user->display_name;
$full_name = trim($user->first_name . ' ' . $user->last_name);
$phone = get_user_meta($user->ID, 'phone', true);
$company = get_user_meta($user->ID, 'company', true);
$address = get_user_meta($user->ID, 'address', true);
$registered = $user->user_registered ? date_i18n('j M Y', strtotime($user->user_registered)) : '';
$message = '';
$message_type = '';

if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tsf_account_nonce']) && wp_verify_nonce($_POST['tsf_account_nonce'], 'tsf_account_update') ) {
  $full_name_input = isset($_POST['full_name']) ? sanitize_text_field(wp_unslash($_POST['full_name'])) : '';
  $phone = isset($_POST['phone']) ? sanitize_text_field(wp_unslash($_POST['phone'])) : '';
  $company = isset($_POST['company']) ? sanitize_text_field(wp_unslash($_POST['company'])) : '';
  $address = isset($_POST['address']) ? sanitize_text_field(wp_unslash($_POST['address'])) : '';
  $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';
  $password = isset($_POST['password']) ? wp_unslash($_POST['password']) : '';

  $errors = [];
  if ( empty($email) || ! is_email($email) ) {
    $errors[] = 'Adresse mail invalide.';
  } elseif ( $email !== $user->user_email && email_exists($email) ) {
    $errors[] = 'Adresse mail deja utilisee.';
  }

  $first_name_value = $full_name_input;
  $last_name_value = '';
  if ( $full_name_input ) {
    $parts = preg_split('/\s+/', $full_name_input, 2);
    $first_name_value = $parts[0];
    $last_name_value = isset($parts[1]) ? $parts[1] : '';
  }

  if ( empty($errors) ) {
    $userdata = [
      'ID' => $user->ID,
      'first_name' => $first_name_value,
      'last_name' => $last_name_value,
      'user_email' => $email,
    ];
    if ( $password !== '' ) {
      $userdata['user_pass'] = $password;
    }
    $result = wp_update_user($userdata);
    if ( is_wp_error($result) ) {
      $message = 'Erreur lors de la mise a jour.';
      $message_type = 'error';
    } else {
      update_user_meta($user->ID, 'phone', $phone);
      update_user_meta($user->ID, 'company', $company);
      update_user_meta($user->ID, 'address', $address);
      if ( $password !== '' ) {
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID);
      }
      $user = wp_get_current_user();
      $first_name = $user->first_name ? $user->first_name : $user->display_name;
      $full_name = trim($user->first_name . ' ' . $user->last_name);
      $message = 'Informations mises a jour.';
      $message_type = 'success';
    }
  } else {
    $message = implode(' ', $errors);
    $message_type = 'error';
  }
}
?>

<main class="tsf-account">
  <section class="tsf-account__wrap">
    <header class="tsf-account__header">
      <h1 class="tsf-account__title">Bonjour, <?php echo esc_html($first_name); ?></h1>
      <?php if ( $registered ) : ?>
        <p class="tsf-account__sub">Membre depuis le <?php echo esc_html($registered); ?></p>
      <?php endif; ?>
    </header>

    <div class="tsf-account__card">
      <?php if ( $message ) : ?>
        <div class="tsf-account__message tsf-account__message--<?php echo esc_attr($message_type); ?>">
          <?php echo esc_html($message); ?>
        </div>
      <?php endif; ?>
      <form class="tsf-account__form" method="post">
        <?php wp_nonce_field('tsf_account_update', 'tsf_account_nonce'); ?>
        <section class="tsf-account__section">
          <h2 class="tsf-account__h2">Informations personnelles</h2>
          <div class="tsf-account__grid">
            <div class="tsf-account__row" data-field="full_name">
              <div class="tsf-account__label">Nom</div>
              <div class="tsf-account__value"><?php echo esc_html($full_name ? $full_name : '-'); ?></div>
              <input class="tsf-account__input" type="text" name="full_name" value="<?php echo esc_attr($full_name ? $full_name : ''); ?>">
              <button class="tsf-account__edit" type="button" aria-label="Modifier le nom">✎</button>
            </div>

            <div class="tsf-account__row" data-field="phone">
              <div class="tsf-account__label">Telephone portable</div>
              <div class="tsf-account__value"><?php echo esc_html($phone ? $phone : '-'); ?></div>
              <input class="tsf-account__input" type="text" name="phone" value="<?php echo esc_attr($phone ? $phone : ''); ?>">
              <button class="tsf-account__edit" type="button" aria-label="Modifier le telephone">✎</button>
            </div>

            <div class="tsf-account__row" data-field="company">
              <div class="tsf-account__label">Entreprise</div>
              <div class="tsf-account__value"><?php echo esc_html($company ? $company : '-'); ?></div>
              <input class="tsf-account__input" type="text" name="company" value="<?php echo esc_attr($company ? $company : ''); ?>">
              <button class="tsf-account__edit" type="button" aria-label="Modifier l'entreprise">✎</button>
            </div>

            <div class="tsf-account__row" data-field="address">
              <div class="tsf-account__label">Adresse</div>
              <div class="tsf-account__value"><?php echo esc_html($address ? $address : '-'); ?></div>
              <input class="tsf-account__input" type="text" name="address" value="<?php echo esc_attr($address ? $address : ''); ?>">
              <button class="tsf-account__edit" type="button" aria-label="Modifier l'adresse">✎</button>
            </div>
          </div>
        </section>

        <section class="tsf-account__section">
          <h2 class="tsf-account__h2">Adresse mail</h2>
          <div class="tsf-account__grid">
            <div class="tsf-account__row" data-field="email">
              <div class="tsf-account__label">Adresse mail</div>
              <div class="tsf-account__value"><?php echo esc_html($user->user_email); ?></div>
              <input class="tsf-account__input" type="email" name="email" value="<?php echo esc_attr($user->user_email); ?>">
              <button class="tsf-account__edit" type="button" aria-label="Modifier l'adresse mail">✎</button>
            </div>
          </div>
        </section>

        <section class="tsf-account__section">
          <h2 class="tsf-account__h2">Mot de passe</h2>
          <div class="tsf-account__grid">
            <div class="tsf-account__row" data-field="password">
              <div class="tsf-account__label">Mot de passe</div>
              <div class="tsf-account__value">••••••••••••••</div>
              <input class="tsf-account__input" type="password" name="password" value="" placeholder="Nouveau mot de passe">
              <button class="tsf-account__edit" type="button" aria-label="Modifier le mot de passe">✎</button>
            </div>
          </div>
        </section>
        <div class="tsf-account__actions" id="tsf-account-actions" hidden>
          <button class="tsf-account__button" type="submit">Enregistrer</button>
        </div>
      </form>
    </div>
  </section>
</main>

<script>
  var actions = document.getElementById('tsf-account-actions');
  document.querySelectorAll('.tsf-account__edit').forEach(function (button) {
    button.addEventListener('click', function () {
      var row = button.closest('.tsf-account__row');
      if (!row) {
        return;
      }
      row.classList.add('is-editing');
      if (actions) {
        actions.hidden = false;
      }
      var input = row.querySelector('.tsf-account__input');
      if (input) {
        input.focus();
      }
    });
  });
</script>

<?php get_footer(); ?>
