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
// text truncate max length 100
if(mb_strlen($description) > 100){
    $description = substr($description, 0, 100)."...";
}
$total_replies = array_pop(ClipitPost::count_by_destination(array($entity->id)))
?>
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
    <div class="description discussion-text">
        <?php if($description): ?>
            <?php echo $description;?>
        <?php endif; ?>
    </div>
    <small class="show">
        <?php echo elgg_view('output/url', array(
            'href'  => $vars['href']."#replies",
            'title' => elgg_echo("reply:total", array($total_replies)),
            'text'  => '<i class="fa fa-comment fa-stack-2x"></i><i class="fa-stack-1x replies-count" style="color:#fff;font-style: normal;">'.$total_replies.'</i>',
            'class' => 'fa-stack'
        ));
        ?>
        <?php echo elgg_view('output/url', array(
            'href'  => $vars['href']."#create_reply",
            'title' => elgg_echo('reply'),
            'text'  => '<i class="fa fa-plus"></i> '.elgg_echo('reply'),
            'class' => 'btn btn-xs btn-primary pull-right'
        ));
        ?>
    </small>
</div>