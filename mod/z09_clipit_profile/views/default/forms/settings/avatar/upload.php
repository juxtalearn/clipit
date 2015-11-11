<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   20/06/14
 * Last update:     20/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity = elgg_extract('entity', $vars);
?>
<?php echo elgg_view("input/hidden", array('name' => 'user_id', 'value' => $entity->id)); ?>
<p class="bg-info">
    <?php echo elgg_echo('avatar:upload:instructions'); ?>
</p>
<div>
    <label for="avatar"><?php echo elgg_echo("avatar:upload"); ?></label>
    <?php echo elgg_view("input/file", array('name' => 'avatar', 'required' => true)); ?>
</div>
<p style="margin-top: 20px" class="pull-right">
    <?php echo elgg_view('input/submit', array('value' => elgg_echo('upload'), 'class' => 'btn btn-primary')); ?>
</p>
