(function ($) {
  Drupal.behaviors.mainJs = {
    attach: function (context, settings) {
      $(window, context).once('mainJs').each(function () {
        /*-------------------------
         main-menu active
         --------------------------*/
        $('.main-menu nav').meanmenu({
          meanScreenWidth: "991",
          meanMenuContainer: '.mobile-menu'
        });

        /* isotop active */

        $('.grid').imagesLoaded( function() {

          // init Isotope
          var $grid = $('.grid').isotope({
            itemSelector: '.grid-item',
            percentPosition: true,
            masonry: {
              // use outer width of grid-sizer for columnWidth
              columnWidth: '.grid-item',
            }
          });
        });

        /*-------------------------
         product thumb img slider
         --------------------------*/
        var owl = $('.pro-thumb-img-slider');
        owl.owlCarousel({
          singleItem: true,
          items:1,
          loop:true,
          margin:10,
          nav: true,
          autoplay:true,
          autoplayTimeout:15000,
          autoplayHoverPause:true,
          navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        });
        $('.play').on('click',function(){
          owl.trigger('autoplay.play.owl',[1000])
        })
        $('.stop').on('click',function(){
          owl.trigger('autoplay.stop.owl')
        })

        // Remove item from card.
        $('a.remove-item').on('click', function (event) {
          $parent = $(this).parent();
          $parent.children(':first-child').children().click();
        });

        // On checkout click
        $('.cart-total a.checkout').on('click', function (event) {
          console.log('test');
          $('#edit-checkout').click();
        });

        // Append card summary.
        if ($('.cart-summary') !== undefined) {
          $('.cart-main-area .container-fluid').append($('.cart-summary'));
          $('.cart-main-area .container-fluid .coupon2').append($('#edit-submit'));
          $('#edit-checkout').addClass('hidden');
        }
      });
    }
  };
}(jQuery));
