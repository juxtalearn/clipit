<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   02/06/2015
 * Last update:     02/06/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
?>
<span class="visible-xs visible-sm">
    <i class="fa <?php echo $vars['icon'];?>"></i>
    <?php echo $vars['badge'];?>
</span>
<span class="hidden-xs hidden-sm">
    <?php echo $vars['text'];?> <?php echo $vars['badge'];?>
</span>