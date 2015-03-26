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
//<script>
elgg.provide('clipit.admin');

clipit.admin.init = function() {
    $(document).on("click", ".submit-add-teachers", clipit.admin.addTeachers);
    $(document).on("click", ".submit-create-teachers", clipit.admin.createTeachers);
    $("#get-users").click(clipit.admin.getUsers);
};
elgg.register_hook_handler('init', 'system', clipit.admin.init);

clipit.admin.addTeachers = function(){
    var form = $(this).closest("form");
    form.append($("<input/>",{"type": "hidden", "name": "act"}).val("to_activity"));
    $(this).button('loading').data("loading-text", elgg.echo('loading')+ "...").button('loading');
    elgg.action('activity/admin/users', {
        data: form.serialize(),
        success: function(){
            location.reload();
        }
    });
};
clipit.admin.createTeachers = function() {
    var form = $(this).closest("form");
    $(this).button('loading').data("loading-text", elgg.echo('loading')+ "...").button('loading');
    elgg.action('activity/admin/users', {
        data: form.serialize(),
        success: function(){
            location.reload();
        }
    });
};
clipit.admin.getUsers = function(){
    var data_role = $(this).data("role"),
        data_activity = $(this).data("activity"),
        container = $("#shite ul") || $("#site select");
    switch(data_role){
        case "student":
            var container = $("#site ul");
            break;
        case "teacher":
            var container = $("#site select");
            break;
    }
    container.html($("<i class='fa fa-spinner fa-spin blue'/>"));
    elgg.action('activity/admin/users', {
        data: {act: "get_users", role: data_role, activity_id: data_activity},
        success: function(data){
            container.html("");
            $.each(data.output, function(i, user) {
                switch(data_role){
                    case "student":
                        var content = $("<li/>",{
                            "data-user": user.id,
                            "style": "padding: 2px;",
                            "class": "cursor-pointer list-item-5 searchable",
                        })
                            .html(user.avatar + " " + user.name);
                        break;
                    case "teacher":
                        var content = $("<option/>",{
                            "value": user.id,
                            "class": "searchable"
                        })
                            .text(user.name);
                        break;
                }
                container.append(content);
            });

            $('input#search-users').quicksearch(container.find(".searchable"));
        }
    });
};