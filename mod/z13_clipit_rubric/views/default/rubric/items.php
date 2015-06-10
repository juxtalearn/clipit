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
    .row-horizon {
        overflow-x: scroll;
        overflow-y: hidden;
        white-space: nowrap;
    }
    .row-horizon > [class*="col-lg"], .row-horizon > [class*="col-md"], .row-horizon > [class*="col-sm"], .row-horizon > [class*="col-xs"] {
        float: none;
        display: inline-block;
        white-space: normal;
        vertical-align: top;
    }
    .row-horizon > .col-xs-12 {
        width: 90%;
    }
    .row-horizon > .col-xs-11 {
        width: 82.5%;
    }
    .row-horizon > .col-xs-10 {
        width: 75%;
    }
    .row-horizon > .col-xs-9 {
        width: 67.5%;
    }
    .row-horizon > .col-xs-8 {
        width: 60%;
    }
    .row-horizon > .col-xs-7 {
        width: 52.5%;
    }
    .row-horizon > .col-xs-6 {
        width: 45%;
    }
    .row-horizon > .col-xs-5 {
        width: 37.5%;
    }
    .row-horizon > .col-xs-4 {
        width: 30%;
    }
    .row-horizon > .col-xs-3 {
        width: 22.5%;
    }
    .row-horizon > .col-xs-2 {
        width: 15%;
    }
    .row-horizon > .col-xs-1 {
        width: 7.5%;
    }
    @media (min-width: 768px) {
        .row-horizon > .col-sm-12 {
            width: 90%;
        }
        .row-horizon > .col-sm-11 {
            width: 82.5%;
        }
        .row-horizon > .col-sm-10 {
            width: 75%;
        }
        .row-horizon > .col-sm-9 {
            width: 67.5%;
        }
        .row-horizon > .col-sm-8 {
            width: 60%;
        }
        .row-horizon > .col-sm-7 {
            width: 52.5%;
        }
        .row-horizon > .col-sm-6 {
            width: 45%;
        }
        .row-horizon > .col-sm-5 {
            width: 37.5%;
        }
        .row-horizon > .col-sm-4 {
            width: 30%;
        }
        .row-horizon > .col-sm-3 {
            width: 22.5%;
        }
        .row-horizon > .col-sm-2 {
            width: 15%;
        }
        .row-horizon > .col-sm-1 {
            width: 7.5%;
        }
    }
    @media (min-width: 992px) {
        .row-horizon > .col-md-12 {
            width: 90%;
        }
        .row-horizon > .col-md-11 {
            width: 82.5%;
        }
        .row-horizon > .col-md-10 {
            width: 75%;
        }
        .row-horizon > .col-md-9 {
            width: 67.5%;
        }
        .row-horizon > .col-md-8 {
            width: 60%;
        }
        .row-horizon > .col-md-7 {
            width: 52.5%;
        }
        .row-horizon > .col-md-6 {
            width: 45%;
        }
        .row-horizon > .col-md-5 {
            width: 37.5%;
        }
        .row-horizon > .col-md-4 {
            width: 30%;
        }
        .row-horizon > .col-md-3 {
            width: 19.95%;
        }
        .row-horizon > .col-md-2 {
            width: 15%;
        }
        .row-horizon > .col-md-1 {
            width: 7.5%;
        }
    }
    @media (min-width: 1200px) {
        .row-horizon > .col-lg-12 {
            width: 90%;
        }
        .row-horizon > .col-lg-11 {
            width: 82.5%;
        }
        .row-horizon > .col-lg-10 {
            width: 75%;
        }
        .row-horizon > .col-lg-9 {
            width: 67.5%;
        }
        .row-horizon > .col-lg-8 {
            width: 60%;
        }
        .row-horizon > .col-lg-7 {
            width: 52.5%;
        }
        .row-horizon > .col-lg-6 {
            width: 45%;
        }
        .row-horizon > .col-lg-5 {
            width: 37.5%;
        }
        .row-horizon > .col-lg-4 {
            width: 30%;
        }
        .row-horizon > .col-lg-3 {
            width: 22.5%;
        }
        .row-horizon > .col-lg-2 {
            width: 15%;
        }
        .row-horizon > .col-lg-1 {
            width: 7.5%;
        }
    }
    fieldset {
        min-width: 0;
    }
    .row-horizon {
        padding-bottom: 5px;
    }
    .row-horizon > .rubric-item {
        padding: 0 5px;
    }
    .rubric-item .rating{
        background-color: #d9edf7;
        font-size: 85%;
        padding: 2px 5px;
        color: #32b4e5;
        margin-top: 5px;
    }
    .rubric-item:hover{
        cursor: default;
        position: relative;
        box-shadow: inset 0 0 0 2px #99cb00;
        background: rgba(153, 203, 0, 0.08) !important;
    }
    .rubric-item:hover .fa-stack{
        display: block !important;
    }
    .rubric-item:hover .rubric-rating{
        visibility: hidden;
    }
</style>
<?php if(count($rubric) > 1): ?>
    <?php echo elgg_view('input/hidden', array(
        'name' => 'input-remove',
        'id' => 'input-remove',
    ));
    ?>
<?php endif;?>
<ul class="rubrics">
    <?php foreach($rubrics as $rubric):
        $id = uniqid('rubric_');
        ?>
        <li class="row list-item rubric"
            data-rubric="<?php echo $rubric->id;?>"
            <?php echo in_array($rubric->id, $selected_array) ? 'style="display:none;"':''?>>

            <div class="col-md-2">
                <strong style="font-size: 13px;" class="show"><?php echo $rubric->name;?></strong>
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
            <div class="col-md-10 row-horizon row" style="overflow-x: auto;">
                <?php
                foreach($rubric->level_array as $i => $rubric_item):
                    if($rubric->id){
                        $rating = round(($rubric->level_increment*($i+1))*10);
                    } else {
                        $rating = round(($i + 1) * (1 / $total) * 10 * 10, 1) / 10;
                    }
                ?>
                    <div class="col-md-3 col-xs-6 rubric-item" style="background: rgb(236, 247, 252);border-radius: 4px;">
                        <div style="padding: 5px;font-size:13px;"><?php echo $rubric_item;?></div>
                        <div  class="margin-bottom-5 text-left" style="background: #fff;padding: 0 5px;">
                            <div class="fa-stack fa-lg green" style="position: absolute;bottom: 3px;right: 3px;display: none;">
                                <i class="fa fa-circle fa-stack-2x"></i>
                                <span class="fa-stack-1x fa-inverse"><?php echo $rating;?></span>
                            </div>
                            <strong class="blue rubric-rating pull-right"><?php echo $rating;?></strong>
                            <small>Puntuación </small>
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