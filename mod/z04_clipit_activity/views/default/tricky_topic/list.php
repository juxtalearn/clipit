<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   7/07/14
 * Last update:     7/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$tricky_topic_id = get_input('tricky_topic');
if($from_view = elgg_extract('tricky_topic', $vars)){
    $tricky_topic_id = $from_view;
}
$tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($tricky_topic_id)));
?>
<div class="col-md-12" style="padding:5px;">
    <h4>
        <?php echo elgg_view('output/url', array(
            'href'  => "explore/search?by=tricky_topic&id={$tricky_topic->id}",
            'target' => '_blank',
            'title' => $tricky_topic->name,
            'text'  => $tricky_topic->name,
        ));
        ?>
    </h4>
    <hr class="margin-0">
    <small class="show margin-top-5"><?php echo elgg_echo("tags");?></small>
</div>
<?php
foreach($tricky_topic->tag_array as $tag_id):
    $tag = array_pop(ClipitTag::get_by_id(array($tag_id)));
?>
<div class="col-md-4 text-truncate" style="padding:5px;">
    <?php echo elgg_view('output/url', array(
        'href'  => "explore/search?by=tag&id={$tag->id}",
        'target' => '_blank',
        'title' => $tag->name,
        'text'  => $tag->name,
    ));
    ?>
</div>
<?php endforeach;?>