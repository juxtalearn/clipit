<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   2/06/14
 * Last update:     2/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
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
            <li id="<?php echo $tag->id; ?>"><strong><?php echo $tag->name; ?></strong></li>
            <?php endforeach; ?>
        </ul>
    </li>
</ul>
<div id="chart" class="orgChart"></div>