<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   9/05/14
 * Last update:     9/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$rows = elgg_extract("rows", $vars);
$table_class = "table table-advance table-hover";
if($vars['class']){
    $table_class = "$table_class ".$vars['class'];
}
?>
<table class="<?php echo $table_class; ?>">
    <?php
        foreach($rows as $row):
            $cells = $row['content'];
            unset($row['content']);
    ?>
        <tr <?php echo elgg_format_attributes($row); ?>>
            <?php
            foreach($cells as $cell):
                $content = $cell['content'];
                unset($cell['content']);
            ?>
                <td <?php echo elgg_format_attributes($cell); ?>>
                    <?php echo $content; ?>
                </td>
            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>
</table>
