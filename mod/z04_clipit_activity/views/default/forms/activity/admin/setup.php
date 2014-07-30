<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   18/07/14
 * Last update:     18/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity = elgg_extract('entity', $vars);
$teachers = ClipitActivity::get_teachers($activity->id);
$teachers = ClipitUser::get_by_id($teachers);
?>
<div class="row">
    <?php echo elgg_view("input/hidden", array(
        'name' => 'entity-id',
        'value' => $activity->id,
    ));
    ?>
    <div class="col-md-6">
        <div class="form-group">
            <label for="activity-title"><?php echo elgg_echo("activity:title");?></label>
            <?php echo elgg_view("input/text", array(
                'name' => 'activity-title',
                'class' => 'form-control',
                'value' => $activity->name,
                'required' => true
            ));
            ?>
        </div>
        <div class="form-group margin-top-10">
            <label for="activity-description"><?php echo elgg_echo("activity:description");?></label>
            <?php echo elgg_view("input/plaintext", array(
                'name'  => 'activity-description',
                'class' => 'form-control',
                'value' => $activity->description,
                'required' => true,
                'rows'  => 12,
            ));
            ?>
        </div>
    </div>
    <div class="col-md-6">
        <label><?php echo elgg_echo("tricky_topic");?></label>
        <div style="background: #fafafa;padding: 10px;" class="content-block">
            <?php echo elgg_view('tricky_topic/list', array('tricky_topic' => $activity->tricky_topic));?>
        </div>
        <a name="add_teachers"></a>
        <label class="margin-top-5 margin-bottom-10"><?php echo elgg_echo("activity:teachers");?></label>
        <div>
            <ul>
                <?php foreach($teachers as $teacher):?>
                    <li class="list-item-5">
                        <?php if(elgg_get_logged_in_user_guid() != $teacher->id):?>
                            <?php echo elgg_view('output/url', array(
                                'title' => elgg_echo('delete'),
                                'text' => '<i class="fa fa-trash-o"></i>',
                                'href' => "action/activity/admin/teachers?entity-id={$activity->id}&remove_teacher={$teacher->id}",
                                'is_action' => true,
                                'class' => 'pull-right btn btn-xs btn-danger delete-user',
                            ));
                            ?>
                        <?php endif;?>
                        <?php echo elgg_view('output/img', array(
                            'src' => get_avatar($teacher, 'small'),
                            'class' => 'avatar-tiny margin-right-5'
                        ));
                        ?>
                        <?php echo elgg_view("messages/compose_icon", array('entity' => $teacher));?>
                        <?php echo elgg_view('output/url', array(
                            'title' => $teacher->name,
                            'text' => $teacher->name,
                            'href' => "profile/{$teacher->login}",
                        ));
                        ?>
                    </li>
                <?php endforeach;?>
                <li class="margin-top-10">
                    <div class="dropdown">
                        <span id="drop4" class="btn btn-xs btn-border-blue btn-primary" role="button" data-toggle="dropdown" href="#">Add teachers <i class="caret"></i></span>
                        <ul id="menu1" class="dropdown-menu" role="menu" aria-labelledby="drop4">
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" data-toggle="create" class="option-select" href="javascript:;">
                                    <i class="fa fa-user"></i> Create users
                                </a>
                            </li>
                            <!--
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" data-toggle="site" class="option-select" href="javascript:;">
                                    <i class="fa fa-file-excel-o"></i> <?php echo elgg_echo('called:students:add:from_excel');?>
                                </a>
                            </li>
                            -->
                            <li role="presentation">
                                <a role="menuitem" tabindex="-1" data-toggle="site" class="option-select" href="javascript:;">
                                    <i class="fa fa-globe"></i> Select from site
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="option-content margin-top-10" id="site" style="display: none;background: #fafafa;padding: 10px;">
                        <select multiple class="form-control" name="teachers_list[]">
                            <?php
                            foreach(array_pop(ClipitUser::get_by_role(array('teacher'))) as $user):
                                if(!in_array($user->id, $activity->teacher_array)):
                                    ?>
                                    <option value="<?php echo $user->id;?>"><?php echo $user->name;?></option>
                                <?php
                                endif;
                            endforeach;
                            ?>
                        </select>
                        <p class="margin-top-10 text-right">
                            <?php
                            echo elgg_view('input/button', array(
                                'value' => elgg_echo('add'),
                                'class' => "submit-add-teachers btn btn-primary btn-xs",
                            ));
                            ?>
                        </p>
                    </div>
                    <div class="option-content margin-top-10 overflow-hidden" id="create" style="display: none;background: #fafafa;padding: 10px;">
                        <div class="add-user-list">
                            <?php echo elgg_view('activity/admin/add_teacher');?>
                        </div>
                        <div class="col-md-12 margin-top-5 margin-bottom-5">
                            <?php
                            echo elgg_view('input/button', array(
                                'value' => elgg_echo('create'),
                                'class' => "submit-add-teachers btn btn-primary btn-xs pull-right",
                            ));
                            ?>
                            <strong>
                                <?php echo elgg_view('output/url', array(
                                    'href'  => "javascript:;",
                                    'id' => 'add_teacher',
                                    'title' => elgg_echo('user:add'),
                                    'text'  => '<i class="fa fa-plus"></i> '.elgg_echo('user:add'),
                                ));
                                ?>
                            </strong>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-md-12">
        <hr>
        <?php
            echo elgg_view('input/submit', array(
                'value' => elgg_echo('update'),
                'class' => "btn btn-primary pull-right",
            ));
        ?>
    </div>
</div>