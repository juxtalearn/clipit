<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   10/07/14
 * Last update:     10/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
<h3 class="title-block"><?php echo elgg_echo('activity:grouping_mode');?></h3>
<div class="panel-group" id="accordion_grouping">
    <div class="panel panel-default">
        <div class="panel-heading" style="background: #fff;">
            <h4 class="panel-title blue select-radio" data-toggle="collapse" data-parent="#accordion_grouping" href="#collapse_1">
            <input class="margin-right-5" value="1" type="radio" required name="groups_creation"/>
                <a href="javascript:;">
                    <i class="fa fa-user"></i>
                    Teacher make groups
                </a>
            </h4>
        </div>
        <div id="collapse_1" class="panel-collapse collapse">
            <div class="panel-body">
                Anim pariatur cliche reprehenderit,
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading" style="background: #fff;">
            <h4 class="panel-title blue select-radio" data-toggle="collapse" data-parent="#accordion_grouping" href="#collapse_2">
                <input class="margin-right-5" value="2" type="radio" required name="groups_creation"/>
                <a href="javascript:;">
                    <i class="fa fa-users"></i>
                    Students make groups
                </a>
            </h4>
        </div>
        <div id="collapse_2" class="panel-collapse collapse">
            <div class="panel-body">
                <?php echo elgg_view("activity/create/groups/limit");?>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading" style="background: #fff;">
            <h4 class="panel-title blue select-radio" data-toggle="collapse" data-parent="#accordion_grouping" href="#collapse_3">
                <input class="margin-right-5" value="3" type="radio" required name="groups_creation"/>
                <a href="javascript:;">
                    <i class="fa fa-users"></i>
                    Create random groups
                </a>
            </h4>
        </div>
        <div id="collapse_3" class="panel-collapse collapse">
            <div class="panel-body form-group">
                <?php echo elgg_view("activity/create/groups/limit");?>
            </div>
        </div>
    </div>
</div>