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
            "ajax/view/tricky_topics/tags/search",{
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
        container.append(<?php echo json_encode(elgg_view("tricky_topics/tags/add"));?>);
        container.find(".input-tag:last").focus().autocomplete(tags_autocomplete);
    });
    $(document).on("keypress", ".form-add-tags input[type=text]", function(e){
        if(e.keyCode == 13) {
            e.preventDefault();
            $(this).closest('form').find('#add-tag').click();
            return false;
        }
    });
    $(function(){
        $(document).on({
            mouseenter: function () {
                var container = $(this).closest(".reflection-item");
                container.find(".reflect-description").hide();
                container.find("[data-reflect_item="+$(this).attr("id")+"]").show();
            },
            mouseleave: function () {
                var container = $(this).closest(".reflection-item");
                container.find(".reflect-description").hide();
                container.find(".reflect-description:first").show();
            }
        }, ".reflection-item label");

        $(document).on("click", ".add-input", function(){
            var container = $(this).closest(".form-group").find(".group-input"),
                input_clone = container.find('.clone-input:last').clone();
            input_clone.find('input').val('');
            input_clone.find('.remove-input').show();

            if($(this).hasClass('collapse-type')){
                input_clone.find(".in").removeClass('in').addClass('collapse');
                $( input_clone.find('[data-toggle="collapse"]') ).each(function(){
                    var btn_collapse = $(this),
                        num = (btn_collapse.attr('href').replace('#collapse_', ''));
                    var container_collapse = input_clone.find('#collapse_'+ num);
                    container_collapse.attr('id', 'collapse_' + (num+1) );
                    btn_collapse.attr('href', '#collapse_' + (num+1) );
                });
                var num_panel = parseInt(input_clone.find('.panel-group').attr('id').replace('panel_', ''));
                input_clone.find('.panel-group').attr('id', 'panel_' + (num_panel+1) );
                input_clone.find('[data-toggle="collapse"]').attr('data-parent', '#panel_' + (num_panel+1) );
            }

            container.append(input_clone);
        });
        $(document).on("click", ".remove-input", function(){
            $(this).closest('.clone-input').remove();
        });
    });
    $(document).on("click", ".show-examples", function(){
        var tr = $(this).closest("tr")
        id = $(this).attr("id"),
            tr_example = $("[data-tag="+id+"]");
        if(tr_example.length > 0){
            tr_example.toggle();
            return false;
        }
        elgg.get('ajax/view/examples/summary',{
            data: {
                stumbling_block: id
            },
            success: function(content){
                var container = $("<tr/>")
                    .attr("data-tag", id)
                    .html( $('<td/>').attr("colspan", 4).html(content).css("padding", "10px") );
                tr.after(container);
            }
        });
    });
    $(".link-tricky-topic").click(function(){
        $(this).toggle();
        var content = <?php echo json_encode(elgg_view_form('stumbling_blocks/link', array('data-validate' => 'true')));?>,
            container = $(this).closest("td").find(".list-tricky-topic");
        container.toggle().html(content);
        container.find("form .input-entity-id").val($(this).attr("id"));
        container.find('form option').each(function(){
            var text=$(this).text()
            if (text.length > 30)
                $(this).val(text).text(text.substr(0,30)+'…')
        })
    });
});
