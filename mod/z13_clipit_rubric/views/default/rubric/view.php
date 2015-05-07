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
$rubrics = array();
$rubrics = array_pop(elgg_extract('entities', $vars));
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
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="row performance_item" style="padding: 20px;">
            <div class="col-md-7"><h4 class="margin-0 margin-bottom-15"><?php echo elgg_echo('performance_item');?></h4></div>
            <div class="col-md-5"><h4 class="margin-0 margin-bottom-15"><?php echo elgg_echo('category');?></h4></div>
            <div class="col-md-7 group-input" style="border-right: 1px solid #eee;">
                <?php
                $count = 0;
                $category_name = $rubrics[0]->category;
                $category_description = $rubrics[0]->category_description;
                foreach($rubrics as $rubric):
                    $input_prefix = 'item['.$i.']['.$count.']';
                    $disabled = false;
                    $user = array_pop(ClipitUser::get_by_id(array($rubric->owner_id)));
                    echo elgg_view('forms/rubric/save_inputs', array(
                        'entity' => $rubric,
                        'owner' => $user,
                        'disabled' => true,
                        'id' => $rubric->id
                    ));
                    ?>

                    <?php
                    $count++;
                endforeach;
                ?>
            </div>
            <div class="col-md-5">
                <p><strong><?php echo $category_name;?></strong></p>
                <?php if($category_description):?>
                    <small class="show"><?php echo elgg_echo('description');?></small>
                    <p><?php echo $category_description;?></p>
                    <?php echo elgg_view("input/hidden", array(
                        'name' => 'category',
                        'value' => $category_name,
                    ));
                    ?>
                <?php endif;?>
            </div>
        </div>
    </div>
</div>