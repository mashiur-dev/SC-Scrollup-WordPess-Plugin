(function () {
  ("use strict");

  // Get the scroll button element
  let scroller = document.getElementById("scUPscroller");
  // Get the defined scroll animation speed
  let scrollSpeed = scup_vars.scrollSpeed;

  /*************************
   * Show/Hide Scroller on Scroll
   *************************/
  window.addEventListener("scroll", () => {
    // Get the current vertical scroll position
    const scrollPosition = window.scrollY || document.documentElement.scrollTop;

    // Show scroller if scrolled past 100px, otherwise hide it
    if (scrollPosition > 100) {
      scroller.classList.add("active"); // Fade in
    } else {
      scroller.classList.remove("active"); // Fade out
    }
  });

  /**
   * Smooth Scroll-to-Top Function
   * Scrolls the window smoothly to the top using requestAnimationFrame.
   */
  function scrollToTop(duration) {
    const start = window.scrollY || document.documentElement.scrollTop;
    if (start === 0) return;

    const startTime = performance.now();

    function animateScroll(currentTime) {
      const elapsedTime = currentTime - startTime;
      const progress = Math.min(elapsedTime / duration, 1);

      // Easing function (easeOutQuad) for smooth deceleration
      const easeProgress =
        progress < 0.5
          ? 2 * progress * progress
          : 1 - Math.pow(-2 * progress + 2, 2) / 2;

      // Calculate new position
      const newScrollPos = start * (1 - easeProgress);

      window.scrollTo(0, newScrollPos);

      // Continue animation until duration ends
      if (elapsedTime < duration) {
        window.requestAnimationFrame(animateScroll);
      }
    }

    window.requestAnimationFrame(animateScroll);
  }

  /**
   * Button Click Handler
   */
  scroller.addEventListener("click", (e) => {
    e.preventDefault();
    // Start the scroll-to-top animation
    scrollToTop(scrollSpeed);
  });
})();