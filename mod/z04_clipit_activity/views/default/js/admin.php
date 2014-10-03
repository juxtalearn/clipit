<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   30/07/14
 * Last update:     30/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
$(document).on("click", ".submit-add-teachers", function(){
    var form = $(this).closest("form");
    $(this).button('loading').data("loading-text", "<?php echo elgg_echo('loading');?>...").button('loading');
    elgg.action('activity/admin/teachers', {
        data: form.serialize(),
        success: function(){
            location.reload();
        }
    });
});

$("#get-users").click(function(){
    var data_role = $(this).data("role"),
        data_activity = $(this).data("activity");
    $("#site ul").html($("<i class='fa fa-spinner fa-spin blue'/>"));
    elgg.action('activity/admin/users', {
        data: {act: "get_users", role: data_role, activity_id: data_activity},
        success: function(data){
            $("#site ul").html(data.output);
        }
    });
});