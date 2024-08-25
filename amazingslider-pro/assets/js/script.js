var thumbs = new Swiper(".gallery-thumbs", {
    slidesPerView: "auto",
    speed: 900,
    spaceBetween: 10,
    centeredSlides: false,
    loopedSlides: 10,
    loop: true,
    slideToClickedSlide: true
});

slider.controller.control = thumbs;
thumbs.controller.control = slider;