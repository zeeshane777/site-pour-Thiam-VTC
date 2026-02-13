<?php
/**
 * Template Name: Reservation Aeroport
 * Template Post Type: page
 */
get_header();
?>

<main class="page">
  <div id="reservation-map">
    <?php echo do_shortcode('[thiam_vtc_clean_resa mode="airport"]'); ?>
  </div>
</main>

<?php get_footer(); ?>
