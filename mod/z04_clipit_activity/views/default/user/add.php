<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   30/07/14
 * Last update:     30/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$id = uniqid();
?>
<div class="add-user row">
    <div class="col-md-1">
        <i class="fa fa-times red image-block" style="cursor: pointer" onclick="javascript:$(this).closest('.add-user').remove();"></i>
    </div>
    <div class="col-md-12">
        <div class="col-md-12 form-group">
            <label><?php echo elgg_echo("user:username");?></label>
            <?php echo elgg_view("input/text", array(
                'name' => 'user['.$id.'][name]',
                'class' => 'form-control focus-in',
                'required' => true
            ));
            ?>
        </div>
        <div class="form-group col-md-6">
            <label><?php echo elgg_echo("user:log_in");?></label>
            <?php echo elgg_view("input/text", array(
                'name' => 'user['.$id.'][login]',
                'class' => 'form-control',
                'required' => true
            ));
            ?>
        </div>
        <div class="form-group col-md-6">
            <label><?php echo elgg_echo("user:password");?></label>
            <?php echo elgg_view("input/password", array(
                'name' => 'user['.$id.'][password]',
                'class' => 'form-control',
                'required' => true
            ));
            ?>
        </div>
        <div class="form-group col-md-12">
            <label for="user-email"><?php echo elgg_echo("user:email");?></label>
            <?php echo elgg_view("input/text", array(
                'name' => 'user['.$id.'][email]',
                'class' => 'form-control',
            ));
            ?>
        </div>
    </div>
</div>
