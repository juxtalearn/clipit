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
?>
<script>
$(function(){
    var $content = $("#metric"),
        metric_id = $content.data("metric");
        timeout = 3000;
    var get_metric = function(){
        elgg.get('ajax/view/metrics/get_metric',{
            data: {
                metric: metric_id
            },
            success: function(data){
//                if(data) {
//                    $content.html(data);
//                } else {
//                    setInterval(get_metric, timeout);
//                }
                if(data) {
                    clearInterval(refreshAjaxCall);
                    $content.html(data);
                }
            }
        });
    }
//    get_metric();
    var refreshAjaxCall =  setInterval(get_metric, timeout);
});
</script>
<?php
/*
$context['actor_id'] -> Integer
$context['object_id'] -> Integer
$context['group_id'] -> Integer
$context['activity_id'] -> Integer
$context['verb'] -> String (currently: "added", "annotate", "create", "createUser", "login", "logout", "remove", "upload")
$context['role'] -> String ("student" or "teacher")

$context['lowerbound'] -> Integer
$context['upperbound'] -> Integer
*/
$metric_id = elgg_extract('metric_id', $vars);
$context = array(
    'actor_id' => 0,
    'object_id' => 0,
    'group_id' => 0,
    'activity_id' => 0,
    'verb' => '',
    'role' => $user->role,
    'lowerbound' => 0,
    'upperbound' => 0,
);
$context = array(
    'activity_id' => 478
);
$metric = ClipitLA::get_metric($metric_id, $context);
var_dump($metric);
?>
<div id="metric" class="frame-container" data-metric="<?php echo $metric;?>">
    <?php echo elgg_view('page/components/loading_block', array('height' => '245px', 'text' => elgg_echo('loading:charts')));?>
</div>
