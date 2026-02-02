<!doctype html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="tsf-header">
  <div class="tsf-header__inner">

    <!-- Logo -->
<?php if ( has_custom_logo() ) : ?>
  <div class="tsf-header__logo">
    <?php the_custom_logo(); ?>
  </div>
<?php else : ?>
  <a class="tsf-header__logo" href="<?php echo esc_url(home_url('/')); ?>" aria-label="Accueil">
<img class="tsf-logo-img" src="<?php echo esc_url( thiam_asset_url('Logo.svg') ); ?>" alt="Logo Thiam VTC">
  </a>
<?php endif; ?>

    <!-- Menu -->
    <nav class="tsf-nav" aria-label="Navigation principale">
      <ul class="tsf-nav__list">
        <?php
        echo wp_nav_menu([
          'theme_location' => 'primary',
          'container'      => false,
          'menu_class'     => 'tsf-nav__list',
          'fallback_cb'    => false,
          'items_wrap'     => '%3$s',
          'echo'           => false,
        ]);
        ?>
        <li class="tsf-nav__item tsf-nav__item--services">
          <button class="tsf-nav__link tsf-nav__link--button" type="button" aria-haspopup="true" aria-expanded="false">
            Nos services <span class="tsf-nav__caret" aria-hidden="true"></span>
          </button>
          <ul class="tsf-nav__dropdown" aria-label="Nos services">
            <li><a href="<?php echo esc_url(home_url('/depose-aeroport/')); ?>">Dépose aéroport</a></li>
            <li><a href="<?php echo esc_url(home_url('/trajet-en-ville/')); ?>">Trajet en ville</a></li>
            <li><a href="<?php echo esc_url(home_url('/parcours-touristique/')); ?>">Parcours touristique</a></li>
          </ul>
        </li>
      </ul>
    </nav>

    <!-- Bouton S'identifier / Mon compte -->
    <?php
      $login_page = get_page_by_path('s-identifier');
      $account_page = get_page_by_path('mon-compte');
      $login_link = $login_page ? get_permalink($login_page) : home_url('/s-identifier/');
      $account_link = $account_page ? get_permalink($account_page) : home_url('/mon-compte/');
      $is_logged_in = is_user_logged_in();
      $link = $is_logged_in ? $account_link : $login_link;
      $label = $is_logged_in ? 'Mon compte' : "S'identifier";
    ?>
    <a class="tsf-btn-auth" href="<?php echo esc_url($link); ?>">
      <span class="tsf-btn-auth__icon" aria-hidden="true">
        <!-- ton svg user -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" aria-hidden="true">
          <path d="M3 12C3 13.1819 3.23279 14.3522 3.68508 15.4442C4.13738 16.5361 4.80031 17.5282 5.63604 18.364C6.47177 19.1997 7.46392 19.8626 8.55585 20.3149C9.64778 20.7672 10.8181 21 12 21C13.1819 21 14.3522 20.7672 15.4442 20.3149C16.5361 19.8626 17.5282 19.1997 18.364 18.364C19.1997 17.5282 19.8626 16.5361 20.3149 15.4442C20.7672 14.3522 21 13.1819 21 12C21 10.8181 20.7672 9.64778 20.3149 8.55585C19.8626 7.46392 19.1997 6.47177 18.364 5.63604C17.5282 4.80031 16.5361 4.13738 15.4442 3.68508C14.3522 3.23279 13.1819 3 12 3C10.8181 3 9.64778 3.23279 8.55585 3.68508C7.46392 4.13738 6.47177 4.80031 5.63604 5.63604C4.80031 6.47177 4.13738 7.46392 3.68508 8.55585C3.23279 9.64778 3 10.8181 3 12Z"
            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M6.16797 18.849C6.41548 18.0252 6.92194 17.3032 7.61222 16.79C8.30249 16.2768 9.13982 15.9997 9.99997 16H14C14.8612 15.9997 15.6996 16.2774 16.3904 16.7918C17.0811 17.3062 17.5874 18.0298 17.834 18.855M8.99997 10C8.99997 10.7956 9.31604 11.5587 9.87865 12.1213C10.4413 12.6839 11.2043 13 12 13C12.7956 13 13.5587 12.6839 14.1213 12.1213C14.6839 11.5587 15 10.7956 15 10C15 9.20435 14.6839 8.44129 14.1213 7.87868C13.5587 7.31607 12.7956 7 12 7C11.2043 7 10.4413 7.31607 9.87865 7.87868C9.31604 8.44129 8.99997 9.20435 8.99997 10Z"
            stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </span>
      <span class="tsf-btn-auth__text"><?php echo esc_html($label); ?></span>
    </a>

  </div>
</header>
