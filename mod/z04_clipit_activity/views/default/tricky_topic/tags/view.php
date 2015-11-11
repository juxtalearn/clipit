<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/06/14
 * Last update:     24/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$tags = elgg_extract('tags', $vars);
$tags_rating = elgg_extract('tags_rating', $vars);

$limit = $vars['limit'] ? $vars['limit'] : count($tags);
$width = elgg_extract('width', $vars);
$width = is_integer($width) ? $width."px" : $width;
if($width){
    $width = "max-width:{$width}";
}
?>
<?php if($tags):?>
<div class="tags">
    <?php
    foreach(array_slice($tags, 0, $limit) as $tag_id):
        $tag = array_pop(ClipitTag::get_by_id(array($tag_id)));
    ?>
        <?php echo elgg_view('output/url', array(
            'href' => "explore/search?by=tag&id={$tag->id}",
            'text' => $tag->name,
            'class' => 'label label-primary',
            'style' => $width,
            'title' => $tag->name,
            'is_trusted' => true,
        ));
        ?>
    <?php endforeach;?>
    <?php if(count($tags) > $limit ): ?>
        <a href="javascript:;" style="vertical-align: bottom;" data-toggle="popover" class="more-tags fa fa-ellipsis-h" rel="popover" data-placement="bottom"></a>
        <div id="popover_content_wrapper" class="popover-content popover_content_wrapper tags" style="display: none">
            <?php echo elgg_view('tricky_topic/tags/view', array('tags' => array_slice($tags, $limit, count($tags)), 'limit' => count($tags)));?>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>
