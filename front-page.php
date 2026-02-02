<?php get_header(); ?>

<main>
  <section class="hero">
    <div class="hero__content">
      <h1 class="hero__title">
        Votre prochain trajet<br>
        dans ce qui se fait de mieux
      </h1>
    </div>
  </section>

  <div class="home-gap">
    <div class="home-gap__inner">
      <form class="hero-form">
        <h2>Où allons-nous ?</h2>

        <div class="hero-form__addresses">

          <!-- Champ Départ -->
          <div class="field">
            <span class="field__tag">Départ</span>

            <input type="text" placeholder="Adresse, gare, aéroport">

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

            <input type="text" placeholder="Adresse de destination">

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
          <button class="btn-primary" type="submit">R�server</button>
        </div>

      </form>
    </div>
  </div>

  <section class="premium">
    <div class="premium__inner">
      <h2 class="premium__title">SERVICES DE CHAUFFEUR PRIV�E PRENIUM</h2>
      <p class="premium__text">
        Profitez d&#39;un service de transport haut de gamme avec chauffeur professionnel. V&#233;hicule confortable, ponctualit&#233; garantie et discr&#233;tion assur&#233;e pour tous vos d&#233;placements. Que ce soit pour un trajet priv&#233;, professionnel ou touristique, nous vous accompagnons avec s&#233;rieux et &#233;l&#233;gance afin de vous offrir une exp&#233;rience de voyage sereine.
      </p>
    </div>
  </section>
</main>

<?php get_footer(); ?>