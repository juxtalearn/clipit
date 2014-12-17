<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   03/12/2014
 * Last update:     03/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
$(function(){
var tags_autocomplete = {
    source: function (request, response) {
        elgg.getJSON(
            "ajax/view/tricky_topic/tags/search",{
                data: {q: request.term},
                success: function(data){
                    response(data);
                }
            }
        );
    },
    open: function () {
        $(this).data("ui-autocomplete").menu.element
                .addClass("tags-autocomplete")
                .css("display", "inline-block");
    },
    select: function( event, ui ) {
        event.preventDefault();
        this.value = ui.item.label;
    },
    focus: function(event, ui) {
        event.preventDefault();
        this.value = ui.item.label;
    },
    minLength: 2
};
$(".input-tag").autocomplete(tags_autocomplete);

$(document).on("click", "#add-tag", function(){
    var container = $(".form-add-tags");
    container.append(<?php echo json_encode(elgg_view("tricky_topic/add"));?>);
    container.find(".input-tag:last").focus().autocomplete(tags_autocomplete);
});
$(document).on("keypress", ".form-add-tags input[type=text]", function(e){
    if(e.keyCode == 13) {
        e.preventDefault();
        $("#add-tag").click();
        return false;
    }
});
});
