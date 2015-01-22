jQuery(document).ready(function ($) {

    $('.DMarker').on('click', function (event) {
        var label =    ("." + $(this).attr("class").split(' ')[2]);
        var index = $(label).index(this);
        index++;
        var target = $(label).get(index);
        if (typeof target == 'undefined') {
            target = label;
        }
        // you can adjust the number after top to the number you desire for positioning
        $('html, body').animate({
            scrollTop: $(target).offset().top -35
        }, 1000);
    });


});
