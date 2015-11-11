<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/06/14
 * Last update:     23/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$search_term = get_input('text');
?>
<form method="GET">
    <input type="text" name="text" value="<?php echo isset($search_term) ? $search_term : "";?>" class="elgg-input-text form-control">
    <input type="hidden" value="all" name="by">
    <div class="text-right">
        <input type="submit" class="btn btn-default btn-xs" style="margin-top: 10px;" value="Submit">
    </div>
</form>