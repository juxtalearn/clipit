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
if($rubric){
    echo elgg_view("input/hidden", array(
        'name' => 'entity-id',
        'value' => $rubric->id,
    ));
}
?>
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
            $lang_code = ClipitPerformanceItem::get_index_language($i);
            echo elgg_view("input/hidden", array(
                'name' => 'item['.$i.'][language]',
                'value' => $lang_code,
            ));
        ?>
            <div role="tabpanel" class="row tab-pane <?php echo $language_index == $i ? 'active':'';?>" id="<?php echo $i;?>" style="padding: 20px;">
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="item-name[<?php echo $i;?>]"><?php echo elgg_echo('title');?></label>
                        <?php echo elgg_view("input/text", array(
                            'name' => 'item['.$i.'][item_name]',
                            'class' => 'form-control',
                            'value' => $rubric->item_name[$i],
                        ));
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="item-description[<?php echo $i;?>]"><?php echo elgg_echo('description');?></label>
                        <?php echo elgg_view("input/plaintext", array(
                            'name' => 'item['.$i.'][item_description]',
                            'class' => 'form-control',
                            'rows' => 5,
                            'value' => $rubric->item_description[$i],
                        ));
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="item-example[<?php echo $i;?>]"><?php echo elgg_echo('performance_item:example');?></label>
                        <?php echo elgg_view("input/text", array(
                            'name' => 'item['.$i.'][example]',
                            'class' => 'form-control',
                            'value' => $rubric->example[$i],
                        ));
                        ?>
                    </div>
                </div>
                <div class="col-md-5">
                    <h4 class="margin-0 margin-bottom-15"><?php echo elgg_echo('category');?></h4>
                    <div class="form-group">
                        <label for="category-name[<?php echo $i;?>]"><?php echo elgg_echo('title');?></label>
                        <?php echo elgg_view("input/text", array(
                            'name' => 'item['.$i.'][category]',
                            'class' => 'form-control',
                            'required' => true,
                            'value' => $rubric->category[$i],
                        ));
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="category-description[<?php echo $i;?>]"><?php echo elgg_echo('description');?></label>
                        <?php
                        echo elgg_view('input/plaintext', array(
                            'name' => 'item['.$i.'][category_description]',
                            'class' => 'form-control',
                            'value' => $rubric->category_description[$i],
                            'rows' => 5
                        ));
                        ?>
                    </div>
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