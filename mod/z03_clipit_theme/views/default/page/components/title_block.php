<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   26/05/14
 * Last update:     26/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$title = elgg_extract('title', $vars, '');
$secondary_text = elgg_extract('secondary_text', $vars, '');
?>
<h3 class="title-block">
    <?php echo $title; ?>
    <?php if($secondary_text): ?>
    <span class="pull-right blue-lighter"><?php echo $secondary_text; ?></span>
    <?php endif; ?>
</h3>