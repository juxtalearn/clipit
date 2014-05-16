<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   14/05/14
 * Last update:     14/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
<style>
.input-radios-horizontal{
    margin-bottom: 0;
}
.fa-star.empty{
    color: #bae6f6;
}
</style>
<div class="row">
    <div class="col-md-6">
        <span class="show">
            Does this video help you to understand Tricky Topic?
        </span>
        <?php echo elgg_view('input/radio', array(
            'name' => 'tricky-understand',
            'options' => array(elgg_echo("input:yes"), elgg_echo("input:no")),
            'class' => 'input-radios-horizontal blue',
        )); ?>
        <span class="show">
            Check topics covered in this video, and explain why:
        </span>
        <div style="margin-top: 5px;">
            <label style="display: inline-block">Trabajo y potencia</label>
            <?php echo elgg_view('input/radio', array(
                'name' => "admin",
                'options' => array(elgg_echo("input:yes"), elgg_echo("input:no")),
                'class' => 'input-radios-horizontal blue pull-right',
            )); ?>
        </div>
        <?php echo elgg_view("input/plaintext", array(
                'name'  => 'file-description',
                'class' => 'form-control',
                'placeholder' => 'Why is/isn\'t this SB correctly covered?',
                'required' => true,
                'rows'  => 1,
            ));
        ?>
        <div style="margin-top: 5px;">
        <label style="display: inline-block">Cinética</label>
        <?php echo elgg_view('input/radio', array(
            'name' => "admin",
            'options' => array(elgg_echo("input:yes"), elgg_echo("input:no")),
            'class' => 'input-radios-horizontal blue pull-right',
        )); ?>
        <?php echo elgg_view("input/plaintext", array(
            'name'  => 'file-description',
            'class' => 'form-control',
            'placeholder' => 'Why is/isn\'t this SB correctly covered?',
            'required' => true,
            'rows'  => 1,
        ));
        ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="pull-right">
            <h4>
                <strong>My rating</strong>
            </h4>
            <div>
                <div class="rating" style="color: #e7d333;float: right;font-size: 18px;;margin: 0 10px;">
                    <i class="fa fa-star empty"></i>
                    <i class="fa fa-star empty"></i>
                    <i class="fa fa-star empty"></i>
                    <i class="fa fa-star empty"></i>
                    <i class="fa fa-star empty"></i>
                </div>
                <span class="text-truncate">Innovation</span>
            </div>
            <div>
                <div class="rating" style="color: #e7d333;float: right;font-size: 18px;;margin: 0 10px;">
                    <i class="fa fa-star empty"></i>
                    <i class="fa fa-star empty"></i>
                    <i class="fa fa-star empty"></i>
                    <i class="fa fa-star empty"></i>
                    <i class="fa fa-star empty"></i>
                </div>
                <span class="text-truncate">Design</span>
            </div>
            <div>
                <div class="rating" style="color: #e7d333;float: right;font-size: 18px;margin: 0 10px;">
                    <i class="fa fa-star empty"></i>
                    <i class="fa fa-star empty"></i>
                    <i class="fa fa-star empty"></i>
                    <i class="fa fa-star empty"></i>
                    <i class="fa fa-star empty"></i>
                </div>
                <span class="text-truncate">Learning</span>
            </div>
        </div>
    </div>
</div>