(function ($) {
  "use strict";

  let scroller = $("#scUPscroller");
  let scrollSpeed = scup_vars.scrollSpeed;

  $(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
      scroller.fadeIn();
    } else {
      scroller.fadeOut();
    }
  });

  scroller.click(function () {

    $("html, body").animate({ scrollTop: 0 }, scrollSpeed);
    return false;
  });
})(jQuery);
