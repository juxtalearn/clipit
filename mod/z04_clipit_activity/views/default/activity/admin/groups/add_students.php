<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   01/10/2014
 * Last update:     01/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$activity = elgg_extract('entity', $vars);
?>
<div class="dropdown">
    <span id="drop4" class="btn btn-xs btn-border-blue btn-primary" role="button" data-toggle="dropdown" href="#">
        <?php echo elgg_echo('students:add');?> <i class="caret"></i>
    </span>
    <ul id="menu1" class="dropdown-menu" role="menu" aria-labelledby="drop4">
        <li role="presentation">
            <a role="menuitem" tabindex="-1" data-toggle="create-users" class="option-select" href="javascript:;">
                <i class="fa fa-user"></i> <?php echo elgg_echo('users:create');?>
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
<div class="option-content margin-top-10 overflow-hidden" id="create-users" style="display: none;background: #fafafa;padding: 10px;">
    <div class="add-user-list">
        <?php echo elgg_view('user/add');?>
        <?php echo elgg_view("input/hidden", array(
            'name' => 'activity_id',
            'value' => $activity->id,
        ));
        ?>
        <?php echo elgg_view("input/hidden", array(
            'name' => 'act',
            'value' => 'create',
        ));
        ?>
        <?php echo elgg_view("input/hidden", array(
            'name' => 'role',
            'value' => 'student',
        ));
        ?>
    </div>
    <div class="col-md-12 margin-top-5 margin-bottom-5">
        <?php
        echo elgg_view('input/button', array(
            'value' => elgg_echo('create'),
            'class' => "submit-add-students btn btn-primary btn-sm pull-right",
        ));
        ?>
        <strong>
            <?php echo elgg_view('output/url', array(
                'href'  => "javascript:;",
                'id' => 'add_user',
                'title' => elgg_echo('user:add'),
                'text'  => '<i class="fa fa-plus"></i> '.elgg_echo('user:add'),
            ));
            ?>
        </strong>
    </div>
</div>
<div class="option-content margin-top-10" id="site" style="display: none;background: #fafafa;padding: 10px;">
    <?php echo elgg_view("input/text", array(
        'id' => 'search-users',
        'class' => 'form-control',
        'placeholder' => elgg_echo('filter')."...",
    ));
    ?>
    <ul class="margin-top-10 site-users" style="max-height: 200px;overflow-y: auto;background: #fff;"></ul>
</div>
<div class="option-content margin-top-10" id="file" style="display: none;background: #fafafa;padding: 10px;">
    <a class="pull-right" href="<?php echo elgg_get_site_url();?>mod/z04_clipit_activity/vendors/templates/clipit_users.xlsx" target="_blank">
        <i class="fa fa-file-excel-o green"></i>
        <strong><?php echo elgg_echo('called:students:excel_template');?></strong>
    </a>
    <div class="btn btn-sm btn-primary fileinput-button inline-block" id="insert-site">
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