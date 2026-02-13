document.addEventListener("DOMContentLoaded", () => {
  const serviceToggle = document.querySelector(".tsf-nav__link--button");
  const serviceItem = document.querySelector(".tsf-nav__item--services");

  if (!serviceToggle || !serviceItem) {
    // Keep going; other page features can still initialize.
  }

  if (serviceToggle && serviceItem) {
    const dropdown = serviceItem.querySelector(".tsf-nav__dropdown");
    const setExpanded = (isOpen) => {
      serviceToggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
    };

    serviceItem.addEventListener("mouseenter", () => setExpanded(true));
    serviceItem.addEventListener("mouseleave", () => setExpanded(false));
    serviceItem.addEventListener("focusin", () => setExpanded(true));
    serviceItem.addEventListener("focusout", () => setExpanded(false));

    if (dropdown) {
      dropdown.addEventListener("click", () => setExpanded(false));
    }
  }

  const bindPasswordToggle = (checkboxId, inputId) => {
    const checkbox = document.getElementById(checkboxId);
    const input = document.getElementById(inputId);
    if (!checkbox || !input) {
      return;
    }

    const labelText = checkbox.closest("label");
    const setState = () => {
      const show = checkbox.checked;
      input.type = show ? "text" : "password";
      if (labelText) {
        labelText.lastElementChild.textContent = show
          ? "Masquer le mot de passe"
          : "Affichez le mot de passe";
      }
    };

    checkbox.addEventListener("change", setState);
    setState();
  };

  bindPasswordToggle("tsf_toggle_password", "tsf_password");
  bindPasswordToggle("tsf_toggle_password_register", "reg_password");

  const parallaxItems = Array.from(document.querySelectorAll(".parallax-zoom"));
  if (parallaxItems.length) {
    let ticking = false;

    const clamp = (value, min, max) => Math.min(Math.max(value, min), max);

    const updateParallax = () => {
      const viewport = window.innerHeight || 1;
      parallaxItems.forEach((item) => {
        const rect = item.getBoundingClientRect();
        const total = rect.height + viewport;
        if (total <= 0) {
          return;
        }
        const progress = clamp((viewport - rect.top) / total, 0, 1);
        const scale = 1.35 - progress * 0.35;
        const shift = (0.5 - progress) * 80;
        item.style.setProperty("--pz-scale", scale.toFixed(3));
        item.style.setProperty("--pz-shift", `${shift.toFixed(1)}px`);
      });
      ticking = false;
    };

    const requestTick = () => {
      if (ticking) {
        return;
      }
      ticking = true;
      window.requestAnimationFrame(updateParallax);
    };

    updateParallax();
    window.addEventListener("scroll", requestTick, { passive: true });
    window.addEventListener("resize", requestTick);
  }

  const heroForm = document.getElementById("hero-form");
  const heroStart = document.getElementById("hero-start");
  const heroEnd = document.getElementById("hero-end");
  const heroStartSuggestions = document.getElementById("hero-start-suggestions");
  const heroEndSuggestions = document.getElementById("hero-end-suggestions");

  if (heroForm && heroStart && heroEnd && heroStartSuggestions && heroEndSuggestions) {
    const idfViewbox = "1.4460,49.2500,3.5600,48.1200";
    const nominatimUrl = "https://nominatim.openstreetmap.org/search";

    const debounce = (fn, wait) => {
      let t;
      return (...args) => {
        clearTimeout(t);
        t = setTimeout(() => fn(...args), wait);
      };
    };

    const clearSuggestions = (listEl) => {
      listEl.innerHTML = "";
      listEl.style.display = "none";
    };

    const formatAddress = (item) => {
      if (!item || !item.address) {
        return item && item.display_name ? item.display_name : "";
      }
      const a = item.address;
      const street = [a.house_number, a.road].filter(Boolean).join(" ");
      const city =
        a.city || a.town || a.village || a.municipality || a.suburb || a.county;
      const postcode = a.postcode;
      const parts = [];
      if (street) parts.push(street);
      if (postcode || city) parts.push([postcode, city].filter(Boolean).join(" "));
      if (a.country) parts.push(a.country);
      return parts.length ? parts.join(", ") : item.display_name || "";
    };

    const precisionScore = (item) => {
      const a = item && item.address ? item.address : {};
      if (a.house_number || item.type === "house" || item.type === "building") return 0;
      if (a.road || item.type === "residential" || item.type === "road") return 1;
      if (a.neighbourhood || a.suburb || a.city_district) return 2;
      if (a.city || a.town || a.village || a.municipality) return 3;
      return 4;
    };

    const orderSuggestions = (items) =>
      items
        .slice()
        .sort((a, b) => {
          const scoreA = precisionScore(a);
          const scoreB = precisionScore(b);
          if (scoreA !== scoreB) return scoreA - scoreB;
          const impA = typeof a.importance === "number" ? a.importance : 0;
          const impB = typeof b.importance === "number" ? b.importance : 0;
          return impB - impA;
        })
        .slice(0, 8);

    const showSuggestions = (listEl, items, onSelect) => {
      listEl.innerHTML = "";
      items.forEach((item) => {
        const btn = document.createElement("button");
        btn.type = "button";
        btn.textContent = formatAddress(item);
        btn.addEventListener("click", () => {
          onSelect(item);
          clearSuggestions(listEl);
        });
        listEl.appendChild(btn);
      });
      listEl.style.display = items.length ? "block" : "none";
    };

    const fetchSuggestions = (query, listEl, onSelect) => {
      if (!query || query.length < 3) {
        clearSuggestions(listEl);
        return;
      }
      const url =
        nominatimUrl +
        `?format=jsonv2&addressdetails=1&limit=8&bounded=1&viewbox=${idfViewbox}` +
        `&countrycodes=fr&accept-language=fr&dedupe=1&q=${encodeURIComponent(query)}`;
      fetch(url, { headers: { Accept: "application/json" } })
        .then((res) => res.json())
        .then((data) => {
          const items = Array.isArray(data) ? orderSuggestions(data) : [];
          showSuggestions(listEl, items, onSelect);
        })
        .catch(() => clearSuggestions(listEl));
    };

    const onHeroStart = debounce((e) => {
      fetchSuggestions(e.target.value, heroStartSuggestions, (item) => {
        heroStart.value = formatAddress(item);
      });
    }, 300);

    const onHeroEnd = debounce((e) => {
      fetchSuggestions(e.target.value, heroEndSuggestions, (item) => {
        heroEnd.value = formatAddress(item);
      });
    }, 300);

    heroStart.addEventListener("input", onHeroStart);
    heroEnd.addEventListener("input", onHeroEnd);

    document.addEventListener("click", (event) => {
      if (!heroStartSuggestions.contains(event.target) && event.target !== heroStart) {
        clearSuggestions(heroStartSuggestions);
      }
      if (!heroEndSuggestions.contains(event.target) && event.target !== heroEnd) {
        clearSuggestions(heroEndSuggestions);
      }
    });

    heroForm.addEventListener("submit", (event) => {
      event.preventDefault();
      const start = heroStart.value.trim();
      const end = heroEnd.value.trim();
      const baseUrl = heroForm.getAttribute("action") || "/trajet-en-ville/";
      const params = new URLSearchParams();
      params.set("reservation", "1");
      if (start) params.set("start", start);
      if (end) params.set("end", end);
      window.location.href = `${baseUrl}?${params.toString()}#reservation-map`;
    });
  }

  const accordionToggles = Array.from(
    document.querySelectorAll("[data-aero-accordion-toggle]")
  );
  const accordionPanels = Array.from(
    document.querySelectorAll("[data-aero-accordion-panel]")
  );

  if (accordionToggles.length && accordionPanels.length) {
    const closePanel = (name) => {
      const panel = accordionPanels.find(
        (item) => item.getAttribute("data-aero-accordion-panel") === name
      );
      const toggle = accordionToggles.find(
        (item) => item.getAttribute("data-aero-accordion-toggle") === name
      );
      if (!panel || !toggle) return;
      panel.hidden = true;
      toggle.classList.remove("is-open");
      toggle.setAttribute("aria-expanded", "false");
    };

    const openPanel = (name) => {
      accordionPanels.forEach((item) => {
        const panelName = item.getAttribute("data-aero-accordion-panel");
        if (panelName !== name) closePanel(panelName);
      });
      const panel = accordionPanels.find(
        (item) => item.getAttribute("data-aero-accordion-panel") === name
      );
      const toggle = accordionToggles.find(
        (item) => item.getAttribute("data-aero-accordion-toggle") === name
      );
      if (!panel || !toggle) return;
      panel.hidden = false;
      toggle.classList.add("is-open");
      toggle.setAttribute("aria-expanded", "true");
    };

    accordionToggles.forEach((toggle) => {
      toggle.setAttribute("aria-expanded", "false");
      toggle.addEventListener("click", (event) => {
        event.preventDefault();
        const name = toggle.getAttribute("data-aero-accordion-toggle");
        if (!name) return;
        const panel = accordionPanels.find(
          (item) => item.getAttribute("data-aero-accordion-panel") === name
        );
        if (!panel) return;
        if (panel.hidden) {
          openPanel(name);
        } else {
          closePanel(name);
        }
      });
    });
  }
});
