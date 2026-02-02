document.addEventListener("DOMContentLoaded", () => {
  const serviceToggle = document.querySelector(".tsf-nav__link--button");
  const serviceItem = document.querySelector(".tsf-nav__item--services");

  if (!serviceToggle || !serviceItem) {
    // Keep going; other page features can still initialize.
  }

  if (serviceToggle && serviceItem) {
    const dropdown = serviceItem.querySelector(".tsf-nav__dropdown");
    const setExpanded = (isOpen) => {
      serviceItem.classList.toggle("is-open", isOpen);
      serviceToggle.setAttribute("aria-expanded", isOpen ? "true" : "false");
    };

    serviceToggle.addEventListener("click", (event) => {
      event.preventDefault();
      setExpanded(!serviceItem.classList.contains("is-open"));
    });

    document.addEventListener("click", (event) => {
      if (!serviceItem.contains(event.target)) {
        setExpanded(false);
      }
    });

    if (dropdown) {
      dropdown.addEventListener("click", (event) => {
        if (event.target.tagName === "A") {
          setExpanded(false);
        }
      });
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
});
