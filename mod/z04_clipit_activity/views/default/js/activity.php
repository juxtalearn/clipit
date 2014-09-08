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
            content
                .append(<?php echo json_encode(elgg_view('activity/create/add_user'));?>)
                .find("input[name='user-name[]']")
                .focus();
    });

    $(document).on("click", "#add_teacher",function(){
        var content = $(".add-user-list");
            content
                .append(<?php echo json_encode(elgg_view('activity/admin/add_teacher'));?>)
                .find("input[name='user-name[]']")
                .focus();
    });
});