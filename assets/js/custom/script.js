jQuery(document).ready(function($) {
    // Mega Menu offscreen
    $(".main-navigation li").on("mouseenter mouseleave", function(e) {
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
    $(".main-navigation .menu > li.menu-item-has-children").hover(
        function() {
            if (576 < $(window).width()) {
                $(this)
                    .children(".sub-menu")
                    .addClass("animated refruFadeInUp")
                    .removeClass("fadeOut");
            }
        },
        function() {
            if (576 < $(window).width()) {
                $(this)
                    .children(".sub-menu")
                    .addClass("fadeOut")
                    .removeClass("refruFadeInUp");
            }
        }
    );

    //Animation to section on Main Menu
    $("body").on(
        "click",
        '#primary-menu > li > a[href^="#"], #secondary-menu > ul > li > a[href^="#"]',
        function(event) {
            event.preventDefault();
            $("html, body").animate(
                {
                    scrollTop: $($(this).attr("href")).offset().top
                },
                1000
            );
        }
    );

    setTimeout(function() {
        $("body").removeClass("pace-running");
        $("body").addClass("pace-done");
    }, 4000);

    // Re layout flickity after lazyload images
    $(document).on("lazyloaded", function(e) {
        if ($(".woocommerce-product-gallery").length) {
            // Resize WooCommerce Single Product Slider
            $(".woocommerce-product-gallery")
                .data("flexslider")
                .resize();
        }
    });
    // Jetpack Lazy load
    $(".woocommerce-product-gallery img").on(
        "jetpack-lazy-loaded-image",
        function(e) {
            if ($(".woocommerce-product-gallery").length) {
                // Resize WooCommerce Single Product Slider
                $(".woocommerce-product-gallery")
                    .data("flexslider")
                    .resize();
                setTimeout(function() {
                    $(".woocommerce-product-gallery")
                        .data("flexslider")
                        .resize();
                }, 200);
            }
        }
    );

    /*
	WooCommerce Cart Widget Button
	=========================================================
	*/
    $("body").on("click", "#header .refru-cart-btn", function(event) {
        event.preventDefault();
        /* Act on the event */
        window.location.href = $(this).attr("href");
    });

    //Add to cart button on variable products
    $("body").on(
        "click",
        ".products .product .product_text .add_to_cart_button.product_type_variable",
        function(event) {
            event.preventDefault();
            /* Act on the event */
            window.location.href = $(this).attr("href");
        }
    );

    $(".dropdown-toggle").dropdown();
    $('*[data-toggle="tooltip"]').tooltip();
});
