$(window).on("load", function () {
  setTimeout(function () {
    $("#preloader").fadeOut(800, function () {
      $("#app-wrapper").fadeIn(800);
      AOS.init();
    });
  }, 1500);
});
