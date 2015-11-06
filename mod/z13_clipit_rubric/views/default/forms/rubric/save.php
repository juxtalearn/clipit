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
$input_prefix = 'rubric';
if($rubric){
    $rubric_items = ClipitRubricItem::get_by_id($rubric->rubric_item_array, 0, 0, 'time_created', false);
    if(elgg_extract('input_prefix', $vars)){
        $input_prefix = elgg_extract('input_prefix', $vars) .'[rubric]';
    }
    echo elgg_view('input/hidden', array(
        'name' => $input_prefix.'[id]',
        'value' => $rubric->id,
    ));
}
if($rubric_id = get_input('entity_id')){
    $rubric = array_pop(ClipitRubric::get_by_id(array($rubric_id)));
    $rubric_items = ClipitRubricItem::get_by_id($rubric->rubric_item_array);
    $select = true;
    $selected_array = get_input('selected');
    $input_prefix = get_input('input_prefix');
}
if($vars['create']){
    $rubric_items = array('' => array_fill(0, 4, ''));
}
?>
<style>
    fieldset{
        min-width: 0;
    }
    .row-horizon > .col-md-3 {
        padding: 0 5px;
    }
    .row-horizon>.col-md-3 {
        width: 23%;
    }
    .rubric textarea{
        padding: 5px;
        width: 100%;
        resize: vertical;
        max-height: 200px;
    }
    .rubric-item textarea{
        font-size:13px;
        border-radius: 0 0 4px 4px;
        border: 1px solid #ccc;
        border-top: 0;
    }
    .rubric-item .rating{
        background-color: #d9edf7;
        font-size: 85%;
        padding: 2px 5px;
        color: #32b4e5;
        margin-top: 5px;
    }
    .rubric-item .rubric-details{
        background: #f4f4f4;
        padding: 0 5px;
        cursor: e-resize;
    }
    .add-rubric-item{
        display: table;
        width: 100%;
        height: 140px;
        border-radius: 4px;
    }
    .add-rubric-item > div{
        display: table-cell;
        vertical-align: middle;
        text-align: center;
    }
</style>
<script>
$(function(){
    $( ".rubric .row-horizon").sortable({
        containment: "parent",
        update: function(event, ui) {
            clipit.rubric.rating_calculate($(ui.item).closest('.rubric'));
        }
    });
});
</script>
<?php if(count($rubric) > 1): ?>
    <?php echo elgg_view('input/hidden', array(
        'name' => 'input-remove',
        'id' => 'input-remove',
    ));
    ?>
<?php endif;?>
<div class="row">
    <div class="col-md-6 form-group">
        <label><?php echo elgg_echo('rubric:name');?></label>
        <?php echo elgg_view('input/text', array(
            'class' => 'form-control',
            'name' => $input_prefix.'[name]',
            'maxlength' => 100,
            'value' => $rubric->name,
            'autofocus' => true,
            'aria-label' => elgg_echo('rubric:name'),
            'required' => true,
        ));
        ?>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-2">
        <label><?php echo elgg_echo('rubric:item');?></label>
    </div>
    <div class="col-md-10">
        <label><?php echo elgg_echo('rubric:levels');?></label>
    </div>
</div>
<hr class="margin-top-5">

<ul class="rubrics">
<?php foreach($rubric_items as $rubric_item):
    $id = uniqid('rubric_');
    $levels = $rubric_item;
    if($rubric_item->id){
        $levels = $rubric_item->level_array;
    }
?>
<li class="row list-item rubric">
    <div>
    <div class="col-md-3">
        <?php
        if($rubric_item->id) {
            echo elgg_view('input/hidden', array(
                'class' => 'rubric-remove',
                'name' => $input_prefix.'[item][' . $id . '][remove]',
                'value' => 0
            ));
            echo elgg_view('input/hidden', array(
                'class' => 'rubric-id',
                'name' => $input_prefix.'[item][' . $id . '][id]',
                'value' => $rubric_item->id
            ));
        }
        ?>
        <?php echo elgg_view('output/url', array(
            'href'  => 'javascript:;',
            'class' => 'remove-rubric btn btn-xs btn-primary margin-bottom-10 btn-border-red show',
            'text'  => '<i class="fa fa-trash-o"></i> '.elgg_echo('rubric:item:remove'),
            'aria-label' => elgg_echo('rubric:item:remove'),
        ));
        ?>
        <?php echo elgg_view('input/plaintext', array(
            'class' => 'form-control',
            'rows' => 2,
            'name' => $input_prefix.'[item]['.$id.'][name]',
            'placeholder' => elgg_echo('rubric:item:name'),
            'value' => $rubric_item->name,
            'required' => true,
            'aria-label'=> elgg_echo('rubric:item:name'),
        ));
        ?>
    </div>
    <div class="col-md-9 row-horizon row" style="overflow-x: auto;">
        <?php
        $total = count($levels);
        foreach($levels as $i => $level):
            if($rubric_item->id){
                $rating = round(($rubric_item->level_increment*($i+1))*10, 1);
            } else {
                $rating = round(($i + 1) * (1 / $total) * 10 * 10, 1) / 10;
            }
        ?>
        <div class="col-md-3 col-xs-6 rubric-item">
            <div class="rubric-details" style="border: 1px solid #ccc;border-bottom: 1px solid #eee;border-radius: 4px 4px 0 0;">
                <a href="javascript:;" class="fa fa-trash-o red remove-rubric-item" aria-label="<?php echo elgg_echo('rubric:level:remove');?>" name="<?php echo elgg_echo('rubric:level:remove');?>" tabindex="2" title="<?php echo elgg_echo('rubric:level:remove');?>"></a>
                <span class="pull-right">
                    <small><?php echo elgg_echo('rubric:score');?>: </small>
                    <strong class="blue rubric-rating-value"><?php echo $rating;?></strong>
                </span>
            </div>
            <?php echo elgg_view('input/plaintext', array(
                'rows' => 6,
                'name' => $input_prefix.'[item]['.$id.'][level][]',
                'placeholder' => elgg_echo('rubric:item:level:description'),
                'value' => $level,
                'required' => true,
                'aria-label' => elgg_echo('rubric:description').$rating,

            ));
            ?>
        </div>
        <?php endforeach;?>
        <div class="col-md-1" style="padding: 0">
            <a class="add-rubric-item cursor-pointer" aria-label="<?php echo elgg_echo('rubric:add_item');?>" href="javascript:;" title="<?php echo elgg_echo('rubric:add_item');?>">
                <div>
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x blue"></i>
                        <i class="fa fa-plus fa-stack-1x fa-inverse"></i>
                    </span>
                </div>
            </a>
        </div>
    </div>
    </div>
</li>
<?php endforeach;?>
</ul>
<hr>
<div>
    <a class="btn btn-sm btn-primary" id="add-rubric"><i class="fa fa-plus"></i> <?php echo elgg_echo('rubric:add');?></a>
</div>
<?php if($button_value):?>
<div class="text-right">
    <?php echo elgg_view('input/submit', array(
        'class' => 'btn btn-primary',
        'value'  => $button_value,
    ));
    ?>
</div>
<?php endif;?>