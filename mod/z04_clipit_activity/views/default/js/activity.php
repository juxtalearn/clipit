<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/07/14
 * Last update:     23/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
?>

<?php
// Tasks (admin, student)
echo elgg_view('js/tasks');
// Activity admin
echo elgg_view('js/admin');
// Quiz (admin, student)
echo elgg_view('js/quiz');
// Discussion
echo elgg_view('js/discussion');
?>
$(function(){
});
//<script>
elgg.provide('clipit.activity');

clipit.activity.init = function() {
    $(document).on("click", ".option-select", clipit.activity.addUserToggleOptions);
    $(document).on("click", "#add_user", clipit.activity.addFormUser);
};
elgg.register_hook_handler('init', 'system', clipit.activity.init);

clipit.activity.addUserToggleOptions = function() {
    var view = $(this).data("toggle");
    $(".option-content").hide();
    $("#"+ view).show();
};
clipit.activity.addFormUser = function() {
    var content = $(".add-user-list");
    elgg.get( "ajax/view/user/add", function( data ) {
        content.append(data).find(".focus-in").focus();
    });
};

function selected_count(){
    var count_selected = $("#called_users option:selected").length;
    $(".ms-selection h4").find("span").text(count_selected);
    var count_selectable = $("#called_users option:not(:selected)").length;
    $(".ms-selectable h4").find("span").text(count_selectable);
}