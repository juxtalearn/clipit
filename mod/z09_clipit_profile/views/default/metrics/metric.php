<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/10/2014
 * Last update:     23/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$metrics = get_input('metrics');
?>
<?php
foreach($metrics as $metric):
    $id = uniqid();
    $metric_la = ClipitLA::get_metric((int)$metric['metric_id'], $metric['context']);
?>
<script>
$(function(){
    var $content = $("#metric_<?php echo $id;?>"),
        metric_id = $content.data("metric");
    timeout = 3000;
    var get_metric = function () {
        elgg.get('ajax/view/metrics/get_metric', {
            data: {
                metric: metric_id
            },
            success: function (data) {
//                if(data) {
//                    $content.html(data);
//                } else {
//                    setInterval(get_metric, timeout);
//                }
                if (data) {
                    clearInterval(refreshAjaxCall);
                    $content.html(data);
                }
            }
        });
    }
//    get_metric();
    var refreshAjaxCall = setInterval(get_metric, timeout);
});
</script>
<div class="col-md-6">
    <?php var_dump($metric_la->id);?>
    <div class="frame-container metric" id="metric_<?php echo $id;?>" data-metric="<?php echo $metric_la->id;?>">
        <?php echo elgg_view('page/components/loading_block', array('height' => '245px', 'text' => elgg_echo('loading:charts')));?>
    </div>
</div>
<?php endforeach;?>