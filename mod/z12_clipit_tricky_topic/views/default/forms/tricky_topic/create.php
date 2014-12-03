<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   03/12/2014
 * Last update:     03/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
<div class="row">
    <div class="col-md-7">
        <div class="form-group">
            <label><?php echo elgg_echo('title');?></label>
            <?php echo elgg_view('input/text', array(
                'class' => 'form-control',
                'name' => 'title'
            ));
            ?>
        </div>
        <div class="form-group">
            <label><?php echo elgg_echo('description');?></label>
            <?php echo elgg_view('input/plaintext', array(
                'class' => 'form-control mceEditor',
                'name' => 'description'
            ));
            ?>
        </div>
    </div>
    <div class="col-md-5">
        <label>
            <?php echo elgg_echo('tags');?>
            <small class="show"><?php echo elgg_echo('tags:commas:separated');?></small>
        </label>
        <div class="form-add-tags form-group margin-top-10">
            <?php echo elgg_view("tricky_topic/add");?>
        </div>
        <?php echo elgg_view('output/url', array(
            'href'  => "javascript:;",
            'class' => 'btn btn-xs btn-primary',
            'title' => elgg_echo('add'),
            'text'  => '<i class="fa fa-plus"></i>' . elgg_echo('add'),
            'id'    => 'add-tag'
        ));
        ?>
    </div>
</div>
<div class="text-right">
    <?php echo elgg_view('input/submit', array('value' => elgg_echo('create'), 'class'=>'btn btn-primary')); ?>
</div>
