<?php get_header(); ?>

<main>
  <section class="hero parallax-zoom">
    <div class="hero__content">
      <h1 class="hero__title">
        Votre prochain trajet<br>
        dans ce qui se fait de mieux
      </h1>
    </div>
  </section>

  <div class="home-gap">
    <div class="home-gap__inner">
      <form class="hero-form" id="hero-form" action="<?php echo esc_url( home_url('/trajet-en-ville/') ); ?>" method="get">
        <input type="hidden" name="reservation" value="1">
        <h2>Où allons-nous ?</h2>

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
      <h2 class="premium__title">SERVICES DE CHAUFFEUR PRIV&Eacute; PREMIUM</h2>
      <p class="premium__text">
        Profitez d&#39;un service de transport haut de gamme avec chauffeur professionnel. V&#233;hicule confortable, ponctualit&#233; garantie et discr&#233;tion assur&#233;e pour tous vos d&#233;placements. Que ce soit pour un trajet priv&#233;, professionnel ou touristique, nous vous accompagnons avec s&#233;rieux et &#233;l&#233;gance afin de vous offrir une exp&#233;rience de voyage sereine.
      </p>
    </div>
  </section>
  <section class="popular">
    <div class="popular__header">
      <h2 class="popular__title">Les services populaires</h2>
      <hr class="popular__rule" />
    </div>

    <div class="popular__grid">
      <a class="card card--big" href="<?php echo esc_url( home_url('/depose-aeroport/') ); ?>">
        <div class="card__media">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/photo avion aeroport.webp" alt="Transfert aéroport" />
        </div>

        <div class="card__overlay">
          <p class="card__title">Transfert aéroport</p>
          <p class="card__cta">Découvrir &rsaquo;</p>
        </div>
      </a>

      <a class="card" href="<?php echo esc_url( home_url('/trajet-en-ville/') ); ?>">
        <div class="card__media">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/trajet en ville.webp" alt="Trajet en ville" />
        </div>

        <div class="card__overlay">
          <p class="card__title">Trajet en ville</p>
          <p class="card__cta">Découvrir &rsaquo;</p>
        </div>
      </a>

      <a class="card" href="<?php echo esc_url( home_url('/parcours-touristique/') ); ?>">
        <div class="card__media">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/Photo parcours touristique.webp" alt="Trajet touristique" />
        </div>

        <div class="card__overlay">
          <p class="card__title">Trajet touristique</p>
          <p class="card__cta">Découvrir &rsaquo;</p>
        </div>
      </a>
    </div>
  </section>  <section class="presentation">
    <div class="presentation__content">
      <h2 class="presentation__title">PLUS QU&rsquo;UN SIMPLE TRAJET</h2>
      <div class="presentation__text">
        <p>
          Plus qu&rsquo;un simple d&eacute;placement d'un point A vers un point B, chaque trajet que vous entreprenez avec nous est une v&eacute;ritable exp&eacute;rience sur mesure, minutieusement pens&eacute;e pour votre confort absolu et votre totale s&eacute;r&eacute;nit&eacute;. Nous sommes convaincus que le transport ne doit plus &ecirc;tre une contrainte, mais une parenth&egrave;se privil&eacute;gi&eacute;e dans votre journ&eacute;e.
        </p>
        <p>
          C&rsquo;est pourquoi nous mettons un point d&rsquo;honneur &agrave; soigner chaque d&eacute;tail, de l'accueil personnalis&eacute; &agrave; la fluidit&eacute; de la conduite, afin de vous garantir un moment agr&eacute;able et ressour&ccedil;ant. Notre engagement est de transformer vos minutes de voyage en un instant de calme et de raffinement, o&ugrave; votre seule pr&eacute;occupation sera de vous laisser porter.
        </p>
      </div>
      <div class="presentation__image parallax-zoom">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/photo chauffeur homepage.webp" alt="Chauffeur priv&eacute;" />
      </div>
    </div>
  </section>

  <section class="reviews reviews--slider">
    <h2>Les avis de nos clients</h2>
    <hr>

    <div class="slider">
      <div class="slider__track">
        <div class="review">
          <h3 class="review__name">Sandrine Duval</h3>
          <p class="review__meta">Parcours touristique il y a 1 jour</p>
          <p class="review__headline"><span class="review__stars">&#9733; &#9733; &#9733; &#9733; &#9733;</span><strong>Exp&eacute;rience Parisienne Inoubliable !</strong></p>
          <p class="review__text">Un service tout simplement exceptionnel ! J'ai eu le plaisir d'&ecirc;tre conduite par Monsieur Antoine &agrave; bord d'un magnifique Mercedes Classe V pour mon tour touristique.</p>
          <p class="review__text">Le confort du v&eacute;hicule est incomparable : spacieux et impeccable, parfait pour admirer Paris sans stress logistique.</p>
          <p class="review__text">Monsieur Antoine a fait preuve d'un professionnalisme rare. Il &eacute;tait ponctuel, discret et d'une courtoisie exquise, adaptant l'itin&eacute;raire &agrave; mes envies tout en partageant des anecdotes passionnantes.</p>
        </div>

        <div class="review">
          <h3 class="review__name">Martin Rodrigues</h3>
          <p class="review__meta">Trajet en ville il y a 3 jours</p>
          <p class="review__headline"><span class="review__stars">&#9733; &#9733; &#9733; &#9733; &#9733;</span><strong>Un trajet parfait du d&eacute;but &agrave; la fin</strong></p>
          <p class="review__text">V&eacute;hicule confortable, chauffeur tr&egrave;s professionnel et ponctuel.</p>
          <p class="review__text">R&eacute;servation rapide et service fluide. Je recommande sans h&eacute;siter.</p>
        </div>

        <div class="review">
          <h3 class="review__name">Louise Renard</h3>
          <p class="review__meta">Transfert a&eacute;roport il y a 2 jours</p>
          <p class="review__headline"><span class="review__stars">&#9733; &#9733; &#9733; &#9733; &#9733;</span><strong>Confort et s&eacute;r&eacute;nit&eacute;</strong></p>
          <p class="review__text">Arriv&eacute;e &agrave; l'heure, conduite souple et service premium.</p>
          <p class="review__text">Une exp&eacute;rience tr&egrave;s rassurante, je reprendrai ce service.</p>
        </div>

        <div class="review">
          <h3 class="review__name">Sandrine Duval</h3>
          <p class="review__meta">Parcours touristique il y a 1 jour</p>
          <p class="review__headline"><span class="review__stars">&#9733; &#9733; &#9733; &#9733; &#9733;</span><strong>Exp&eacute;rience Parisienne Inoubliable !</strong></p>
          <p class="review__text">Un service tout simplement exceptionnel ! J'ai eu le plaisir d'&ecirc;tre conduite par Monsieur Antoine &agrave; bord d'un magnifique Mercedes Classe V pour mon tour touristique.</p>
          <p class="review__text">Le confort du v&eacute;hicule est incomparable : spacieux et impeccable, parfait pour admirer Paris sans stress logistique.</p>
          <p class="review__text">Monsieur Antoine a fait preuve d'un professionnalisme rare. Il &eacute;tait ponctuel, discret et d'une courtoisie exquise, adaptant l'itin&eacute;raire &agrave; mes envies tout en partageant des anecdotes passionnantes.</p>
        </div>

        <div class="review">
          <h3 class="review__name">Martin Rodrigues</h3>
          <p class="review__meta">Trajet en ville il y a 3 jours</p>
          <p class="review__headline"><span class="review__stars">&#9733; &#9733; &#9733; &#9733; &#9733;</span><strong>Un trajet parfait du d&eacute;but &agrave; la fin</strong></p>
          <p class="review__text">V&eacute;hicule confortable, chauffeur tr&egrave;s professionnel et ponctuel.</p>
          <p class="review__text">R&eacute;servation rapide et service fluide. Je recommande sans h&eacute;siter.</p>
        </div>

        <div class="review">
          <h3 class="review__name">Louise Renard</h3>
          <p class="review__meta">Transfert a&eacute;roport il y a 2 jours</p>
          <p class="review__headline"><span class="review__stars">&#9733; &#9733; &#9733; &#9733; &#9733;</span><strong>Confort et s&eacute;r&eacute;nit&eacute;</strong></p>
          <p class="review__text">Arriv&eacute;e &agrave; l'heure, conduite souple et service premium.</p>
          <p class="review__text">Une exp&eacute;rience tr&egrave;s rassurante, je reprendrai ce service.</p>
        </div>
      </div>
    </div>
  </section></main>

<?php get_footer(); ?>
