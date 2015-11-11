<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/07/14
 * Last update:     23/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$activities = elgg_extract('entities', $vars);
$activity = reset($activities);
?>
<script>
$(function(){
    // Dashboard, load group status by activity
    clipit.loadActivityGroupStatus(<?php echo $activity->id;?>);
});
$(document).ready(function(){

    $("#next").click(function() {
        if ($(".charts .group_activities:visible").next().length != 0){
            $(".charts .group_activities:visible").next().fadeIn(
                function(){
                    clipit.loadActivityGroupStatus($(this).data('entity'));
                }).prev().hide();
        } else {
            $(".charts .group_activities:visible").hide();
            $(".charts .group_activities:first").show();
        }
        $(window).trigger('resize');
        return false;
    });

    $("#prev").click(function(){
        if ($(".charts .group_activities:visible").prev().length != 0) {
            $(".charts .group_activities:visible").prev().fadeIn(
                function () {
                    clipit.loadActivityGroupStatus($(this).data('entity'));
                }).next().hide();
        } else {
            $(".charts .group_activities:visible").hide();
            $(".charts .group_activities:last").fadeIn(
                function(){
                    clipit.loadActivityGroupStatus($(this).data('entity'));
                });
        }
        $(window).trigger('resize');
        return false;
    });
});
</script>
<?php if(count($activities) > 1):?>
    <a href="javascript:;" class="fa fa-chevron-right" id="next"></a>
    <a href="javascript:;" class="fa fa-chevron-left" id="prev"></a>
<?php endif;?>

<div class='charts'>
<?php
$count = 0;
foreach($activities as $activity):
    $show = "block";
    if($count > 0){
        $show = "none";
    }
    ?>
    <div data-entity="<?php echo $activity->id;?>" id="chart_bar_<?php echo $activity->id;?>" class="group_activities separator" style="display: <?php echo $show;?>">
        <h3 style="color: #<?php echo $activity->color;?>;"><?php echo $activity->name;?></h3>
        <div class="chart-js">
            <?php echo elgg_view('page/components/loading_block', array('height' => '200px', 'text' => elgg_echo('loading:charts')));?>
        </div>
    </div>
    <?php
    $count++;
endforeach;
?>
</div>
<style>
.chart-js .separator{
    border: 0;
}
</style>