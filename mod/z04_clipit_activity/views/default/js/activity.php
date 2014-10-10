<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/07/14
 * Last update:     23/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
$(function(){
<?php
// Tasks js
echo elgg_view('js/tasks');
// Activity admin
echo elgg_view('js/admin');
?>
    $(document).on("click", ".option-select", function(){
        var view = $(this).data("toggle");
        $(".option-content").hide();
        $("#"+ view).show();
    });
    $(document).on("click", "#add_user",function(){
        var content = $(".add-user-list");
        elgg.get( "ajax/view/user/add", function( data ) {
            content.append(data).find(".focus-in").focus();
        });
    });
});
function selected_count(){
    var count_selected = $("#called_users option:selected").length;
    $(".ms-selection h4").find("span").text(count_selected);
    var count_selectable = $("#called_users option:not(:selected)").length;
    $(".ms-selectable h4").find("span").text(count_selectable);
}