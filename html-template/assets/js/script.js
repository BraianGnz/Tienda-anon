'use strict';

// modal variables
const modal = document.querySelector('[data-modal]');
const modalCloseBtn = document.querySelector('[data-modal-close]');
const modalCloseOverlay = document.querySelector('[data-modal-overlay]');

// modal function
const modalCloseFunc = function () {
  if (modal) {
    modal.classList.add('closed');
  }
};

// modal eventListener
if (modalCloseOverlay) {
  modalCloseOverlay.addEventListener('click', modalCloseFunc);
}

if (modalCloseBtn) {
  modalCloseBtn.addEventListener('click', modalCloseFunc);
}

// notification toast variables
const notificationToast = document.querySelector('[data-toast]');
const toastCloseBtn = document.querySelector('[data-toast-close]');

// notification toast eventListener
if (toastCloseBtn && notificationToast) {
  toastCloseBtn.addEventListener('click', function () {
    notificationToast.classList.add('closed');
  });
}

// mobile menu variables
const mobileMenuOpenBtn = document.querySelectorAll('[data-mobile-menu-open-btn]');
const mobileMenu = document.querySelectorAll('[data-mobile-menu]');
const mobileMenuCloseBtn = document.querySelectorAll('[data-mobile-menu-close-btn]');
const overlay = document.querySelector('[data-overlay]');

for (let i = 0; i < mobileMenuOpenBtn.length; i++) {

  const mobileMenuCloseFunc = function () {
    if (mobileMenu[i]) {
      mobileMenu[i].classList.remove('active');
    }
    if (overlay) {
      overlay.classList.remove('active');
    }
  };

  mobileMenuOpenBtn[i].addEventListener('click', function () {
    if (mobileMenu[i]) {
      mobileMenu[i].classList.add('active');
    }
    if (overlay) {
      overlay.classList.add('active');
    }
  });

  if (mobileMenuCloseBtn[i]) {
    mobileMenuCloseBtn[i].addEventListener('click', mobileMenuCloseFunc);
  }

  if (overlay) {
    overlay.addEventListener('click', mobileMenuCloseFunc);
  }

}

// accordion variables
const accordionBtn = document.querySelectorAll('[data-accordion-btn]');
const accordion = document.querySelectorAll('[data-accordion]');

for (let i = 0; i < accordionBtn.length; i++) {

  accordionBtn[i].addEventListener('click', function () {

    const nextElement = this.nextElementSibling;

    if (!nextElement) return;

    const clickedBtn = nextElement.classList.contains('active');

    for (let j = 0; j < accordion.length; j++) {

      if (clickedBtn) break;

      if (accordion[j].classList.contains('active')) {

        accordion[j].classList.remove('active');

        if (accordionBtn[j]) {
          accordionBtn[j].classList.remove('active');
        }

      }

    }

    nextElement.classList.toggle('active');
    this.classList.toggle('active');

  });

}
