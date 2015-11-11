<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   02/10/2014
 * Last update:     02/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$activity = elgg_extract('entity', $vars);
?>
<?php echo elgg_view("input/hidden", array(
    'name' => 'activity_id',
    'value' => $activity->id,
));
?>
<div class="dropdown">
    <span id="drop4" class="btn btn-xs btn-border-blue btn-primary" role="button" data-toggle="dropdown" href="#">
        <?php echo elgg_echo('teachers:add');?> <i class="caret"></i>
</span>
<ul id="menu1" class="dropdown-menu" role="menu" aria-labelledby="drop4">
    <li role="presentation">
        <a role="menuitem" tabindex="-1" data-toggle="create" class="option-select" href="javascript:;">
            <i class="fa fa-user"></i> <?php echo elgg_echo('users:create');?>
        </a>
    </li>
    <li role="presentation">
        <a role="menuitem" tabindex="-1" data-toggle="site" id="get-users" data-activity="<?php echo $activity->id;?>" data-role="teacher" class="option-select" href="javascript:;">
            <i class="fa fa-globe"></i> <?php echo elgg_echo('called:students:add_from_site');?>
        </a>
    </li>
</ul>
</div>
<div class="option-content margin-top-10 overflow-hidden" id="create" style="display: none;background: #fafafa;padding: 10px;">
    <div class="add-user-list">
        <?php echo elgg_view('user/add');?>

        <?php echo elgg_view("input/hidden", array(
            'name' => 'act',
            'value' => 'create',
        ));
        ?>
        <?php echo elgg_view("input/hidden", array(
            'name' => 'role',
            'value' => 'teacher',
        ));
        ?>
    </div>
    <div class="col-md-12 margin-top-5 margin-bottom-5">
        <?php
        echo elgg_view('input/button', array(
            'value' => elgg_echo('create'),
            'class' => "submit-create-teachers btn btn-primary btn-sm pull-right",
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
<div class="option-content margin-top-10" id="site" id="get-users" data-activity="<?php echo $activity->id;?>" data-role="teacher" style="display: none;background: #fafafa;padding: 10px;">
    <?php echo elgg_view("input/text", array(
        'id' => 'search-users',
        'class' => 'form-control margin-bottom-20',
        'placeholder' => elgg_echo('filter')."...",
    ));
    ?>
    <select multiple class="form-control" name="select_users[]" style="height: auto !important;"></select>
    <p class="margin-top-10 text-right">
        <?php
        echo elgg_view('input/button', array(
            'value' => elgg_echo('add'),
            'class' => "submit-add-teachers btn btn-primary btn-sm",
        ));
        ?>
    </p>
</div>