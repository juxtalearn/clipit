<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/04/14
 * Last update:     24/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$messages = elgg_extract('entity', $vars);
?>
<table class="messages-table table table-advance table-hover">
    <?php foreach($messages as $message): ?>
        <tr>
            <?php echo elgg_view("messages/list/item", array('entity' => $message)); ?>
        </tr>
    <?php endforeach; ?>
</table>