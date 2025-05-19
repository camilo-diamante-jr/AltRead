function loadNavbar() {
  return new Promise((resolve) => {
    $("#app-header").load("/navbar", () => {
      // Navbar burger toggle
      document.querySelectorAll(".navbar-burger").forEach((el) => {
        el.addEventListener("click", () => {
          const targetId = el.dataset.target;
          const targetEl = document.getElementById(targetId);

          if (targetEl) {
            el.classList.toggle("is-active");
            targetEl.classList.toggle("is-active");
          }
        });
      });

      // Smooth scrolling
      document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
          const targetId = this.getAttribute("href");
          if (targetId && targetId.length > 1) {
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
              e.preventDefault();
              targetElement.scrollIntoView({
                behavior: "smooth",
                block: "start",
              });
            }
          }
        });
      });

      resolve();
    });
  });
}

function loadComponent(targetSelector, filePath) {
  return new Promise((resolve) => {
    $(targetSelector).load(filePath, () => resolve());
  });
}

async function loadApp() {
  try {
    await loadNavbar();
    await loadComponent("#home", "/hero");
    await loadComponent("#features", "/features");
    await loadComponent("#how-it-works", "/how-it-works");
    await loadComponent("#about", "/about");
    await loadComponent("#contact", "/contact");

    // Delay and then hide loader
    setTimeout(() => {
      $(".loader-container").fadeOut(800, function () {
        $("#app-wrapper").fadeIn(800, function () {
          if (typeof AOS !== "undefined") {
            AOS.init({ once: true });
          }
        });
      });
    }, 500); // optional delay
  } catch (err) {
    console.error("Error loading app:", err);
    $(".loader-container").fadeOut(); // fail-safe
  }
}

$(window).on("load", function () {
  loadApp();
});
