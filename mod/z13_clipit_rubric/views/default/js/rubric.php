<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   09/06/2015
 * Last update:     09/06/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
?>
//<script>
elgg.provide('clipit.rubric');

clipit.rubric.init = function() {
    $(document).on('click', '#add-rubric', clipit.rubric.add);
    $(document).on('click', '.remove-rubric', clipit.rubric.remove);
    $(document).on('click', '.add-rubric-item', clipit.rubric.add_item);
    $(document).on('click', '.remove-rubric-item', clipit.rubric.remove_item);
    $(document).on('click', '.rubric-select', clipit.rubric.select_item);
    $(document).on('click', '.rubric-unselect', clipit.rubric.unselect_item);
    // Click item for rating
    $(document).on('click', '.rubrics-rating .rubric-item', clipit.rubric.set_rating);
    $(document).on("click", ".show-items", clipit.rubric.show_items);
};
elgg.register_hook_handler('init', 'system', clipit.rubric.init);

clipit.rubric.add = function(){
    var $list = $('.rubrics'),
        element = $list.find('.rubric:last:visible'),
        clone = element.clone().hide(),
        count = $list.find('.rubric').length;
    clone.appendTo($list);
    clone.find('.rubric-id, .rubric-remove').remove();
    var pattern = Date.now();
    clone.find('input[type="text"], textarea').attr('name', function(i, val){
        return val.replace(/(rubric_)\w+/g, 'rubric_' + pattern);
    });
    clone.fadeIn('fast').find('textarea').val('');
    clone.find('textarea:first').focus();
    clipit.rubric.rating_calculate(clone.find('.rubric'));
};
clipit.rubric.remove = function(){
    var $list = $(this).closest('.rubric');
    if($list.parent().find('.rubric').length > 1) {
        if ($list.find('.rubric-id').length > 1) {
            $list.hide();
            $list.find('.rubric-remove').val('1');
        } else {
            var elements = $list.find('*:visible').hide(),
                buttons = $('#add-rubric, input[type=submit]');
            $list.find('*:visible').not('.undo-item').hide();
            buttons.prop('disabled', true).addClass('disabled');
            var timer = setTimeout(function(){
                $list.fadeOut('fast', function(){ $(this).hide(); });
                $list.find('.rubric-remove').val('1');
                buttons.prop('disabled', false).removeClass('disabled');
            }, 3000);
            $list.prepend(
                $('<a style="margin: 0 15px;display: none;" class="undo-item bg-info text-muted show" href="javascript:;"><strong class="blue"><i class="fa fa-undo"></i> Deshacer</strong> - Eliminado</a>')
                .click({'hiddenElements': elements, 'timer': timer, 'buttons': buttons}, clipit.rubric.undo
                ).fadeIn('fast'));
        }
    } else {
        elgg.register_error(elgg.echo('rubric:item:cantremove'));
    }
};
clipit.rubric.undo = function(event){
    clearTimeout(event.data.timer);
    event.data.buttons.prop('disabled', false).removeClass('disabled');
    event.data.hiddenElements.fadeIn('fast');
    // Remove undo link
    event.target.remove();
};
clipit.rubric.add_item = function(){
    var element = $(this).closest('.row.list-item').find('.rubric-item:last'),
        clone = element.clone().hide(),
        that = $(this);
    element.after(clone);
    clone.fadeIn('fast').find('textarea').val('').focus();
    $(this).closest('.row-horizon').animate({
        scrollLeft: that.offset().left
    }, 500);
    clipit.rubric.rating_calculate($(this).closest('.row.list-item'));
};
clipit.rubric.remove_item = function(){
    var $list = $(this).closest('.row.list-item'),
        level = $(this).closest('.rubric-item');
    if(level.parent().find('.rubric-item').length > 1) {
        level.fadeOut('fast', function () {
            $(this).remove();
            clipit.rubric.rating_calculate($list);
        });
    } else {
        elgg.register_error(elgg.echo('rubric:level:cantremove'));
    }
};

clipit.rubric.rating_calculate = function(list){
    var items = list.find('.rubric-item'),
        count = items.length;
    items.each(function(i){
        var rating = ( Math.round( (i + 1) * (1 / items.length)*10*10 )/10 );
        $(this).find('.rubric-rating-value').text(rating);
    });
};

clipit.rubric.get_by_owner = function(){
    var id = $(this).val(),
        container = $(this).data('container'),
        selected_list = $(container).find('.rubrics-selected'),
        unselected_list = $(container).find('.rubrics-unselected');
    if(id != '') {
        $(container).show();
        selected = [];
        selected_list.find('.rubric').each(function(){
            selected.push($(this).data('rubric'));
        });
        unselected_list.html('<i class="fa fa-spinner fa-spin fa-2x blue"></i>');
        elgg.get('ajax/view/rubric/items', {
            data: {
                'input_prefix': $(this).data('input-prefix'),
                'entity_id': id,
            },
            success: function (data) {
                unselected_list.html(data);
            }
        });
    } else {
        $(container).html('');
    }
};
clipit.rubric.show_items = function(){
    var tr = $(this).closest("tr")
    id = $(this).attr("id"),
        tr_rubric = $(this).closest('table').find("[data-rubric="+id+"]");
    if(tr_rubric.length > 0){
        tr_rubric.toggle();
        return false;
    }
    var container =
        $("<tr/>").attr("data-rubric", id).html(
            $('<td/>').attr("colspan", 4)
                .html('<i class="fa fa-spinner fa-spin fa-2x blue"/>')
                .css({"padding": "10px", "overflowY": "auto", "overflowX": "hidden", "maxHeight": "450px"})
        );
    tr.after(container);
    elgg.get('ajax/view/rubric/items',{
        data: {
            'entity_id': id
        },
        success: function(content){
            container.find('td').html(content);
        }
    });
};
clipit.rubric.select_item = function(){
    var selected_list = $(this).closest('.rubric-select-list').find('.rubrics-selected'),
        $rubric = $(this).closest('.rubric').hide().clone();
    $rubric.hide().appendTo(selected_list.find('.rubrics')).fadeIn('fast');
    selected_list.fadeIn('fast');
    $rubric.find('.rubric-select').hide();
    $rubric.find('.rubric-unselect').show();
    $rubric.find('.input-select').val($rubric.data('rubric'));

};
clipit.rubric.unselect_item = function() {
    var $rubric = $(this).closest('.rubric'),
        container = $rubric.closest('.rubrics-selected');
    $('[data-rubric="'+ $rubric.data('rubric') +'"').fadeIn('show');
    if(container.find('.rubric').length == 1){
        container.hide();
    }
    $rubric.remove();
};

clipit.rubric.set_rating = function() {
    var container = $(this).closest('.rubric'),
        value = $(this).find('.rubric-rating-value').text();
    container.find('.rubric-item').removeClass('rubric-rated');
    $(this).addClass('rubric-rated');
    $('#'+ container.data('rubric')+ ".text-rating-value").text(value).hide().fadeIn('fast');
    container.find('.input-rating-value').val( $(this).index() + 1 );
    // Update average rating
    clipit.rubric.get_rating_avg(container.closest('.rubrics'));
};
clipit.rubric.get_rating_avg = function($list) {
    var total_count = $list.find('.rubric').length,
        value = 0;
    $list.find('.rubric .rubric-rated').each(function(){
        value += parseFloat($(this).find('.rubric-rating-value').text());
    });
    $('#rubric-rating-avg').text((value/total_count).toFixed(1)).hide().fadeIn('fast');
};