<?php
/**
 * Provide code for the Learning Analytics Dashboard
 */
?>
//<script type="javascript">
    elgg.provide('clipit.la.widgets');


    clipit.la.widgets.init = function () {
        $(document).on('click', 'a.elgg-widget-resize-button', clipit.la.widgets.resizeButton);
//    $('form').data('validate',true);
    };

    clipit.la.widgets.resizeButton = function (event) {
        var parts = event.target.href.split("-");
        var widget_id = parts[parts.length - 1];
        var srcString = "";
        if ($("#elgg-widget-content-" + widget_id + " iframe")[0]) {
            srcString = $("#elgg-widget-content-" + widget_id + " iframe")[0].src;

            var title = $("#elgg-widget-content-" + widget_id + " h5[role|=title]").text();
            $.fancybox({
                'titleFormat': function (title, currentArray, currentIndex, currentOpts) {
                    return "<h4>" + title + "</h4>"
                },
                'title': title,
                'titlePosition': 'over',
                'content': srcString,
                'type': 'iframe',
                'width': '100%',
                'height': '95%',
                'onComplete': function () {
                    $("#fancybox-title").css({
                        'top': '0px',
                        'text-align': 'center',
                        'bottom': 'auto'
                    });
                }
            });
            $('#fancybox-wrap, #fancybox-content').css({
                '-moz-box-sizing': 'content-box',
                '-webkit-box-sizing': 'content-box',
                '-safari-box-sizing': 'content-box',
                'box-sizing': 'content-box'
            });
            $('#fancybox-content').css({
                '-moz-box-sizing': 'content-box',
                '-webkit-box-sizing': 'content-box',
                '-safari-box-sizing': 'content-box',
                'box-sizing': 'content-box',
                'padding-top': '45px'
            });
        }
    };

    elgg.register_hook_handler('init', 'system', clipit.la.widgets.init);

    //</script>