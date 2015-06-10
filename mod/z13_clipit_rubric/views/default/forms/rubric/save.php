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
?>
<link rel="stylesheet" href="http://rawgithub.com/FluidApps/bootstrap-horizon/master/bootstrap-horizon.css">
<style>
    fieldset{
        min-width: 0;
    }
    .row-horizon{
        padding-bottom: 5px;
    }
    .row-horizon > .col-md-3 {
        padding: 0 5px;
        width: 19.95%;
    }
    .rubric-item .rating{
        background-color: #d9edf7;
        font-size: 85%;
        padding: 2px 5px;
        color: #32b4e5;
        margin-top: 5px;
    }
</style>
<?php if(count($rubric) > 1): ?>
    <?php echo elgg_view('input/hidden', array(
        'name' => 'input-remove',
        'id' => 'input-remove',
    ));
    ?>
<?php endif;?>
<div class="row">
    <div class="col-md-2">
        <label><?php echo elgg_echo('name');?></label>
    </div>
    <div class="col-md-10">
        <label><?php echo elgg_echo('rubric:items');?></label>
    </div>
</div>
<hr class="margin-top-5">
<ul class="rubrics">
<?php foreach($rubrics as $rubric):
    $id = uniqid('rubric_');
    $items = $rubric;
    if($rubric->id){
        $items = $rubric->level_array;
    }
?>
<li class="row list-item rubric">
    <div class="col-md-2">
        <?php
        if($rubric->id) {
            echo elgg_view('input/hidden', array(
                'class' => 'rubric-remove',
                'name' => 'rubric[' . $id . '][remove]',
                'value' => 0
            ));
            echo elgg_view('input/hidden', array(
                'class' => 'rubric-id',
                'name' => 'rubric[' . $id . '][id]',
                'value' => $rubric->id
            ));
        }
        ?>
        <?php echo elgg_view('input/plaintext', array(
            'style' => 'padding: 5px;font-size:13px;width: 100%;resize: vertical;',
            'class' => 'form-control',
            'rows' => 2,
            'name' => 'rubric['.$id.'][name]',
            'value' => $rubric->name
        ));
        ?>
        <?php echo elgg_view('output/url', array(
            'href'  => 'javascript:;',
            'class' => 'add-rubric-item btn btn-xs btn-primary margin-top-10 btn-border-blue',
            'text'  => 'Añadir criterio'
        ));
        ?>
        <?php echo elgg_view('output/url', array(
            'href'  => 'javascript:;',
            'class' => 'remove-rubric btn btn-xs btn-primary margin-top-10 btn-border-red',
            'text'  => elgg_echo('remove')
        ));
        ?>
    </div>
    <div class="col-md-10 row-horizon row" style="overflow-x: auto;">
        <?php
        $total = count($items);
        foreach($items as $i => $rubric_item):
            if($rubric->id){
                $rating = round(($rubric->level_increment*($i+1))*10);
            } else {
                $rating = round(($i + 1) * (1 / $total) * 10 * 10, 1) / 10;
            }
        ?>
        <div class="col-md-3 col-xs-6 rubric-item">
            <?php echo elgg_view('input/plaintext', array(
                'style' => 'padding: 5px;font-size:13px;width: 100%;border-radius: 4px;border: 1px solid #ccc;resize:vertical;',
                'rows' => 6,
                'name' => 'rubric['.$id.'][item][]',
                'value' => $rubric_item
            ));
            ?>
            <div style="background: #f4f4f4;padding: 0 5px;">
                <a href="javascript:;" class="fa fa-trash-o red remove-rubric-item"></a>
                <span class="pull-right">
                    <small>Puntuación: </small><strong class="blue rubric-rating"><?php echo $rating;?></strong>
                </span>
            </div>
        </div>
        <?php endforeach;?>
        <div class="col-md-3" style="display: none">
            <a class="add-rubric-item bg-info cursor-pointer" href="javascript:;">
                <div>
                    <span class="fa-stack fa-lg">
                        <i class="fa fa-circle fa-stack-2x blue"></i>
                        <i class="fa fa-plus fa-stack-1x fa-inverse"></i>
                    </span>
                </div>
            </a>
        </div>
    </div>
</li>
<?php endforeach;?>
</ul>
<hr>
<div>
    <a class="btn btn-sm btn-primary" id="add-rubric"><i class="fa fa-plus"></i> Añadir rúbrica</a>
</div>
<div class="text-right">
    <?php echo elgg_view('input/submit', array(
        'class' => 'btn btn-primary',
        'value'  => $button_value,
    ));
    ?>
</div>