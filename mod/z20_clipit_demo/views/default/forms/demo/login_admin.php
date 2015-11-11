<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   05/03/2015
 * Last update:     05/03/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
?>
<div>
    <div>
        <label><?php echo elgg_echo('loginusername'); ?></label>
        <?php echo elgg_view('input/text', array(
            'name' => 'username',
            'class' => 'form-control input-lg',
        ));
        ?>
    </div>
    <div>
        <label><?php echo elgg_echo('password'); ?></label>
        <?php echo elgg_view('input/password',
            array(
                'name' => 'password',
                'class' => 'form-control input-lg'
            ));
        ?>
    </div>
    <div>
        <label style="margin: 10px 0px 0px">
            <input type="checkbox" name="persistent" value="true" />
            <?php echo elgg_echo('user:persistent'); ?>
        </label>
    </div>
    <?php echo elgg_view('login/extend', $vars); ?>
    <div class="elgg-foot">
        <?php echo elgg_view('input/submit', array('value' => elgg_echo('login'), 'class'=>'btn btn-primary btn-lg')); ?>

        <?php
        if (isset($vars['returntoreferer'])) {
            echo elgg_view('input/hidden', array('name' => 'returntoreferer', 'value' => 'true'));
        }
        ?>

    </div>
</div>