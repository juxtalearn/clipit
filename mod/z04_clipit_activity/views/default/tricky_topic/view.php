<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   2/06/14
 * Last update:     2/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity = elgg_extract('entity', $vars);
$tags = $entity->tag_array;
?>
<script src="<?php echo elgg_get_site_url() . "mod/z04_clipit_activity/vendors/jquery.jOrgChart.js";?>"></script>
<script>
    $("#org").jOrgChart({
        chartElement : '#chart',
        dragAndDrop  : false
    });
</script>
<ul id="org" style="display:none">
    <li>
        <strong><?php echo $entity->name; ?></strong>
        <ul>
            <?php
            foreach($tags as $tag_id):
            $tag = array_pop(ClipitTag::get_by_id(array($tag_id)));
            ?>
            <li id="<?php echo $tag->id; ?>">
                <strong>
                <?php echo elgg_view('output/url', array(
                    'href'  => "explore/search?by=tag&id=".$tag->id,
                    'title' => $tag->name,
                    'text'  => $tag->name));
                ?>
                </strong>
            </li>
            <?php endforeach; ?>
        </ul>
    </li>
</ul>
<div id="chart" class="orgChart"></div>