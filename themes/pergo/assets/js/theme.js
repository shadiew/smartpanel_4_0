function Langding_page(){
    var self= this;
    this.init= function(){
    };

    $('body').scrollspy({
        target: '#headerNav',
        offset: 54
    });

      // Collapse Navbar
    var navbarCollapse = function() {
        if ($("#headerNav").offset().top > 100) {
          $("#headerNav").addClass("shrink");
          $("#headerNav .site-logo").removeClass("d-none");
          $("#headerNav .site-logo-white").addClass("d-none");
        } else {
          $("#headerNav").removeClass("shrink");
          $("#headerNav .site-logo").addClass("d-none");
          $("#headerNav .site-logo-white").removeClass("d-none");
        }
    };
    // Collapse now if page is not at top
    navbarCollapse();
    // Collapse the navbar when page is scrolled
    $(window).scroll(navbarCollapse);

    $(document).on("click", ".js-scroll-trigger", function(){
        _that = $(this);
        $(this).parent().addClass('active');
        $(this).parent().siblings().removeClass('active');
        _div = _that.attr('href');
        $('html, body').animate({
            scrollTop: $(_div).offset().top
        }, 1000);
    });
}
Langding_page= new Langding_page();
$(function(){
    Langding_page.init();
});