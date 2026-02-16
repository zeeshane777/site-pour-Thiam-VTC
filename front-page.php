<?php
get_header();

$asset_base = get_template_directory_uri() . '/assets/';

$home_hero_image = $asset_base . rawurlencode('hero1.webp');
$home_hero_title_line_1 = 'Votre prochain trajet';
$home_hero_title_line_2 = 'dans ce qui se fait de mieux';
$home_form_title = 'Ou allons-nous ?';

$home_premium_title = 'SERVICES DE CHAUFFEUR PRIVE PREMIUM';
$home_premium_text = "Profitez d'un service de transport haut de gamme avec chauffeur professionnel. Vehicule confortable, ponctualite garantie et discretion assuree pour tous vos deplacements. Que ce soit pour un trajet prive, professionnel ou touristique, nous vous accompagnons avec serieux et elegance afin de vous offrir une experience de voyage sereine.";

$home_popular_title = 'Les services populaires';
$home_card_1_title = 'Transfert aeroport';
$home_card_1_cta = 'Decouvrir >';
$home_card_1_url = home_url('/depose-aeroport/');
$home_card_1_img = $asset_base . rawurlencode('photo avion aeroport.webp');

$home_card_2_title = 'Trajet en ville';
$home_card_2_cta = 'Decouvrir >';
$home_card_2_url = home_url('/trajet-en-ville/');
$home_card_2_img = $asset_base . rawurlencode('trajet en ville.webp');

$home_card_3_title = 'Trajet touristique';
$home_card_3_cta = 'Decouvrir >';
$home_card_3_url = home_url('/parcours-touristique/');
$home_card_3_img = $asset_base . rawurlencode('Photo parcours touristique.webp');

$home_presentation_image = $asset_base . rawurlencode('photo chauffeur homepage.webp');
$home_presentation_title = 'PLUS QU\'UN SIMPLE TRAJET';
$home_presentation_text_1 = "Plus qu'un simple deplacement d'un point A vers un point B, chaque trajet que vous entreprenez avec nous est une veritable experience sur mesure, minutieusement pensee pour votre confort absolu et votre totale serenite. Nous sommes convaincus que le transport ne doit plus etre une contrainte, mais une parenthese privilegiee dans votre journee.";
$home_presentation_text_2 = "C'est pourquoi nous mettons un point d'honneur a soigner chaque detail, de l'accueil personnalise a la fluidite de la conduite, afin de vous garantir un moment agreable et ressourcant. Notre engagement est de transformer vos minutes de voyage en un instant de calme et de raffinement, ou votre seule preoccupation sera de vous laisser porter.";

$home_reviews_title = 'Les avis de nos clients';
$home_review_1_name = 'Sandrine Duval';
$home_review_1_meta = 'Parcours touristique il y a 1 jour';
$home_review_1_headline = 'Experience Parisienne Inoubliable !';
$home_review_1_text_1 = "Un service tout simplement exceptionnel ! J'ai eu le plaisir d'etre conduite par Monsieur Antoine a bord d'un magnifique Mercedes Classe V pour mon tour touristique.";
$home_review_1_text_2 = "Le confort du vehicule est incomparable : spacieux et impeccable, parfait pour admirer Paris sans stress logistique.";
$home_review_1_text_3 = "Monsieur Antoine a fait preuve d'un professionnalisme rare. Il etait ponctuel, discret et d'une courtoisie exquise, adaptant l'itineraire a mes envies tout en partageant des anecdotes passionnantes.";

$home_review_2_name = 'Martin Rodrigues';
$home_review_2_meta = 'Trajet en ville il y a 3 jours';
$home_review_2_headline = 'Un trajet parfait du debut a la fin';
$home_review_2_text_1 = 'Vehicule confortable, chauffeur tres professionnel et ponctuel.';
$home_review_2_text_2 = 'Reservation rapide et service fluide. Je recommande sans hesiter.';

$home_review_3_name = 'Louise Renard';
$home_review_3_meta = 'Transfert aeroport il y a 2 jours';
$home_review_3_headline = 'Confort et serenite';
$home_review_3_text_1 = "Arrivee a l'heure, conduite souple et service premium.";
$home_review_3_text_2 = 'Une experience tres rassurante, je reprendrai ce service.';

if ( function_exists('get_field') ) {
  $value = get_field('home_hero_image');
  if ( is_array($value) && ! empty($value['url']) ) { $home_hero_image = $value['url']; }
  elseif ( is_string($value) && $value !== '' ) { $home_hero_image = $value; }

  $value = get_field('home_hero_title_line_1');
  if ( is_string($value) && $value !== '' ) { $home_hero_title_line_1 = $value; }
  $value = get_field('home_hero_title_line_2');
  if ( is_string($value) && $value !== '' ) { $home_hero_title_line_2 = $value; }
  $value = get_field('home_form_title');
  if ( is_string($value) && $value !== '' ) { $home_form_title = $value; }
  $value = get_field('home_premium_title');
  if ( is_string($value) && $value !== '' ) { $home_premium_title = $value; }
  $value = get_field('home_premium_text');
  if ( is_string($value) && $value !== '' ) { $home_premium_text = $value; }
  $value = get_field('home_popular_title');
  if ( is_string($value) && $value !== '' ) { $home_popular_title = $value; }

  $value = get_field('home_card_1_title');
  if ( is_string($value) && $value !== '' ) { $home_card_1_title = $value; }
  $value = get_field('home_card_1_cta');
  if ( is_string($value) && $value !== '' ) { $home_card_1_cta = $value; }
  $value = get_field('home_card_1_url');
  if ( is_string($value) && $value !== '' ) { $home_card_1_url = $value; }
  $value = get_field('home_card_1_img');
  if ( is_array($value) && ! empty($value['url']) ) { $home_card_1_img = $value['url']; }
  elseif ( is_string($value) && $value !== '' ) { $home_card_1_img = $value; }

  $value = get_field('home_card_2_title');
  if ( is_string($value) && $value !== '' ) { $home_card_2_title = $value; }
  $value = get_field('home_card_2_cta');
  if ( is_string($value) && $value !== '' ) { $home_card_2_cta = $value; }
  $value = get_field('home_card_2_url');
  if ( is_string($value) && $value !== '' ) { $home_card_2_url = $value; }
  $value = get_field('home_card_2_img');
  if ( is_array($value) && ! empty($value['url']) ) { $home_card_2_img = $value['url']; }
  elseif ( is_string($value) && $value !== '' ) { $home_card_2_img = $value; }

  $value = get_field('home_card_3_title');
  if ( is_string($value) && $value !== '' ) { $home_card_3_title = $value; }
  $value = get_field('home_card_3_cta');
  if ( is_string($value) && $value !== '' ) { $home_card_3_cta = $value; }
  $value = get_field('home_card_3_url');
  if ( is_string($value) && $value !== '' ) { $home_card_3_url = $value; }
  $value = get_field('home_card_3_img');
  if ( is_array($value) && ! empty($value['url']) ) { $home_card_3_img = $value['url']; }
  elseif ( is_string($value) && $value !== '' ) { $home_card_3_img = $value; }

  $value = get_field('home_presentation_image');
  if ( is_array($value) && ! empty($value['url']) ) { $home_presentation_image = $value['url']; }
  elseif ( is_string($value) && $value !== '' ) { $home_presentation_image = $value; }

  $value = get_field('home_presentation_title');
  if ( is_string($value) && $value !== '' ) { $home_presentation_title = $value; }
  $value = get_field('home_presentation_text_1');
  if ( is_string($value) && $value !== '' ) { $home_presentation_text_1 = $value; }
  $value = get_field('home_presentation_text_2');
  if ( is_string($value) && $value !== '' ) { $home_presentation_text_2 = $value; }

  $value = get_field('home_reviews_title');
  if ( is_string($value) && $value !== '' ) { $home_reviews_title = $value; }

  $value = get_field('home_review_1_name');
  if ( is_string($value) && $value !== '' ) { $home_review_1_name = $value; }
  $value = get_field('home_review_1_meta');
  if ( is_string($value) && $value !== '' ) { $home_review_1_meta = $value; }
  $value = get_field('home_review_1_headline');
  if ( is_string($value) && $value !== '' ) { $home_review_1_headline = $value; }
  $value = get_field('home_review_1_text_1');
  if ( is_string($value) && $value !== '' ) { $home_review_1_text_1 = $value; }
  $value = get_field('home_review_1_text_2');
  if ( is_string($value) && $value !== '' ) { $home_review_1_text_2 = $value; }
  $value = get_field('home_review_1_text_3');
  if ( is_string($value) && $value !== '' ) { $home_review_1_text_3 = $value; }

  $value = get_field('home_review_2_name');
  if ( is_string($value) && $value !== '' ) { $home_review_2_name = $value; }
  $value = get_field('home_review_2_meta');
  if ( is_string($value) && $value !== '' ) { $home_review_2_meta = $value; }
  $value = get_field('home_review_2_headline');
  if ( is_string($value) && $value !== '' ) { $home_review_2_headline = $value; }
  $value = get_field('home_review_2_text_1');
  if ( is_string($value) && $value !== '' ) { $home_review_2_text_1 = $value; }
  $value = get_field('home_review_2_text_2');
  if ( is_string($value) && $value !== '' ) { $home_review_2_text_2 = $value; }

  $value = get_field('home_review_3_name');
  if ( is_string($value) && $value !== '' ) { $home_review_3_name = $value; }
  $value = get_field('home_review_3_meta');
  if ( is_string($value) && $value !== '' ) { $home_review_3_meta = $value; }
  $value = get_field('home_review_3_headline');
  if ( is_string($value) && $value !== '' ) { $home_review_3_headline = $value; }
  $value = get_field('home_review_3_text_1');
  if ( is_string($value) && $value !== '' ) { $home_review_3_text_1 = $value; }
  $value = get_field('home_review_3_text_2');
  if ( is_string($value) && $value !== '' ) { $home_review_3_text_2 = $value; }
}
?>

<main>
  <section class="hero parallax-zoom" style="background-image:url('<?php echo esc_url($home_hero_image); ?>');">
    <div class="hero__content">
      <h1 class="hero__title">
        <?php echo esc_html($home_hero_title_line_1); ?><br>
        <?php echo esc_html($home_hero_title_line_2); ?>
      </h1>
    </div>
  </section>

  <div class="home-gap">
    <div class="home-gap__inner">
      <form class="hero-form" id="hero-form" action="<?php echo esc_url( home_url('/trajet-en-ville/') ); ?>" method="get">
        <input type="hidden" name="reservation" value="1">
        <h2><?php echo esc_html($home_form_title); ?></h2>

        <div class="hero-form__addresses">

          <!-- Champ Départ -->
          <div class="field">
            <span class="field__tag">Départ</span>

            <input type="text" id="hero-start" name="start" placeholder="Adresse, gare, aéroport" autocomplete="off">

            <div class="hero-suggestions" id="hero-start-suggestions" role="listbox"></div>

            <span class="field__icon" aria-hidden="true">
              <!-- Pin -->
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M9 11C9 11.7956 9.31607 12.5587 9.87868 13.1213C10.4413 13.6839 11.2044 14 12 14C12.7956 14 13.5587 13.6839 14.1213 13.1213C14.6839 12.5587 15 11.7956 15 11C15 10.2044 14.6839 9.44129 14.1213 8.87868C13.5587 8.31607 12.7956 8 12 8C11.2044 8 10.4413 8.31607 9.87868 8.87868C9.31607 9.44129 9 10.2044 9 11Z" stroke="#141414" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M17.657 16.657L13.414 20.9C13.039 21.2746 12.5306 21.4851 12.0005 21.4851C11.4704 21.4851 10.962 21.2746 10.587 20.9L6.343 16.657C5.22422 15.5382 4.46234 14.1127 4.15369 12.5609C3.84504 11.009 4.00349 9.40053 4.60901 7.93874C5.21452 6.47696 6.2399 5.22755 7.55548 4.34852C8.87107 3.46949 10.4178 3.00031 12 3.00031C13.5822 3.00031 15.1289 3.46949 16.4445 4.34852C17.7601 5.22755 18.7855 6.47696 19.391 7.93874C19.9965 9.40053 20.155 11.009 19.8463 12.5609C19.5377 14.1127 18.7758 15.5382 17.657 16.657Z" stroke="#141414" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
          </div>

          <!-- Champ Arrivée -->
          <div class="field">
            <span class="field__tag">Arrivée</span>

            <input type="text" id="hero-end" name="end" placeholder="Adresse de destination" autocomplete="off">

            <div class="hero-suggestions" id="hero-end-suggestions" role="listbox"></div>

            <span class="field__icon" aria-hidden="true">
              <!-- Pin -->
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M9 11C9 11.7956 9.31607 12.5587 9.87868 13.1213C10.4413 13.6839 11.2044 14 12 14C12.7956 14 13.5587 13.6839 14.1213 13.1213C14.6839 12.5587 15 11.7956 15 11C15 10.2044 14.6839 9.44129 14.1213 8.87868C13.5587 8.31607 12.7956 8 12 8C11.2044 8 10.4413 8.31607 9.87868 8.87868C9.31607 9.44129 9 10.2044 9 11Z" stroke="#141414" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M17.657 16.657L13.414 20.9C13.039 21.2746 12.5306 21.4851 12.0005 21.4851C11.4704 21.4851 10.962 21.2746 10.587 20.9L6.343 16.657C5.22422 15.5382 4.46234 14.1127 4.15369 12.5609C3.84504 11.009 4.00349 9.40053 4.60901 7.93874C5.21452 6.47696 6.2399 5.22755 7.55548 4.34852C8.87107 3.46949 10.4178 3.00031 12 3.00031C13.5822 3.00031 15.1289 3.46949 16.4445 4.34852C17.7601 5.22755 18.7855 6.47696 19.391 7.93874C19.9965 9.40053 20.155 11.009 19.8463 12.5609C19.5377 14.1127 18.7758 15.5382 17.657 16.657Z" stroke="#141414" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </span>
          </div>

        </div><!-- /.hero-form__addresses -->

        <div class="hero-form__time">
          <button type="button">Quand</button>
          <button type="button">Maintenant</button>
          <button type="button">Plus tard</button>
          <span class="hero-form__calendar" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path d="M16 3V7M8 3V7M4 11H20M4 7C4 6.46957 4.21071 5.96086 4.58579 5.58579C4.96086 5.21071 5.46957 5 6 5H18C18.5304 5 19.0391 5.21071 19.4142 5.58579C19.7893 5.96086 20 6.46957 20 7V19C20 19.5304 19.7893 20.0391 19.4142 20.4142C19.0391 20.7893 18.5304 21 18 21H6C5.46957 21 4.21071 20.7893 4.58579 20.4142C4.21071 20.0391 4 19.5304 4 19V7Z" stroke="#141414" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M8 15H10V17H8V15Z" stroke="#141414" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
          </span>
        </div>

        <div class="hero-form__actions">
          <button class="btn-primary" type="submit">R&eacute;server</button>
        </div>

      </form>
    </div>
  </div>

  <section class="premium parallax-zoom">
    <div class="premium__inner">
      <h2 class="premium__title"><?php echo esc_html($home_premium_title); ?></h2>
      <p class="premium__text">
        <?php echo esc_html($home_premium_text); ?>
      </p>
    </div>
  </section>
  <section class="popular">
    <div class="popular__header">
      <h2 class="popular__title"><?php echo esc_html($home_popular_title); ?></h2>
      <hr class="popular__rule" />
    </div>

    <div class="popular__grid">
      <a class="card card--big" href="<?php echo esc_url($home_card_1_url); ?>">
        <div class="card__media">
          <img src="<?php echo esc_url($home_card_1_img); ?>" alt="<?php echo esc_attr($home_card_1_title); ?>" />
        </div>

        <div class="card__overlay">
          <p class="card__title"><?php echo esc_html($home_card_1_title); ?></p>
          <p class="card__cta"><?php echo esc_html($home_card_1_cta); ?></p>
        </div>
      </a>

      <a class="card" href="<?php echo esc_url($home_card_2_url); ?>">
        <div class="card__media">
          <img src="<?php echo esc_url($home_card_2_img); ?>" alt="<?php echo esc_attr($home_card_2_title); ?>" />
        </div>

        <div class="card__overlay">
          <p class="card__title"><?php echo esc_html($home_card_2_title); ?></p>
          <p class="card__cta"><?php echo esc_html($home_card_2_cta); ?></p>
        </div>
      </a>

      <a class="card" href="<?php echo esc_url($home_card_3_url); ?>">
        <div class="card__media">
          <img src="<?php echo esc_url($home_card_3_img); ?>" alt="<?php echo esc_attr($home_card_3_title); ?>" />
        </div>

        <div class="card__overlay">
          <p class="card__title"><?php echo esc_html($home_card_3_title); ?></p>
          <p class="card__cta"><?php echo esc_html($home_card_3_cta); ?></p>
        </div>
      </a>
    </div>
  </section>  <section class="presentation">
    <div class="presentation__content">
      <h2 class="presentation__title"><?php echo esc_html($home_presentation_title); ?></h2>
      <div class="presentation__text">
        <p>
          <?php echo esc_html($home_presentation_text_1); ?>
        </p>
        <p>
          <?php echo esc_html($home_presentation_text_2); ?>
        </p>
      </div>
      <div class="presentation__image parallax-zoom">
        <img src="<?php echo esc_url($home_presentation_image); ?>" alt="Chauffeur prive" />
      </div>
    </div>
  </section>

  <section class="reviews reviews--slider">
    <h2><?php echo esc_html($home_reviews_title); ?></h2>
    <hr>

    <div class="slider">
      <div class="slider__track">
        <div class="review">
          <h3 class="review__name"><?php echo esc_html($home_review_1_name); ?></h3>
          <p class="review__meta"><?php echo esc_html($home_review_1_meta); ?></p>
          <p class="review__headline"><span class="review__stars">&#9733; &#9733; &#9733; &#9733; &#9733;</span><strong><?php echo esc_html($home_review_1_headline); ?></strong></p>
          <p class="review__text"><?php echo esc_html($home_review_1_text_1); ?></p>
          <p class="review__text"><?php echo esc_html($home_review_1_text_2); ?></p>
          <p class="review__text"><?php echo esc_html($home_review_1_text_3); ?></p>
        </div>

        <div class="review">
          <h3 class="review__name"><?php echo esc_html($home_review_2_name); ?></h3>
          <p class="review__meta"><?php echo esc_html($home_review_2_meta); ?></p>
          <p class="review__headline"><span class="review__stars">&#9733; &#9733; &#9733; &#9733; &#9733;</span><strong><?php echo esc_html($home_review_2_headline); ?></strong></p>
          <p class="review__text"><?php echo esc_html($home_review_2_text_1); ?></p>
          <p class="review__text"><?php echo esc_html($home_review_2_text_2); ?></p>
        </div>

        <div class="review">
          <h3 class="review__name"><?php echo esc_html($home_review_3_name); ?></h3>
          <p class="review__meta"><?php echo esc_html($home_review_3_meta); ?></p>
          <p class="review__headline"><span class="review__stars">&#9733; &#9733; &#9733; &#9733; &#9733;</span><strong><?php echo esc_html($home_review_3_headline); ?></strong></p>
          <p class="review__text"><?php echo esc_html($home_review_3_text_1); ?></p>
          <p class="review__text"><?php echo esc_html($home_review_3_text_2); ?></p>
        </div>

        <div class="review">
          <h3 class="review__name"><?php echo esc_html($home_review_1_name); ?></h3>
          <p class="review__meta"><?php echo esc_html($home_review_1_meta); ?></p>
          <p class="review__headline"><span class="review__stars">&#9733; &#9733; &#9733; &#9733; &#9733;</span><strong><?php echo esc_html($home_review_1_headline); ?></strong></p>
          <p class="review__text"><?php echo esc_html($home_review_1_text_1); ?></p>
          <p class="review__text"><?php echo esc_html($home_review_1_text_2); ?></p>
          <p class="review__text"><?php echo esc_html($home_review_1_text_3); ?></p>
        </div>

        <div class="review">
          <h3 class="review__name"><?php echo esc_html($home_review_2_name); ?></h3>
          <p class="review__meta"><?php echo esc_html($home_review_2_meta); ?></p>
          <p class="review__headline"><span class="review__stars">&#9733; &#9733; &#9733; &#9733; &#9733;</span><strong><?php echo esc_html($home_review_2_headline); ?></strong></p>
          <p class="review__text"><?php echo esc_html($home_review_2_text_1); ?></p>
          <p class="review__text"><?php echo esc_html($home_review_2_text_2); ?></p>
        </div>

        <div class="review">
          <h3 class="review__name"><?php echo esc_html($home_review_3_name); ?></h3>
          <p class="review__meta"><?php echo esc_html($home_review_3_meta); ?></p>
          <p class="review__headline"><span class="review__stars">&#9733; &#9733; &#9733; &#9733; &#9733;</span><strong><?php echo esc_html($home_review_3_headline); ?></strong></p>
          <p class="review__text"><?php echo esc_html($home_review_3_text_1); ?></p>
          <p class="review__text"><?php echo esc_html($home_review_3_text_2); ?></p>
        </div>
      </div>
    </div>
  </section></main>

<?php get_footer(); ?>
