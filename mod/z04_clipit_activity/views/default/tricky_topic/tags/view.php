<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/06/14
 * Last update:     24/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$tags = elgg_extract('tags', $vars);
$limit = $vars['limit'] ? $vars['limit'] : count($tags);
$width = elgg_extract('width', $vars);
if($width){
    $width = "max-width:{$width}px;";
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
    <?php if(count($tags) > 2 && $vars['limit']): ?>
        <a class="more-tags fa fa-plus"></a>
    <?php endif; ?>
</div>
<?php endif; ?>
