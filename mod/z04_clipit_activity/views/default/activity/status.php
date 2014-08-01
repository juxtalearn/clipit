<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   30/07/14
 * Last update:     30/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity = elgg_extract('entity', $vars);
$status = get_activity_status($activity->status);
?>
<div class="pull-right white cursor-default" style="background: rgba(255,255,255,0.3);padding: 2px 10px;">
    <strong>
        <i class="fa fa-<?php echo $status['icon'];?>"></i>
        <?php echo $status['text'];?>
    </strong>
</div>