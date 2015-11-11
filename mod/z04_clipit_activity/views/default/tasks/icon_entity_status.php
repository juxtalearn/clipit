<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   25/07/14
 * Last update:     25/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$status = elgg_extract('status', $vars);
?>
<?php if($status):?>
    <i class="fa fa-check green"></i>
<?php else: ?>
    <i class="fa fa-times red"></i>
<?php endif;?>