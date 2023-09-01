import Swiper from 'swiper/bundle';

// adding swiper wrapper div and  class  in thumbnail items and  swiper wrapper
window.addEventListener("load",  function() { 
  var divclass = document.querySelector('.product')
  if(divclass){
    let thumbSwiper = document.querySelector(".flex-control-nav ");

    let org_html = thumbSwiper.innerHTML;
    let new_html = "<div class='swiper-wrapper'>" + org_html + "</div>";
    document.querySelector(".flex-control-nav").innerHTML = new_html;
    thumbSwiper.classList.add('swiper');
    let thumbSwiperItem=  document.querySelectorAll(".flex-control-nav li");
    for(let i = 0; i < thumbSwiperItem.length; i++){
      thumbSwiperItem[i].classList.add('swiper-slide');
    }
  // init swiper for for product slider 
    var swiperThumb = new Swiper(".flex-control-nav.swiper", {
      loop: true,
      slidesPerView: 4,
      spaceBetween:16,
      watchOverflow: true,
      allowTouchMove:true,
    });
  
    // adding swiper wrapper div and  class  in product slider 
  
    var largeImageSwiper = document.querySelector(".flex-viewport");
    var largeImgswiper = document.querySelector(".woocommerce-product-gallery__wrapper")
    largeImageSwiper.classList.add('swiper');
    largeImgswiper.classList.add('swiper-wrapper');
    let swiperItem=  document.querySelectorAll(".flex-viewport .woocommerce-product-gallery__image");
    for(let i = 0; i < thumbSwiperItem.length; i++){
      swiperItem[i].classList.add('swiper-slide');
    }
    var swiperImage = new Swiper(".flex-viewport.swiper", {
      loop: true,
      allowTouchMove:false,
      thumbs: {
        swiper: swiperThumb,
      },
    });
    swiperThumb.on('click', function () {
      swiperThumb.autoplay.start();
      // swiperImage.autoplay.start();
      for(let i = 0; i < thumbSwiperItem.length; i++){
        if (thumbSwiperItem[i].classList.contains("swiper-slide-thumb-active")) {
          // console.log(thumbSwiperItem[i].querySelectorAll('.swiper-slide img'));
          thumbSwiperItem[i].querySelector('.swiper-slide img').classList.add("flex-active");
        }
        else{
          thumbSwiperItem[i].querySelector('.swiper-slide img').classList.remove("flex-active");
        }
      }
      swiperImage.on('slideChange', function () {
        for(let i = 0; i < swiperItem.length; i++){
          if (swiperItem[i].classList.contains("swiper-slide-active")) {
            swiperItem[i].classList.add("flex-active-slide");
          }
          else{
            swiperItem[i].classList.remove("flex-active-slide");
          }
        }
        
      });
    });
  }
  
});
