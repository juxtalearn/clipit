<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/06/14
 * Last update:     23/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$tags = elgg_extract('tags', $vars);
?>
<div class="wrapper separator">
    <ul class="tag-cloud">
        <?php foreach($tags as $tag):?>
        <li>
            <?php echo elgg_view('output/url', array(
                'href' => "explore/search?by=tag&id={$tag->id}",
                'text' => $tag->name,
                'is_trusted' => true,
            ));
            ?>
        </li>
        <?php endforeach;?>
    </ul>
</div>