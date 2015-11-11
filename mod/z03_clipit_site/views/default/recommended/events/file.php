<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   30/05/14
 * Last update:     30/05/14
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
    <div class="title">
        <?php echo elgg_view('output/url', array(
            'href'  => 'file/download/'.$entity->id,
            'title' => elgg_echo('download').": ".$entity->name,
            'class' => 'btn btn-primary btn-xs pull-right',
            'text'  => '<i class="fa fa-download"></i>',
        ));
        ?>
        <strong>
            <?php echo elgg_view('output/url', array(
                'href'  => $vars['href'],
                'title' => $entity->name,
                'text'  => $entity->name,
            ));
            ?>
        </strong>
    </div>
    <small class="description">
        <?php if($description): ?>
            <?php echo $description;?>
        <?php endif; ?>
    </small>
</div>
