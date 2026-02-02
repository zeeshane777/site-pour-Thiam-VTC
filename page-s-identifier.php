<?php
/**
 * Template Name: S'identifier
 */

get_header();

// ===== Gestion du POST (login WordPress) =====
$error_msg = '';

if ( $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tsf_login_submit']) ) {

  if ( ! isset($_POST['tsf_login_nonce']) || ! wp_verify_nonce($_POST['tsf_login_nonce'], 'tsf_login_action') ) {
    $error_msg = "Erreur de sécurité. Réessaie.";
  } else {

    $email_or_user = isset($_POST['tsf_email']) ? sanitize_text_field( wp_unslash($_POST['tsf_email']) ) : '';
    $password      = isset($_POST['tsf_password']) ? (string) wp_unslash($_POST['tsf_password']) : '';

    $creds = [
      'user_login'    => $email_or_user,
      'user_password' => $password,
      'remember'      => true,
    ];

    $user = wp_signon( $creds, is_ssl() );

    if ( is_wp_error($user) ) {
      $error_msg = "Identifiants incorrects. Vérifie ton email ou ton mot de passe.";
    } else {
      wp_safe_redirect( home_url('/') );
      exit;
    }
  }
}

/* ===== Lien INSCRIPTION (PAGE RÉELLE WP) ===== */
$google_error = isset($_GET['google_login']) ? sanitize_text_field( wp_unslash($_GET['google_login']) ) : '';
if ( empty($error_msg) && ! empty($google_error) ) {
  switch ($google_error) {
    case 'failed':
      $error_msg = "Connexion Google annulÇ¸e. RÇ¸essaie.";
      break;
    case 'config':
      $error_msg = "Connexion Google indisponible. Contacte l'administrateur.";
      break;
    default:
      $error_msg = "Impossible de se connecter avec Google. RÇ¸essaie.";
      break;
  }
}

$page_inscription = get_page_by_path('inscription');
$inscription_url  = $page_inscription
  ? get_permalink($page_inscription)
  : home_url('/');
?>

<main class="tsf-login-page">
  <section class="tsf-login-card" aria-labelledby="tsf-login-title">

    <h1 id="tsf-login-title" class="tsf-login-title">Se connectez</h1>

    <?php if ( ! empty($error_msg) ) : ?>
      <div class="tsf-login-alert" role="alert">
        <?php echo esc_html($error_msg); ?>
      </div>
    <?php endif; ?>

    <form class="tsf-login-form" method="post" action="">
      <?php wp_nonce_field('tsf_login_action', 'tsf_login_nonce'); ?>

      <!-- Champ email (2 écritures comme Figma) -->
      <div class="tsf-field-inline">
        <label class="tsf-inline-label" for="tsf_email">Adresse mail</label>
        <input
          class="tsf-inline-input"
          id="tsf_email"
          name="tsf_email"
          type="text"
          inputmode="email"
          autocomplete="username"
          placeholder="Adresse mail"
          required
        >
      </div>

      <!-- Champ mot de passe (2 écritures comme Figma) -->
      <div class="tsf-field-inline">
        <label class="tsf-inline-label" for="tsf_password">Mot de passe</label>
        <input
          class="tsf-inline-input"
          id="tsf_password"
          name="tsf_password"
          type="password"
          autocomplete="current-password"
          placeholder="Mot de passe"
          required
        >
      </div>

      <label class="tsf-checkbox">
        <input type="checkbox" id="tsf_toggle_password">
        <span>Affichez le mot de passe</span>
      </label>

      <button class="tsf-btn-primary" type="submit" name="tsf_login_submit" value="1">
        Continuez
      </button>

      <p class="tsf-login-foot">
        Vous n'avez pas de compte ?
        <a class="tsf-link" href="<?php echo esc_url($inscription_url); ?>">
          Inscription
        </a>
      </p>

      <div class="tsf-separator" aria-hidden="true">
        <span></span><em>Ou</em><span></span>
      </div>

      <!-- Google -->
      <a class="tsf-btn-social" href="<?php echo esc_url( thiam_google_login_url() ); ?>" role="button">
        <img
          src="<?php echo esc_url( thiam_asset_url('google.png') ); ?>"
          alt="Google"
          class="tsf-social-icon"
        >
        <span>Continuez avec Google</span>
      </a>

    </form>
  </section>
</main>

<?php get_footer(); ?>
