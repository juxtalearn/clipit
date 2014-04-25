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
$items = $vars['item'];
if ($item_class = $vars['item_class']) {
    $item_class = "$item_class row";
}
?>

<?php foreach($items as $item): ?>
<td class="<?php echo $item_class; ?>">
    <?php echo $item; ?>
</td>
<?php endforeach; ?>