<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   14/05/14
 * Last update:     14/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$tags = elgg_extract("tags", $vars);
?>
<div class="tags-block">
    <h3><?php echo elgg_echo("tags");?></h3>
    <ul class="tags-list">
        <?php
        foreach($tags as $tag_id):
            $tag = array_pop(ClipitTag::get_by_id(array($tag_id)));
            ?>
            <li><a href=""><strong><?php echo $tag->name;?></strong></a></li>
        <?php endforeach;?>
    </ul>
</div>