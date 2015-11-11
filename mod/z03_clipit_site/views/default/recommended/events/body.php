<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   29/05/14
 * Last update:     29/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity = elgg_extract('entity', $vars);
$description = trim(elgg_strip_tags($entity->description));
// text truncate max length 180
if(mb_strlen($description)>180){
    $description = substr($description, 0, 180)."...";
}
?>
<?php if($vars['image']): ?>
    <div class="icon image-block multimedia-preview">
        <?php echo $vars['image'];?>
    </div>
<?php endif; ?>
<div class="content-block">
    <?php if($entity->name): ?>
    <div class="title">
        <strong>
        <?php echo elgg_view('output/url', array(
            'href'  => $vars['href'],
            'title' => $entity->name,
            'text'  => $entity->name,
        ));
        ?>
        </strong>
    </div>
    <?php endif; ?>
    <div class="description">
        <?php if($description): ?>
            <?php echo $description;?>
        <?php endif; ?>
    </div>
</div>