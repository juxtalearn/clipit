<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   09/03/2015
 * Last update:     09/03/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
//<script>
elgg.provide('clipit.message');

clipit.message.init = function() {
    $("input#compose").send_msg();
    $('.inbox-summary').click(clipit.message.inboxSummary);
};
elgg.register_hook_handler('init', 'system', clipit.message.init);

clipit.message.inboxSummary = function(){
    var menu = $(this).parent('li'),
        content = menu.find('#menu_messages');
    if(menu.find('.loading').length > 0) {
        elgg.get('ajax/view/messages/inbox_summary', {
            success: function (data) {
                content.html(data);
            }
        });
    }
};
/**
 * jQuery send_msg function
 * Autocomplete user info
 * @param user    set default username value
 *
 */
$.fn.extend({
    send_msg: function(username_data){
        if(!username_data){
            username_data = [];
        }
        $(this).tokenInput(elgg.config.wwwroot+"ajax/view/messages/search_to",
            {
                hintText: elgg.echo("autocomplete:hint"),
                noResultsText: elgg.echo("autocomplete:noresults"),
                searchingText: elgg.echo("autocomplete:searching"),
                zindex: 1052,
                searchDelay: 0,
                allowTabOut: true,
                preventDuplicates: true,
                animateDropdown: false,
                propertyToSearch: "first_name",
                prePopulate: username_data,
                resultsFormatter: function(item){
                    var img = "<img class='img' src='" + item.avatar + "' title='" + item.first_name + "' height='25px' width='25px' />";
                    if(item.icon){
                        img = "<i class='img fa fa-"+ item.icon +"'></i>";
                    }
                    return "<li>" + img + "<div style='display: inline-block; padding-left: 10px;'><div class='title'>" + item.first_name + "</div><div class='sub-title'>" + item.username + "</div></div></li>" },
                tokenFormatter: function(item) { return "<li>" + item.first_name + "</li>" }
            }
        );
    }
});