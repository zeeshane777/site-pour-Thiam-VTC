<?php
/**
 * Template Name: Reservations
 * Template Post Type: page
 */
get_header();
?>

<main class="tsf-reservations">
  <style>
    .tsf-reservations { padding: 16px 32px; background: #f8f3ee; }
    .tsf-reservations__title { color: #000; font-family: Urbanist, sans-serif; font-size: 32px; font-weight: 400; margin: 18px 0 12px; }
    .tsf-reservations__card { background: #f1f1f1; border-radius: 16px; padding: 16px 24px; display: grid; gap: 12px; }
    .tsf-reservations__row { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; align-items: start; }
    .tsf-reservations__label { color: #444; font-size: 14px; }
    .tsf-reservations__value { color: #111; font-size: 14px; }
    .tsf-reservations__status { display: flex; align-items: center; gap: 8px; justify-content: flex-end; font-size: 12px; color: #333; }
    .tsf-reservations__dot { width: 8px; height: 8px; border-radius: 50%; background: #2bbf62; display: inline-block; }
    .tsf-reservations__total { font-size: 22px; font-weight: 500; text-align: right; }
    .tsf-reservations__cta { display: flex; justify-content: center; }
    .tsf-reservations__button { width: 456px; height: 59px; padding: 4px 35px; border-radius: 16px; background: #ff3b3b; color: #fff; border: 0; cursor: pointer; }
    .tsf-reservations__empty { text-align: center; color: #777; padding: 40px 0; }
    .tsf-reservations__login { padding: 24px; background: #f1f1f1; border-radius: 16px; }
    @media (max-width: 900px) {
      .tsf-reservations { padding: 16px; }
      .tsf-reservations__row { grid-template-columns: 1fr; }
      .tsf-reservations__button { width: 100%; }
    }
  </style>

  <?php if ( ! is_user_logged_in() ) : ?>
    <div class="tsf-reservations__login">
      <p>Merci de vous connecter pour voir vos reservations.</p>
      <a class="thiam-route__cta" href="<?php echo esc_url( home_url('/s-identifier/') ); ?>">Se connecter</a>
    </div>
  <?php else : ?>
    <?php
      $now = current_time('timestamp');
      $query = new WP_Query([
        'post_type' => 'thiam_reservation',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'author' => get_current_user_id(),
        'orderby' => 'date',
        'order' => 'DESC',
      ]);
      $upcoming = [];
      $past = [];
      if ( $query->have_posts() ) {
        while ( $query->have_posts() ) {
          $query->the_post();
          $arrival_ts = (int) get_post_meta(get_the_ID(), 'thiam_arrival_ts', true);
          $item = [
            'id' => get_the_ID(),
            'start' => get_post_meta(get_the_ID(), 'thiam_start_address', true),
            'end' => get_post_meta(get_the_ID(), 'thiam_end_address', true),
            'depart' => get_post_meta(get_the_ID(), 'thiam_depart_time', true),
            'arrival' => get_post_meta(get_the_ID(), 'thiam_arrival_time', true),
            'passengers' => get_post_meta(get_the_ID(), 'thiam_passengers', true),
            'price' => get_post_meta(get_the_ID(), 'thiam_price_eur', true),
          ];
          if ( $arrival_ts && $arrival_ts < $now ) {
            $past[] = $item;
          } else {
            $upcoming[] = $item;
          }
        }
        wp_reset_postdata();
      }
    ?>

    <h1 class="tsf-reservations__title">Vos reservation a venir</h1>

    <?php if ( empty($upcoming) ) : ?>
      <div class="tsf-reservations__card">
        <div class="tsf-reservations__empty">Aucune reservations</div>
      </div>
    <?php else : ?>
      <?php foreach ( $upcoming as $item ) : ?>
        <section class="tsf-reservations__card" aria-label="Reservation a venir">
          <div class="tsf-reservations__row">
            <div>
              <div class="tsf-reservations__value">Reservation en cours</div>
            </div>
            <div></div>
            <div class="tsf-reservations__status">
              <span class="tsf-reservations__dot" aria-hidden="true"></span>
              <span>En cours</span>
            </div>
          </div>
          <div class="tsf-reservations__row">
            <div>
              <div class="tsf-reservations__label">Depart</div>
              <div class="tsf-reservations__label">Arrivee</div>
              <div class="tsf-reservations__label">Passagers</div>
            </div>
            <div>
              <div class="tsf-reservations__value"><?php echo esc_html($item['start']); ?></div>
              <div class="tsf-reservations__value"><?php echo esc_html($item['end']); ?></div>
              <div class="tsf-reservations__value"><?php echo esc_html($item['passengers']); ?></div>
            </div>
            <div>
              <div class="tsf-reservations__label">Heure de depart</div>
              <div class="tsf-reservations__label">Heure d'arrivee</div>
              <div class="tsf-reservations__label">Total</div>
              <div class="tsf-reservations__value" style="text-align:right;"><?php echo esc_html($item['depart']); ?></div>
              <div class="tsf-reservations__value" style="text-align:right;"><?php echo esc_html($item['arrival']); ?></div>
              <div class="tsf-reservations__total"><?php echo esc_html(number_format((float) $item['price'], 2)); ?> EUR</div>
            </div>
          </div>
          <div class="tsf-reservations__cta">
            <button class="tsf-reservations__button" type="button" data-reservation-id="<?php echo esc_attr($item['id']); ?>">Annuler la reservation</button>
          </div>
        </section>
      <?php endforeach; ?>
    <?php endif; ?>

    <h2 class="tsf-reservations__title">Vos reservation passees</h2>
    <?php if ( empty($past) ) : ?>
      <div class="tsf-reservations__card">
        <div class="tsf-reservations__empty">Aucune reservations</div>
      </div>
    <?php else : ?>
      <?php foreach ( $past as $item ) : ?>
        <section class="tsf-reservations__card" aria-label="Reservation passee">
          <div class="tsf-reservations__row">
            <div>
              <div class="tsf-reservations__value">Reservation passee</div>
            </div>
          </div>
          <div class="tsf-reservations__row">
            <div>
              <div class="tsf-reservations__label">Depart</div>
              <div class="tsf-reservations__label">Arrivee</div>
              <div class="tsf-reservations__label">Passagers</div>
            </div>
            <div>
              <div class="tsf-reservations__value"><?php echo esc_html($item['start']); ?></div>
              <div class="tsf-reservations__value"><?php echo esc_html($item['end']); ?></div>
              <div class="tsf-reservations__value"><?php echo esc_html($item['passengers']); ?></div>
            </div>
            <div>
              <div class="tsf-reservations__label">Heure de depart</div>
              <div class="tsf-reservations__label">Heure d'arrivee</div>
              <div class="tsf-reservations__label">Total</div>
              <div class="tsf-reservations__value" style="text-align:right;"><?php echo esc_html($item['depart']); ?></div>
              <div class="tsf-reservations__value" style="text-align:right;"><?php echo esc_html($item['arrival']); ?></div>
              <div class="tsf-reservations__total"><?php echo esc_html(number_format((float) $item['price'], 2)); ?> EUR</div>
            </div>
          </div>
        </section>
      <?php endforeach; ?>
    <?php endif; ?>
  <?php endif; ?>

  <script>
    document.addEventListener('click', function (event) {
      var btn = event.target.closest('.tsf-reservations__button');
      if (!btn) {
        return;
      }
      var id = btn.getAttribute('data-reservation-id');
      if (!id) {
        return;
      }
      var payload = new FormData();
      payload.append('action', 'thiam_vtc_cancel_reservation');
      payload.append('nonce', '<?php echo esc_js( wp_create_nonce('thiam_vtc_reservation') ); ?>');
      payload.append('reservation_id', id);
      fetch('<?php echo esc_url( admin_url('admin-ajax.php') ); ?>', {
        method: 'POST',
        credentials: 'same-origin',
        body: payload
      })
        .then(function (res) { return res.json(); })
        .then(function (data) {
          if (data && data.success) {
            window.location.reload();
          }
        });
    });
  </script>
</main>

<?php get_footer(); ?>
