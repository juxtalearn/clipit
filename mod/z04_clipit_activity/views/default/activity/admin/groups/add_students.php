<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   01/10/2014
 * Last update:     01/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity = elgg_extract('entity', $vars);
?>
<script>
    $(function(){
        $("#get-users").click(function(){
            var data_role = $(this).data("role"),
               data_activity = $(this).data("activity");
            $("#site ul").html($("<i class='fa fa-spinner fa-spin blue'/>"));
            elgg.action('activity/admin/users', {
                data: {act: "get_users", role: data_role, activity_id: data_activity},
                success: function(data){
                    $("#site ul").html(data.output);
                }
            });
        });
    });
</script>
<div class="dropdown">
    <span id="drop4" class="btn btn-xs btn-border-blue btn-primary" role="button" data-toggle="dropdown" href="#">Add teachers <i class="caret"></i></span>
    <ul id="menu1" class="dropdown-menu" role="menu" aria-labelledby="drop4">
        <li role="presentation">
            <a role="menuitem" tabindex="-1" data-toggle="create" class="option-select" href="javascript:;">
                <i class="fa fa-user"></i> Create users
            </a>
        </li>
        <li role="presentation">
            <a role="menuitem" tabindex="-1" data-toggle="site" id="get-users" data-activity="<?php echo $activity->id;?>" data-role="student" class="option-select" href="javascript:;">
                <i class="fa fa-globe"></i> <?php echo elgg_echo('called:students:add_from_site');?>
            </a>
        </li>
        <li role="presentation">
            <a role="menuitem" tabindex="-1" data-toggle="file" class="option-select" href="javascript:;">
                <i class="fa fa-upload"></i> <?php echo elgg_echo('called:students:add_from_excel');?>
            </a>
        </li>
    </ul>
</div>
<div class="option-content margin-top-10" id="site" style="display: none;background: #fafafa;padding: 10px;">
    <ul class="margin-top-10 site-users" style="max-height: 200px;overflow-y: auto;background: #fff;"></ul>
</div>
<div class="option-content margin-top-10" id="file" style="display: none;background: #fafafa;padding: 10px;">
    <a class="pull-right" href="<?php echo elgg_get_site_url();?>mod/z04_clipit_activity/vendors/templates/clipit_users.xlsx" target="_blank">
        <i class="fa fa-file-excel-o green"></i>
        <strong><?php echo elgg_echo('called:students:excel_template');?></strong>
    </a>
    <div class="blue fileinput-button inline-block" id="insert-site">
        <i class="fa fa-upload"></i>
        <?php echo elgg_echo('upload');?>
        <?php echo elgg_view("input/file", array(
            'name' => 'upload-users',
            'class' => 'upload-users',
            'id' => 'upload-users',
        ));
        ?>
    </div>
    <div>
        <a class="upload-messages"></a>
    </div>
</div>