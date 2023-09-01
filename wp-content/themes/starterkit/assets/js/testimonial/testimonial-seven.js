import Swiper from 'swiper/bundle';
// init Swiper for testimonial seven :
const swiperSeven = new Swiper('.testimonial-seven', {
  direction:"horizontal",
  loop:true,
  spaceBetween: 40,
  centeredSlides: false,
  autoHeight:true,
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
