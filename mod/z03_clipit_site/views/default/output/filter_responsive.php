<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   02/06/2015
 * Last update:     02/06/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
<span class="visible-xs visible-sm">
    <i class="fa <?php echo $vars['icon'];?>"></i>
    <?php echo $vars['badge'];?>
</span>
<span class="hidden-xs hidden-sm">
    <?php echo $vars['text'];?> <?php echo $vars['badge'];?>
</span>