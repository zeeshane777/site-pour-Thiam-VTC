<?php
/**
 * Template Name: Depose Aeroport
 * Template Post Type: page
 */
get_header();

$show_reservation = isset($_GET['reservation']) && $_GET['reservation'] === '1';
$asset_base = get_template_directory_uri() . '/assets/';

function thiam_page_asset_url($base, $file) {
  return $base . rawurlencode($file);
}

$hero_img = thiam_page_asset_url($asset_base, 'photo avion aeroport.webp');
$img_front = thiam_page_asset_url($asset_base, 'Merco avant.webp');
$img_luggage = thiam_page_asset_url($asset_base, 'aeroportA.webp');
$img_business = thiam_page_asset_url($asset_base, 'aeroportB.webp');
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
        <div class="aero-hero__label">Transfert a&eacute;roport</div>
      </section>

      <section class="aero-feature-row" aria-label="Points forts">
        <article class="aero-feature-item">
          <span class="aero-feature-item__icon" aria-hidden="true"><img src="<?php echo esc_url($icon_reservation); ?>" alt=""></span>
          <h3 class="aero-feature-item__title aero-feature-item__title--reservation">Réservation</h3>
          <p class="aero-feature-item__text aero-feature-item__text--pickup">Indiquez votre lieu de prise en charge, votre destination et l'horaire souhaité en quelques clics.</p>
        </article>
        <article class="aero-feature-item">
          <span class="aero-feature-item__icon" aria-hidden="true"><img src="<?php echo esc_url($icon_pickup); ?>" alt=""></span>
          <h3 class="aero-feature-item__title aero-feature-item__title--pickup">Prise en charge</h3>
          <p class="aero-feature-item__text aero-feature-item__text--timing">Votre chauffeur vous attend à l'heure convenue, avec un suivi attentif de votre vol si nécessaire.</p>
        </article>
        <article class="aero-feature-item">
          <span class="aero-feature-item__icon" aria-hidden="true"><img src="<?php echo esc_url($icon_serenite); ?>" alt=""></span>
          <h3 class="aero-feature-item__title aero-feature-item__title--serenites">Sérénité</h3>
          <p class="aero-feature-item__text aero-feature-item__text--serenites">Voyagez confortablement jusqu'a votre destination finale, en toute tranquillite</p>
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
            <h2>UN TRANSFERT AÉROPORT ADAPTÉ À VOS BESOINS</h2>
            <p>
              Nous assurons vos transferts vers et depuis les aéroports avec un sérieux exemplaire et un professionnalisme constant. Que vous voyagiez seul, en famille ou pour vos impératifs professionnels, chaque trajet est rigoureusement organisé pour vous offrir un confort absolu et une tranquillité d'esprit totale. Anticipation précise des horaires, prise en charge soignée et conduite sécurisée : tout est pensé pour que votre déplacement se déroule dans les meilleures conditions. Nos chauffeurs s'engagent à faire de votre trajet un moment serein et ponctuel.
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
            <h2>UNE SOLUTION SIMPLE POUR VOS DÉPLACEMENTS</h2>
            <p>
              Organiser un transfert aéroport n'a jamais été aussi simple et rapide. Indiquez simplement votre point de départ, votre destination précise ainsi que l'horaire souhaité, et nous nous chargeons du reste avec une efficacité totale. Notre service premium est conçu pour simplifier votre logistique de voyage au maximum. Profitez d'une planification sans stress où chaque détail est géré par nos experts. De la réservation à l'arrivée, bénéficiez d'un accompagnement fluide, d'une ponctualité rigoureuse et d'un confort optimal pour tous vos trajets.
            </p>
          </article>
        </section>
      </div>

    </div>
  <?php else : ?>
    <div id="reservation-map">
      <?php echo do_shortcode('[thiam_vtc_clean_resa mode="airport"]'); ?>
    </div>
  <?php endif; ?>
</main>

<?php get_footer(); ?>

