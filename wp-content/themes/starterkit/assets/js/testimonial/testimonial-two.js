import Swiper from 'swiper/bundle';
// init Swiper for testimonial two :
const swipertwo = new Swiper(' .testimonial-single-two', {
  direction:"horizontal",
  loop:false,
  spaceBetween: 40,
  centeredSlides: true,
  // If we need navigation
  navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
  },
  // If we need pagination
  pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
});