<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   16/03/2015
 * Last update:     16/03/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
?>
//<script>
elgg.provide('clipit.discussion');
clipit.discussion.init = function() {
    // Discussion quote click
    $(document).on("click", ".quote-ref", clipit.discussion.getQuote);
    // Set quote reference to text editor
    $(".msg-quote").click(clipit.discussion.setQuote);
};
elgg.register_hook_handler('init', 'system', clipit.discussion.init);

/**
 * Get quote from reference id for discussion posts
 */
clipit.discussion.getQuote = function(){
    var quote_id = $(this).data("quote-ref");
    var parent = $(this).closest("div");
    var $obj = $(this);
    var quote_content = parent.find(".quote-content[data-quote-id="+quote_id+"]");

    if(quote_content.length == 0){
        $(this).addClass("active");
        $(this).after("<div class='quote-content' data-quote-id='"+quote_id+"'></div>");
        var quote_content = parent.find(".quote-content[data-quote-id="+quote_id+"]");
        quote_content.html("<a class='loading'><i class='fa fa-spinner fa-spin'></i> "+elgg.echo('loading')+"...</a>");
        var message_id = $(this).closest(".discussion-reply-msg").data("message-destination");
        elgg.get("ajax/view/discussion/quote", {
            data: { quote_id : quote_id, message_destination_id : message_id},
            success: function(data){
                quote_content.html(data);
            }
        });
    } else {
        parent.find(".quote-content[data-quote-id="+quote_id+"]").toggle(1,function(){
            $obj.toggleClass("active");
        });
    }
};
/*
 * Discussion comment reference
 */
clipit.discussion.setQuote = function() {
    var editor = tinyMCE.editors['mceEditor'];
    editor.execCommand('mceInsertContent', false, this.innerText + '&nbsp;');
    var form = editor.formElement;

    $('html, body').animate({
        scrollTop: $(form).offset().top
    }, 50);
};