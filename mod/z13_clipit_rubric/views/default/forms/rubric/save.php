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
$rubrics = array_pop(elgg_extract('entities', $vars));
$button_value = elgg_extract('submit_value', $vars);
$id = uniqid('rubric_');
?>
<script>
$(function(){
    $(document).on('click', '.add-rubric', function(){
        var container = $(this).closest('.group-input'),
            clone = <?php echo json_encode(elgg_view('forms/rubric/save_inputs', array('id' => $id, 'input_prefix' => 'item['.$id.']')));?>,
            clone = clone.split('<?php echo $id;?>').join(Date.now()),
            $clone = $(clone);
        container.find('.performance-items').append($clone);
        $clone.find('.remove-p').show();
        $clone.find('input[type=text]:first').focus();
    });
});
</script>
<div role="tabpanel">
    <!-- Tab panes -->
    <div class="tab-content">
        <div class="row performance_item" id="<?php echo $i;?>" style="padding: 20px;">
            <div class="col-md-7"><h4 class="margin-0 margin-bottom-15"><?php echo elgg_echo('performance_item');?></h4></div>
            <div class="col-md-5"><h4 class="margin-0 margin-bottom-15"><?php echo elgg_echo('category');?></h4></div>
            <div class="col-md-7 group-input" style="border-right: 1px solid #eee;">
                <div class="performance-items">
                <?php
                $count = 0;
                $category_name = $rubrics[0]->category;
                $category_description = $rubrics[0]->category_description;
                foreach($rubrics as $rubric):
                    $input_prefix = 'item['.$count.']';
                    $disabled = false;
                    if(isset($rubric->id)){
                        $id = $rubric->id;
                        $entity_input =  elgg_view('input/hidden', array(
                            'name' => $input_prefix.'[id]',
                            'value' => $rubric->id
                        ));
                        if($rubric->owner_id != elgg_get_logged_in_user_guid()){
                            $user = array_pop(ClipitUser::get_by_id(array($rubric->owner_id)));
                            $disabled = true;
                            $entity_input = false;
                        }
                        echo $entity_input;
                    }
                    echo elgg_view('forms/rubric/save_inputs', array(
                        'entity' => $rubric,
                        'owner' => $user,
                        'disabled' => $disabled,
                        'input_prefix' => $input_prefix,
                        'id' => $id
                    ));
                    $count++;
                endforeach;
                ?>
                </div>
                <div class="clearfix"></div>
                <?php echo elgg_view('output/url', array(
                    'class' => 'btn btn-xs btn-primary btn-border-blue add-rubric add-input',
                    'text'  => elgg_echo('add'),
                ));
                ?>
            </div>
            <div class="col-md-5">
                <?php if($category_name):?>
                    <p><strong><?php echo $category_name;?></strong></p>
                    <?php echo elgg_view("input/hidden", array(
                        'name' => 'category',
                        'value' => $category_name,
                    ));
                    ?>
                    <?php if($category_description):?>
                        <small class="show"><?php echo elgg_echo('description');?></small>
                        <p><?php echo $category_description;?></p>
                        <?php echo elgg_view("input/hidden", array(
                            'name' => 'category_description',
                            'value' => $category_description,
                        ));
                        ?>
                    <?php endif;?>
                <?php else:?>
                    <div class="form-group">
                        <label for="category-name[<?php echo $i;?>]"><?php echo elgg_echo('title');?></label>
                        <?php echo elgg_view("input/text", array(
                            'name' => 'category',
                            'class' => 'form-control input-category-name',
                            'required' => true,
                            'value' => $category_name,
                        ));
                        ?>
                        <div class="margin-top-10">
                            <a data-toggle="collapse" href="#category_desc_<?php echo $i; ?>" aria-expanded="false" class="margin-right-10">
                                <strong>+ <?php echo elgg_echo('description'); ?></strong>
                            </a>
                        </div>
                        <div class="form-group collapse margin-top-10" id="category_desc_<?php echo $i;?>">
                            <?php
                            echo elgg_view('input/plaintext', array(
                                'name' => 'category_description',
                                'class' => 'form-control input-category-description',
                                'rows' => 7,
                                'value' => $category_description
                            ));
                            ?>
                        </div>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>

</div>
<div class="text-right">
    <?php echo elgg_view('input/submit', array(
        'class' => 'btn btn-primary',
        'value'  => $button_value,
    ));
    ?>
</div>