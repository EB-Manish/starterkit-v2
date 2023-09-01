
import Swiper from 'swiper/bundle';
  // init Swiper for testimonial one :
  const swiper = new Swiper('.testimonial-single-one', {
    direction:"horizontal",
    loop:true,
    spaceBetween: 40,
    centeredSlides: false,
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
