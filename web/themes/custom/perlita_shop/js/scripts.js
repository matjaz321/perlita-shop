(function ($) {
  Drupal.behaviors.isotopeGrid = {
    attach: function (context, settings) {
      /* isotop active */

        // init Isotope
        var $grid = $('.grid').isotope({
          itemSelector: '.grid-item',
          percentPosition: true,
          masonry: {
            // use outer width of grid-sizer for columnWidth
            columnWidth: '.grid-item',
          }
        });

      /*-------------------------
       product thumb img slider
       --------------------------*/
      $('.pro-thumb-img-slider').owlCarousel({
        loop: true,
        animateOut: 'fadeOut',
        animateIn: 'fadeIn',
        items: 5,
        dots: false,
        margin: 25,
        nav: true,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        responsive: {
          0: {
            items: 3
          },
          600: {
            items: 3
          },
          1000: {
            items: 5
          }
        }
      })
    }
  };


}(jQuery));
