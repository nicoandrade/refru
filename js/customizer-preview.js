/**
 * customizer.js
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function($) {
    // Site title and description.
    wp.customize("blogname", function(value) {
        value.bind(function(to) {
            $(".site-title a").text(to);
        });
    });
    wp.customize("blogdescription", function(value) {
        value.bind(function(to) {
            $(".site-description").text(to);
        });
    });
    /*
    Site
    =====================================================
    */
    //Background Color
    wp.customize("refru_site_background_color", function(value) {
        value.bind(function(to) {
            $("body").css({
                "background-color": to
            });
        });
    });
})(jQuery);

function hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result
        ? {
              r: parseInt(result[1], 16),
              g: parseInt(result[2], 16),
              b: parseInt(result[3], 16)
          }
        : null;
}
