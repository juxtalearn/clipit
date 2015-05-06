<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   27/11/2014
 * Last update:     27/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$rubrics = elgg_extract('entities', $vars);
?>
<div class="pull-right">
    <div class="inline-block">
        <?php echo elgg_view('page/components/admin_options', array(
            'entity' => $rubrics[0],
        ));
        ?>
    </div>
    <span class="margin-left-10">
        <?php echo elgg_view("page/components/print_button");?>
    </span>
</div>
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
                        $disabled = false;
                        $user = array_pop(ClipitUser::get_by_id(array($rubric->owner_id)));
                        ?>
                        <div class="form-group <?php echo $disabled?'locked':'';?>" style="background: #fafafa;padding: 10px;">
                            <small class="pull-right">
                                <?php echo elgg_echo('author');?>:
                                <i class="fa fa-user blue"></i>
                                <?php echo elgg_view('output/url', array(
                                    'href'  => "profile/{$user->login}",
                                    'title' => $user->name,
                                    'text'  => $user->name,
                                ));
                                ?>
                            </small>
                           <a><strong><?php echo $rubric->item_name[$i];?></strong></a>
                            <div class="form-group">
                                <?php if($rubric->item_description[$i] !='-EMPTY-'):?>
                                    <p class="text-muted">
                                        <?php echo $rubric->item_description[$i];?>
                                    </p>
                                <?php endif;?>
                                <?php if($rubric->example[$i] !='-EMPTY-'):?>
                                    <p class="text-muted">
                                       <small class="show"><strong><?php echo elgg_echo('performance_item:example'); ?></strong></small>
                                        <?php echo $rubric->example[$i];?>
                                    </p>
                                <?php endif;?>
                            </div>
                            <div class="toggle-content collapse form-group" id="item_example_<?php echo $i;?>_<?php echo $count;?>">
                                <label for="item-example[<?php echo $i;?>]"><?php echo elgg_echo('performance_item:example');?></label>
                                <?php echo elgg_view("input/text", array(
                                    'name' => $input_prefix.'[example]',
                                    'value' => $rubric->example[$i] !='-EMPTY-'?$rubric->example[$i]:'',
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
                </div>
                <div class="col-md-5">
                    <?php if(empty($rubrics)):?>
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
                    <?php
                    else:
                        $input_category_prefix = 'item['.$i.']';
                        echo elgg_view("input/hidden", array(
                            'name' => $input_category_prefix.'[category]',
                            'value' => $rubrics[0]->category[$i] !='-EMPTY-'?$rubrics[0]->category[$i]:'',
                        ));
                        echo elgg_view("input/hidden", array(
                            'name' => $input_category_prefix.'[category_description]',
                            'value' => $rubrics[0]->category_description[$i] !='-EMPTY-'?$rubrics[0]->category_description[$i]:'',
                        ));
                        ?>
                        <strong class="show"><?php echo $rubrics[0]->category[$i] !='-EMPTY-'?$rubrics[0]->category[$i]:'';?></strong>
                        <p class="text-muted"><?php echo $rubrics[0]->category_description[$i] !='-EMPTY-'?$rubrics[0]->category_description[$i]:'';?></p>
                    <?php endif;?>
                </div>
            </div>
        <?php endforeach;?>
    </div>

</div>