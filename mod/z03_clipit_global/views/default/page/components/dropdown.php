<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */

$class = "dropdown";
$style = "";
if(isset($vars['style'])){
    $style = 'style="'.$vars['style'].'"';
}
?>
<div name="<?php echo $vars['name']; ?>" <?php echo $style; ?> class="<?php echo $class; ?>">
    <?php echo $vars['button']; ?>
    <ul class="dropdown-menu" role="menu">
        <?php foreach ($vars['options'] as $option): ?>
        <li role="presentation">
            <a <?php echo elgg_format_attributes($option['attr']);?> role="menuitem" tabindex="-1">
            <?php if($option['icon']): ?>
                <i class="fa fa-<?php echo $option['icon'];?>"></i>
            <?php endif; ?>

            <?php echo $option['text'];?>
            </a>
        </li>
        <?php endforeach; ?>
    </ul>
</div>

