
(function($) {
    "use strict"; 
	
	/* Preloader */
	$(window).on('load', function() {
		var preloaderFadeOutTime = 500;
		function hidePreloader() {
			var preloader = $('.spinner-wrapper');
			setTimeout(function() {
				preloader.fadeOut(preloaderFadeOutTime);
			}, 500);
		}
		hidePreloader();
	});
	

    // jQuery to collapse the navbar on scroll
    $(window).on('scroll load', function() {
        if ($(".navbar").length > 0) {
            if ($(".navbar").offset().top > 60) {
                $(".fixed-top").addClass("top-nav-collapse");
            } else {
                $(".fixed-top").removeClass("top-nav-collapse");
            }
        }
    });


    // closes the responsive menu on menu item click
    $(".navbar-nav li a").on("click", function(event) {
    if (!$(this).parent().hasClass('dropdown'))
        $(".navbar-collapse").collapse('hide');
    });


    /* Image Slider - Swiper */
    var imageSlider = new Swiper('.image-slider', {
        autoplay: {
            delay: 2000,
            disableOnInteraction: false
		},
        loop: true,
        spaceBetween: 30,
        slidesPerView: 5,
		breakpoints: {
            // when window is <= 580px
            580: {
                slidesPerView: 1,
                spaceBetween: 10
            },
            // when window is <= 768px
            768: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            // when window is <= 992px
            992: {
                slidesPerView: 3,
                spaceBetween: 20
            },
            // when window is <= 1200px
            1200: {
                slidesPerView: 4,
                spaceBetween: 20
            },

        }
    });


    /* Text Slider - Swiper */
	var textSlider = new Swiper('.text-slider', {
        autoplay: {
            delay: 6000,
            disableOnInteraction: false
		},
        loop: true,
        navigation: {
			nextEl: '.swiper-button-next',
			prevEl: '.swiper-button-prev'
		}
    });

    
    /* Move Form Fields Label When User Types */
    // for input and textarea fields
    $("input, textarea").keyup(function(){
		if ($(this).val() != '') {
			$(this).addClass('notEmpty');
		} else {
			$(this).removeClass('notEmpty');
		}
    });

})(jQuery);