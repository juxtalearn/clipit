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
$rubrics = array();
$rubrics = elgg_extract('entities', $vars);
$button_value = elgg_extract('submit_value', $vars);
$language_index = ClipitPerformanceItem::get_language_index(get_current_language());
$rubrics = array_merge($rubrics, array('to_clone'));
?>
<script>
    $(function(){
        $(document).on('click', '.add-rubric', function(){

            $('.performance_item.tab-pane').each(function(){
                var lang_id = $(this).closest('.performance_item').attr('id'),
                    container = $(this).find('.group-input'),
                    clone = container.find('.clone-input:not(.locked):last').clone()
//                    clone = container.find('.to-clone:first').clone()
                    count = container.find('.clone-input').length-2;
                clone.find('.toggle').attr('href', function(i, val){ return val.replace(/(\d*$)/, (count+1)) });
                clone.find('.toggle-content').attr('id', function(i, val){ return val.replace(/(\d*$)/, (count+1)) });

                clone.find('input, textarea').each(function(i, v){
                    $(this).val('').prop('disabled', false);
                    var parts = $(this).attr('name').match(/([\w])+/g);
                    if(parts) {
                        var new_name = parts[0] + '[' + lang_id + '][' + (count+(1)) + '][' + parts[3] + ']';
                        $(this).attr('name', new_name);
                    }
                });
                container.find('.clone-input:last').after(clone.show());
                clone.find('input[type=text]:first').focus();
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
                    <?php
                    $count = 0;
                    foreach($rubrics as $rubric):
                        $input_prefix = 'item['.$i.']['.$count.']';
                        $readonly = false;
                        if($rubric->owner_id != elgg_get_logged_in_user_guid() && is_array($rubric)){
                            $readonly = true;
                            $user = array_pop(ClipitUser::get_by_id(array($rubric->owner_id)));
                        }
                        if($rubric->item_name[$i]) {
                            echo elgg_view("input/hidden", array(
                                'name' => $input_prefix.'[reference]',
                                'value' => $rubric->reference,
                            ));
                        }
                        $disabled = false;
                        if($rubric=='to_clone'){
                            $disabled = true;
                        }
                    ?>
                    <div class="form-group clone-input <?php echo $readonly?'locked':'';?>"
                         style="background: #fafafa;padding: 10px; <?php echo $rubric=='to_clone'?'display:none;':''?>">
                        <?php echo elgg_view("input/text", array(
                            'name' => $input_prefix.'[item_name]',
                            'class' => 'form-control',
                            'required' => true,
                            'value' => $rubric->item_name[$i] !='-EMPTY-'?$rubric->item_name[$i]:'',
                            'readonly' => $readonly,
                            'disabled' => $disabled,
                            'placeholder' => elgg_echo('name', $lang_code),
                        ));
                        ?>
                        <div class="margin-top-10">
                            <a class="toggle" data-toggle="collapse" href="#item_category_desc_<?php echo $i; ?>_<?php echo $count;?>" aria-expanded="false" class="margin-right-10">
                                <strong>+ <?php echo elgg_echo('description'); ?></strong>
                            </a>
                            <a class="toggle margin-left-10" data-toggle="collapse" href="#item_example_<?php echo $i; ?>_<?php echo $count;?>" aria-expanded="false">
                                <strong>+ <?php echo elgg_echo('performance_item:example'); ?></strong>
                            </a>
                            <?php if($readonly):?>
                                <small class="pull-right">
                                    <i class="fa fa-lock"></i>
                                    <?php echo elgg_echo('author');?>:
                                    <?php echo elgg_view('output/url', array(
                                        'href'  => "profile/{$user->login}",
                                        'title' => $user->name,
                                        'text'  => $user->name,
                                    ));
                                    ?>
                                </small>
                            <?php endif;?>
                        </div>
                        <div class="toggle-content collapse form-group" id="item_category_desc_<?php echo $i;?>_<?php echo $count;?>">
                            <label for="item-description[<?php echo $i;?>]"><?php echo elgg_echo('description');?></label>
                            <?php echo elgg_view("input/plaintext", array(
                                'name' => $input_prefix.'[item_description]',
                                'value' => $rubric->item_description[$i] !='-EMPTY-'?$rubric->item_description[$i]:'',
                                'readonly' => $readonly,
                                'disabled' => $disabled,
                                'class' => 'form-control margin-top-20',
                                'style' => 'overflow-y: auto;resize: none;',
                                'rows' => 3,
                            ));
                            ?>
                        </div>
                        <div class="toggle-content collapse form-group" id="item_example_<?php echo $i;?>_<?php echo $count;?>">
                            <label for="item-example[<?php echo $i;?>]"><?php echo elgg_echo('performance_item:example');?></label>
                            <?php echo elgg_view("input/text", array(
                                'name' => $input_prefix.'[example]',
                                'value' => $rubric->example[$i] !='-EMPTY-'?$rubric->example[$i]:'',
                                'readonly' => $readonly,
                                'disabled' => $disabled,
                                'class' => 'form-control',
                            ));
                            ?>
                        </div>
                    </div>
                    <?php
                        $count++;
                    endforeach;
                    ?>
                    <div class="clearfix"></div>
                    <?php echo elgg_view('output/url', array(
                        'class' => 'btn btn-xs btn-primary btn-border-blue add-rubric add-input',
                        'text'  => elgg_echo('rubric:add'),
                    ));
                    ?>
                </div>
                <div class="col-md-5">
<!--                    --><?php //if(empty($rubrics)):?>
                    <div class="form-group">
                        <label for="category-name[<?php echo $i;?>]"><?php echo elgg_echo('title');?></label>
                        <?php echo elgg_view("input/text", array(
                            'name' => $input_prefix.'[category]',
                            'class' => 'form-control input-category-name',
                            'required' => true,
                            'value' => $rubrics[0]->category[$i] !='-EMPTY-'?$rubrics[0]->category[$i]:'',
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
                                'name' => $input_prefix.'[category_description]',
                                'class' => 'form-control input-category-description',
                                'rows' => 7,
                                'value' => $rubrics[0]->category_description[$i] !='-EMPTY-'?$rubrics[0]->category_description[$i]:''
                            ));
                            ?>
                        </div>
                    </div>
<!--                    --><?php
//                    else:
//                        $input_category_prefix = 'item['.$i.']';
//                        echo elgg_view("input/hidden", array(
//                            'name' => $input_category_prefix.'[category]',
//                            'value' => $rubrics[0]->category[$i] !='-EMPTY-'?$rubrics[0]->category[$i]:'',
//                        ));
//                        echo elgg_view("input/hidden", array(
//                            'name' => $input_category_prefix.'[category_description]',
//                            'value' => $rubrics[0]->category_description[$i] !='-EMPTY-'?$rubrics[0]->category_description[$i]:'',
//                        ));
//                    ?>
<!--                        <strong class="show">--><?php //echo $rubrics[0]->category[$i] !='-EMPTY-'?$rubrics[0]->category[$i]:'';?><!--</strong>-->
<!--                        <p class="text-muted">--><?php //echo $rubrics[0]->category_description[$i] !='-EMPTY-'?$rubrics[0]->category_description[$i]:'';?><!--</p>-->
<!--                    --><?php //endif;?>
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