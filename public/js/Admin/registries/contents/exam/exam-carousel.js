function loadCarouselsInitialization() {
  $("#moduleSelectionRow").owlCarousel({
    loop: false,
    margin: 10,
    nav: false,
    dots: true,
    responsive: {
      0: {
        items: 1,
      },
      600: {
        items: 2,
      },
      1000: {
        items: 3,
      },
    },
  });
}


$(document).ready(function () {
  loadCarouselsInitialization();
});

