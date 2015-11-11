<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   14/05/14
 * Last update:     14/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$tags = elgg_extract("tags", $vars);
$tricky_topic_id = elgg_extract("tt", $vars);
$tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($tricky_topic_id)));
?>
<div class="tags-block">
    <?php echo elgg_view("page/components/modal_remote", array('id'=> "tricky-topic-{$tricky_topic->id}" ));?>
    <h3>
        <?php
        echo elgg_view('output/url', array(
            'href'  => "ajax/view/modal/tricky_topic/view?id={$tricky_topic->id}",
            'text'  => $tricky_topic->name,
            'data-toggle'   => 'modal',
            'data-target'   => '#tricky-topic-'.$tricky_topic->id
        ));
        ?>
    </h3>
    <ul class="tags-list">
        <?php
        foreach($tags as $tag_id):
            $tag = array_pop(ClipitTag::get_by_id(array($tag_id)));
            ?>
            <li>
                <strong>
                <?php echo elgg_view('output/url', array(
                    'href' => "explore/search?by=tag&id={$tag->id}",
                    'text' => $tag->name,
                    'title' => $tag->name,
                    'is_trusted' => true,
                ));
                ?>
                </strong>
            </li>
        <?php endforeach;?>
    </ul>
</div>