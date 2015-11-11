<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   8/07/14
 * Last update:     8/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
?>
<div class="add-user">
    <div class="form-group col-md-3">
        <i class="fa fa-times red image-block" style="cursor: pointer" onclick="javascript:$(this).closest('.add-user').remove();"></i>
        <div class="content-block">
            <label for="activity-title"><?php echo elgg_echo("user:username");?></label>
            <?php echo elgg_view("input/text", array(
                'name' => 'user-name[]',
                'class' => 'form-control',
                'required' => true
            ));
            ?>
        </div>
    </div>
    <div class="form-group col-md-3">
        <label for="activity-title"><?php echo elgg_echo("user:log_in");?></label>
        <?php echo elgg_view("input/text", array(
            'name' => 'user-login[]',
            'class' => 'form-control',
            'required' => true
        ));
        ?>
    </div>
    <div class="form-group col-md-3">
        <label for="activity-title"><?php echo elgg_echo("user:password");?></label>
        <?php echo elgg_view("input/password", array(
            'name' => 'user-password[]',
            'class' => 'form-control',
            'required' => true
        ));
        ?>
    </div>
    <div class="form-group col-md-3">
        <label for="user-email"><?php echo elgg_echo("user:email");?></label>
        <?php echo elgg_view("input/text", array(
            'name' => 'user-email[]',
            'class' => 'form-control',
            'required' => true
        ));
        ?>
    </div>
</div>