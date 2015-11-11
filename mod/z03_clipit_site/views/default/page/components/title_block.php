<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   26/05/14
 * Last update:     26/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$title = elgg_extract('title', $vars, '');
$secondary_text = elgg_extract('secondary_text', $vars, '');
$badge_text = elgg_extract('badge_text', $vars, '');
?>
<h3 class="title-block">
    <?php echo $title; ?>
    <?php if($secondary_text): ?>
    <span class="pull-right blue-lighter"><?php echo $secondary_text; ?></span>
    <?php elseif($badge_text): //at the moment mutual exclusive with secondary texts!?>
    <span class="badge" style="font-size: xx-small;font-weight:normal;vertical-align: top;"><?php echo $badge_text; ?></span>
    <?php endif; ?>
</h3>
