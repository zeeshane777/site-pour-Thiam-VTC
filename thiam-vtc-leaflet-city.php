<?php
if ( ! defined('ABSPATH') ) {
  exit;
}

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
          Vous pouvez également consulter vos reservations en cours dans la page Vos reservations.
        </p>
        <a class="thiam-route__cta thiam-route__cta--confirm" href="<?php echo esc_url( home_url('/reservations/') ); ?>">Vos reservations</a>
      </div>
    </div>
  </div>
  <?php
  return ob_get_clean();
}
add_shortcode('thiam_vtc_route', 'thiam_vtc_route_shortcode');

function thiam_vtc_route_assets() {
  global $post;
  if ( ! $post || ! has_shortcode($post->post_content, 'thiam_vtc_route') ) {
    return;
  }

  thiam_vtc_enqueue_leaflet_assets();

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

  function setPoint(point, isStart) {
    var lat = parseFloat(point.lat);
    var lon = parseFloat(point.lon);
    if (!idfBounds.contains([lat, lon])) {
      metaEl.textContent = 'Adresse hors Île-de-France.';
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
        metaEl.textContent = 'Merci de choisir une heure de départ.';
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
            metaEl.textContent = data && data.data ? data.data : 'Erreur lors de la réservation.';
            return;
          }
          formEl.hidden = true;
          confirmEl.hidden = false;
        })
        .catch(function () {
          metaEl.textContent = 'Erreur lors de la réservation.';
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
          metaEl.textContent = 'Aucun trajet trouvé.';
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
JS;

  wp_add_inline_script('thiam-leaflet', $js, 'after');
}
add_action('wp_enqueue_scripts', 'thiam_vtc_route_assets');
