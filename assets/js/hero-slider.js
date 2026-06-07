'use strict';

document.addEventListener('DOMContentLoaded', function () {
  var heroSliderEl = document.querySelector('[data-hero-slider]');
  if (!heroSliderEl) return;

  var swiper = new Swiper(heroSliderEl, {
    loop: true,
    autoplay: {
      delay: 6000,
      pauseOnMouseEnter: true,
    },
    grabCursor: true,
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
  });

  document.addEventListener('visibilitychange', function () {
    if (document.hidden) {
      swiper.autoplay.stop();
    } else {
      swiper.autoplay.start();
    }
  });
});
