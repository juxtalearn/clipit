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
<link rel="stylesheet" href="http://dl.dropboxusercontent.com/u/4151695/html/jOrgChart/example/css/jquery.jOrgChart.css"/>
<script src="<?php echo elgg_get_site_url() . "mod/z04_clipit_activity/vendors/jquery.jOrgChart.js";?>"></script>
<script>
    $("#org").jOrgChart({
        chartElement : '#chart',
        dragAndDrop  : false
    });
</script>
<style>
.jOrgChart .down{
    background-color: #bae6f6;
}
.jOrgChart .left {
    border-right: 2px solid #bae6f6;
}
.jOrgChart .right {
    border-left: 2px solid #bae6f6;
}
.jOrgChart .top {
    border-top: 3px solid #bae6f6;
}
.jOrgChart table{
    width: 100%;
}
.jOrgChart .node {
    background-color: #fff;
    width: auto;
    height: auto;
    color: #32b4e5;
    border: 1px solid #32b4e5;
    padding: 10px;
    border-radius: 3px;
}
</style>
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