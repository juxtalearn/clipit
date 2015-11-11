<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   30/07/14
 * Last update:     30/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
?>
<div class="add-user row">
    <div class="col-md-1">
        <i class="fa fa-times red image-block" style="cursor: pointer" onclick="javascript:$(this).closest('.add-user').remove();"></i>
    </div>
    <div class="col-md-11">
        <div class="col-md-12 form-group">
            <label for="activity-title"><?php echo elgg_echo("user:username");?></label>
            <?php echo elgg_view("input/text", array(
                'name' => 'user-name[]',
                'class' => 'form-control',
            ));
            ?>
        </div>
        <div class="form-group col-md-6">
            <label for="activity-title"><?php echo elgg_echo("user:log_in");?></label>
            <?php echo elgg_view("input/text", array(
                'name' => 'user-login[]',
                'class' => 'form-control',
            ));
            ?>
        </div>
        <div class="form-group col-md-6">
            <label for="activity-title"><?php echo elgg_echo("user:password");?></label>
            <?php echo elgg_view("input/password", array(
                'name' => 'user-password[]',
                'class' => 'form-control',
            ));
            ?>
        </div>
        <div class="form-group col-md-12">
            <label for="user-email"><?php echo elgg_echo("user:email");?></label>
            <?php echo elgg_view("input/text", array(
                'name' => 'user-email[]',
                'class' => 'form-control',
            ));
            ?>
        </div>
    </div>
</div>
