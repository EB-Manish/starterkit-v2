import Swiper from 'swiper/bundle';
// init swiper for testimonial five
var swiperLogo = new Swiper(".mySwiper", {
  loop: true,
  spaceBetween: 30,
  slidesPerView: 1,
  watchOverflow: true,
  // allowTouchMove: false,
  breakpoints: {
    640: {
      slidesPerView: 3,
    },
    768: {
      slidesPerView: 4,
    },
    1024: {
      slidesPerView: 6,
    },
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: false,
  },
  autoplay: {
    delay: 2000,
    autoplayDisableOnInteraction: false,
    pauseOnMouseEnter: false,
  },

});

var swiperText = new Swiper(".mySwiper2", {
  loop: true,
  spaceBetween: 30,
  autoHeight: true,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  thumbs: {
    swiper: swiperLogo,
  },
  controller: {
    inverse: true,
  },
  autoplay: {
    delay: 2000,
    autoplayDisableOnInteraction: false,
    pauseOnMouseEnter: false,
  },

});

swiperLogo.on('click', function () {
  swiperLogo.autoplay.start();
  swiperText.autoplay.start();
});
swiperText.on('touchMove, slideChange, slideMove', function () {
  swiperLogo.autoplay.start();
  swiperText.autoplay.start();
});