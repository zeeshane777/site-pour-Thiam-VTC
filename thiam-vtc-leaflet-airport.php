<?php
if ( ! defined('ABSPATH') ) {
  exit;
}

function thiam_vtc_airport_markup($mode) {
  $allow_toggle = $mode === 'toggle';
  $mode = $mode === 'retrait' ? 'retrait' : 'depot';
  $address_label = $mode === 'retrait' ? 'Adresse de destination' : 'Adresse de d&eacute;part';
  $show_reservation = isset($_GET['reservation']) && $_GET['reservation'] === '1';

  $asset_base = get_template_directory_uri() . '/assets/';
  $hero_img = $asset_base . rawurlencode('photo avion aeroport.webp');
  $img2 = $asset_base . rawurlencode('Merco avant.webp');
  $img3 = $asset_base . rawurlencode('aeroportA.webp');
  $img4 = $asset_base . rawurlencode('aeroportB.webp');

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
        <a class="aero-mini-card" href="#reservoir" aria-label="R&eacute;servoir">
          <div class="aero-mini-card__icon">&#x26FD;</div>
          <h3 class="aero-mini-card__title">R&eacute;servoir</h3>
          <p class="aero-mini-card__text">Informations sur l&rsquo;autonomie / carburant.</p>
        </a>

        <a class="aero-mini-card" href="#coffre" aria-label="Volume du coffre">
          <div class="aero-mini-card__icon">&#x1F9F3;</div>
          <h3 class="aero-mini-card__title">Volume du coffre</h3>
          <p class="aero-mini-card__text">Capacit&eacute; bagages selon vos besoins.</p>
        </a>

        <a class="aero-mini-card" href="#sieges" aria-label="Si&egrave;ges">
          <div class="aero-mini-card__icon">&#x2665;</div>
          <h3 class="aero-mini-card__title">Si&egrave;ges</h3>
          <p class="aero-mini-card__text">Confort et places disponibles.</p>
        </a>
      </section>

      <section class="aero-content-grid">
        <div class="aero-col">
          <article class="aero-text-block" id="reservoir">
            <h2>UN TRANSFERT A&Eacute;ROPORT ADAPT&Eacute; &Agrave; VOS BESOINS</h2>
            <p>Texte de pr&eacute;sentation&hellip; (&agrave; remplacer).</p>
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
            <h2>UNE SOLUTION SIMPLE POUR VOS D&Eacute;PLACEMENTS</h2>
            <p>Texte de pr&eacute;sentation&hellip; (&agrave; remplacer).</p>
            <span class="aero-badge aero-badge--inline">704</span>
          </article>

          <a class="aero-img-card aero-img-card--4" href="#sieges" <?php echo $img4 ? 'style="--bg: url(\'' . esc_url($img4) . '\');"' : ''; ?>></a>
        </div>
      </section>

      <div class="aero-reserver">
        <a class="aero-reserver__btn" href="<?php echo esc_url($reserve_url); ?>">R&eacute;server</a>
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
            <label class="thiam-route__label" for="thiam-airport-select">Votre a&eacute;roport</label>
            <select id="thiam-airport-select">
              <option value="cdg">Charles de Gaulle (CDG)</option>
              <option value="ory">Orly (ORY)</option>
            </select>

            <label class="thiam-route__label" for="thiam-airport-flight">Num&eacute;ro de vol</label>
            <div class="thiam-route__field">
              <input id="thiam-airport-flight" type="text" placeholder="Votre numero">
            </div>

            <label class="thiam-route__label" id="thiam-airport-address-label" for="thiam-airport-address"><?php echo $address_label; ?></label>
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
            <h3 class="thiam-route__confirm-title">Votre r&eacute;servation a &eacute;t&eacute; confirm&eacute;e</h3>
            <p class="thiam-route__confirm-text">
              Votre r&eacute;servation a bien &eacute;t&eacute; enregistr&eacute;e. Un message de confirmation
              contenant tous les d&eacute;tails de votre course vous sera envoy&eacute;.
            </p>
            <p class="thiam-route__confirm-text">
              Vous pouvez &eacute;galement consulter vos r&eacute;servations en cours dans la page R&eacute;servations.
            </p>
            <a class="thiam-route__cta thiam-route__cta--confirm" href="<?php echo esc_url( home_url('/reservations/') ); ?>">R&eacute;servations</a>
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

function thiam_vtc_airport_depot_shortcode() {
  return thiam_vtc_airport_markup('depot');
}
add_shortcode('thiam_vtc_aeroport_depot', 'thiam_vtc_airport_depot_shortcode');

function thiam_vtc_airport_retrait_shortcode() {
  return thiam_vtc_airport_markup('retrait');
}
add_shortcode('thiam_vtc_aeroport_retrait', 'thiam_vtc_airport_retrait_shortcode');

add_filter('the_content', function ($content) {
  if ( is_admin() ) {
    return $content;
  }
  if ( ! is_page('depose-aeroport') && ! is_page_template('page-depose-aeroport.php') ) {
    return $content;
  }
  return do_shortcode('[thiam_vtc_aeroport]');
}, 20);

function thiam_vtc_airport_assets() {
  global $post;
  $is_airport_page = is_page('depose-aeroport')
    || is_page_template('page-depose-aeroport.php')
    || is_page('reservation-aeroport')
    || is_page_template('page-reservation-aeroport.php');
  $has_shortcode = $post && ( has_shortcode($post->post_content, 'thiam_vtc_aeroport')
    || has_shortcode($post->post_content, 'thiam_vtc_aeroport_depot')
    || has_shortcode($post->post_content, 'thiam_vtc_aeroport_retrait') );
  $show_reservation = $is_airport_page && isset($_GET['reservation']) && $_GET['reservation'] === '1';

  if ( ! $has_shortcode && ! $show_reservation ) {
    return;
  }

  thiam_vtc_enqueue_leaflet_assets();

  $js = <<<'JS'
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
      addressLabel.textContent = mode === 'retrait' ? 'Adresse de destination' : 'Adresse de d\u00e9part';
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
        metaEl.textContent = 'Adresse hors \u00cele-de-France.';
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
          metaEl.textContent = 'Aucun trajet trouv\u00e9.';
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
            metaEl.textContent = data && data.data ? data.data : 'Erreur lors de la r\u00e9servation.';
            return;
          }
          formEl.hidden = true;
          confirmEl.hidden = false;
        })
        .catch(function () {
          metaEl.textContent = 'Erreur lors de la r\u00e9servation.';
        });
    });
  }
})();
JS;

  wp_add_inline_script('thiam-leaflet', $js, 'after');
}
add_action('wp_enqueue_scripts', 'thiam_vtc_airport_assets');

