<?php
get_header();

$raw_code = 0;
if ( isset($_GET['code']) ) {
  $raw_code = absint(wp_unslash($_GET['code']));
} elseif ( isset($_SERVER['REDIRECT_STATUS']) ) {
  $raw_code = absint($_SERVER['REDIRECT_STATUS']);
} else {
  $raw_code = absint(http_response_code());
}

if ( $raw_code < 400 || $raw_code > 599 ) {
  $raw_code = 404;
}

status_header($raw_code);

$errors = [
  400 => [
    'title' => 'Requete invalide',
    'text'  => 'La requete envoyee n est pas valide. Merci de verifier puis reessayer.',
  ],
  401 => [
    'title' => 'Authentification requise',
    'text'  => 'Vous devez vous connecter pour acceder a cette ressource.',
  ],
  403 => [
    'title' => 'Acces refuse',
    'text'  => 'Vous n avez pas la permission d acceder a cette page.',
  ],
  404 => [
    'title' => 'Page introuvable',
    'text'  => 'La page que vous cherchez n existe pas ou a ete deplacee.',
  ],
  405 => [
    'title' => 'Methode non autorisee',
    'text'  => 'La methode de requete utilisee n est pas autorisee pour cette page.',
  ],
  408 => [
    'title' => 'Delai depasse',
    'text'  => 'La requete a pris trop de temps. Merci de reessayer.',
  ],
  410 => [
    'title' => 'Contenu supprime',
    'text'  => 'Cette ressource n est plus disponible.',
  ],
  429 => [
    'title' => 'Trop de requetes',
    'text'  => 'Vous avez effectue trop de requetes. Merci de patienter puis reessayer.',
  ],
  500 => [
    'title' => 'Erreur serveur',
    'text'  => 'Une erreur interne est survenue. Merci de reessayer plus tard.',
  ],
  502 => [
    'title' => 'Mauvaise passerelle',
    'text'  => 'Le serveur a recu une reponse invalide en amont.',
  ],
  503 => [
    'title' => 'Service indisponible',
    'text'  => 'Le service est temporairement indisponible. Merci de reessayer plus tard.',
  ],
  504 => [
    'title' => 'Delai de passerelle depasse',
    'text'  => 'Le serveur en amont ne repond pas dans les temps.',
  ],
];

$current = isset($errors[$raw_code]) ? $errors[$raw_code] : [
  'title' => 'Erreur inattendue',
  'text'  => 'Une erreur est survenue. Merci de reessayer.',
];
?>

<main class="tsf-404" role="main">
  <section class="tsf-404__card">
    <p class="tsf-404__code">Erreur <?php echo esc_html((string) $raw_code); ?></p>
    <h1 class="tsf-404__title"><?php echo esc_html($current['title']); ?></h1>
    <p class="tsf-404__text">
      <?php echo esc_html($current['text']); ?>
    </p>

    <div class="tsf-404__actions">
      <a class="btn-primary" href="<?php echo esc_url(home_url('/')); ?>">Retour a l'accueil</a>
      <a class="btn-secondary" href="<?php echo esc_url(home_url('/trajet-en-ville/?reservation=1')); ?>">Reserver un trajet</a>
    </div>
  </section>
</main>

<?php
get_footer();
?>
