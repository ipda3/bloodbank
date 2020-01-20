$(document).ready(function () {
    $('#owl-articles').owlCarousel({
        loop: true,
        margin: 10,
        dots: false,
        responsiveClass: true,
        autoplay: true,
        autoplayTimeout: 2000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1,
                nav: true
            },
            600: {
                items: 2,
                nav: false
            },
            1000: {
                items: 3,
                nav: true,
                loop: false,
                margin: 20
            }
        }

    })
});
// loader
$(window).on("load", function () {

    $("body").css("overflow", "auto");
    $(".overlay").fadeOut(2000);

});





