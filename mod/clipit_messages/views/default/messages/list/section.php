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
$items = elgg_extract('items', $vars);
if ($items_class = $vars['items_class']) {
    $items_class = "$items_class row";
}
?>
<table class="messages-table table table-advance table-hover">
    <?php foreach($items as $item): ?>
        <tr class="<?php echo $item_class; ?>">
            <?php echo elgg_view("messages/list/item", array('item' => $item)); ?>
        </tr>
    <?php endforeach; ?>
</table>