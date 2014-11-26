var icons_appear = function() {
    $("[data-icon=1] .bar").animate({
        width: "50%"
    }, 1500, function () {
        $("[data-icon=2] .bar-left").animate({
            width: "50%"
        }, 1000, function () {
            $("[data-icon=2] .bar-right").animate({
                width: "50%"
            }, 1000, function () {
                $("[data-icon=3] .bar").animate({
                    width: "50%"
                }, 1000);
            });
        });
    });
}
$(function(){
    $("#animated_banner").attr("src", elgg.config.wwwroot+"mod/z03_clipit_global/graphics/landing/graphic.gif?" + Math.random());
    jQuery('.animate').appear();
    jQuery(document.body).on('appear', '.animate', function(e, $affected) {
        var fadeDelayAttr;
        var fadeDelay;
        jQuery(this).each(function(){
            if (jQuery(this).data("delay")) {
                fadeDelayAttr = jQuery(this).data("delay")
                fadeDelay = fadeDelayAttr;
            } else {
                fadeDelay = 0;
            }
            jQuery(this).delay(fadeDelay).queue(function(){
                jQuery(this).addClass('animated bounceIn').clearQueue();
                icons_appear();
            });
        })
    });
    $(document).on("click", "[data-video]",function(){
        var video_link = $(this).data("video");
        if (video_link.indexOf('youtube.com') != -1 || video_link.indexOf('youtube.be')) {
            var pattern = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=|\?v=)([^#\&\?]*).*/;
            var video_id = video_link.match(pattern);
            var iframe_src = 'https://youtube.com/embed/'+video_id[2]+'?autoplay=1';
        }
        $("[data-video]").removeClass("active");
        $(this).addClass("active");
        $("#show-video")
            .html($('<iframe/>', {
                'src': iframe_src,
                'style': 'width:100%;height: 100%;',
                'frameborder': 0,
                'allowfullscreen': true
            })).show();
        $("#show-video").closest(".main-video").find(".preview-video").hide();
        $(".cancel-video-view").fadeIn();
    });
    $(document).on("click", ".cancel-video-view",function(){
        $(this).hide();
        $("[data-video]").removeClass("active");
        $("#show-video").html("").hide();
        $(".preview-video").fadeIn();
    });
});

