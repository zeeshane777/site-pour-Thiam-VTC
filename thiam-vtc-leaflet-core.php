<?php
if ( ! defined('ABSPATH') ) {
  exit;
}

function thiam_vtc_register_reservations() {
  register_post_type('thiam_reservation', [
    'labels' => [
      'name' => 'Réservations',
      'singular_name' => 'Réservation',
    ],
    'public' => false,
    'show_ui' => true,
    'show_in_menu' => true,
    'supports' => ['title', 'author'],
    'capability_type' => 'post',
  ]);
}
add_action('init', 'thiam_vtc_register_reservations');

function thiam_vtc_route_shortcode() {
  $prefill_start = isset($_GET['start']) ? sanitize_text_field(wp_unslash($_GET['start'])) : '';
  $prefill_end = isset($_GET['end']) ? sanitize_text_field(wp_unslash($_GET['end'])) : '';
  ob_start();
  ?>
  <div class="thiam-route">
    <div class="thiam-route__map" id="thiam-route-map" aria-label="Map"></div>
    <div class="thiam-route__panel">
      <div class="thiam-route__form" id="thiam-route-form">
      <label class="thiam-route__label" for="thiam-route-start">Départ</label>
      <div class="thiam-route__field">
        <input id="thiam-route-start" type="text" placeholder="Votre adresse" autocomplete="off" value="<?php echo esc_attr($prefill_start); ?>">
        <div class="thiam-route__suggestions" id="thiam-route-start-suggestions" role="listbox"></div>
      </div>

      <label class="thiam-route__label" for="thiam-route-end">Arrivée</label>
      <div class="thiam-route__field">
        <input id="thiam-route-end" type="text" placeholder="Adresse de destination" autocomplete="off" value="<?php echo esc_attr($prefill_end); ?>">
        <div class="thiam-route__suggestions" id="thiam-route-end-suggestions" role="listbox"></div>
      </div>

      <label class="thiam-route__label" for="thiam-route-time">Heure de départ</label>
      <input id="thiam-route-time" type="time">

      <label class="thiam-route__label" for="thiam-route-passengers">Nombre de passagers</label>
      <select id="thiam-route-passengers">
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
      </select>

      <div class="thiam-route__total">
        <span>Total</span>
        <strong id="thiam-route-price">-- EUR</strong>
      </div>

      <button class="thiam-route__cta" id="thiam-route-cta" type="button">Reserver</button>
      <div class="thiam-route__meta" id="thiam-route-meta"></div>
      </div>
      <div class="thiam-route__confirm" id="thiam-route-confirm" hidden>
        <div class="thiam-route__confirm-icon" aria-hidden="true">&#10003;</div>
        <h3 class="thiam-route__confirm-title">Votre réservation a été confirmée</h3>
        <p class="thiam-route__confirm-text">
          Votre réservation a bien été enregistrée. Un message de confirmation
          contenant tous les détails de votre course vous sera envoyé.
        </p>
        <p class="thiam-route__confirm-text">
          Vous pouvez également consulter vos réservations en cours dans la page Réservations.
        </p>
        <a class="thiam-route__cta thiam-route__cta--confirm" href="<?php echo esc_url( home_url('/reservations/') ); ?>">Réservations</a>
      </div>
    </div>
  </div>
  <?php
  return ob_get_clean();
}
add_shortcode('thiam_vtc_route', 'thiam_vtc_route_shortcode');

function thiam_vtc_airport_markup($mode) {
  $allow_toggle = $mode === 'toggle';
  $mode = $mode === 'retrait' ? 'retrait' : 'depot';
  $address_label = $mode === 'retrait' ? 'Adresse de destination' : 'Adresse de depart';
  $show_reservation = isset($_GET['reservation']) && $_GET['reservation'] === '1';

  $hero_img = thiam_asset_url('photo avion aeroport.webp');
  $img2 = thiam_asset_url('Merco avant.webp');
  $img3 = thiam_asset_url('aeroportA.webp');
  $img4 = '';
  $reserve_url = add_query_arg('reservation', '1', get_permalink());
  $reserve_url = $reserve_url . '#reservation-map';

  ob_start();
  ?>
  <?php if ( ! $show_reservation ) : ?>
    <div class="aero-landing">
      <section class="aero-hero" style="--aero-hero: url('<?php echo esc_url($hero_img); ?>');">
        <div class="aero-hero__label">Transfert a&eacute;roport</div>
        <a class="aero-hero__cta" href="<?php echo esc_url($reserve_url); ?>">R&eacute;server</a>
      </section>

      <section class="aero-mini-grid">
        <a class="aero-mini-card" href="#reservoir" aria-label="Reservoir">
          <div class="aero-mini-card__icon">⛽</div>
          <h3 class="aero-mini-card__title">Reservoir</h3>
          <p class="aero-mini-card__text">Informations sur l&rsquo;autonomie / carburant.</p>
        </a>

        <a class="aero-mini-card" href="#coffre" aria-label="Volume du coffre">
          <div class="aero-mini-card__icon">🧳</div>
          <h3 class="aero-mini-card__title">Volume du coffre</h3>
          <p class="aero-mini-card__text">Capacite bagages selon vos besoins.</p>
        </a>

        <a class="aero-mini-card" href="#sieges" aria-label="Sieges">
          <div class="aero-mini-card__icon">❤</div>
          <h3 class="aero-mini-card__title">Sieges</h3>
          <p class="aero-mini-card__text">Confort et places disponibles.</p>
        </a>
      </section>

      <section class="aero-content-grid">
        <div class="aero-col">
          <article class="aero-text-block" id="reservoir">
            <h2>UN TRANSFERT AEROPORT ADAPTE A VOS BESOINS</h2>
            <p>Texte de presentation... (a remplacer).</p>
          </article>

          <figure class="aero-img-3">
            <img src="<?php echo esc_url($img3); ?>" alt="">
          </figure>
        </div>

        <div class="aero-col">
          <a class="aero-img-card aero-img-card--2" href="#coffre" style="--bg: url('<?php echo esc_url($img2); ?>');">
            <span class="aero-badge">1801</span>
          </a>

          <article class="aero-text-block" id="coffre">
            <h2>UNE SOLUTION SIMPLE POUR VOS DEPLACEMENTS</h2>
            <p>Texte de presentation... (a remplacer).</p>
            <span class="aero-badge aero-badge--inline">704</span>
          </article>

          <a class="aero-img-card aero-img-card--4" href="#sieges" <?php echo $img4 ? 'style="--bg: url(\'' . esc_url($img4) . '\');"' : ''; ?>></a>
        </div>
      </section>

      <div class="aero-reserver">
        <a class="aero-reserver__btn" href="<?php echo esc_url($reserve_url); ?>">Reserver</a>
      </div>
    </div>
  <?php else : ?>
    <div class="thiam-airport" id="reservation-map" data-mode="<?php echo esc_attr($mode); ?>" data-toggle="<?php echo $allow_toggle ? '1' : '0'; ?>">
      <div class="thiam-route">
        <div class="thiam-airport__map-wrap">
          <?php if ( $allow_toggle ) : ?>
            <div class="thiam-airport__tabs" role="tablist" aria-label="Type de trajet">
              <button class="thiam-airport__tab is-active" type="button" data-mode="depot" role="tab" aria-selected="true">Depot</button>
              <button class="thiam-airport__tab" type="button" data-mode="retrait" role="tab" aria-selected="false">Retrait</button>
            </div>
          <?php endif; ?>
          <div class="thiam-route__map" id="thiam-airport-map" aria-label="Map"></div>
        </div>
        <div class="thiam-route__panel">
          <div class="thiam-route__form" id="thiam-airport-form">
            <label class="thiam-route__label" for="thiam-airport-select">Votre aeroport</label>
            <select id="thiam-airport-select">
              <option value="cdg">Charles de Gaulle (CDG)</option>
              <option value="ory">Orly (ORY)</option>
            </select>

            <label class="thiam-route__label" for="thiam-airport-flight">Numero de vol</label>
            <div class="thiam-route__field">
              <input id="thiam-airport-flight" type="text" placeholder="Votre numero">
            </div>

            <label class="thiam-route__label" id="thiam-airport-address-label" for="thiam-airport-address"><?php echo esc_html($address_label); ?></label>
            <div class="thiam-route__field">
              <input id="thiam-airport-address" type="text" placeholder="Votre adresse" autocomplete="off">
              <div class="thiam-route__suggestions" id="thiam-airport-address-suggestions" role="listbox"></div>
            </div>

            <label class="thiam-route__label" for="thiam-airport-time">Heure de ramassage</label>
            <input id="thiam-airport-time" type="time">

            <label class="thiam-route__label" for="thiam-airport-passengers">Nombre de passagers</label>
            <select id="thiam-airport-passengers">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>

            <div class="thiam-route__total">
              <span>Total</span>
              <strong id="thiam-airport-price">-- EUR</strong>
            </div>

            <button class="thiam-route__cta" id="thiam-airport-cta" type="button">Reserver</button>
            <div class="thiam-route__meta" id="thiam-airport-meta"></div>
          </div>
          <div class="thiam-route__confirm" id="thiam-airport-confirm" hidden>
            <div class="thiam-route__confirm-icon" aria-hidden="true">&#10003;</div>
            <h3 class="thiam-route__confirm-title">Votre reservation a ete confirmee</h3>
            <p class="thiam-route__confirm-text">
              Votre reservation a bien ete enregistree. Un message de confirmation
              contenant tous les details de votre course vous sera envoye.
            </p>
            <p class="thiam-route__confirm-text">
              Vous pouvez egalement consulter vos reservations en cours dans la page Reservations.
            </p>
            <a class="thiam-route__cta thiam-route__cta--confirm" href="<?php echo esc_url( home_url('/reservations/') ); ?>">Reservations</a>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <?php
  return ob_get_clean();
}

function thiam_vtc_airport_shortcode() {
  return thiam_vtc_airport_markup('toggle');
}
add_shortcode('thiam_vtc_aeroport', 'thiam_vtc_airport_shortcode');

add_filter('the_content', function ($content) {
  if ( is_admin() ) {
    return $content;
  }
  if ( ! is_page('depose-aeroport') && ! is_page_template('page-depose-aeroport.php') ) {
    return $content;
  }
  return do_shortcode('[thiam_vtc_aeroport]');
}, 20);

function thiam_vtc_airport_depot_shortcode() {
  return thiam_vtc_airport_markup('depot');
}
add_shortcode('thiam_vtc_aeroport_depot', 'thiam_vtc_airport_depot_shortcode');

function thiam_vtc_airport_retrait_shortcode() {
  return thiam_vtc_airport_markup('retrait');
}
add_shortcode('thiam_vtc_aeroport_retrait', 'thiam_vtc_airport_retrait_shortcode');

function thiam_vtc_route_assets() {
  global $post;

  $is_airport_page = is_page('depose-aeroport') || is_page_template('page-depose-aeroport.php');

  $has_shortcode = $post && (
    has_shortcode($post->post_content, 'thiam_vtc_route')
    || has_shortcode($post->post_content, 'thiam_vtc_aeroport')
    || has_shortcode($post->post_content, 'thiam_vtc_aeroport_depot')
    || has_shortcode($post->post_content, 'thiam_vtc_aeroport_retrait')
  );

  $show_reservation = $is_airport_page && isset($_GET['reservation']) && $_GET['reservation'] === '1';

  if ( ! $has_shortcode && ! $show_reservation ) {
    return;
  }

  wp_enqueue_style(
    'thiam-leaflet',
    'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
    [],
    '1.9.4'
  );

  wp_enqueue_script(
    'thiam-leaflet',
    'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
    [],
    '1.9.4',
    true
  );

  $css = "
.thiam-route{display:grid;grid-template-columns:1.1fr .7fr;gap:24px;align-items:start}
.thiam-route__map{min-height:520px;border-radius:14px;overflow:hidden;border:1px solid #e6e1df}
.thiam-route__panel{background:#f7f2ee;border:1px solid #efe7e3;border-radius:16px;padding:20px;display:grid;gap:10px}
.thiam-route__label{font-size:14px;color:#4b3d3b}
.thiam-route__field{position:relative}
.thiam-route__field input,.thiam-route__panel select,.thiam-route__panel input[type=time]{width:100%;display:flex;align-items:center;gap:10px;align-self:stretch;height:59px;padding:8px 24px 8px 8px;border:1px solid #e3d9d2;border-radius:16px;background:var(--DB-Primary,#f9f4ef);color:var(--DB-Secondary,#141414);font-family:\"Satoshi\",sans-serif;font-size:20px;font-style:normal;font-weight:500;line-height:normal}
.thiam-route__suggestions{position:absolute;left:0;right:0;top:100%;z-index:10;background:#fff;border:1px solid #e3d9d2;border-radius:10px;margin-top:6px;display:none;max-height:180px;overflow:auto}
.thiam-route__suggestions button{display:block;width:100%;text-align:left;padding:8px 10px;border:0;background:#fff;cursor:pointer}
.thiam-route__suggestions button:hover{background:#f5f1ee}
.thiam-route__total{display:flex;justify-content:space-between;align-items:center;margin-top:6px}
.thiam-route__cta{margin-top:6px;background:#3c0f1b;color:#fff;border:0;padding:12px 16px;border-radius:999px;cursor:pointer}
.thiam-route__meta{font-size:13px;color:#5b4f4a}
.thiam-route__confirm{background:#f7f2ee;border:1px solid #efe7e3;border-radius:16px;padding:28px;display:grid;gap:12px;align-content:start}
.thiam-route__confirm[hidden]{display:none}
.thiam-route__confirm-icon{width:72px;height:72px;border-radius:50%;border:3px solid #3c0f1b;color:#3c0f1b;display:grid;place-items:center;font-size:36px;margin-bottom:6px}
.thiam-route__confirm-title{margin:0;font-size:20px;color:#1f1a17}
.thiam-route__confirm-text{margin:0;font-size:14px;color:#5b4f4a;line-height:1.4}
.thiam-airport__map-wrap{display:grid;gap:10px}
.thiam-airport__tabs{display:flex;gap:12px}
.thiam-airport__tab{min-width:140px;height:42px;padding:0 18px;border-radius:12px;border:1px solid #e3d9d2;background:#f1eeeb;color:#2b2320;font-weight:600;cursor:pointer}
.thiam-airport__tab.is-active{background:#3c0f1b;color:#fff;border-color:#3c0f1b}
.thiam-airport .thiam-route__map{height:520px}
@media (max-width: 900px){.thiam-route{grid-template-columns:1fr}.thiam-route__map{min-height:360px}}
";
  wp_add_inline_style('thiam-leaflet', $css);

  $config = [
    'pricePerKm' => 2.5,
    'nominatim' => 'https://nominatim.openstreetmap.org/search',
    'osrm' => 'https://router.project-osrm.org/route/v1/driving/',
    'reservationsUrl' => home_url('/reservations/'),
    'ajaxUrl' => admin_url('admin-ajax.php'),
    'nonce' => wp_create_nonce('thiam_vtc_reservation'),
    'isLoggedIn' => is_user_logged_in(),
    'loginUrl' => home_url('/s-identifier/'),
  ];
  wp_add_inline_script('thiam-leaflet', 'window.THIA_ROUTE_CONFIG=' . wp_json_encode($config) . ';', 'before');

  $js = <<<'JS'
(function () {
  var mapEl = document.getElementById('thiam-route-map');
  if (!mapEl || typeof L === 'undefined') {
    return;
  }
  var idfBounds = L.latLngBounds(
    [48.1200, 1.4460],
    [49.2500, 3.5600]
  );
  var map = L.map('thiam-route-map', {
    scrollWheelZoom: false,
    maxBounds: idfBounds,
    maxBoundsViscosity: 1.0
  }).fitBounds(idfBounds);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; OpenStreetMap'
  }).addTo(map);

  var startInput = document.getElementById('thiam-route-start');
  var endInput = document.getElementById('thiam-route-end');
  var startSuggestions = document.getElementById('thiam-route-start-suggestions');
  var endSuggestions = document.getElementById('thiam-route-end-suggestions');
  var metaEl = document.getElementById('thiam-route-meta');
  var priceEl = document.getElementById('thiam-route-price');
  var startPoint = null;
  var endPoint = null;
  var routeLayer = null;
  var startMarker = null;
  var endMarker = null;
  var lastDistanceKm = null;
  var lastDurationSec = null;

  function debounce(fn, wait) {
    var t;
    return function () {
      var args = arguments;
      clearTimeout(t);
      t = setTimeout(function () { fn.apply(null, args); }, wait);
    };
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

  function formatAddress(item) {
    if (!item || !item.address) {
      return item && item.display_name ? item.display_name : '';
    }
    var a = item.address;
    var street = [a.house_number, a.road].filter(Boolean).join(' ');
    var city = a.city || a.town || a.village || a.municipality || a.suburb || a.county;
    var postcode = a.postcode;
    var parts = [];
    if (street) { parts.push(street); }
    if (postcode || city) { parts.push([postcode, city].filter(Boolean).join(' ')); }
    if (a.country) { parts.push(a.country); }
    return parts.length ? parts.join(', ') : (item.display_name || '');
  }

  function precisionScore(item) {
    var a = item && item.address ? item.address : {};
    if (a.house_number || item.type === 'house' || item.type === 'building') {
      return 0;
    }
    if (a.road || item.type === 'residential' || item.type === 'road') {
      return 1;
    }
    if (a.neighbourhood || a.suburb || a.city_district) {
      return 2;
    }
    if (a.city || a.town || a.village || a.municipality) {
      return 3;
    }
    return 4;
  }

  function orderSuggestions(items) {
    return items.slice().sort(function (a, b) {
      var scoreA = precisionScore(a);
      var scoreB = precisionScore(b);
      if (scoreA !== scoreB) { return scoreA - scoreB; }
      var impA = typeof a.importance === 'number' ? a.importance : 0;
      var impB = typeof b.importance === 'number' ? b.importance : 0;
      return impB - impA;
    });
  }

  function fetchSuggestions(query, listEl, onSelect) {
    if (!query || query.length < 3) {
      clearSuggestions(listEl);
      return;
    }
    var viewbox = '1.4460,49.2500,3.5600,48.1200';
    var url = window.THIA_ROUTE_CONFIG.nominatim +
      '?format=jsonv2&addressdetails=1&limit=8&bounded=1&viewbox=' + viewbox +
      '&countrycodes=fr&accept-language=fr&dedupe=1' +
      '&q=' + encodeURIComponent(query);
    fetch(url, { headers: { 'Accept': 'application/json' } })
      .then(function (res) { return res.json(); })
      .then(function (data) {
        var items = Array.isArray(data) ? orderSuggestions(data).slice(0, 8) : [];
        showSuggestions(listEl, items, onSelect);
      })
      .catch(function () { clearSuggestions(listEl); });
  }

  function fetchFirstSuggestion(query, onSelect) {
    if (!query || query.length < 3) {
      return;
    }
    var viewbox = '1.4460,49.2500,3.5600,48.1200';
    var url = window.THIA_ROUTE_CONFIG.nominatim +
      '?format=jsonv2&addressdetails=1&limit=5&bounded=1&viewbox=' + viewbox +
      '&countrycodes=fr&accept-language=fr&dedupe=1' +
      '&q=' + encodeURIComponent(query);
    fetch(url, { headers: { 'Accept': 'application/json' } })
      .then(function (res) { return res.json(); })
      .then(function (data) {
        var items = Array.isArray(data) ? orderSuggestions(data) : [];
        if (items.length) {
          onSelect(items[0]);
        }
      })
      .catch(function () {});
  }

  function prefillFromQuery() {
    if (!window.URLSearchParams) {
      return;
    }
    var params = new URLSearchParams(window.location.search);
    var startQ = params.get('start');
    var endQ = params.get('end');
    if (startQ) {
      startInput.value = startQ;
      fetchFirstSuggestion(startQ, function (item) { setPoint(item, true); });
    }
    if (endQ) {
      endInput.value = endQ;
      fetchFirstSuggestion(endQ, function (item) { setPoint(item, false); });
    }
  }

  function setPoint(point, isStart) {
    var lat = parseFloat(point.lat);
    var lon = parseFloat(point.lon);
    if (!idfBounds.contains([lat, lon])) {
      metaEl.textContent = 'Adresse hors Ile-de-France.';
      return;
    }
    if (isStart) {
      startPoint = { lat: lat, lon: lon };
      if (startMarker) { map.removeLayer(startMarker); }
      startMarker = L.marker([lat, lon]).addTo(map);
      startInput.value = formatAddress(point);
    } else {
      endPoint = { lat: lat, lon: lon };
      if (endMarker) { map.removeLayer(endMarker); }
      endMarker = L.marker([lat, lon]).addTo(map);
      endInput.value = formatAddress(point);
    }
    tryRoute();
  }

  var onStartInput = debounce(function (e) {
    fetchSuggestions(e.target.value, startSuggestions, function (item) { setPoint(item, true); });
  }, 300);
  var onEndInput = debounce(function (e) {
    fetchSuggestions(e.target.value, endSuggestions, function (item) { setPoint(item, false); });
  }, 300);

  startInput.addEventListener('input', onStartInput);
  endInput.addEventListener('input', onEndInput);
  prefillFromQuery();

  var ctaEl = document.getElementById('thiam-route-cta');
  var confirmEl = document.getElementById('thiam-route-confirm');
  var formEl = document.getElementById('thiam-route-form');
  if (ctaEl && confirmEl && formEl) {
    ctaEl.addEventListener('click', function () {
      if (!window.THIA_ROUTE_CONFIG.isLoggedIn) {
        window.location.href = window.THIA_ROUTE_CONFIG.loginUrl;
        return;
      }
      if (!startInput.value || !endInput.value || !lastDistanceKm || !lastDurationSec) {
        metaEl.textContent = 'Merci de renseigner le trajet.';
        return;
      }
      var departTime = document.getElementById('thiam-route-time').value;
      if (!departTime) {
        metaEl.textContent = 'Merci de choisir une heure de depart.';
        return;
      }
      var passengers = document.getElementById('thiam-route-passengers').value;
      var priceText = priceEl.textContent.replace(' EUR', '');
      var payload = new FormData();
      payload.append('action', 'thiam_vtc_create_reservation');
      payload.append('nonce', window.THIA_ROUTE_CONFIG.nonce);
      payload.append('start_address', startInput.value);
      payload.append('end_address', endInput.value);
      payload.append('depart_time', departTime);
      payload.append('passengers', passengers);
      payload.append('distance_km', lastDistanceKm);
      payload.append('duration_sec', lastDurationSec);
      payload.append('price_eur', priceText);
      fetch(window.THIA_ROUTE_CONFIG.ajaxUrl, {
        method: 'POST',
        credentials: 'same-origin',
        body: payload
      })
        .then(function (res) { return res.json(); })
        .then(function (data) {
          if (!data || !data.success) {
            metaEl.textContent = data && data.data ? data.data : 'Erreur lors de la reservation.';
            return;
          }
          formEl.hidden = true;
          confirmEl.hidden = false;
        })
        .catch(function () {
          metaEl.textContent = 'Erreur lors de la reservation.';
        });
    });
  }

  function tryRoute() {
    if (!startPoint || !endPoint) {
      return;
    }
    var url = window.THIA_ROUTE_CONFIG.osrm +
      startPoint.lon + ',' + startPoint.lat + ';' + endPoint.lon + ',' + endPoint.lat +
      '?overview=full&geometries=geojson';
    fetch(url)
      .then(function (res) { return res.json(); })
      .then(function (data) {
        if (!data.routes || !data.routes.length) {
          metaEl.textContent = 'Aucun trajet trouve.';
          return;
        }
        var route = data.routes[0];
        var coords = route.geometry.coordinates.map(function (c) { return [c[1], c[0]]; });
        if (routeLayer) { map.removeLayer(routeLayer); }
        routeLayer = L.polyline(coords, { color: '#4a2d2b', weight: 5 }).addTo(map);
        map.fitBounds(routeLayer.getBounds(), { padding: [20, 20] });

        var km = route.distance / 1000;
        var price = km * window.THIA_ROUTE_CONFIG.pricePerKm;
        priceEl.textContent = price.toFixed(2) + ' EUR';
        lastDistanceKm = km.toFixed(2);
        lastDurationSec = Math.round(route.duration);
        metaEl.textContent = km.toFixed(1) + ' km - ' + Math.round(route.duration / 60) + ' min';
      })
      .catch(function () {
        metaEl.textContent = 'Erreur de calcul.';
      });
  }
})();

(function initAirportMap() {
  var mapEl = document.getElementById('thiam-airport-map');
  if (!mapEl) {
    return;
  }
  if (typeof L === 'undefined') {
    setTimeout(initAirportMap, 100);
    return;
  }
  var wrapperEl = mapEl.closest('.thiam-airport');
  var mode = wrapperEl && wrapperEl.getAttribute('data-mode') ? wrapperEl.getAttribute('data-mode') : 'depot';
  var allowToggle = wrapperEl && wrapperEl.getAttribute('data-toggle') === '1';
  if (mode !== 'retrait') {
    mode = 'depot';
  }
  var idfBounds = L.latLngBounds(
    [48.1200, 1.4460],
    [49.2500, 3.5600]
  );
  var map = L.map('thiam-airport-map', {
    scrollWheelZoom: false,
    maxBounds: idfBounds,
    maxBoundsViscosity: 1.0
  }).fitBounds(idfBounds);
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; OpenStreetMap'
  }).addTo(map);

  mapEl.style.height = '520px';
  mapEl.style.minHeight = '520px';
  setTimeout(function () {
    map.invalidateSize();
  }, 150);
  window.addEventListener('load', function () {
    map.invalidateSize();
  });

  var airports = {
    cdg: { name: 'Charles de Gaulle', lat: 49.0097, lon: 2.5479 },
    ory: { name: 'Orly', lat: 48.7276, lon: 2.3590 }
  };

  var airportSelect = document.getElementById('thiam-airport-select');
  var addressInput = document.getElementById('thiam-airport-address');
  var addressSuggestions = document.getElementById('thiam-airport-address-suggestions');
  var addressLabel = document.getElementById('thiam-airport-address-label');
  var metaEl = document.getElementById('thiam-airport-meta');
  var priceEl = document.getElementById('thiam-airport-price');
  var lastDistanceKm = null;
  var lastDurationSec = null;
  var addressPoint = null;
  var routeLayer = null;
  var tabs = wrapperEl ? wrapperEl.querySelectorAll('.thiam-airport__tab') : null;

  if (airportSelect && window.URLSearchParams) {
    var airportParam = new URLSearchParams(window.location.search).get('airport');
    if (airportParam && airports[airportParam]) {
      airportSelect.value = airportParam;
    }
  }

  function setMode(nextMode) {
    if (nextMode !== 'retrait') {
      nextMode = 'depot';
    }
    mode = nextMode;
    if (wrapperEl) {
      wrapperEl.setAttribute('data-mode', mode);
    }
    if (addressLabel) {
      addressLabel.textContent = mode === 'retrait' ? 'Adresse de destination' : 'Adresse de depart';
    }
    if (tabs && tabs.length) {
      tabs.forEach(function (tab) {
        var isActive = tab.getAttribute('data-mode') === mode;
        tab.classList.toggle('is-active', isActive);
        tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
      });
    }
    tryRoute();
  }

  function debounce(fn, wait) {
    var t;
    return function () {
      var args = arguments;
      clearTimeout(t);
      t = setTimeout(function () { fn.apply(null, args); }, wait);
    };
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

  function formatAddress(item) {
    if (!item || !item.address) {
      return item && item.display_name ? item.display_name : '';
    }
    var a = item.address;
    var street = [a.house_number, a.road].filter(Boolean).join(' ');
    var city = a.city || a.town || a.village || a.municipality || a.suburb || a.county;
    var postcode = a.postcode;
    var parts = [];
    if (street) { parts.push(street); }
    if (postcode || city) { parts.push([postcode, city].filter(Boolean).join(' ')); }
    if (a.country) { parts.push(a.country); }
    return parts.length ? parts.join(', ') : (item.display_name || '');
  }

  function precisionScore(item) {
    var a = item && item.address ? item.address : {};
    if (a.house_number || item.type === 'house' || item.type === 'building') {
      return 0;
    }
    if (a.road || item.type === 'residential' || item.type === 'road') {
      return 1;
    }
    if (a.neighbourhood || a.suburb || a.city_district) {
      return 2;
    }
    if (a.city || a.town || a.village || a.municipality) {
      return 3;
    }
    return 4;
  }

  function orderSuggestions(items) {
    return items.slice().sort(function (a, b) {
      var scoreA = precisionScore(a);
      var scoreB = precisionScore(b);
      if (scoreA !== scoreB) { return scoreA - scoreB; }
      var impA = typeof a.importance === 'number' ? a.importance : 0;
      var impB = typeof b.importance === 'number' ? b.importance : 0;
      return impB - impA;
    });
  }

  function fetchSuggestions(query, listEl, onSelect) {
    if (!query || query.length < 3) {
      clearSuggestions(listEl);
      return;
    }
    var viewbox = '1.4460,49.2500,3.5600,48.1200';
    var url = window.THIA_ROUTE_CONFIG.nominatim +
      '?format=jsonv2&addressdetails=1&limit=8&bounded=1&viewbox=' + viewbox +
      '&countrycodes=fr&accept-language=fr&dedupe=1' +
      '&q=' + encodeURIComponent(query);
    fetch(url, { headers: { 'Accept': 'application/json' } })
      .then(function (res) { return res.json(); })
      .then(function (data) {
        var items = Array.isArray(data) ? orderSuggestions(data).slice(0, 8) : [];
        showSuggestions(listEl, items, onSelect);
      })
      .catch(function () { clearSuggestions(listEl); });
  }

  var onAddressInput = debounce(function (e) {
    fetchSuggestions(e.target.value, addressSuggestions, function (item) {
      var lat = parseFloat(item.lat);
      var lon = parseFloat(item.lon);
      if (!idfBounds.contains([lat, lon])) {
        metaEl.textContent = 'Adresse hors Ile-de-France.';
        return;
      }
      addressPoint = { lat: lat, lon: lon, label: formatAddress(item) };
      addressInput.value = formatAddress(item);
      tryRoute();
    });
  }, 300);

  addressInput.addEventListener('input', onAddressInput);
  airportSelect.addEventListener('change', tryRoute);
  if (allowToggle && tabs && tabs.length) {
    tabs.forEach(function (tab) {
      tab.addEventListener('click', function () {
        setMode(tab.getAttribute('data-mode'));
      });
    });
  }

  function tryRoute() {
    if (!addressPoint) {
      return;
    }
    var airport = airports[airportSelect.value];
    if (!airport) {
      return;
    }
    var start = mode === 'depot' ? addressPoint : airport;
    var end = mode === 'depot' ? airport : addressPoint;
    var url = window.THIA_ROUTE_CONFIG.osrm +
      start.lon + ',' + start.lat + ';' + end.lon + ',' + end.lat +
      '?overview=full&geometries=geojson';
    fetch(url)
      .then(function (res) { return res.json(); })
      .then(function (data) {
        if (!data.routes || !data.routes.length) {
          metaEl.textContent = 'Aucun trajet trouve.';
          return;
        }
        var route = data.routes[0];
        var coords = route.geometry.coordinates.map(function (c) { return [c[1], c[0]]; });
        if (routeLayer) { map.removeLayer(routeLayer); }
        routeLayer = L.polyline(coords, { color: '#4a2d2b', weight: 5 }).addTo(map);
        map.fitBounds(routeLayer.getBounds(), { padding: [20, 20] });

        var km = route.distance / 1000;
        var price = km * window.THIA_ROUTE_CONFIG.pricePerKm;
        priceEl.textContent = price.toFixed(2) + ' EUR';
        lastDistanceKm = km.toFixed(2);
        lastDurationSec = Math.round(route.duration);
        metaEl.textContent = km.toFixed(1) + ' km - ' + Math.round(route.duration / 60) + ' min';
      })
      .catch(function () {
        metaEl.textContent = 'Erreur de calcul.';
      });
  }

  var ctaEl = document.getElementById('thiam-airport-cta');
  var confirmEl = document.getElementById('thiam-airport-confirm');
  var formEl = document.getElementById('thiam-airport-form');
  if (ctaEl && confirmEl && formEl) {
    ctaEl.addEventListener('click', function () {
      if (!window.THIA_ROUTE_CONFIG.isLoggedIn) {
        window.location.href = window.THIA_ROUTE_CONFIG.loginUrl;
        return;
      }
      if (!addressInput.value || !lastDistanceKm || !lastDurationSec) {
        metaEl.textContent = 'Merci de renseigner le trajet.';
        return;
      }
      var timeValue = document.getElementById('thiam-airport-time').value;
      if (!timeValue) {
        metaEl.textContent = 'Merci de choisir une heure de ramassage.';
        return;
      }
      var passengers = document.getElementById('thiam-airport-passengers').value;
      var flight = document.getElementById('thiam-airport-flight').value;
      var airport = airports[airportSelect.value];
      var startLabel = mode === 'depot' ? addressInput.value : (airport ? airport.name : '');
      var endLabel = mode === 'depot' ? (airport ? airport.name : '') : addressInput.value;

      var priceText = priceEl.textContent.replace(' EUR', '');
      var payload = new FormData();
      payload.append('action', 'thiam_vtc_create_reservation');
      payload.append('nonce', window.THIA_ROUTE_CONFIG.nonce);
      payload.append('start_address', startLabel);
      payload.append('end_address', endLabel);
      payload.append('depart_time', timeValue);
      payload.append('passengers', passengers);
      payload.append('distance_km', lastDistanceKm);
      payload.append('duration_sec', lastDurationSec);
      payload.append('price_eur', priceText);
      payload.append('service_type', 'aeroport');
      payload.append('airport_name', airport ? airport.name : '');
      payload.append('flight_number', flight);
      payload.append('airport_mode', mode);
      fetch(window.THIA_ROUTE_CONFIG.ajaxUrl, {
        method: 'POST',
        credentials: 'same-origin',
        body: payload
      })
        .then(function (res) { return res.json(); })
        .then(function (data) {
          if (!data || !data.success) {
            metaEl.textContent = data && data.data ? data.data : 'Erreur lors de la reservation.';
            return;
          }
          formEl.hidden = true;
          confirmEl.hidden = false;
        })
        .catch(function () {
          metaEl.textContent = 'Erreur lors de la reservation.';
        });
    });
  }
})();
JS;

  wp_add_inline_script('thiam-leaflet', $js, 'after');
}
add_action('wp_enqueue_scripts', 'thiam_vtc_route_assets');

function thiam_vtc_create_reservation() {
  if ( ! is_user_logged_in() ) {
    wp_send_json_error('Connexion requise.');
  }
  if ( ! isset($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'thiam_vtc_reservation') ) {
    wp_send_json_error('Requête invalide.');
  }

  $start_address = isset($_POST['start_address']) ? sanitize_text_field(wp_unslash($_POST['start_address'])) : '';
  $end_address = isset($_POST['end_address']) ? sanitize_text_field(wp_unslash($_POST['end_address'])) : '';
  $depart_time = isset($_POST['depart_time']) ? sanitize_text_field(wp_unslash($_POST['depart_time'])) : '';
  $passengers = isset($_POST['passengers']) ? absint($_POST['passengers']) : 1;
  $distance_km = isset($_POST['distance_km']) ? floatval($_POST['distance_km']) : 0;
  $duration_sec = isset($_POST['duration_sec']) ? absint($_POST['duration_sec']) : 0;
  $price_eur = isset($_POST['price_eur']) ? floatval($_POST['price_eur']) : 0;
  $service_type = isset($_POST['service_type']) ? sanitize_text_field(wp_unslash($_POST['service_type'])) : 'ville';
  $airport_name = isset($_POST['airport_name']) ? sanitize_text_field(wp_unslash($_POST['airport_name'])) : '';
  $flight_number = isset($_POST['flight_number']) ? sanitize_text_field(wp_unslash($_POST['flight_number'])) : '';
  $airport_mode = isset($_POST['airport_mode']) ? sanitize_text_field(wp_unslash($_POST['airport_mode'])) : '';

  if ( empty($start_address) || empty($end_address) || empty($depart_time) ) {
    wp_send_json_error('Champs manquants.');
  }

  $time_parts = explode(':', $depart_time);
  if ( count($time_parts) < 2 ) {
    wp_send_json_error('Heure invalide.');
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
    'post_title' => 'Réservation ' . $now->format('Y-m-d H:i'),
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
  update_post_meta($post_id, 'thiam_airport_mode', $airport_mode);

  $user = wp_get_current_user();
  $client_email = $user && $user->user_email ? $user->user_email : '';
  $admin_email = get_option('admin_email');
  $common_lines = [
    'Réservation confirmée.',
    'Départ: ' . $start_address,
    'Arrivée: ' . $end_address,
    'Heure de départ: ' . $departure_dt->format('H:i'),
    'Heure d\'arrivée: ' . $arrival_dt->format('H:i'),
    'Passagers: ' . $passengers,
    'Distance (km): ' . number_format($distance_km, 2),
    'Prix (EUR): ' . number_format($price_eur, 2),
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
add_action('wp_ajax_thiam_vtc_create_reservation', 'thiam_vtc_create_reservation');

function thiam_vtc_cancel_reservation() {
  if ( ! is_user_logged_in() ) {
    wp_send_json_error('Connexion requise.');
  }
  if ( ! isset($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'thiam_vtc_reservation') ) {
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
add_action('wp_ajax_thiam_vtc_cancel_reservation', 'thiam_vtc_cancel_reservation');
