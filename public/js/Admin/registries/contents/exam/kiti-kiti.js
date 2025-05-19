$(".view-parts-per-lesson-button").on("click", function() {
 

  $('#partPerLesson').removeClass("d-none");
  $('#lessonPerModule').addClass('d-none');


  const lessonID = $(this).data("lesson-id");


});

// Ensure this event binding is outside the previous function
$('.back-to-lesson-btn').on("click", function() {
  $('#partPerLesson').addClass("d-none");
  $('#lessonPerModule').removeClass('d-none');
});