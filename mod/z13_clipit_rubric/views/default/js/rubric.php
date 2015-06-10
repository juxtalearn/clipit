<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   09/06/2015
 * Last update:     09/06/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
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
    // Select rubric by owner from drop-down
    $(document).on('change', '.rubric-owner', clipit.rubric.get_by_owner);
};
elgg.register_hook_handler('init', 'system', clipit.rubric.init);

clipit.rubric.add = function(){
    var $list = $('.rubrics'),
        element = $list.find('.rubric:last'),
        clone = element.clone().hide(),
        count = $list.find('.rubric').length;
    clone.appendTo($list);
    clone.find('.rubric-id, .rubric-remove').remove();
    clone.find('input[type="text"], textarea').attr('name', function(i, val){
        return val.replace(/(rubric_)\w+/g, 'rubric_'+Date.now())
    });
    clone.fadeIn('fast').find('textarea').val('');
    clone.find('textarea:first').focus();
    clipit.rubric.rating_calculate(clone.find('.rubric'));
};
clipit.rubric.remove = function(){
    var $list = $(this).closest('.rubric');
    if($list.find('.rubric-id').length > 0){
        $list.hide();
        $list.find('.rubric-remove').val('1');
    } else {
        $list.remove();
    }
};
clipit.rubric.add_item = function(){
    var element = $(this).closest('.row.list-item').find('.rubric-item:last'),
        clone = element.clone().hide();
    element.after(clone);
    clone.fadeIn('fast').find('textarea').val('').focus();
    clipit.rubric.rating_calculate($(this).closest('.row.list-item'));
};
clipit.rubric.remove_item = function(){
    var $list = $(this).closest('.row.list-item');
    $(this).closest('.rubric-item').fadeOut('fast', function(){
        $(this).remove();
        clipit.rubric.rating_calculate($list);
    });
};

clipit.rubric.rating_calculate = function(list){
    var items = list.find('.rubric-item'),
        count = items.length;
    items.each(function(i){
        var rating = ( Math.round( (i + 1) * (1 / items.length)*10*10 )/10 );
        $(this).find('.rubric-rating').text(rating);
    });
};

clipit.rubric.get_by_owner = function(){
    var user_id = $(this).val(),
        container = $(this).data('container'),
        selected_list = $(container).find('.rubrics-selected'),
        unselected_list = $(container).find('.rubrics-unselected');
    if(user_id != '') {
        $(container).show();
        selected = [];
        selected_list.find('.rubric').each(function(){
            selected.push($(this).data('rubric'));
        });
        unselected_list.html('<i class="fa fa-spinner fa-spin fa-2x blue"></i>');
        elgg.get('ajax/view/rubric/items', {
            data: {
                'input_prefix': $(this).data('input-prefix'),
                'by_owner': user_id,
                'selected': selected
            },
            success: function (data) {
                unselected_list.html(data);
            }
        });
    } else {
        $(container).html('');
    }
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