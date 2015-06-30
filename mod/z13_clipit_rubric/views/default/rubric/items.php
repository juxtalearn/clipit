<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   08/06/2015
 * Last update:     08/06/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$rubrics = elgg_extract('entities', $vars);
$select = elgg_extract('select', $vars);
$rating = elgg_extract('rating', $vars, false);
$rating_selected = elgg_extract('rating_selected', $vars);
if($rubric_id = get_input('entity_id')){
    $rubric = array_pop(ClipitRubric::get_by_id(array($rubric_id)));
    $rubrics = ClipitRubricItem::get_by_id($rubric->rubric_item_array);
}
$selected_array = array();
$input_prefix = elgg_extract('input_prefix', $vars);
if($by_owner = get_input('by_owner')){
    $rubrics = array_pop(ClipitRubricItem::get_by_owner(array($by_owner), 0, 0, 'time_created', false));
    $select = true;
    $selected_array = get_input('selected');
    $input_prefix = get_input('input_prefix');
}
?>
<style>
    fieldset {
        min-width: 0;
    }
    .row-horizon>.col-md-3 {
        width: 25%;
    }
    .row-horizon > .rubric-item {
        padding: 0 5px;
    }
    .rubrics-rating .rubric-item:hover{
        box-shadow: inset 0 0 0 2px #32b4e5;
        cursor: pointer;
    }
    .rubric-rated .rating{
        background-color: #d9edf7;
        font-size: 85%;
        padding: 2px 5px;
        color: #32b4e5;
        margin-top: 5px;
    }
    .rubric-rated {
        cursor: default;
        position: relative;
        box-shadow: inset 0 0 0 2px #99cb00 !important;
        background: rgba(153, 203, 0, 0.08) !important;
    }
    .rubric-rated .fa-stack{
        display: block !important;
    }
    .rubric-rated .rubric-rating{
        visibility: hidden;
    }
</style>
<?php if(count($rubrics) > 1): ?>
    <?php echo elgg_view('input/hidden', array(
        'name' => 'input-remove',
        'id' => 'input-remove',
    ));
    ?>
<?php endif;?>
<ul class="rubrics <?php echo $rating ? 'rubrics-rating':'';?>">
    <?php foreach($rubrics as $rubric):
        $id = uniqid('rubric_');
        ?>
        <li class="row list-item rubric"
            data-rubric="<?php echo $rubric->id;?>"
            <?php echo in_array($rubric->id, $selected_array) ? 'style="display:none;"':''?>>

            <div class="col-md-3">
                <p><strong style="font-size: 13px;" class="show"><?php echo $rubric->name;?></strong></p>
                <?php if($rating):?>
                    <label for="rubric_rating[<?php echo $rubric->id;?>][level]"></label>
                    <?php echo elgg_view('input/text', array(
                        'name' => 'rubric_rating['.$rubric->id.'][level]',
                        'class' => 'input-rating-value',
                        'value' => $rating_selected[$rubric->id]->level,
                        'style' => 'visibility: hidden;height: 0;float:left;',
                        'required' => true
                    ));
                    ?>
                    <?php if($rating_selected):?>
                        <?php echo elgg_view('input/hidden', array(
                            'name' => 'rubric_rating['.$rubric->id.'][id]',
                            'value' => $rating_selected[$rubric->id]->id,
                        ));
                        ?>
                    <?php endif;?>
                <?php endif;?>
                <?php if($select):?>
                    <?php echo elgg_view('input/hidden', array(
                        'name' => $input_prefix.'[rubric][]',
                        'class' => 'input-select',
                        'value' => $vars['pre_populate'] ? $rubric->id:''
                    ));
                    ?>
                    <a style="<?php echo $vars['unselected']?'display: none;':'';?>" class="btn btn-xs btn-primary btn-border-blue rubric-select margin-top-10">
                        <?php echo elgg_echo('select');?>
                    </a>
                    <a style="<?php echo $vars['unselected']?'':'display: none;';?>" class="btn btn-xs btn-primary btn-border-red rubric-unselect margin-top-10">
                        <?php echo elgg_echo('btn:remove');?>
                    </a>
                <?php endif;?>
            </div>
            <div class="col-md-9 row-horizon row" style="overflow-x: auto;">
                <?php
                foreach($rubric->level_array as $i => $rubric_item):
                    if($rubric->id){
                        $default_rating = round(($rubric->level_increment*($i+1))*10, 1);
                    } else {
                        $default_rating = round(($i + 1) * (1 / $total) * 10 * 10, 1) / 10;
                    }
                ?>
                    <div class="col-md-3 col-xs-6 rubric-item
                                <?php echo $rating_selected[$rubric->id]->level == ($i+1) ? 'rubric-rated':'';?>"
                         style="background: rgb(236, 247, 252);border-radius: 4px;">
                        <div  class="margin-top-5 text-left" style="background: #fff;padding: 0 5px;">
                            <div class="fa-stack fa-lg green" style="line-height: 30px;position: absolute;top: 3px;right: 0px;display: none;">
                                <i class="fa fa-circle fa-stack-2x" style="font-size: 30px;"></i>
                                <strong class="fa-stack-1x fa-inverse" style="font-size: 15px;"><?php echo $default_rating;?></strong>
                            </div>
                            <strong class="blue rubric-rating-value pull-right"><?php echo $default_rating;?></strong>
                            <small><?php echo elgg_echo('rubric:score');?> </small>
                        </div>
                        <p style="padding: 5px;font-size:13px;"><?php echo $rubric_item;?></p>
                    </div>
                <?php endforeach;?>
            </div>
        </li>
    <?php endforeach;?>
</ul>
<?php if($rating):?>
    <div class="clearfix"></div>
    <hr style="visibility: hidden;">
    <div class="row">
        <div class="col-md-10">
        <ul class="row">
        <?php
        $score = 0;
        foreach($rubrics as $rubric):
            $score += $rating_selected[$rubric->id]->score*10;
        ?>
            <li class="col-md-6">
                <div style="border-bottom: 1px solid #bae6f6;padding-bottom: 5px;margin-bottom: 5px;">
                    <strong>
                        <a id="<?php echo $rubric->id;?>" class="pull-right text-rating-value">
                            <?php echo $rating_selected ? round($rating_selected[$rubric->id]->score*100)/10 : '-';?>
                        </a>
                        <span style="font-size: 13px;" class="show text-truncate"><?php echo $rubric->name;?></span>
                    </strong>
                </div>
            </li>
        <?php endforeach;?>
        </ul>
        </div>
        <div class="col-md-2">
            <div style="
    background-color: rgb(236, 247, 252);
    padding: 5px;
    border-radius: 100px;
    width: 80px;
    height: 80px;
    line-height: 70px;
    text-align: center;
    float: right;
    margin-top: -45px;
">
    <span id="rubric-rating-avg" style="
    color: rgb(50, 180, 229);
    font-weight: bold;
    font-size: 30px;
    font-family: FuturaBoldRegular,Impact,'Impact Bold',Helvetica,Arial,sans,sans-serif;
">
        <?php echo $rating_selected ? floor(($score/count($rating_selected))*10)/10 : '-';?>
    </span>

            </div>
        </div>
    </div>
<?php endif;?>