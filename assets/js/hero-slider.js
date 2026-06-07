'use strict';

document.addEventListener('DOMContentLoaded', function () {
  var heroSliderEl = document.querySelector('[data-hero-slider]');
  if (!heroSliderEl) return;

  var slideCount = heroSliderEl.querySelectorAll('.swiper-slide').length;
  var hasMultipleSlides = slideCount > 1;

  var swiper = new Swiper(heroSliderEl, {
    loop: hasMultipleSlides,
    autoplay: hasMultipleSlides ? {
      delay: 6000,
      pauseOnMouseEnter: true,
    } : false,
    grabCursor: hasMultipleSlides,
    pagination: hasMultipleSlides ? {
      el: '.swiper-pagination',
      clickable: true,
    } : false,
    navigation: hasMultipleSlides ? {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    } : false,
  });

  if (hasMultipleSlides) {
    document.addEventListener('visibilitychange', function () {
      if (document.hidden) {
        swiper.autoplay.stop();
      } else {
        swiper.autoplay.start();
      }
    });
  }
});
