<?php
/**
 * Plugin Name: Thiam VTC Clean Resa
 * Description: Reservation map (city + airport) with IDF focus, price calculation, confirmation and emails.
 * Version: 1.2.0
 * Author: Thiam
 */

if ( ! defined('ABSPATH') ) {
  exit;
}

function thiam_vtc_clean_reservations_url() {
  return 'https://thiam-services-france.fr/reservation-vtc-premium-paris-chauffeur-prive-luxe/';
}

function thiam_vtc_clean_register_reservations() {
  if ( post_type_exists('thiam_reservation') ) {
    return;
  }
  register_post_type('thiam_reservation', [
    'labels' => [
      'name' => 'Reservations',
      'singular_name' => 'Reservation',
    ],
    'public' => false,
    'show_ui' => true,
    'show_in_menu' => true,
    'supports' => ['title', 'author'],
    'capability_type' => 'post',
  ]);
}
add_action('init', 'thiam_vtc_clean_register_reservations');

function thiam_vtc_clean_resa_shortcode($atts = []) {
  $atts = shortcode_atts([
    'mode' => 'city',
  ], $atts, 'thiam_vtc_clean_resa');

  $mode = $atts['mode'] === 'airport' ? 'airport' : 'city';
  $airport_flow = ( $mode === 'airport' ) ? 'depot' : 'default';

  ob_start();
  ?>
  <div class="thiam-clean" data-mode="<?php echo esc_attr($mode); ?>" data-airport-flow="<?php echo esc_attr($airport_flow); ?>">
    <div class="thiam-clean__map-wrap">
      <?php if ( $mode === 'airport' ) : ?>
        <div class="thiam-clean-tabs" role="tablist" aria-label="Type de trajet">
          <button type="button" class="thiam-clean-tab is-active" data-airport-mode="depot" aria-selected="true">Depot</button>
          <button type="button" class="thiam-clean-tab" data-airport-mode="retrait" aria-selected="false">Retrait</button>
        </div>
      <?php endif; ?>
      <div class="thiam-clean__map" id="thiam-clean-map-<?php echo esc_attr($mode); ?>"></div>
    </div>

    <div class="thiam-clean__panel">
      <div class="thiam-clean__form">
        <?php if ( $mode === 'airport' ) : ?>
          <div class="thiam-clean-inline" aria-label="Votre aeroport">
            <span class="thiam-clean-inline__label">Votre aeroport</span>
            <select class="thiam-clean-airport">
              <option value="cdg">Charles de Gaulle (CDG)</option>
              <option value="ory">Orly (ORY)</option>
            </select>
          </div>

          <div class="thiam-clean-inline" aria-label="Numero de vol">
            <span class="thiam-clean-inline__label">Numero de vol</span>
            <input type="text" class="thiam-clean-flight" placeholder="Votre numero">
          </div>

          <div class="thiam-clean-inline" aria-label="Adresse">
            <span class="thiam-clean-inline__label thiam-clean-airport-address-label">Adresse de depart</span>
            <div class="thiam-clean__field">
              <input type="text" class="thiam-clean-airport-address" placeholder="Votre adresse" autocomplete="off">
              <div class="thiam-clean-suggestions thiam-clean-airport-address-suggestions" role="listbox"></div>
            </div>
          </div>

          <div class="thiam-clean-inline" aria-label="Heure de ramassage">
            <span class="thiam-clean-inline__label">Heure de ramassage</span>
            <input type="time" class="thiam-clean-time">
          </div>

          <div class="thiam-clean-inline" aria-label="Choix du modele">
            <span class="thiam-clean-inline__label">Choix du modele</span>
            <select class="thiam-clean-model">
              <option value="tesla_model_y">Tesla Model Y</option>
              <option value="mercedes_classe_v">Mercedes Classe V</option>
            </select>
          </div>
        <?php else : ?>
          <div class="thiam-clean-inline" aria-label="Depart">
            <span class="thiam-clean-inline__label">Depart</span>
            <div class="thiam-clean__field">
              <input type="text" class="thiam-clean-start" placeholder="Adresse de depart" autocomplete="off">
              <div class="thiam-clean-suggestions thiam-clean-start-suggestions" role="listbox"></div>
            </div>
          </div>

          <div class="thiam-clean-inline" aria-label="Arrivee">
            <span class="thiam-clean-inline__label">Arrivee</span>
            <div class="thiam-clean__field">
              <input type="text" class="thiam-clean-end" placeholder="Adresse de destination" autocomplete="off">
              <div class="thiam-clean-suggestions thiam-clean-end-suggestions" role="listbox"></div>
            </div>
          </div>

          <div class="thiam-clean-inline" aria-label="Heure">
            <span class="thiam-clean-inline__label">Heure</span>
            <input type="time" class="thiam-clean-time">
          </div>
        <?php endif; ?>
        <div class="thiam-clean-inline" aria-label="Passagers">
          <span class="thiam-clean-inline__label">Passagers</span>
          <select class="thiam-clean-passengers">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
          </select>
        </div>

        <div class="thiam-clean-total">
          <span>Total</span>
          <strong class="thiam-clean-price">-- EUR</strong>
        </div>

        <button type="button" class="thiam-clean-btn">Réserver</button>
        <div class="thiam-clean-meta"></div>
      </div>

      <div class="thiam-clean-confirm" hidden>
        <div class="thiam-clean-confirm__icon">&#10003;</div>
        <h3>Votre réservation a été confirmée</h3>
        <p>Votre réservation a bien été enregistrée.</p>
        <a class="thiam-clean-btn thiam-clean-btn--link" href="<?php echo esc_url(thiam_vtc_clean_reservations_url()); ?>">Voir mes réservations</a>
      </div>
    </div>
  </div>
  <?php
  return ob_get_clean();
}
add_shortcode('thiam_vtc_clean_resa', 'thiam_vtc_clean_resa_shortcode');

add_filter('the_content', function($content) {
  if ( is_admin() ) {
    return $content;
  }

  $show = isset($_GET['reservation']) && $_GET['reservation'] === '1';
  if ( ! $show ) {
    return $content;
  }

  if ( is_page('reservation-aeroport') || is_page('depose-aeroport') ) {
    return do_shortcode('[thiam_vtc_clean_resa mode="airport"]');
  }

  if ( is_page('trajet-en-ville') ) {
    return do_shortcode('[thiam_vtc_clean_resa mode="city"]');
  }

  return $content;
}, 20);

add_action('wp_enqueue_scripts', function() {
  $needs_assets = false;

  if (
    isset($_GET['reservation']) && $_GET['reservation'] === '1' &&
    is_page(['reservation-aeroport', 'trajet-en-ville', 'depose-aeroport'])
  ) {
    $needs_assets = true;
  }

  global $post;
  if ( $post && has_shortcode($post->post_content, 'thiam_vtc_clean_resa') ) {
    $needs_assets = true;
  }

  if ( ! $needs_assets ) {
    return;
  }

  wp_enqueue_style('leaflet-css', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css', [], '1.9.4');
  wp_enqueue_script('leaflet-js', 'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js', [], '1.9.4', true);

  $config = [
    'pricePerKm' => 2.5,
    'nominatim' => 'https://nominatim.openstreetmap.org/search',
    'osrm' => 'https://router.project-osrm.org/route/v1/driving/',
    'reservationsUrl' => thiam_vtc_clean_reservations_url(),
    'ajaxUrl' => admin_url('admin-ajax.php'),
    'nonce' => wp_create_nonce('thiam_vtc_clean_reservation'),
    'isLoggedIn' => is_user_logged_in(),
    'loginUrl' => home_url('/s-identifier/'),
    'airportFlow' => 'depot',
  ];
  wp_add_inline_script('leaflet-js', 'window.THIA_CLEAN_RESA_CONFIG=' . wp_json_encode($config) . ';', 'before');

  $css = <<<CSS
.thiam-clean{display:grid;grid-template-columns:1.2fr .8fr;gap:24px;max-width:1400px;margin:24px auto;padding:0 24px}
.thiam-clean__map-wrap{display:grid;gap:8px;align-content:start}
.thiam-clean__map{min-height:560px;border:1px solid #ddd;border-radius:14px;overflow:hidden}
.thiam-clean__panel{
  background:var(--DB-Primary,#F9F7F2);
  border:0;
  border-radius:16px;
  padding:20px
}
.thiam-clean__form{display:grid;gap:10px}
.thiam-clean__form[hidden]{display:none !important}
.thiam-clean label{font-size:14px}
.thiam-clean-tabs{display:grid;grid-template-columns:1fr 1fr;gap:8px}
.thiam-clean-tab{
  display:flex;
  flex-direction:column;
  justify-content:center;
  align-items:center;
  gap:10px;
  flex:1 0 0;
  align-self:stretch;
  height:42px;
  border:0;
  border-radius:8px;
  background:var(--DB-Third-color,#E5E5E5);
  color:#3A0713;
  font-family:Satoshi,sans-serif;
  font-size:16px;
  font-weight:600;
  cursor:pointer
}
.thiam-clean-tab.is-active{
  background:var(--DB-Bordeaux,#3A0713);
  color:#fff
}
.thiam-clean__field{
  position:relative;
  display:flex;
  height:59px;
  padding:8px;
  align-items:center;
  gap:10px;
  align-self:stretch;
  border:1px solid #ddd;
  border-radius:16px;
  background:var(--DB-Primary,#F9F7F2);
  box-shadow:0 0 10px -4px rgba(0,0,0,.35);
}
.thiam-clean input,.thiam-clean select{
  height:59px;
  border:1px solid #ddd;
  border-radius:16px;
  padding:8px 12px;
  background:var(--DB-Primary,#F9F7F2);
  box-shadow:0 0 10px -4px rgba(0,0,0,.35);
  color:var(--DB-Secondary,#141414);
  font-family:Satoshi,sans-serif;
  font-size:20px;
  font-style:normal;
  font-weight:500;
  line-height:normal;
}
.thiam-clean-time{
  display:flex;
  height:59px;
  padding:8px;
  flex-direction:column;
  justify-content:center;
  align-items:center;
  gap:10px;
  border:0;
  border-radius:8px;
  background:var(--DB-Third-color,#E5E5E5);
  box-shadow:none;
  color:var(--DB-Secondary,#141414);
  font-family:Satoshi,sans-serif;
  font-size:20px;
  font-style:normal;
  font-weight:400;
  line-height:normal;
}
.thiam-clean-inline{
  display:flex;
  height:59px;
  padding:8px;
  align-items:center;
  gap:10px;
  align-self:stretch;
  border:1px solid #ddd;
  border-radius:16px;
  background:var(--DB-Primary,#F9F7F2);
  box-shadow:0 0 10px -4px rgba(0,0,0,.35);
}
.thiam-clean-inline__label{
  color:var(--DB-Secondary,#141414);
  font-family:Satoshi,sans-serif;
  font-size:20px;
  font-style:normal;
  font-weight:500;
  line-height:normal;
  white-space:nowrap;
  min-width:170px;
}
.thiam-clean-inline input,
.thiam-clean-inline select{
  flex:1;
  height:100%;
  min-width:0;
  border:0;
  background:transparent;
  box-shadow:none;
  padding:0 8px;
  text-align:right;
}
.thiam-clean-inline .thiam-clean-time{
  flex:0 0 auto;
  margin-left:auto;
  min-width:170px;
}
.thiam-clean-inline .thiam-clean-time::-webkit-datetime-edit{
  text-align:right;
}
.thiam-clean-inline .thiam-clean-time::-webkit-datetime-edit-fields-wrapper{
  justify-content:flex-end;
}
.thiam-clean-inline .thiam-clean__field{
  flex:1;
  min-width:0;
  border:0;
  box-shadow:none;
  background:transparent;
  padding:0;
  height:100%;
}
.thiam-clean__field input{
  width:100%;
  height:100%;
  border:0;
  border-radius:12px;
  padding:0 8px;
  background:transparent;
  box-shadow:none;
}
.thiam-clean input::placeholder{
  color:var(--DB-Secondary,#141414);
  opacity:.6;
  font-family:Satoshi,sans-serif;
  font-size:20px;
  font-style:normal;
  font-weight:500;
  line-height:normal;
}
.thiam-clean input:focus,
.thiam-clean input:focus-visible,
.thiam-clean select:focus,
.thiam-clean select:focus-visible{
  outline:none !important;
  box-shadow:none !important;
  border-color:#ddd;
}
.thiam-clean__field:focus-within,
.thiam-clean-inline:focus-within{
  outline:none !important;
  box-shadow:0 0 10px -4px rgba(0,0,0,.35);
}
.thiam-clean-total{display:flex;align-items:center;justify-content:space-between;margin-top:2px}
.thiam-clean-total strong{font-size:18px}
.thiam-clean-btn{
  display:flex;
  height:59px;
  padding:4px 35px;
  justify-content:center;
  align-items:center;
  gap:10px;
  align-self:stretch;
  border:0;
  border-radius:16px;
  background:var(--DB-Bordeaux,#3A0713);
  color:#F9F7F2;
  font-weight:700;
  cursor:pointer
}
.thiam-clean-btn--link{display:flex;align-items:center;justify-content:center;text-decoration:none}
.thiam-clean-meta{
  margin-top:4px;
  padding:10px 12px;
  border-radius:12px;
  border:0;
  background:transparent;
  color:var(--DB-Bordeaux,#3A0713);
  font-family:Satoshi,sans-serif;
  font-size:18px;
  font-weight:700;
  line-height:1.2;
  text-align:center;
}
.thiam-clean-confirm{display:grid;gap:10px}
.thiam-clean-confirm[hidden]{display:none !important}
.thiam-clean-confirm__icon{width:54px;height:54px;border-radius:50%;border:2px solid #3A0713;display:grid;place-items:center;font-size:26px}
.thiam-clean-suggestions{position:absolute;left:0;right:0;top:100%;z-index:20;background:#fff;border:1px solid #ddd;border-radius:10px;margin-top:4px;display:none;max-height:190px;overflow:auto}
.thiam-clean-suggestions button{display:block;width:100%;text-align:left;padding:8px 10px;border:0;background:#fff;cursor:pointer}
.thiam-clean-suggestions button:hover{background:#f5f1ee}
@media (max-width: 980px){.thiam-clean{grid-template-columns:1fr}.thiam-clean__map{min-height:380px}}
CSS;
  wp_add_inline_style('leaflet-css', $css);

  $js = <<<JS
document.addEventListener('DOMContentLoaded', function () {
  if (typeof L === 'undefined' || !window.THIA_CLEAN_RESA_CONFIG) return;

  var idfBounds = L.latLngBounds([48.1200, 1.4460], [49.2500, 3.5600]);
  var viewbox = '1.4460,49.2500,3.5600,48.1200';
  var nominatim = window.THIA_CLEAN_RESA_CONFIG.nominatim;

  function debounce(fn, wait) {
    var t;
    return function () {
      var args = arguments;
      clearTimeout(t);
      t = setTimeout(function () { fn.apply(null, args); }, wait);
    };
  }

  function formatAddress(item) {
    if (!item || !item.address) return item && item.display_name ? item.display_name : '';
    var a = item.address;
    var street = [a.house_number, a.road].filter(Boolean).join(' ');
    var city = a.city || a.town || a.village || a.municipality || a.suburb || a.county;
    var postcode = a.postcode;
    var parts = [];
    if (street) parts.push(street);
    if (postcode || city) parts.push([postcode, city].filter(Boolean).join(' '));
    if (a.country) parts.push(a.country);
    return parts.length ? parts.join(', ') : (item.display_name || '');
  }

  function precisionScore(item) {
    var a = item && item.address ? item.address : {};
    if (a.house_number || item.type === 'house' || item.type === 'building') return 0;
    if (a.road || item.type === 'residential' || item.type === 'road') return 1;
    if (a.neighbourhood || a.suburb || a.city_district) return 2;
    if (a.city || a.town || a.village || a.municipality) return 3;
    return 4;
  }

  function orderSuggestions(items) {
    return items.slice().sort(function (a, b) {
      var scoreA = precisionScore(a);
      var scoreB = precisionScore(b);
      if (scoreA !== scoreB) return scoreA - scoreB;
      var impA = typeof a.importance === 'number' ? a.importance : 0;
      var impB = typeof b.importance === 'number' ? b.importance : 0;
      return impB - impA;
    }).slice(0, 8);
  }

  function clearSuggestions(listEl) {
    listEl.innerHTML = '';
    listEl.style.display = 'none';
  }

  function showSuggestions(listEl, items, onSelect) {
    listEl.innerHTML = '';
    items.forEach(function (item) {
      var btn = document.createElement('button');
      btn.type = 'button';
      btn.textContent = formatAddress(item);
      btn.addEventListener('click', function () {
        onSelect(item);
        clearSuggestions(listEl);
      });
      listEl.appendChild(btn);
    });
    listEl.style.display = items.length ? 'block' : 'none';
  }

  function fetchSuggestions(query, listEl, onSelect) {
    if (!query || query.length < 3) {
      clearSuggestions(listEl);
      return;
    }
    var url = nominatim +
      '?format=jsonv2&addressdetails=1&limit=8&bounded=1&viewbox=' + viewbox +
      '&countrycodes=fr&accept-language=fr&dedupe=1&q=' + encodeURIComponent(query);
    fetch(url, { headers: { 'Accept': 'application/json' } })
      .then(function (res) { return res.json(); })
      .then(function (data) {
        var items = Array.isArray(data) ? orderSuggestions(data) : [];
        showSuggestions(listEl, items, onSelect);
      })
      .catch(function () { clearSuggestions(listEl); });
  }

  function fetchFirstSuggestion(query, onSelect) {
    if (!query || query.length < 3) return;
    var url = nominatim +
      '?format=jsonv2&addressdetails=1&limit=5&bounded=1&viewbox=' + viewbox +
      '&countrycodes=fr&accept-language=fr&dedupe=1&q=' + encodeURIComponent(query);
    fetch(url, { headers: { 'Accept': 'application/json' } })
      .then(function (res) { return res.json(); })
      .then(function (data) {
        var items = Array.isArray(data) ? orderSuggestions(data) : [];
        if (items.length) onSelect(items[0]);
      })
      .catch(function () {});
  }

  document.querySelectorAll('.thiam-clean').forEach(function (wrap) {
    var mode = wrap.getAttribute('data-mode');
    var airportFlow = wrap.getAttribute('data-airport-flow') || (window.THIA_CLEAN_RESA_CONFIG.airportFlow || 'default');
    var isAirport = mode === 'airport';
    var airportTripMode = isAirport && airportFlow === 'retrait' ? 'retrait' : 'depot';
    var mapEl = wrap.querySelector('.thiam-clean__map');
    var form = wrap.querySelector('.thiam-clean__form');
    var confirm = wrap.querySelector('.thiam-clean-confirm');
    var btn = wrap.querySelector('.thiam-clean-btn');
    var meta = wrap.querySelector('.thiam-clean-meta');
    var priceEl = wrap.querySelector('.thiam-clean-price');
    var startInput = wrap.querySelector('.thiam-clean-start');
    var endInput = wrap.querySelector('.thiam-clean-end');
    var startList = wrap.querySelector('.thiam-clean-start-suggestions');
    var endList = wrap.querySelector('.thiam-clean-end-suggestions');
    var airportAddressInput = wrap.querySelector('.thiam-clean-airport-address');
    var airportAddressList = wrap.querySelector('.thiam-clean-airport-address-suggestions');
    var airportAddressLabel = wrap.querySelector('.thiam-clean-airport-address-label');
    var airportTabs = wrap.querySelectorAll('.thiam-clean-tab');

    if (!mapEl) return;

    var map = L.map(mapEl, {
      scrollWheelZoom: false,
      maxBounds: idfBounds,
      maxBoundsViscosity: 1.0
    }).fitBounds(idfBounds);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; OpenStreetMap'
    }).addTo(map);

    var startMarker = null;
    var endMarker = null;
    var routeLayer = null;
    var startPoint = null;
    var endPoint = null;
    var lastDistanceKm = null;
    var lastDurationSec = null;

    var onStartInput = debounce(function (e) {
      fetchSuggestions(e.target.value, startList, function (item) {
        var lat = parseFloat(item.lat);
        var lon = parseFloat(item.lon);
        if (!idfBounds.contains([lat, lon])) {
          meta.textContent = 'Adresse hors Île-de-France.';
          return;
        }
        meta.textContent = '';
        startPoint = { lat: lat, lon: lon };
        startInput.value = formatAddress(item);
        if (startMarker) map.removeLayer(startMarker);
        startMarker = L.marker([lat, lon]).addTo(map);
        tryRoute();
      });
    }, 280);

    var onEndInput = debounce(function (e) {
      fetchSuggestions(e.target.value, endList, function (item) {
        var lat = parseFloat(item.lat);
        var lon = parseFloat(item.lon);
        if (!idfBounds.contains([lat, lon])) {
          meta.textContent = 'Adresse hors Île-de-France.';
          return;
        }
        meta.textContent = '';
        endPoint = { lat: lat, lon: lon };
        endInput.value = formatAddress(item);
        if (endMarker) map.removeLayer(endMarker);
        endMarker = L.marker([lat, lon]).addTo(map);
        tryRoute();
      });
    }, 280);

    var addressPoint = null;
    var onAirportAddressInput = debounce(function (e) {
      fetchSuggestions(e.target.value, airportAddressList, function (item) {
        var lat = parseFloat(item.lat);
        var lon = parseFloat(item.lon);
        if (!idfBounds.contains([lat, lon])) {
          meta.textContent = 'Adresse hors Île-de-France.';
          return;
        }
        meta.textContent = '';
        addressPoint = { lat: lat, lon: lon };
        airportAddressInput.value = formatAddress(item);
        if (endMarker) map.removeLayer(endMarker);
        endMarker = L.marker([lat, lon]).addTo(map);
        updateAirportRoutePoints();
      });
    }, 280);

    if (!isAirport && startInput) startInput.addEventListener('input', onStartInput);
    if (!isAirport && endInput) endInput.addEventListener('input', onEndInput);
    if (isAirport && airportAddressInput) airportAddressInput.addEventListener('input', onAirportAddressInput);

    document.addEventListener('click', function (event) {
      if (startList && !startList.contains(event.target) && event.target !== startInput) clearSuggestions(startList);
      if (endList && !endList.contains(event.target) && event.target !== endInput) clearSuggestions(endList);
      if (airportAddressList && !airportAddressList.contains(event.target) && event.target !== airportAddressInput) clearSuggestions(airportAddressList);
    });

    var airportSelect = wrap.querySelector('.thiam-clean-airport');
    var airportPoints = {
      cdg: [49.0097, 2.5479],
      ory: [48.7276, 2.3590]
    };
    var airportMarker = null;
    var airportPoint = null;

    function setAirportMode(nextMode) {
      if (!isAirport) return;
      airportTripMode = nextMode === 'retrait' ? 'retrait' : 'depot';
      if (airportAddressLabel) {
        airportAddressLabel.textContent = airportTripMode === 'depot' ? 'Adresse de depart' : 'Adresse d\'arrivee';
      }
      if (airportTabs && airportTabs.length) {
        airportTabs.forEach(function (tab) {
          var active = tab.getAttribute('data-airport-mode') === airportTripMode;
          tab.classList.toggle('is-active', active);
          tab.setAttribute('aria-selected', active ? 'true' : 'false');
        });
      }
      updateAirportRoutePoints();
    }

    function updateAirportRoutePoints() {
      if (!isAirport || !airportPoint || !addressPoint) return;
      if (airportTripMode === 'depot') {
        startPoint = { lat: addressPoint.lat, lon: addressPoint.lon };
        endPoint = { lat: airportPoint.lat, lon: airportPoint.lon };
      } else {
        startPoint = { lat: airportPoint.lat, lon: airportPoint.lon };
        endPoint = { lat: addressPoint.lat, lon: addressPoint.lon };
      }
      tryRoute();
    }

    function updateAirportMarker() {
      if (!isAirport || !airportSelect) return;
      var key = airportSelect.value;
      var pt = airportPoints[key];
      if (!pt) return;
      if (airportMarker) map.removeLayer(airportMarker);
      airportMarker = L.marker(pt).addTo(map);
      map.setView(pt, 11);
      airportPoint = { lat: pt[0], lon: pt[1] };
      updateAirportRoutePoints();
    }

    if (airportSelect) {
      airportSelect.addEventListener('change', updateAirportMarker);
      updateAirportMarker();
    }
    if (isAirport && airportTabs && airportTabs.length) {
      airportTabs.forEach(function (tab) {
        tab.addEventListener('click', function () {
          setAirportMode(tab.getAttribute('data-airport-mode'));
        });
      });
      setAirportMode(airportTripMode);
    }

    function tryRoute() {
      if (!startPoint || !endPoint) return;
      var url = window.THIA_CLEAN_RESA_CONFIG.osrm +
        startPoint.lon + ',' + startPoint.lat + ';' + endPoint.lon + ',' + endPoint.lat +
        '?overview=full&geometries=geojson';
      fetch(url)
        .then(function (res) { return res.json(); })
        .then(function (data) {
          if (!data.routes || !data.routes.length) {
            meta.textContent = 'Aucun trajet trouve.';
            return;
          }
          var route = data.routes[0];
          var coords = route.geometry.coordinates.map(function (c) { return [c[1], c[0]]; });
          if (routeLayer) map.removeLayer(routeLayer);
          routeLayer = L.polyline(coords, { color: '#4a2d2b', weight: 5 }).addTo(map);
          map.fitBounds(routeLayer.getBounds(), { padding: [20, 20] });

          var km = route.distance / 1000;
          var price = km * window.THIA_CLEAN_RESA_CONFIG.pricePerKm;
          if (priceEl) priceEl.textContent = price.toFixed(2) + ' EUR';
          lastDistanceKm = km.toFixed(2);
          lastDurationSec = Math.round(route.duration);
          meta.textContent = km.toFixed(1) + ' km - ' + Math.round(route.duration / 60) + ' min';
        })
        .catch(function () {
          meta.textContent = 'Erreur de calcul.';
        });
    }

    function prefillFromQuery() {
      if (!window.URLSearchParams) return;
      var params = new URLSearchParams(window.location.search);
      var startQ = params.get('start');
      var endQ = params.get('end');
      if (isAirport && airportAddressInput) {
        var addressQ = endQ || startQ;
        if (addressQ) {
          airportAddressInput.value = addressQ;
          fetchFirstSuggestion(addressQ, function (item) {
            var lat = parseFloat(item.lat);
            var lon = parseFloat(item.lon);
            if (!idfBounds.contains([lat, lon])) return;
            addressPoint = { lat: lat, lon: lon };
            airportAddressInput.value = formatAddress(item);
            if (endMarker) map.removeLayer(endMarker);
            endMarker = L.marker([lat, lon]).addTo(map);
            updateAirportRoutePoints();
          });
        }
        return;
      }
      if (startQ && startInput) {
        startInput.value = startQ;
        fetchFirstSuggestion(startQ, function (item) {
          var lat = parseFloat(item.lat);
          var lon = parseFloat(item.lon);
          if (!idfBounds.contains([lat, lon])) return;
          startPoint = { lat: lat, lon: lon };
          startInput.value = formatAddress(item);
          if (startMarker) map.removeLayer(startMarker);
          startMarker = L.marker([lat, lon]).addTo(map);
          tryRoute();
        });
      }
      if (endQ && endInput) {
        endInput.value = endQ;
        fetchFirstSuggestion(endQ, function (item) {
          var lat = parseFloat(item.lat);
          var lon = parseFloat(item.lon);
          if (!idfBounds.contains([lat, lon])) return;
          endPoint = { lat: lat, lon: lon };
          endInput.value = formatAddress(item);
          if (endMarker) map.removeLayer(endMarker);
          endMarker = L.marker([lat, lon]).addTo(map);
          tryRoute();
        });
      }
    }

    if (btn) {
      btn.addEventListener('click', function () {
        var start = startInput ? startInput.value.trim() : '';
        var end = endInput ? endInput.value.trim() : '';
        var airportAddress = airportAddressInput ? airportAddressInput.value.trim() : '';
        var time = wrap.querySelector('.thiam-clean-time').value.trim();
        var passengers = wrap.querySelector('.thiam-clean-passengers').value;
        var airportText = airportSelect ? airportSelect.options[airportSelect.selectedIndex].text : '';
        var flightNumber = wrap.querySelector('.thiam-clean-flight') ? wrap.querySelector('.thiam-clean-flight').value.trim() : '';
        var carModel = wrap.querySelector('.thiam-clean-model') ? wrap.querySelector('.thiam-clean-model').value : '';

        if (isAirport) {
          if (!airportAddress || !time) {
            meta.textContent = 'Merci de renseigner l\'adresse et l\'heure.';
            return;
          }
        } else if (!start || !end || !time) {
          meta.textContent = 'Merci de renseigner Départ, Arrivée et Heure.';
          return;
        }
        if (!lastDistanceKm || !lastDurationSec) {
          meta.textContent = 'Merci de choisir les adresses via les suggestions pour calculer le trajet.';
          return;
        }

        if (!window.THIA_CLEAN_RESA_CONFIG.isLoggedIn) {
          window.location.href = window.THIA_CLEAN_RESA_CONFIG.loginUrl;
          return;
        }

        var payload = new FormData();
        payload.append('action', 'thiam_vtc_clean_create_reservation');
        payload.append('nonce', window.THIA_CLEAN_RESA_CONFIG.nonce);
        payload.append('start_address', isAirport ? (airportTripMode === 'depot' ? airportAddress : airportText) : start);
        payload.append('end_address', isAirport ? (airportTripMode === 'depot' ? airportText : airportAddress) : end);
        payload.append('depart_time', time);
        payload.append('passengers', passengers);
        payload.append('distance_km', lastDistanceKm);
        payload.append('duration_sec', lastDurationSec);
        payload.append('price_eur', priceEl ? priceEl.textContent.replace(' EUR', '') : '0');
        payload.append('service_type', mode);
        payload.append('airport_name', airportText);
        payload.append('flight_number', flightNumber);
        payload.append('car_model', carModel);
        payload.append('airport_mode', airportTripMode);

        fetch(window.THIA_CLEAN_RESA_CONFIG.ajaxUrl, {
          method: 'POST',
          credentials: 'same-origin',
          body: payload
        })
          .then(function (res) { return res.json(); })
          .then(function (data) {
            if (!data || !data.success) {
              meta.textContent = data && data.data ? data.data : 'Erreur lors de la réservation.';
              return;
            }
            meta.textContent = '';
            form.hidden = true;
            confirm.hidden = false;
          })
          .catch(function () {
            meta.textContent = 'Erreur lors de la réservation.';
          });
        });
    }

    prefillFromQuery();

    setTimeout(function () { map.invalidateSize(); }, 140);
    window.addEventListener('load', function () { map.invalidateSize(); });
  });
});
JS;
  wp_add_inline_script('leaflet-js', $js, 'after');
});

function thiam_vtc_clean_create_reservation() {
  if ( ! is_user_logged_in() ) {
    wp_send_json_error('Connexion requise.');
  }
  if ( ! isset($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'thiam_vtc_clean_reservation') ) {
    wp_send_json_error('Requête invalide.');
  }

  $start_address = isset($_POST['start_address']) ? sanitize_text_field(wp_unslash($_POST['start_address'])) : '';
  $end_address = isset($_POST['end_address']) ? sanitize_text_field(wp_unslash($_POST['end_address'])) : '';
  $depart_time = isset($_POST['depart_time']) ? sanitize_text_field(wp_unslash($_POST['depart_time'])) : '';
  $passengers = isset($_POST['passengers']) ? absint($_POST['passengers']) : 1;
  $distance_km = isset($_POST['distance_km']) ? floatval($_POST['distance_km']) : 0;
  $duration_sec = isset($_POST['duration_sec']) ? absint($_POST['duration_sec']) : 0;
  $price_eur = isset($_POST['price_eur']) ? floatval($_POST['price_eur']) : 0;
  $service_type = isset($_POST['service_type']) ? sanitize_text_field(wp_unslash($_POST['service_type'])) : 'city';
  $airport_name = isset($_POST['airport_name']) ? sanitize_text_field(wp_unslash($_POST['airport_name'])) : '';
  $flight_number = isset($_POST['flight_number']) ? sanitize_text_field(wp_unslash($_POST['flight_number'])) : '';
  $car_model = isset($_POST['car_model']) ? sanitize_text_field(wp_unslash($_POST['car_model'])) : '';
  $airport_mode = isset($_POST['airport_mode']) ? sanitize_text_field(wp_unslash($_POST['airport_mode'])) : '';

  if ( empty($start_address) || empty($end_address) || empty($depart_time) ) {
    wp_send_json_error('Champs manquants.');
  }

  $tz = wp_timezone();
  $now = new DateTimeImmutable('now', $tz);
  $date_str = $now->format('Y-m-d');
  $departure_dt = DateTimeImmutable::createFromFormat('Y-m-d H:i', $date_str . ' ' . $depart_time, $tz);
  if ( ! $departure_dt ) {
    wp_send_json_error('Heure invalide.');
  }
  if ( $departure_dt < $now ) {
    $departure_dt = $departure_dt->modify('+1 day');
  }
  $arrival_dt = $duration_sec ? $departure_dt->modify('+' . $duration_sec . ' seconds') : $departure_dt;

  $post_id = wp_insert_post([
    'post_type' => 'thiam_reservation',
    'post_status' => 'publish',
    'post_title' => 'Reservation ' . $now->format('Y-m-d H:i'),
    'post_author' => get_current_user_id(),
  ], true);

  if ( is_wp_error($post_id) ) {
    wp_send_json_error('Erreur lors de la création.');
  }

  update_post_meta($post_id, 'thiam_start_address', $start_address);
  update_post_meta($post_id, 'thiam_end_address', $end_address);
  update_post_meta($post_id, 'thiam_depart_time', $departure_dt->format('H:i'));
  update_post_meta($post_id, 'thiam_arrival_time', $arrival_dt->format('H:i'));
  update_post_meta($post_id, 'thiam_depart_ts', $departure_dt->getTimestamp());
  update_post_meta($post_id, 'thiam_arrival_ts', $arrival_dt->getTimestamp());
  update_post_meta($post_id, 'thiam_passengers', $passengers);
  update_post_meta($post_id, 'thiam_distance_km', $distance_km);
  update_post_meta($post_id, 'thiam_duration_sec', $duration_sec);
  update_post_meta($post_id, 'thiam_price_eur', $price_eur);
  update_post_meta($post_id, 'thiam_status', 'en_cours');
  update_post_meta($post_id, 'thiam_service_type', $service_type);
  update_post_meta($post_id, 'thiam_airport_name', $airport_name);
  update_post_meta($post_id, 'thiam_flight_number', $flight_number);
  update_post_meta($post_id, 'thiam_car_model', $car_model);
  update_post_meta($post_id, 'thiam_airport_mode', $airport_mode);

  $user = wp_get_current_user();
  $client_email = $user && $user->user_email ? $user->user_email : '';
  $admin_email = get_option('admin_email');
  $common_lines = [
    'Réservation confirmée.',
    'Départ : ' . $start_address,
    'Arrivée : ' . $end_address,
    'Heure de départ : ' . $departure_dt->format('H:i'),
    'Heure d\'arrivée : ' . $arrival_dt->format('H:i'),
    'Passagers: ' . $passengers,
    'Distance (km): ' . number_format($distance_km, 2),
    'Prix (EUR): ' . number_format($price_eur, 2),
    'Numero de vol: ' . $flight_number,
    'Mode aéroport: ' . $airport_mode,
    'Modele: ' . $car_model,
  ];
  $message = implode("\n", $common_lines);
  if ( $client_email ) {
    wp_mail($client_email, 'Confirmation de votre réservation VTC', $message);
  }
  if ( $admin_email ) {
    wp_mail($admin_email, 'Nouvelle réservation VTC', $message);
  }

  wp_send_json_success(['id' => $post_id]);
}
add_action('wp_ajax_thiam_vtc_clean_create_reservation', 'thiam_vtc_clean_create_reservation');

function thiam_vtc_clean_cancel_reservation() {
  if ( ! is_user_logged_in() ) {
    wp_send_json_error('Connexion requise.');
  }

  $nonce = isset($_POST['nonce']) ? sanitize_text_field(wp_unslash($_POST['nonce'])) : '';
  $nonce_ok = wp_verify_nonce($nonce, 'thiam_vtc_clean_reservation') || wp_verify_nonce($nonce, 'thiam_vtc_reservation');
  if ( ! $nonce_ok ) {
    wp_send_json_error('Requête invalide.');
  }

  $reservation_id = isset($_POST['reservation_id']) ? absint($_POST['reservation_id']) : 0;
  if ( ! $reservation_id ) {
    wp_send_json_error('Réservation invalide.');
  }

  $post = get_post($reservation_id);
  if ( ! $post || $post->post_type !== 'thiam_reservation' || (int) $post->post_author !== get_current_user_id() ) {
    wp_send_json_error('Accès refusé.');
  }

  wp_trash_post($reservation_id);
  wp_send_json_success();
}
add_action('wp_ajax_thiam_vtc_clean_cancel_reservation', 'thiam_vtc_clean_cancel_reservation');
add_action('wp_ajax_thiam_vtc_cancel_reservation', 'thiam_vtc_clean_cancel_reservation');
