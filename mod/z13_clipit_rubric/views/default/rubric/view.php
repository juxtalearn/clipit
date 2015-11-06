<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   27/11/2014
 * Last update:     27/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$rubric = elgg_extract('entity', $vars);
$rubric_items = ClipitRubricItem::get_by_id($rubric->rubric_item_array, 0, 0, 'time_created', false);
$user = array_pop(ClipitUser::get_by_id(array($rubric->owner_id)));
?>
<style>
@media print {
    #rubric-items {
        max-height: 100% !important;
    }
}
</style>
<div class="pull-right">
    <div class="inline-block">
        <?php echo elgg_view('page/components/admin_options', array(
            'entity' => $rubric,
            'user' => $user
        ));
        ?>
    </div>
    <span class="margin-left-10">
        <?php echo elgg_view("page/components/print_button");?>
    </span>
</div>
<div class="inline-block">
    <small class="show"><?php echo elgg_echo('author');?></small>
    <i class="fa-user fa blue"></i>
    <?php echo elgg_view('output/url', array(
        'href'  => "profile/{$user->login}",
        'title' => $user->name,
        'text'  => $user->name,
    ));
    ?>
</div>
<div class="clearfix"></div>
<hr>
<div id="rubric-items" style="overflow-y: auto;overflow-x: hidden;max-height: 450px;">
    <?php echo elgg_view('rubric/items', array('entities' => $rubric_items));?>
</div>