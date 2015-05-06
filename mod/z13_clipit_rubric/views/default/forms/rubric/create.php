<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/01/2015
 * Last update:     23/01/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$rubric = elgg_extract('entity', $vars);
$button_value = elgg_extract('submit_value', $vars);
//print_r(ClipitPerformanceItem::get_all(15));
?>
<script>
$(function(){
    $(document).on('change', '.load-categories', function(){
        var that = $(this);
        $('.performance_item.tab-pane').each(function() {
            var container = $(this),
                data = container.find('.categories-data').val(),
                value = that.find('option:selected').text();
            data = JSON.parse(data);
            container.find('.load-categories option[value='+that.val()+']').prop('selected', true);
            container.find('.input-category-name').val(data[value].name);
            container.find('.input-category-description').val(data[value].description);
        });
    });
    $(document).on('click', '.add-rubric', function(){
//        var container = $(this).parent('.group-input'),
//            count = container.find('.clone-input').length;

//        var performance = $(this).closest('.performance_item'),
//            lang_id = $(this).closest('.performance_item').attr('id');
        $('.performance_item.tab-pane').each(function(){
            var lang_id = $(this).closest('.performance_item').attr('id'),
                container = $(this).find('.group-input'),
                clone = container.find('.clone-input:last').clone();
            clone.find('input, textarea').each(function(i, v){
                $(this).val('');
                var parts = $(this).attr('name').match(/([\w])+/g);
                if(parts) {
                    var new_name = parts[0] + '[' + lang_id + '][' + (parseInt(parts[2])+(1)) + '][' + parts[3] + ']';
                    $(this).attr('name', new_name);
                }
            });
            container.find('.clone-input:last').after(clone);
        });
    });
});
</script>
<div role="tabpanel">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <?php foreach(performance_items_available_languages() as $i => $language):?>
            <li role="presentation" class="<?php echo $language_index == $i ? 'active':'';?>">
                <a href="#<?php echo $i;?>" aria-controls="<?php echo $i;?>" role="tab" data-toggle="tab"><?php echo $language;?></a>
            </li>
        <?php endforeach;?>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <?php
        foreach(performance_items_available_languages() as $i => $language):
            $count = 0;
            $input_prefix = 'item['.$i.']['.$count.']';
            $lang_code = ClipitPerformanceItem::get_index_language($i);
            $categories = ClipitPerformanceItem::get_from_category(null);
            foreach($categories as $category => $items){
                $item = array_pop($items);
                $categories_data[$item->category[$i]] = array('name'=> $item->category[$i], 'description' =>$item->category_description[$i]);
            }
            echo elgg_view("input/hidden", array(
                'name' => 'item['.$i.'][language]',
                'value' => $lang_code,
            ));
        ?>
            <div role="tabpanel" class="row performance_item tab-pane <?php echo $language_index == $i ? 'active':'';?>" id="<?php echo $i;?>" style="padding: 20px;">
                <div class="col-md-7"><h4 class="margin-0 margin-bottom-15"><?php echo elgg_echo('performance_item');?></h4></div>
                <div class="col-md-5"><h4 class="margin-0 margin-bottom-15"><?php echo elgg_echo('category');?></h4></div>
                <?php echo elgg_view('input/plaintext', array(
                    'name' => 'category-description['.$i.']',
                    'value' => json_encode(array_merge(array('' => array('name' => '', 'description' => '')),$categories_data)),
                    'class' => 'form-control hide categories-data',
                ));
                ?>
                <div class="col-md-7 group-input" style="border-right: 1px solid #eee;">
                    <div class="form-group clone-input" style="background: #fafafa;padding: 10px;">
                        <?php echo elgg_view("input/text", array(
                            'name' => $input_prefix.'[item_name]',
                            'class' => 'form-control',
                            'required' => true,
                            'placeholder' => elgg_echo('name', $lang_code),
                        ));
                        ?>
                        <div class="margin-top-10">
                            <a data-toggle="collapse" href="#item_category_desc_<?php echo $i; ?>" aria-expanded="false" class="margin-right-10">
                                <strong>+ <?php echo elgg_echo('description'); ?></strong>
                            </a>
                            <a data-toggle="collapse" href="#item_example<?php echo $i; ?>" aria-expanded="false">
                                <strong>+ <?php echo elgg_echo('performance_item:example'); ?></strong>
                            </a>
                        </div>
                        <div class="collapse form-group" id="item_category_desc_<?php echo $i;?>">
                            <label for="item-description[<?php echo $i;?>]"><?php echo elgg_echo('description');?></label>
                            <?php echo elgg_view("input/plaintext", array(
                                'name' => $input_prefix.'[item_description]',
                                'class' => 'form-control margin-top-20',
                                'style' => 'overflow-y: auto;resize: none;',
                                'rows' => 3,
                            ));
                            ?>
                        </div>
                        <div class="collapse form-group" id="item_example<?php echo $i;?>">
                            <label for="item-example[<?php echo $i;?>]"><?php echo elgg_echo('performance_item:example');?></label>
                            <?php echo elgg_view("input/text", array(
                                'name' => $input_prefix.'[example]',
                                'class' => 'form-control',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <?php echo elgg_view('output/url', array(
                        'class' => 'btn btn-xs btn-primary btn-border-blue add-rubric add-input',
                        'text'  => elgg_echo('rubric:add'),
                    ));
                    ?>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <div class="form-group">
                        <small class="show margin-bottom-10">Cargar categoría existente</small>
                        <?php echo elgg_view('input/dropdown', array(
//                            'name' => 'item['.$i.']['.$count.'][category]',
                            'class' => 'form-control load-categories',
                            'style' => 'padding: 2px;',
                            'options_values' => array_merge(array(''), array_keys($categories_data))
                        ));
                        ?>
                        </div>
                        <label for="category-name[<?php echo $i;?>]"><?php echo elgg_echo('title');?></label>
                        <?php echo elgg_view("input/text", array(
                            'name' => 'item['.$i.'][category]',
                            'class' => 'form-control input-category-name',
                            'required' => true,
                            'value' => $rubric->category[$i],
                        ));
                        ?>
                        <div class="margin-top-10">
                            <a data-toggle="collapse" href="#category_desc_<?php echo $i; ?>" aria-expanded="false" class="margin-right-10">
                                <strong>+ <?php echo elgg_echo('description'); ?></strong>
                            </a>
                        </div>
                        <div class="form-group collapse" id="category_desc_<?php echo $i;?>">
                            <label for="category-description[<?php echo $i;?>]"><?php echo elgg_echo('description');?></label>
                            <?php
                            echo elgg_view('input/plaintext', array(
                                'name' => 'item['.$i.'][category_description]',
                                'class' => 'form-control input-category-description',
                                'rows' => 7
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
            $count++;
        endforeach;
        ?>
    </div>

</div>
<div class="text-right">
    <?php echo elgg_view('input/submit', array(
        'class' => 'btn btn-primary',
        'value'  => $button_value,
    ));
    ?>
</div>