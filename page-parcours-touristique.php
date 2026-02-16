<?php
/**
 * Template Name: Parcours Touristique
 * Template Post Type: page
 */
get_header();

$show_reservation = isset($_GET['reservation']) && $_GET['reservation'] === '1';
$asset_base = get_template_directory_uri() . '/assets/';

$hero_img = $asset_base . rawurlencode('Photo parcours touristique.webp');
$hero_label = 'Trajet touristique';
$img_front = $asset_base . rawurlencode('Merco avant.webp');
$img_coffre = $img_front;
$img_sieges = $img_front;
$img_luggage = $asset_base . rawurlencode('paris de jour.webp');
$img_business = $asset_base . rawurlencode('femme trajet touristique.webp');

$card_1_title = 'Organisation';
$card_1_text = "Choisissez ce qui vous fait envie et decouvrez la ville d'une nouvelle maniere.";
$card_2_title = 'Accompagnement';
$card_2_text = "Profitez pleinement de votre visite, le trajet s'adapte a votre rythme.";
$card_3_title = 'Decouverte';
$card_3_text = 'Prenez le temps de decouvrir les lieux uniques de maniere plus intime.';

$coffre_title = 'Volumes du coffre';
$coffre_line_1 = 'Volume disponible dans le coffre 300 litre';
$coffre_line_2 = 'Soit 1 x XL, 1 x L, 1 x M';
$coffre_guide_label = 'Guide de taille';
$sieges_title = 'Sieges';
$sieges_line_1 = 'Ce vehicule peut accueillir 6 passagers maximum';

$story_1_title = 'UNE AUTRE FACON DE DECOUVRIR';
$story_1_text = "Decouvrir la ville autrement, c'est prendre le temps d'en admirer les lieux les plus emblematiques dans le confort et la tranquillite d'un VTC. Nos trajets touristiques vous permettent de voyager d'un point A a un point B, tout en traversant les sites incontournables qui font la renommee de la capitale. Au fil du trajet, vous pourrez decouvrir les destinations les plus prisees par les visiteurs, telles que les Champs-Elysees, la Tour Eiffel, la place de la Concorde, le Louvre, Notre-Dame ou encore Montmartre. Grace a un service flexible et personnalise, vous profitez pleinement de votre visite a votre rythme, sans stress lie aux transports.";
$story_2_title = 'PROFITEZ DE CHAQUE INSTANT';
$story_2_text = "Laissez-vous porter et concentrez-vous sur la decouverte, nous nous occupons du reste. Notre mission est de vous liberer de toute charge mentale liee a l'organisation de vos transports. De la planification de l'itineraire a la gestion du temps, chaque aspect de votre voyage est pris en main par notre equipe avec une rigueur absolue. Profitez pleinement de la beaute des paysages ou de vos moments de detente sans vous soucier de la route. Avec nous, voyager devient un plaisir pur, fluide et sans imprevu. Votre serenite est le coeur meme de notre engagement.";

if ( function_exists('get_field') ) {
  $value = get_field('parcours_touristique_hero_image');
  if ( is_array($value) && ! empty($value['url']) ) { $hero_img = $value['url']; }
  elseif ( is_string($value) && $value !== '' ) { $hero_img = $value; }

  $value = get_field('parcours_touristique_hero_label');
  if ( is_string($value) && $value !== '' ) { $hero_label = $value; }

  $value = get_field('parcours_touristique_image_front');
  if ( is_array($value) && ! empty($value['url']) ) { $img_front = $value['url']; }
  elseif ( is_string($value) && $value !== '' ) { $img_front = $value; }
  $img_coffre = $img_front;
  $img_sieges = $img_front;

  $value = get_field('parcours_touristique_image_coffre');
  if ( is_array($value) && ! empty($value['url']) ) { $img_coffre = $value['url']; }
  elseif ( is_string($value) && $value !== '' ) { $img_coffre = $value; }

  $value = get_field('parcours_touristique_image_sieges');
  if ( is_array($value) && ! empty($value['url']) ) { $img_sieges = $value['url']; }
  elseif ( is_string($value) && $value !== '' ) { $img_sieges = $value; }

  $value = get_field('parcours_touristique_image_story_1');
  if ( is_array($value) && ! empty($value['url']) ) { $img_luggage = $value['url']; }
  elseif ( is_string($value) && $value !== '' ) { $img_luggage = $value; }

  $value = get_field('parcours_touristique_image_story_2');
  if ( is_array($value) && ! empty($value['url']) ) { $img_business = $value['url']; }
  elseif ( is_string($value) && $value !== '' ) { $img_business = $value; }

  $value = get_field('parcours_touristique_card_1_title');
  if ( is_string($value) && $value !== '' ) { $card_1_title = $value; }
  $value = get_field('parcours_touristique_card_1_text');
  if ( is_string($value) && $value !== '' ) { $card_1_text = $value; }
  $value = get_field('parcours_touristique_card_2_title');
  if ( is_string($value) && $value !== '' ) { $card_2_title = $value; }
  $value = get_field('parcours_touristique_card_2_text');
  if ( is_string($value) && $value !== '' ) { $card_2_text = $value; }
  $value = get_field('parcours_touristique_card_3_title');
  if ( is_string($value) && $value !== '' ) { $card_3_title = $value; }
  $value = get_field('parcours_touristique_card_3_text');
  if ( is_string($value) && $value !== '' ) { $card_3_text = $value; }

  $value = get_field('parcours_touristique_coffre_title');
  if ( is_string($value) && $value !== '' ) { $coffre_title = $value; }
  $value = get_field('parcours_touristique_coffre_line_1');
  if ( is_string($value) && $value !== '' ) { $coffre_line_1 = $value; }
  $value = get_field('parcours_touristique_coffre_line_2');
  if ( is_string($value) && $value !== '' ) { $coffre_line_2 = $value; }
  $value = get_field('parcours_touristique_coffre_guide_label');
  if ( is_string($value) && $value !== '' ) { $coffre_guide_label = $value; }
  $value = get_field('parcours_touristique_sieges_title');
  if ( is_string($value) && $value !== '' ) { $sieges_title = $value; }
  $value = get_field('parcours_touristique_sieges_line_1');
  if ( is_string($value) && $value !== '' ) { $sieges_line_1 = $value; }

  $value = get_field('parcours_touristique_story_1_title');
  if ( is_string($value) && $value !== '' ) { $story_1_title = $value; }
  $value = get_field('parcours_touristique_story_1_text');
  if ( is_string($value) && $value !== '' ) { $story_1_text = $value; }
  $value = get_field('parcours_touristique_story_2_title');
  if ( is_string($value) && $value !== '' ) { $story_2_title = $value; }
  $value = get_field('parcours_touristique_story_2_text');
  if ( is_string($value) && $value !== '' ) { $story_2_text = $value; }
}

$reserve_url = home_url('/trajet-en-ville/?reservation=1#reservation-map');
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
            <svg xmlns="http://www.w3.org/2000/svg" width="74" height="77" viewBox="0 0 74 77" fill="none">
              <path d="M30.9375 70.3125H10.3125C8.32338 70.3125 6.41572 69.5223 5.0092 68.1158C3.60268 66.7093 2.8125 64.8016 2.8125 62.8125V17.8125C2.8125 15.8234 3.60268 13.9157 5.0092 12.5092C6.41572 11.1027 8.32338 10.3125 10.3125 10.3125H55.3125C57.3016 10.3125 59.2093 11.1027 60.6158 12.5092C62.0223 13.9157 62.8125 15.8234 62.8125 17.8125V32.8125H2.8125M47.8125 2.8125V17.8125M17.8125 2.8125V17.8125" stroke="#3A0713" stroke-width="5.625" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M55.3125 74.0626L67.875 61.7476C68.6453 61 69.2581 60.1057 69.6772 59.1174C70.0962 58.1291 70.313 57.0669 70.3148 55.9934C70.3165 54.92 70.1032 53.857 69.6874 52.8674C69.2715 51.8777 68.6616 50.9814 67.8937 50.2313C66.3276 48.6971 64.2238 47.8359 62.0314 47.8317C59.839 47.8275 57.7319 48.6806 56.16 50.2088L55.32 51.0338L54.4837 50.2088C52.9178 48.6757 50.8147 47.8153 48.6233 47.8111C46.4318 47.8068 44.3255 48.6592 42.7537 50.1863C41.9831 50.9337 41.37 51.8278 40.9506 52.8159C40.5313 53.8041 40.3141 54.8663 40.312 55.9397C40.3099 57.0132 40.5229 58.0762 40.9384 59.066C41.3539 60.0558 41.9635 60.9523 42.7312 61.7026L55.3125 74.0626Z" stroke="#3A0713" stroke-width="5.625" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <h3 class="aero-feature-item__title aero-feature-item__title--reservation"><?php echo esc_html($card_1_title); ?></h3>
          <p class="aero-feature-item__text aero-feature-item__text--pickup"><?php echo esc_html($card_1_text); ?></p>
        </article>
        <article class="aero-feature-item">
          <span class="aero-feature-item__icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="74" height="74" viewBox="0 0 74 74" fill="none">
              <path d="M2.8125 70.3125V62.8125C2.8125 58.8343 4.39285 55.0189 7.2059 52.2059C10.0189 49.3929 13.8343 47.8125 17.8125 47.8125H32.8125C36.7907 47.8125 40.6061 49.3929 43.4191 52.2059C46.2321 55.0189 47.8125 58.8343 47.8125 62.8125V70.3125M51.5625 3.3C54.7891 4.12613 57.6489 6.00263 59.6911 8.63366C61.7334 11.2647 62.8419 14.5006 62.8419 17.8313C62.8419 21.1619 61.7334 24.3978 59.6911 27.0288C57.6489 29.6599 54.7891 31.5364 51.5625 32.3625M70.3125 70.3125V62.8125C70.2935 59.5018 69.1797 56.2905 67.1448 53.679C65.1098 51.0675 62.2681 49.2026 59.0625 48.375M10.3125 17.8125C10.3125 21.7907 11.8929 25.6061 14.7059 28.4191C17.5189 31.2321 21.3343 32.8125 25.3125 32.8125C29.2907 32.8125 33.1061 31.2321 35.9191 28.4191C38.7321 25.6061 40.3125 21.7907 40.3125 17.8125C40.3125 13.8343 38.7321 10.0189 35.9191 7.2059C33.1061 4.39285 29.2907 2.8125 25.3125 2.8125C21.3343 2.8125 17.5189 4.39285 14.7059 7.2059C11.8929 10.0189 10.3125 13.8343 10.3125 17.8125Z" stroke="#3A0713" stroke-width="5.625" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
          <h3 class="aero-feature-item__title aero-feature-item__title--pickup"><?php echo esc_html($card_2_title); ?></h3>
          <p class="aero-feature-item__text aero-feature-item__text--timing"><?php echo esc_html($card_2_text); ?></p>
        </article>
        <article class="aero-feature-item">
          <span class="aero-feature-item__icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="74" height="77" viewBox="0 0 74 77" fill="none">
              <path d="M44.0615 32.8106C44.0607 30.7437 43.4905 28.717 42.4136 26.9529C41.3366 25.1888 39.7945 23.7555 37.9564 22.8103C36.1184 21.8651 34.0554 21.4445 31.9941 21.5947C29.9327 21.7449 27.9525 22.46 26.2709 23.6617C24.5892 24.8633 23.2711 26.505 22.4612 28.4066C21.6513 30.3082 21.3809 32.3961 21.6797 34.4412C21.9785 36.4864 22.8349 38.4097 24.1549 40.0001C25.475 41.5905 27.2077 42.7865 29.1628 43.4568" stroke="#3A0713" stroke-width="5.625" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M31.9114 72.0728C30.2475 71.8718 28.6989 71.1193 27.5127 69.9353L11.5977 54.0241C8.10179 50.5277 5.52428 46.2214 4.09441 41.4884C2.66454 36.7554 2.42664 31.7423 3.40187 26.8952C4.3771 22.048 6.53522 17.5171 9.68427 13.7053C12.8333 9.89356 16.8756 6.91921 21.4517 5.04684C26.0277 3.17448 30.9956 2.46214 35.9134 2.9732C40.8312 3.48426 45.5465 5.20287 49.6397 7.97616C53.733 10.7495 57.0774 14.4914 59.3754 18.8692C61.6733 23.2471 62.8537 28.125 62.8114 33.0691" stroke="#3A0713" stroke-width="5.625" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M55.3115 74.0602L67.874 61.7451C68.6444 60.9976 69.2572 60.1033 69.6762 59.115C70.0952 58.1267 70.312 57.0644 70.3138 55.991C70.3155 54.9175 70.1022 53.8546 69.6864 52.8649C69.2706 51.8753 68.6607 50.979 67.8927 50.2289C66.3267 48.6947 64.2228 47.8335 62.0304 47.8293C59.8381 47.8251 57.7309 48.6782 56.159 50.2064L55.319 51.0314L54.4827 50.2064C52.9168 48.6733 50.8138 47.8128 48.6223 47.8086C46.4308 47.8044 44.3245 48.6568 42.7527 50.1839C41.9821 50.9312 41.369 51.8253 40.9497 52.8135C40.5303 53.8017 40.3131 54.8638 40.3111 55.9373C40.309 57.0107 40.5219 58.0737 40.9374 59.0635C41.3529 60.0533 41.9625 60.9498 42.7302 61.7002L55.3115 74.0602Z" stroke="#3A0713" stroke-width="5.625" stroke-linecap="round" stroke-linejoin="round"/>
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
            <img src="<?php echo esc_url($img_luggage); ?>" alt="Parcours touristique - illustration 1">
          </figure>
        </section>

        <section class="aero-story aero-story--reverse" id="sieges">
          <figure class="aero-story__media">
            <img src="<?php echo esc_url($img_business); ?>" alt="Parcours touristique - illustration 2">
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
