<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   11/07/14
 * Last update:     11/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
?>

<div class="row form-group margin-top-15">
    <div class="col-md-7">
        <label><?php echo elgg_echo('group:max_size');?></label>
    </div>
    <div class="col-md-5">
        <?php echo elgg_view("input/text", array(
            'name' => $vars['name'],
            'class' => 'form-control',
            'required' => true,
            'placeholder' => '0',
            'aria-label' => $vars['name'],
            'data-rule-number' => true
        ));
        ?>
    </div>
</div>