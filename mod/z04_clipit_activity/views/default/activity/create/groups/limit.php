<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   11/07/14
 * Last update:     11/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>

<div class="row form-group margin-top-15">
    <div class="col-md-7">
        <label>Max students per group</label>
    </div>
    <div class="col-md-5">
        <?php echo elgg_view("input/text", array(
            'name' => 'max-users',
            'class' => 'form-control',
            'required' => true,
            'placeholder' => '0',
        ));
        ?>
    </div>
</div>