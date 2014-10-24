<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   09/10/2014
 * Last update:     09/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$user = elgg_extract('entity', $vars);
$metrics = elgg_extract('metrics', $vars);
var_dump(ActivityStreamer::get_available_metrics());
?>
<script>
$(function(){
    elgg.get('ajax/view/metrics/metric', {
        data: {
            metrics: <?php echo json_encode($metrics);?>
        },
        success: function(data){
           if($(".metric").length > 0) {
               $(".metrics").append(data);
           } else {
               $(".metrics").html(data);
           }
       }
    });
});
</script>
<div class="row metrics">
    <div style="height: 245px" class="wrapper separator loading-block">
        <div>
            <i class="fa fa-spinner fa-spin blue-lighter"></i>
            <h3 class="blue-lighter"><?php echo elgg_echo('loading');?>...</h3>
        </div>
    </div>
</div>