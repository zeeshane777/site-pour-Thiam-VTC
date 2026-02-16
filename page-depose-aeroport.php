<?php
/**
 * Template Name: Depose Aeroport
 * Template Post Type: page
 */
get_header();

$show_reservation = isset($_GET['reservation']) && $_GET['reservation'] === '1';
$asset_base = get_template_directory_uri() . '/assets/';

$hero_img = $asset_base . rawurlencode('photo avion aeroport.webp');
$hero_label = 'Transfert aeroport';
$img_front = $asset_base . rawurlencode('Merco avant.webp');
$img_coffre = $img_front;
$img_sieges = $img_front;
$img_luggage = $asset_base . rawurlencode('aeroportA.webp');
$img_business = $asset_base . rawurlencode('aeroportB.webp');

$card_1_title = 'Reservation';
$card_1_text = "Indiquez votre lieu de prise en charge, votre destination et l'horaire souhaite en quelques clics.";
$card_2_title = 'Prise en charge';
$card_2_text = "Votre chauffeur vous attend a l'heure convenue, avec un suivi attentif de votre vol si necessaire.";
$card_3_title = 'Serenite';
$card_3_text = 'Voyagez confortablement jusqu a votre destination finale, en toute tranquillite.';

$coffre_title = 'Volumes du coffre';
$coffre_line_1 = 'Volume disponible dans le coffre 300 litre';
$coffre_line_2 = 'Soit 1 x XL, 1 x L, 1 x M';
$coffre_guide_label = 'Guide de taille';
$sieges_title = 'Sieges';
$sieges_line_1 = 'Ce vehicule peut accueillir 6 passagers maximum';

$story_1_title = 'UN TRANSFERT AEROPORT ADAPTE A VOS BESOINS';
$story_1_text = "Nous assurons vos transferts vers et depuis les aeroports avec un serieux exemplaire et un professionnalisme constant. Que vous voyagiez seul, en famille ou pour vos imperatifs professionnels, chaque trajet est rigoureusement organise pour vous offrir un confort absolu et une tranquillite d'esprit totale. Anticipation precise des horaires, prise en charge soignee et conduite securisee : tout est pense pour que votre deplacement se deroule dans les meilleures conditions. Nos chauffeurs s'engagent a faire de votre trajet un moment serein et ponctuel.";
$story_2_title = 'UNE SOLUTION SIMPLE POUR VOS DEPLACEMENTS';
$story_2_text = "Organiser un transfert aeroport n'a jamais ete aussi simple et rapide. Indiquez simplement votre point de depart, votre destination precise ainsi que l'horaire souhaite, et nous nous chargeons du reste avec une efficacite totale. Notre service premium est concu pour simplifier votre logistique de voyage au maximum. Profitez d'une planification sans stress ou chaque detail est gere par nos experts. De la reservation a l'arrivee, beneficiez d'un accompagnement fluide, d'une ponctualite rigoureuse et d'un confort optimal pour tous vos trajets.";

if ( function_exists('get_field') ) {
  $value = get_field('depose_aeroport_hero_image');
  if ( is_array($value) && ! empty($value['url']) ) { $hero_img = $value['url']; }
  elseif ( is_string($value) && $value !== '' ) { $hero_img = $value; }

  $value = get_field('depose_aeroport_hero_label');
  if ( is_string($value) && $value !== '' ) { $hero_label = $value; }

  $value = get_field('depose_aeroport_image_front');
  if ( is_array($value) && ! empty($value['url']) ) { $img_front = $value['url']; }
  elseif ( is_string($value) && $value !== '' ) { $img_front = $value; }
  $img_coffre = $img_front;
  $img_sieges = $img_front;

  $value = get_field('depose_aeroport_image_coffre');
  if ( is_array($value) && ! empty($value['url']) ) { $img_coffre = $value['url']; }
  elseif ( is_string($value) && $value !== '' ) { $img_coffre = $value; }

  $value = get_field('depose_aeroport_image_sieges');
  if ( is_array($value) && ! empty($value['url']) ) { $img_sieges = $value['url']; }
  elseif ( is_string($value) && $value !== '' ) { $img_sieges = $value; }

  $value = get_field('depose_aeroport_image_story_1');
  if ( is_array($value) && ! empty($value['url']) ) { $img_luggage = $value['url']; }
  elseif ( is_string($value) && $value !== '' ) { $img_luggage = $value; }

  $value = get_field('depose_aeroport_image_story_2');
  if ( is_array($value) && ! empty($value['url']) ) { $img_business = $value['url']; }
  elseif ( is_string($value) && $value !== '' ) { $img_business = $value; }

  $value = get_field('depose_aeroport_card_1_title');
  if ( is_string($value) && $value !== '' ) { $card_1_title = $value; }
  $value = get_field('depose_aeroport_card_1_text');
  if ( is_string($value) && $value !== '' ) { $card_1_text = $value; }
  $value = get_field('depose_aeroport_card_2_title');
  if ( is_string($value) && $value !== '' ) { $card_2_title = $value; }
  $value = get_field('depose_aeroport_card_2_text');
  if ( is_string($value) && $value !== '' ) { $card_2_text = $value; }
  $value = get_field('depose_aeroport_card_3_title');
  if ( is_string($value) && $value !== '' ) { $card_3_title = $value; }
  $value = get_field('depose_aeroport_card_3_text');
  if ( is_string($value) && $value !== '' ) { $card_3_text = $value; }

  $value = get_field('depose_aeroport_coffre_title');
  if ( is_string($value) && $value !== '' ) { $coffre_title = $value; }
  $value = get_field('depose_aeroport_coffre_line_1');
  if ( is_string($value) && $value !== '' ) { $coffre_line_1 = $value; }
  $value = get_field('depose_aeroport_coffre_line_2');
  if ( is_string($value) && $value !== '' ) { $coffre_line_2 = $value; }
  $value = get_field('depose_aeroport_coffre_guide_label');
  if ( is_string($value) && $value !== '' ) { $coffre_guide_label = $value; }
  $value = get_field('depose_aeroport_sieges_title');
  if ( is_string($value) && $value !== '' ) { $sieges_title = $value; }
  $value = get_field('depose_aeroport_sieges_line_1');
  if ( is_string($value) && $value !== '' ) { $sieges_line_1 = $value; }

  $value = get_field('depose_aeroport_story_1_title');
  if ( is_string($value) && $value !== '' ) { $story_1_title = $value; }
  $value = get_field('depose_aeroport_story_1_text');
  if ( is_string($value) && $value !== '' ) { $story_1_text = $value; }
  $value = get_field('depose_aeroport_story_2_title');
  if ( is_string($value) && $value !== '' ) { $story_2_title = $value; }
  $value = get_field('depose_aeroport_story_2_text');
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
          <span class="aero-feature-item__icon" aria-hidden="true"><img src="<?php echo esc_url($asset_base . rawurlencode('calendar-event.svg')); ?>" alt=""></span>
          <h3 class="aero-feature-item__title aero-feature-item__title--reservation"><?php echo esc_html($card_1_title); ?></h3>
          <p class="aero-feature-item__text aero-feature-item__text--pickup"><?php echo esc_html($card_1_text); ?></p>
        </article>
        <article class="aero-feature-item">
          <span class="aero-feature-item__icon" aria-hidden="true"><img src="<?php echo esc_url($asset_base . rawurlencode('clock-shield.svg')); ?>" alt=""></span>
          <h3 class="aero-feature-item__title aero-feature-item__title--pickup"><?php echo esc_html($card_2_title); ?></h3>
          <p class="aero-feature-item__text aero-feature-item__text--timing"><?php echo esc_html($card_2_text); ?></p>
        </article>
        <article class="aero-feature-item">
          <span class="aero-feature-item__icon" aria-hidden="true"><img src="<?php echo esc_url($asset_base . rawurlencode('heart.svg')); ?>" alt=""></span>
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
            <img src="<?php echo esc_url($img_luggage); ?>" alt="Depose aeroport - illustration 1">
          </figure>
        </section>

        <section class="aero-story aero-story--reverse" id="sieges">
          <figure class="aero-story__media">
            <img src="<?php echo esc_url($img_business); ?>" alt="Depose aeroport - illustration 2">
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
      <?php echo do_shortcode('[thiam_vtc_clean_resa mode="airport"]'); ?>
    </div>
  <?php endif; ?>
</main>

<?php get_footer(); ?>
