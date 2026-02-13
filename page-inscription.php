<?php
/**
 * Template Name: Inscription
 */

get_header();

$page_login = get_page_by_path('s-identifier');
$login_url  = $page_login ? get_permalink($page_login) : home_url('/s-identifier/');

$account_page = get_page_by_path('mon-compte');
$account_url  = $account_page ? get_permalink($account_page) : home_url('/mon-compte/');

$register_error = '';

if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tsf_register_submit']) ) {
  if ( ! isset($_POST['tsf_register_nonce']) || ! wp_verify_nonce($_POST['tsf_register_nonce'], 'tsf_register_action') ) {
    $register_error = 'Erreur de sécurité. Réessaie.';
  } else {
    $first_name = isset($_POST['reg_firstname']) ? sanitize_text_field(wp_unslash($_POST['reg_firstname'])) : '';
    $last_name  = isset($_POST['reg_lastname']) ? sanitize_text_field(wp_unslash($_POST['reg_lastname'])) : '';
    $tel        = isset($_POST['reg_tel']) ? sanitize_text_field(wp_unslash($_POST['reg_tel'])) : '';
    $email      = isset($_POST['reg_email']) ? sanitize_email(wp_unslash($_POST['reg_email'])) : '';
    $password   = isset($_POST['reg_password']) ? (string) wp_unslash($_POST['reg_password']) : '';

    if ( empty($email) || ! is_email($email) ) {
      $register_error = 'Adresse email invalide.';
    } elseif ( email_exists($email) ) {
      $register_error = 'Cette adresse email est déjà utilisée.';
    } elseif ( strlen($password) < 6 ) {
      $register_error = 'Le mot de passe doit contenir au moins 6 caractères.';
    } else {
      $user_login = $email;

      if ( username_exists($user_login) ) {
        $register_error = 'Ce compte existe déjà.';
      } else {
        $user_id = wp_insert_user([
          'user_login' => $user_login,
          'user_email' => $email,
          'user_pass'  => $password,
          'first_name' => $first_name,
          'last_name'  => $last_name,
          'role'       => 'subscriber',
        ]);

        if ( is_wp_error($user_id) ) {
          $register_error = $user_id->get_error_message();
        } else {
          if ( $tel !== '' ) {
            update_user_meta($user_id, 'phone', $tel);
          }

          wp_new_user_notification($user_id, null, 'user');

          wp_set_current_user($user_id);
          wp_set_auth_cookie($user_id);
          wp_safe_redirect($account_url);
          exit;
        }
      }
    }
  }
}
?>

<main class="tsf-register">
  <section class="tsf-register__card" aria-labelledby="tsf-register-title">

    <h1 id="tsf-register-title" class="tsf-register__title">Créez un compte</h1>

    <?php if ( ! empty($register_error) ) : ?>
      <div class="tsf-register__alert" role="alert">
        <?php echo esc_html($register_error); ?>
      </div>
    <?php endif; ?>

    <form class="tsf-register__form" action="" method="post">
      <?php wp_nonce_field('tsf_register_action', 'tsf_register_nonce'); ?>

      <!-- Prénom -->
      <div class="tsf-field-inline">
        <label class="tsf-inline-label" for="reg_firstname">Prénom</label>
        <input
          class="tsf-inline-input"
          id="reg_firstname"
          name="reg_firstname"
          type="text"
          placeholder="Jean"
          autocomplete="given-name"
          required
        >
      </div>

      <!-- Nom -->
      <div class="tsf-field-inline">
        <label class="tsf-inline-label" for="reg_lastname">Nom</label>
        <input
          class="tsf-inline-input"
          id="reg_lastname"
          name="reg_lastname"
          type="text"
          placeholder="Dupont"
          autocomplete="family-name"
          required
        >
      </div>

      <!-- Tél -->
      <div class="tsf-field-inline tsf-field-inline--tel">
        <label class="tsf-inline-label" for="reg_tel">Tél</label>

        <div class="tsf-tel-wrap">
          <input
            class="tsf-inline-input tsf-inline-input--tel"
            id="reg_tel"
            name="reg_tel"
            type="tel"
            placeholder="06 00 00 00 00"
            autocomplete="tel"
            required
          >
          <span class="tsf-flag" aria-hidden="true">+33 FR</span>
        </div>
      </div>

      <!-- Adresse mail -->
      <div class="tsf-field-inline">
        <label class="tsf-inline-label" for="reg_email">Adresse mail</label>
        <input
          class="tsf-inline-input"
          id="reg_email"
          name="reg_email"
          type="email"
          placeholder="Adresse mail"
          autocomplete="email"
          required
        >
      </div>

      <!-- Mot de passe -->
      <div class="tsf-field-inline">
        <label class="tsf-inline-label" for="reg_password">Mot de passe</label>
        <input
          class="tsf-inline-input"
          id="reg_password"
          name="reg_password"
          type="password"
          placeholder="Mot de passe"
          autocomplete="new-password"
          required
        >
      </div>

      <label class="tsf-register__checkbox">
        <input type="checkbox" id="tsf_toggle_password_register">
        <span>Afficher le mot de passe</span>
      </label>

      <button class="tsf-register__btn" type="submit" name="tsf_register_submit" value="1">Continuer</button>

      <p class="tsf-register__foot">
        Vous avez déjà un compte ?
        <a class="tsf-register__link" href="<?php echo esc_url($login_url); ?>">Connexion</a>
      </p>

      <div class="tsf-register__sep" aria-hidden="true">
        <span></span><em>Ou</em><span></span>
      </div>

      <a class="tsf-social" href="<?php echo esc_url( thiam_google_login_url() ); ?>" role="button">
        <img src="<?php echo esc_url( thiam_asset_url('google.png') ); ?>" alt="Google" class="tsf-social__icon">
        <span>Continuer avec Google</span>
      </a>

    </form>
  </section>
</main>

<?php get_footer(); ?>
