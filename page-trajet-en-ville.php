<?php
/**
 * Template Name: Trajet En Ville
 * Template Post Type: page
 */
get_header();

$show_reservation = isset($_GET['reservation']) && $_GET['reservation'] === '1';
$asset_base = get_template_directory_uri() . '/assets/';

$hero_img = $asset_base . rawurlencode('trajet en ville.webp');
$hero_label = 'Trajet en ville';
$img_front = $asset_base . rawurlencode('Merco avant.webp');
$img_coffre = $img_front;
$img_sieges = $img_front;
$img_luggage = $asset_base . rawurlencode('van trajet en ville.webp');
$img_business = $asset_base . rawurlencode('poignet trajet en ville.webp');

$card_1_title = 'Reservation rapide';
$card_1_text = 'Indiquez votre point de depart et votre destination pour organiser votre deplacement en toute simplicite.';
$card_2_title = 'Prise en charge';
$card_2_text = "Le trajet s'adapte a votre emploi du temps, a vos besoins et aux conditions de circulation.";
$card_3_title = 'Serenite';
$card_3_text = 'Deplacez-vous sereinement, sans contrainte de stationnement ou de transport.';

$coffre_title = 'Volumes du coffre';
$coffre_line_1 = 'Volume disponible dans le coffre 300 litre';
$coffre_line_2 = 'Soit 1 x XL, 1 x L, 1 x M';
$coffre_guide_label = 'Guide de taille';
$sieges_title = 'Sieges';
$sieges_line_1 = 'Ce vehicule peut accueillir 6 passagers maximum';

$story_1_title = 'UNE SOLUTION PENSEE POUR LA VILLE';
$story_1_text = "Se deplacer en milieu urbain demande souvent une souplesse et une reactivite exemplaires. Chaque trajet est minutieusement organise pour s'adapter a vos contraintes personnelles et vous permettre de circuler en toute tranquillite, meme aux heures de pointe. L'objectif est de rendre vos deplacements plus simples, plus fluides et plus agreables au quotidien grace a une gestion intelligente des itineraires. Nous mettons notre expertise au service de votre mobilite pour supprimer le stress des trajets citadins. Profitez d'une liberte totale sans compromis.";
$story_2_title = 'SE DEPLACER AUTREMENT';
$story_2_text = "Une alternative pratique pour vos rendez-vous, sorties ou deplacements du quotidien, sans contrainte inutile. Nous avons concu ce service pour vous liberer des soucis de stationnement et de circulation. Que ce soit pour un imperatif medical, une soiree entre amis ou un trajet professionnel, nous vous garantissons une disponibilite totale et une souplesse sans egale. Chaque course devient un instant de confort pur, vous permettant de rester concentre sur l'essentiel. Simplifiez-vous la vie avec une solution de transport fiable, reactive et sur mesure.";

if ( function_exists('get_field') ) {
  $value = get_field('trajet_ville_hero_image');
  if ( is_array($value) && ! empty($value['url']) ) { $hero_img = $value['url']; }
  elseif ( is_string($value) && $value !== '' ) { $hero_img = $value; }

  $value = get_field('trajet_ville_hero_label');
  if ( is_string($value) && $value !== '' ) { $hero_label = $value; }

  $value = get_field('trajet_ville_image_front');
  if ( is_array($value) && ! empty($value['url']) ) { $img_front = $value['url']; }
  elseif ( is_string($value) && $value !== '' ) { $img_front = $value; }
  $img_coffre = $img_front;
  $img_sieges = $img_front;

  $value = get_field('trajet_ville_image_coffre');
  if ( is_array($value) && ! empty($value['url']) ) { $img_coffre = $value['url']; }
  elseif ( is_string($value) && $value !== '' ) { $img_coffre = $value; }

  $value = get_field('trajet_ville_image_sieges');
  if ( is_array($value) && ! empty($value['url']) ) { $img_sieges = $value['url']; }
  elseif ( is_string($value) && $value !== '' ) { $img_sieges = $value; }

  $value = get_field('trajet_ville_image_story_1');
  if ( is_array($value) && ! empty($value['url']) ) { $img_luggage = $value['url']; }
  elseif ( is_string($value) && $value !== '' ) { $img_luggage = $value; }

  $value = get_field('trajet_ville_image_story_2');
  if ( is_array($value) && ! empty($value['url']) ) { $img_business = $value['url']; }
  elseif ( is_string($value) && $value !== '' ) { $img_business = $value; }

  $value = get_field('trajet_ville_card_1_title');
  if ( is_string($value) && $value !== '' ) { $card_1_title = $value; }
  $value = get_field('trajet_ville_card_1_text');
  if ( is_string($value) && $value !== '' ) { $card_1_text = $value; }
  $value = get_field('trajet_ville_card_2_title');
  if ( is_string($value) && $value !== '' ) { $card_2_title = $value; }
  $value = get_field('trajet_ville_card_2_text');
  if ( is_string($value) && $value !== '' ) { $card_2_text = $value; }
  $value = get_field('trajet_ville_card_3_title');
  if ( is_string($value) && $value !== '' ) { $card_3_title = $value; }
  $value = get_field('trajet_ville_card_3_text');
  if ( is_string($value) && $value !== '' ) { $card_3_text = $value; }

  $value = get_field('trajet_ville_coffre_title');
  if ( is_string($value) && $value !== '' ) { $coffre_title = $value; }
  $value = get_field('trajet_ville_coffre_line_1');
  if ( is_string($value) && $value !== '' ) { $coffre_line_1 = $value; }
  $value = get_field('trajet_ville_coffre_line_2');
  if ( is_string($value) && $value !== '' ) { $coffre_line_2 = $value; }
  $value = get_field('trajet_ville_coffre_guide_label');
  if ( is_string($value) && $value !== '' ) { $coffre_guide_label = $value; }
  $value = get_field('trajet_ville_sieges_title');
  if ( is_string($value) && $value !== '' ) { $sieges_title = $value; }
  $value = get_field('trajet_ville_sieges_line_1');
  if ( is_string($value) && $value !== '' ) { $sieges_line_1 = $value; }

  $value = get_field('trajet_ville_story_1_title');
  if ( is_string($value) && $value !== '' ) { $story_1_title = $value; }
  $value = get_field('trajet_ville_story_1_text');
  if ( is_string($value) && $value !== '' ) { $story_1_text = $value; }
  $value = get_field('trajet_ville_story_2_title');
  if ( is_string($value) && $value !== '' ) { $story_2_title = $value; }
  $value = get_field('trajet_ville_story_2_text');
  if ( is_string($value) && $value !== '' ) { $story_2_text = $value; }
}

$reserve_url = add_query_arg('reservation', '1', get_permalink()) . '#reservation-map';
?>

<main class="page">
  <?php if ( ! $show_reservation ) : ?>
    <div class="aero-landing aero-landing--depose">
      <section class="aero-hero" style="--aero-hero: url('<?php echo esc_url($hero_img); ?>');">
        <div class="aero-hero__label"><?php echo esc_html($hero_label); ?></div>
      </section>

      <section class="aero-feature-row" aria-label="Points forts">
        <article class="aero-feature-item">
          <span class="aero-feature-item__icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" viewBox="0 0 90 90" fill="none">
              <path d="M50.625 78.75H22.5C20.5109 78.75 18.6032 77.9598 17.1967 76.5533C15.7902 75.1468 15 73.2391 15 71.25V26.25C15 24.2609 15.7902 22.3532 17.1967 20.9467C18.6032 19.5402 20.5109 18.75 22.5 18.75H67.5C69.4891 18.75 71.3968 19.5402 72.8033 20.9467C74.2098 22.3532 75 24.2609 75 26.25V45M60 11.25V26.25M30 11.25V26.25M15 41.25H75M71.25 60L63.75 71.25H78.75L71.25 82.5" stroke="#3A0713" stroke-width="5.625" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <h3 class="aero-feature-item__title aero-feature-item__title--reservation"><?php echo esc_html($card_1_title); ?></h3>
          <p class="aero-feature-item__text aero-feature-item__text--pickup"><?php echo esc_html($card_1_text); ?></p>
        </article>
        <article class="aero-feature-item">
          <span class="aero-feature-item__icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" viewBox="0 0 90 90" fill="none">
              <path d="M78.75 44.9999C78.75 38.3216 76.7687 31.7934 73.0569 26.2417C69.345 20.6899 64.0696 16.3641 57.8982 13.8119C51.7268 11.2596 44.937 10.5957 38.3881 11.904C31.8392 13.2124 25.8257 16.4342 21.1086 21.1617C16.3916 25.8893 13.1832 31.9099 11.8894 38.4617C10.5956 45.0135 11.2747 51.8019 13.8407 57.9676C16.4066 64.1332 20.7441 69.3991 26.3041 73.0985C31.8641 76.798 38.3967 78.7648 45.075 78.7499" stroke="#3A0713" stroke-width="5.625" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M45 26.25V45L48.75 48.75M82.5 60C82.5 75 73.125 82.5 69.375 82.5C65.625 82.5 56.25 75 56.25 60C60 60 65.625 58.125 69.375 54.375C73.125 58.125 78.75 60 82.5 60Z" stroke="#3A0713" stroke-width="5.625" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <h3 class="aero-feature-item__title aero-feature-item__title--pickup"><?php echo esc_html($card_2_title); ?></h3>
          <p class="aero-feature-item__text aero-feature-item__text--timing"><?php echo esc_html($card_2_text); ?></p>
        </article>
        <article class="aero-feature-item">
          <span class="aero-feature-item__icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" viewBox="0 0 90 90" fill="none">
              <path d="M73.1249 47.1448L44.9999 74.9998L16.8749 47.1448C15.0198 45.3396 13.5586 43.1699 12.5832 40.7722C11.6079 38.3745 11.1395 35.8009 11.2077 33.2133C11.2758 30.6257 11.879 28.0803 12.9792 25.7373C14.0795 23.3943 15.6529 21.3045 17.6005 19.5995C19.548 17.8945 21.8276 16.6111 24.2954 15.8304C26.7633 15.0496 29.3662 14.7882 31.94 15.0628C34.5139 15.3374 37.003 16.1419 39.2507 17.4257C41.4983 18.7095 43.4558 20.4448 44.9999 22.5223C46.5507 20.4599 48.5104 18.7398 50.7565 17.4696C53.0026 16.1994 55.4868 15.4065 58.0534 15.1405C60.62 14.8745 63.214 15.1412 65.6728 15.9238C68.1317 16.7064 70.4025 17.9881 72.3432 19.6887C74.2839 21.3893 75.8528 23.4721 76.9515 25.8069C78.0502 28.1417 78.6552 30.6781 78.7286 33.2575C78.8019 35.8368 78.3421 38.4035 77.3779 40.797C76.4137 43.1905 74.9658 45.3591 73.1249 47.1673" stroke="#3A0713" stroke-width="5.625" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <h3 class="aero-feature-item__title aero-feature-item__title--serenites"><?php echo esc_html($card_3_title); ?></h3>
          <p class="aero-feature-item__text aero-feature-item__text--serenites"><?php echo esc_html($card_3_text); ?></p>
        </article>
      </section>
      <div class="aero-feature-dots" aria-hidden="true">
        <span></span><span></span><span></span>
      </div>

      <section class="aero-split" aria-label="Details vehicule">
        <aside class="aero-side-menu" aria-label="Navigation details">
          <a class="aero-side-menu__row" href="#coffre" data-aero-accordion-toggle="coffre">
            <span><?php echo esc_html($coffre_title); ?></span>
            <span class="aero-side-menu__chevron" aria-hidden="true">&#9662;</span>
          </a>
          <div class="aero-side-menu__panel aero-side-menu__panel--coffre" data-aero-accordion-panel="coffre" hidden>
            <p><?php echo esc_html($coffre_line_1); ?></p>
            <p><?php echo esc_html($coffre_line_2); ?></p>
            <a href="#coffre"><?php echo esc_html($coffre_guide_label); ?> &rsaquo;</a>
          </div>
          <a class="aero-side-menu__row" href="#sieges" data-aero-accordion-toggle="sieges">
            <span><?php echo esc_html($sieges_title); ?></span>
            <span class="aero-side-menu__chevron" aria-hidden="true">&#9662;</span>
          </a>
          <div class="aero-side-menu__panel aero-side-menu__panel--sieges" data-aero-accordion-panel="sieges" hidden>
            <p><?php echo esc_html($sieges_line_1); ?></p>
          </div>
          <a class="aero-side-menu__btn" href="<?php echo esc_url($reserve_url); ?>">Reserver</a>
        </aside>
        <figure class="aero-img-card aero-img-card--2" aria-label="Photo vehicule">
          <img
            src="<?php echo esc_url($img_front); ?>"
            alt="Photo vehicule"
            data-aero-main-image
            data-image-default="<?php echo esc_url($img_front); ?>"
            data-image-coffre="<?php echo esc_url($img_coffre); ?>"
            data-image-sieges="<?php echo esc_url($img_sieges); ?>"
          >
        </figure>
      </section>

      <div class="aero-story-stack">
        <section class="aero-story" id="coffre">
          <article class="aero-text-block">
            <h2><?php echo esc_html($story_1_title); ?></h2>
            <p><?php echo esc_html($story_1_text); ?></p>
          </article>
          <figure class="aero-story__media">
            <img src="<?php echo esc_url($img_luggage); ?>" alt="Trajet en ville - illustration 1">
          </figure>
        </section>

        <section class="aero-story aero-story--reverse" id="sieges">
          <figure class="aero-story__media">
            <img src="<?php echo esc_url($img_business); ?>" alt="Trajet en ville - illustration 2">
          </figure>
          <article class="aero-text-block">
            <h2><?php echo esc_html($story_2_title); ?></h2>
            <p><?php echo esc_html($story_2_text); ?></p>
          </article>
        </section>
      </div>

    </div>
  <?php else : ?>
    <div id="reservation-map">
      <?php echo do_shortcode('[thiam_vtc_clean_resa mode="city"]'); ?>
    </div>
  <?php endif; ?>
</main>

<?php get_footer(); ?>
