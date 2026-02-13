<?php
/**
 * Template Name: Trajet En Ville
 * Template Post Type: page
 */
get_header();

$show_reservation = isset($_GET['reservation']) && $_GET['reservation'] === '1';
$asset_base = get_template_directory_uri() . '/assets/';

function thiam_page_asset_url($base, $file) {
  return $base . rawurlencode($file);
}

$hero_img = thiam_page_asset_url($asset_base, 'trajet en ville.webp');
$img_front = thiam_page_asset_url($asset_base, 'Merco avant.webp');
$img_luggage = thiam_page_asset_url($asset_base, 'van trajet en ville.webp');
$img_business = thiam_page_asset_url($asset_base, 'poignet trajet en ville.webp');
$icon_reservation = thiam_page_asset_url($asset_base, 'calendar-event.svg');
$icon_pickup = thiam_page_asset_url($asset_base, 'clock-shield.svg');
$icon_serenite = thiam_page_asset_url($asset_base, 'heart.svg');

$reserve_url = add_query_arg('reservation', '1', get_permalink());
$reserve_url = $reserve_url . '#reservation-map';
?>

<main class="page">
  <?php if ( ! $show_reservation ) : ?>
    <div class="aero-landing aero-landing--depose">
      <section class="aero-hero" style="--aero-hero: url('<?php echo esc_url($hero_img); ?>');">
        <div class="aero-hero__label">Trajet en ville</div>
      </section>

      <section class="aero-feature-row" aria-label="Points forts">
        <article class="aero-feature-item">
          <span class="aero-feature-item__icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" viewBox="0 0 90 90" fill="none">
              <path d="M50.625 78.75H22.5C20.5109 78.75 18.6032 77.9598 17.1967 76.5533C15.7902 75.1468 15 73.2391 15 71.25V26.25C15 24.2609 15.7902 22.3532 17.1967 20.9467C18.6032 19.5402 20.5109 18.75 22.5 18.75H67.5C69.4891 18.75 71.3968 19.5402 72.8033 20.9467C74.2098 22.3532 75 24.2609 75 26.25V45M60 11.25V26.25M30 11.25V26.25M15 41.25H75M71.25 60L63.75 71.25H78.75L71.25 82.5" stroke="#3A0713" stroke-width="5.625" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <h3 class="aero-feature-item__title aero-feature-item__title--reservation">Réservation rapide</h3>
          <p class="aero-feature-item__text aero-feature-item__text--pickup">Indiquez votre point de départ et votre destination pour organiser votre déplacement en toute simplicité.</p>
        </article>
        <article class="aero-feature-item">
          <span class="aero-feature-item__icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" viewBox="0 0 90 90" fill="none">
              <path d="M78.75 44.9999C78.75 38.3216 76.7687 31.7934 73.0569 26.2417C69.345 20.6899 64.0696 16.3641 57.8982 13.8119C51.7268 11.2596 44.937 10.5957 38.3881 11.904C31.8392 13.2124 25.8257 16.4342 21.1086 21.1617C16.3916 25.8893 13.1832 31.9099 11.8894 38.4617C10.5956 45.0135 11.2747 51.8019 13.8407 57.9676C16.4066 64.1332 20.7441 69.3991 26.3041 73.0985C31.8641 76.798 38.3967 78.7648 45.075 78.7499" stroke="#3A0713" stroke-width="5.625" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M45 26.25V45L48.75 48.75M82.5 60C82.5 75 73.125 82.5 69.375 82.5C65.625 82.5 56.25 75 56.25 60C60 60 65.625 58.125 69.375 54.375C73.125 58.125 78.75 60 82.5 60Z" stroke="#3A0713" stroke-width="5.625" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <h3 class="aero-feature-item__title aero-feature-item__title--pickup">Prise en charge</h3>
          <p class="aero-feature-item__text aero-feature-item__text--timing">Le trajet s'adapte à votre emploi du temps, à vos besoins et aux conditions de circulation.</p>
        </article>
        <article class="aero-feature-item">
          <span class="aero-feature-item__icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="90" height="90" viewBox="0 0 90 90" fill="none">
              <path d="M73.1249 47.1448L44.9999 74.9998L16.8749 47.1448C15.0198 45.3396 13.5586 43.1699 12.5832 40.7722C11.6079 38.3745 11.1395 35.8009 11.2077 33.2133C11.2758 30.6257 11.879 28.0803 12.9792 25.7373C14.0795 23.3943 15.6529 21.3045 17.6005 19.5995C19.548 17.8945 21.8276 16.6111 24.2954 15.8304C26.7633 15.0496 29.3662 14.7882 31.94 15.0628C34.5139 15.3374 37.003 16.1419 39.2507 17.4257C41.4983 18.7095 43.4558 20.4448 44.9999 22.5223C46.5507 20.4599 48.5104 18.7398 50.7565 17.4696C53.0026 16.1994 55.4868 15.4065 58.0534 15.1405C60.62 14.8745 63.214 15.1412 65.6728 15.9238C68.1317 16.7064 70.4025 17.9881 72.3432 19.6887C74.2839 21.3893 75.8528 23.4721 76.9515 25.8069C78.0502 28.1417 78.6552 30.6781 78.7286 33.2575C78.8019 35.8368 78.3421 38.4035 77.3779 40.797C76.4137 43.1905 74.9658 45.3591 73.1249 47.1673" stroke="#3A0713" stroke-width="5.625" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <h3 class="aero-feature-item__title aero-feature-item__title--serenites">Sérénité</h3>
          <p class="aero-feature-item__text aero-feature-item__text--serenites">Déplacez-vous sereinement, sans contrainte de stationnement ou de transport.</p>
        </article>
      </section>
      <div class="aero-feature-dots" aria-hidden="true">
        <span></span><span></span><span></span>
      </div>

      <section class="aero-split" aria-label="Details vehicule">
        <aside class="aero-side-menu" aria-label="Navigation details">
          <a class="aero-side-menu__row" href="#coffre" data-aero-accordion-toggle="coffre">
            <span>Volumes du coffre</span>
            <span class="aero-side-menu__chevron" aria-hidden="true">&#9662;</span>
          </a>
          <div class="aero-side-menu__panel aero-side-menu__panel--coffre" data-aero-accordion-panel="coffre" hidden>
            <p>Volume disponible dans le coffre 300 litre</p>
            <p>Soit 1 x XL, 1 x L, 1 x M</p>
            <a href="#coffre">Guide de taille &rsaquo;</a>
          </div>
          <a class="aero-side-menu__row" href="#sieges" data-aero-accordion-toggle="sieges">
            <span>Sièges</span>
            <span class="aero-side-menu__chevron" aria-hidden="true">&#9662;</span>
          </a>
          <div class="aero-side-menu__panel aero-side-menu__panel--sieges" data-aero-accordion-panel="sieges" hidden>
            <p>Ce véhicule peut accueillir 6 passagers maximum</p>
          </div>
          <a class="aero-side-menu__btn" href="<?php echo esc_url($reserve_url); ?>">Réservez</a>
        </aside>
        <figure class="aero-img-card aero-img-card--2" aria-label="Photo vehicule">
          <img src="<?php echo esc_url($img_front); ?>" alt="Photo vehicule">
        </figure>
      </section>

      <div class="aero-story-stack">
        <section class="aero-story" id="coffre">
          <article class="aero-text-block">
            <h2>UNE SOLUTION PENSÉE POUR LA VILLE</h2>
            <p>
              Se déplacer en milieu urbain demande souvent une souplesse et une réactivité exemplaires. Chaque trajet est minutieusement organisé pour s'adapter à vos contraintes personnelles et vous permettre de circuler en toute tranquillité, même aux heures de pointe. L'objectif est de rendre vos déplacements plus simples, plus fluides et plus agréables au quotidien grâce à une gestion intelligente des itinéraires. Nous mettons notre expertise au service de votre mobilité pour supprimer le stress des trajets citadins. Profitez d'une liberté totale sans compromis.
            </p>
          </article>
          <figure class="aero-story__media">
            <img src="<?php echo esc_url($img_luggage); ?>" alt="Bagages en zone aeroportuaire">
          </figure>
        </section>

        <section class="aero-story aero-story--reverse" id="sieges">
          <figure class="aero-story__media">
            <img src="<?php echo esc_url($img_business); ?>" alt="Passager pour deplacement professionnel">
          </figure>
          <article class="aero-text-block">
            <h2>SE DÉPLACER AUTREMENT</h2>
            <p>
              Une alternative pratique pour vos rendez-vous, sorties ou déplacements du quotidien, sans contrainte inutile. Nous avons conçu ce service pour vous libérer des soucis de stationnement et de circulation. Que ce soit pour un impératif médical, une soirée entre amis ou un trajet professionnel, nous vous garantissons une disponibilité totale et une souplesse sans égale. Chaque course devient un instant de confort pur, vous permettant de rester concentré sur l'essentiel. Simplifiez-vous la vie avec une solution de transport fiable, réactive et sur mesure.
            </p>
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
