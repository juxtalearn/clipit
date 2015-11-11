<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   03/07/2015
 * Last update:     03/07/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$tag = elgg_extract('tag', $vars);
$tag_rating = elgg_extract('rating_tag', $vars);

if($tag_rating < 0.3){
    $icon = 'fa-frown-o red';
}
if($tag_rating >= 0.75){
    $icon = 'fa-smile-o green';
}
?>
<div style="border-bottom: 1px solid #bae6f6;padding-bottom: 5px;margin-bottom: 5px;">
    <?php if($tag_rating !== null && $icon):?>
        <i class="fa <?php echo $icon;?> pull-right" style="margin-top: 4px;"></i>
    <?php endif;?>
    <?php echo elgg_view('output/url', array(
        'href' => "explore/search?by=tag&id={$tag->id}",
        'text' => $tag->name,
        'title' => $tag->name,
        'class' => 'text-truncate',
        'is_trusted' => true,
    ));
    ?>
</div>