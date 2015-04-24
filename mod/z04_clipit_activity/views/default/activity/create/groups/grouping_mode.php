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
<?php echo elgg_view("page/components/title_block", array(
    'title' => elgg_echo('activity:grouping_mode'),
));?>
<label for="groups_creation"></label>
<div class="clearfix"></div>
<div class="panel-group" id="accordion_grouping">
    <div class="panel panel-default">
        <div class="panel-heading bg-white cursor-pointer">
            <h4 class="panel-title blue select-radio" data-toggle="collapse" data-parent="#accordion_grouping" href="#collapse_1">
            <input value="1" style="visibility: hidden" type="radio" required name="groups_creation"/>
                <a href="javascript:;" class="child-decoration-none">
                    <i class="fa fa-user"></i>
                    <?php echo elgg_echo('activity:grouping_mode:teacher'); ?>
                </a>
            </h4>
        </div>
        <div id="collapse_1" class="panel-collapse collapse">
            <div class="panel-body">
                <?php echo elgg_echo('activity:grouping_mode:teacher:desc');?>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading bg-white cursor-pointer">
            <h4 class="panel-title blue select-radio" data-toggle="collapse" data-parent="#accordion_grouping" href="#collapse_2">
                <input value="2" style="visibility: hidden" type="radio" required name="groups_creation"/>
                <a href="javascript:;" class="child-decoration-none">
                    <i class="fa fa-users"></i>
                    <?php echo elgg_echo('activity:grouping_mode:student'); ?>
                </a>
            </h4>
        </div>
        <div id="collapse_2" class="panel-collapse collapse">
            <div class="panel-body">
                <?php echo elgg_view("activity/create/groups/limit", array('name' => 'max-users[2]'));?>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading bg-white cursor-pointer">
            <h4 class="panel-title blue select-radio" data-toggle="collapse" data-parent="#accordion_grouping" href="#collapse_3">
                <input value="3" style="visibility: hidden" type="radio" required name="groups_creation"/>
                <a href="javascript:;" class="child-decoration-none">
                    <i class="fa fa-users"></i>
                    <?php echo elgg_echo('activity:grouping_mode:system'); ?>
                </a>
            </h4>
        </div>
        <div id="collapse_3" class="panel-collapse collapse">
            <div class="panel-body form-group">
                <?php echo elgg_view("activity/create/groups/limit", array('name' => 'max-users[3]'));?>
            </div>
        </div>
    </div>
</div>