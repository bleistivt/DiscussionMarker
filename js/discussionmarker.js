jQuery(function ($) {

    $('.DMarker').on('click', function () {
        var label = '.' + $(this).attr('class').split(' ')[2],
            target = $(label).get($(label).index(this) + 1) || label;
        $('html, body').animate({
            scrollTop: $(target).offset().top - 35
        }, 1000);
    });

});
