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
$language_index = ClipitPerformanceItem::get_language_index(get_current_language());
?>
<script>
$(function(){
    $(document).on('change', '.load-categories', function(){
        var container = $(this).closest('.performance_item'),
            data = container.find('.categories-data').val(),
            value = $(this).find('option:selected').text();
        data = JSON.parse(data);
        container.find('.input-category-name').val(data[value].name);
        container.find('.input-category-description').val(data[value].description);
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
            $categories = ClipitPerformanceItem::get_from_category(null, $i);
            foreach($categories as $category => $items){
                $item = array_pop($items);
                $categories_data[$item->category[$i]] = array('name'=> $item->category[$i], 'description' =>$item->category_description[$i]);
            }
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
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="item-name[<?php echo $i;?>]"><?php echo elgg_echo('title');?></label>
                        <?php echo elgg_view("input/text", array(
                            'name' => 'item-name['.$i.']',
                            'class' => 'form-control',
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
                                'name' => 'item-description['.$i.']',
                                'class' => 'form-control margin-top-20',
                                'style' => 'overflow-y: auto;resize: none;',
                                'rows' => 3,
                            ));
                            ?>
                        </div>
                        <div class="collapse form-group" id="item_example<?php echo $i;?>">
                            <label for="item-example[<?php echo $i;?>]"><?php echo elgg_echo('performance_item:example');?></label>
                            <?php echo elgg_view("input/text", array(
                                'name' => 'item-example['.$i.']',
                                'class' => 'form-control',
                            ));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group" style="background: #fafafa;padding: 10px;">
                        <div class="form-group">
                        <small class="show margin-bottom-10">Cargar categoría existente</small>
                        <?php echo elgg_view('input/dropdown', array(
                            'name' => 'group-mode',
                            'class' => 'form-control load-categories',
                            'style' => 'padding: 2px;',
                            'options_values' => array_merge(array(''), array_keys($categories_data))
                        ));
                        ?>
                        </div>
                        <label for="category-name[<?php echo $i;?>]"><?php echo elgg_echo('title');?></label>
                        <?php echo elgg_view("input/text", array(
                            'name' => 'category-name['.$i.']',
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
                                'name' => 'category-description['.$i.']',
                                'class' => 'form-control input-category-description',
                                'rows' => 7
                            ));
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <hr>
                    <?php echo elgg_view('output/url', array(
                        'class' => 'btn btn-xs btn-primary add-rubric',
                        'text'  => elgg_echo('rubric:add'),
                    ));
                    ?>
                </div>
            </div>
        <?php endforeach;?>
    </div>

</div>
<div class="text-right">
    <?php echo elgg_view('input/submit', array(
        'class' => 'btn btn-primary',
        'value'  => $button_value,
    ));
    ?>
</div>