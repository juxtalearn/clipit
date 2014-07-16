<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   7/07/14
 * Last update:     7/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
<script>
$(function(){
   datepicker_setup();
});
</script>

<li class="list-item col-md-12 task">
    <?php echo elgg_view('activity/create/task', array('task_type' => 'upload'));?>
    <ul class="feedback_form" style="margin-left: 20px;display: none">
        <li style="padding: 10px;background: #fafafa;" class="col-md-12">
            <div class="col-md-12">
                <h4>Feedback task</h4>
            </div>
            <?php echo elgg_view('activity/create/task', array('task_type' => 'feedback'));?>
        </li>
    </ul>
</li>
