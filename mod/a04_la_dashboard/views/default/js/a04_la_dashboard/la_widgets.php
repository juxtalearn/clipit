<?php
/**
 * Provide code for the Learning Analytics Dashboard
 */
?>
//<script type="javascript">
elgg.provide('clipit.la.widgets');


clipit.la.widgets.init = function() {
    $(document).on('click','a.elgg-widget-resize-button',clipit.la.widgets.resizeButton);
};

clipit.la.widgets.resizeButton = function(event){
        var parts = event.target.href.split("-");
        var widget_id = parts[parts.length-1];
        var srcString = $("#elgg-widget-content-"+widget_id+" iframe")[0].src;
        $.fancybox({'content':srcString, 'type':'iframe', 'width':'100%','height':'100%'});
    };

elgg.register_hook_handler('init', 'system', clipit.la.widgets.init);

//</script>