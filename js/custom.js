"use strict";

/* global refru */

/**
 * Theme functions file.
 *
 * Contains handlers for navigation and widget area.
 */
(function ($) {
  var masthead, menuToggle, siteNavContain, siteNavigation;

  function initMainNavigation(container) {
    // Add dropdown toggle that displays child menu items.
    var dropdownToggle = $('<button />', {
      'class': 'dropdown-toggle',
      'aria-expanded': false
    }).append('<i class="fa-angle-down icon fa"></i>').append($('<span />', {
      'class': 'screen-reader-text',
      text: refru.expand
    }));
    container.find('.menu-item-has-children > a, .page_item_has_children > a').after(dropdownToggle); // Set the active submenu dropdown toggle button initial state.

    container.find('.current-menu-ancestor > button') //.addClass( 'toggled-on' )
    .attr('aria-expanded', 'true').find('.screen-reader-text').text(refru.collapse); // Set the active submenu initial state.
    //container.find( '.current-menu-ancestor > .sub-menu' ).addClass( 'toggled-on' );

    container.find('.dropdown-toggle').click(function (e) {
      var _this = $(this),
          screenReaderSpan = _this.find('.screen-reader-text');

      e.preventDefault();

      _this.toggleClass('toggled-on');

      _this.next('.children, .sub-menu').toggleClass('toggled-on');

      _this.attr('aria-expanded', _this.attr('aria-expanded') === 'false' ? 'true' : 'false');

      screenReaderSpan.text(screenReaderSpan.text() === refru.expand ? refru.collapse : refru.expand);
    });
  }

  initMainNavigation($('.main-navigation'));
  masthead = $('#header');
  menuToggle = masthead.find('.menu-toggle');
  siteNavContain = masthead.find('.main-navigation');
  siteNavigation = masthead.find('.main-navigation > div > ul'); // Enable menuToggle.

  (function () {
    // Return early if menuToggle is missing.
    if (!menuToggle.length) {
      return;
    } // Add an initial value for the attribute.


    menuToggle.attr('aria-expanded', 'false');
    menuToggle.on('click.refru', function () {
      siteNavContain.toggleClass('toggled-on');
      $(this).attr('aria-expanded', siteNavContain.hasClass('toggled-on'));
    });
  })(); // Fix sub-menus for touch devices and better focus for hidden submenu items for accessibility.


  (function () {
    if (!siteNavigation.length || !siteNavigation.children().length) {
      return;
    } // Toggle `focus` class to allow submenu access on tablets.


    function toggleFocusClassTouchScreen() {
      if ('none' === $('.menu-toggle').css('display')) {
        $(document.body).on('touchstart.refru', function (e) {
          if (!$(e.target).closest('.main-navigation li').length) {
            $('.main-navigation li').removeClass('focus');
          }
        });
        siteNavigation.find('.menu-item-has-children > a, .page_item_has_children > a').on('touchstart.refru', function (e) {
          var el = $(this).parent('li');

          if (!el.hasClass('focus')) {
            e.preventDefault();
            el.toggleClass('focus');
            el.siblings('.focus').removeClass('focus');
          }
        });
      } else {
        siteNavigation.find('.menu-item-has-children > a, .page_item_has_children > a').unbind('touchstart.refru');
      }
    }

    if ('ontouchstart' in window) {
      $(window).on('resize.refru', toggleFocusClassTouchScreen);
      toggleFocusClassTouchScreen();
    }

    siteNavigation.find('a').on('focus.refru blur.refru', function () {
      $(this).parents('.menu-item, .page_item').toggleClass('focus');
    });
  })();
})(jQuery);
"use strict";

jQuery(document).ready(function ($) {
  // Mega Menu offscreen
  $(".main-navigation li").on("mouseenter mouseleave", function (e) {
    if (767 < $(document).width()) {
      if ($("ul", this).length) {
        var elm = $("ul:first", this);
        var off = elm.offset();
        var l = off.left;
        var w = elm.width();
        var docH = $("#header").height();
        var docW = $("#header").width();
        var isEntirelyVisible = l + w <= docW;

        if (!isEntirelyVisible) {
          $(this).addClass("edge");
        } else {
          $(this).removeClass("edge");
        }
      }
    }
  });
  /*
  Menu animation
  =========================================================
  */

  $(".main-navigation .menu > li.menu-item-has-children").hover(function () {
    if (576 < $(window).width()) {
      $(this).children(".sub-menu").addClass("animated refruFadeInUp").removeClass("fadeOut");
    }
  }, function () {
    if (576 < $(window).width()) {
      $(this).children(".sub-menu").addClass("fadeOut").removeClass("refruFadeInUp");
    }
  }); //Animation to section on Main Menu

  $("body").on("click", '#primary-menu > li > a[href^="#"], #secondary-menu > ul > li > a[href^="#"]', function (event) {
    event.preventDefault();
    $("html, body").animate({
      scrollTop: $($(this).attr("href")).offset().top
    }, 1000);
  });
  setTimeout(function () {
    $("body").removeClass("pace-running");
    $("body").addClass("pace-done");
  }, 4000); // Re layout flickity after lazyload images

  $(document).on("lazyloaded", function (e) {
    if ($(".woocommerce-product-gallery").length) {
      // Resize WooCommerce Single Product Slider
      $(".woocommerce-product-gallery").data("flexslider").resize();
    }
  }); // Jetpack Lazy load

  $(".woocommerce-product-gallery img").on("jetpack-lazy-loaded-image", function (e) {
    if ($(".woocommerce-product-gallery").length) {
      // Resize WooCommerce Single Product Slider
      $(".woocommerce-product-gallery").data("flexslider").resize();
      setTimeout(function () {
        $(".woocommerce-product-gallery").data("flexslider").resize();
      }, 200);
    }
  });
  /*
  WooCommerce Cart Widget Button
  =========================================================
  */

  $("body").on("click", "#header .refru-cart-btn", function (event) {
    event.preventDefault();
    /* Act on the event */

    window.location.href = $(this).attr("href");
  }); //Add to cart button on variable products

  $("body").on("click", ".products .product .product_text .add_to_cart_button.product_type_variable", function (event) {
    event.preventDefault();
    /* Act on the event */

    window.location.href = $(this).attr("href");
  });
  $(".dropdown-toggle").dropdown();
  $('*[data-toggle="tooltip"]').tooltip();
});