<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   7/07/14
 * Last update:     7/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
<style>
    .step-point{
        background-color: #32b4e5;
        color: #fff;
        width: 25px;
        display: inline-block;
        height: 25px;
        text-align: center;
        border-radius: 100px;
        line-height: 25px;
        margin-right: 10px;
        font-weight: bold;
    }
    .step-list{
        font-size: 16px;
    }
</style>
<div id="step_0" class="row step">
    <div class="col-md-12 margin-top-20">
        <p class="margin-bottom-20"><?php echo elgg_echo('activity:create:info:title');?>:</p>
    <div class="col-md-6">
        <ul class="step-list">
            <li class="list-item"><span class="step-point">1</span> <?php echo elgg_echo('activity:create:info:step:1');?></li>
            <li class="list-item"><span class="step-point">2</span> <?php echo elgg_echo('activity:create:info:step:2');?></li>
            <li class="list-item"><span class="step-point">3</span> <?php echo elgg_echo('activity:create:info:step:3');?> (*)</li>
            <li class="list-item"><span class="step-point">4</span> <?php echo elgg_echo('activity:create:info:step:4');?></li>
        </ul>
    </div>
    <div class="col-md-6 text-muted">
        <div class="pull-left margin-right-10">(*)</div>
        <div class="content-block">
            <?php echo elgg_echo('activity:create:info:step:3:details');?>
        </div>
    </div>
    </div>
    <div class="col-md-12 text-right margin-top-20">
        <hr>
        <?php echo elgg_view('input/button', array(
                'value' => elgg_echo('next'),
                'data-step' => 1,
                'id' => 'next_step',
                'class' => "btn btn-primary button_step",
            ));
        ?>
    </div>
</div>