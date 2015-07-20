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
$status = get_activity_status($activity->status);
elgg_load_js('fullcalendar:moment');
elgg_load_js("jquery:quicksearch");
?>
<script>
    $(function(){
        $(".datepicker").datepicker();
        $(document).on("click", ".change-status", function(){
            var status = $(this).data("status");
            switch(status){
                case 'active':
                    $(this).parent("a").popover('show');
                    var current_date = new Date().getTime();
                    var days_ago = moment(current_date - (60*60*24*1*1000)).format("DD/MM/YYYY"); // 1 days ago
                    $("#activity-start").val(days_ago).focus();
                    break;
                case 'closed':
                    $(this).parent("a").popover('show');
                    var current_date = new Date().getTime();
                    var days_ago = moment(current_date - (60*60*24*1*1000)).format("DD/MM/YYYY"); // 1 days ago
                    $("#activity-end").val(days_ago).focus();
                    break;
            }
        });
    });
</script>
<div class="row">
    <?php echo elgg_view("input/hidden", array(
        'name' => 'entity-id',
        'value' => $activity->id,
    ));
    ?>
    <div class="col-md-7">
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
        <div class="row margin-bottom-15">
            <div class="col-md-5">
                <small class="show margin-bottom-5"><?php echo elgg_echo('current_status');?></small>
                <strong class="blue cursor-default">
                    <i class="fa fa-<?php echo $status['icon'];?> <?php echo $status['color'];?>"></i>
                    <?php echo $status['text'];?>
                </strong>
            </div>
            <div class="col-md-5">
                <small class="show margin-bottom-5"><?php echo elgg_echo('change_to');?></small>
                <?php echo elgg_view('output/url', array(
                    'title' => elgg_echo('change_to') .": ". $status['change_to'],
                    'text' => $status['btn_change_to'],
                    'data-toggle' => "popover",
                    'tabindex' => "0",
                    'style' => "display:block;",
                    'rel' => "popover",
                    'data-placement' => "left",
                    'data-content' => $status['text_tooltip']
                ));
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <label for="activity-start"><?php echo elgg_echo("activity:start");?></label>
                <?php echo elgg_view("input/text", array(
                    'name' => 'activity-start',
                    'id' => 'activity-start',
                    'class' => 'form-control datepicker',
                    'required' => true,
                    'value' => date("d/m/Y", $activity->start),
                ));
                ?>
            </div>
            <div class="col-md-5">
                <label for="task-end"><?php echo elgg_echo("activity:end");?></label>
                <?php echo elgg_view("input/text", array(
                    'name' => 'activity-end',
                    'id' => 'activity-end',
                    'class' => 'form-control datepicker',
                    'required' => true,
                    'value' => date("d/m/Y", $activity->end),
                ));
                ?>
            </div>
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
    <div class="col-md-5">
        <label><?php echo elgg_echo("tricky_topic");?></label>
        <div style="background: #fafafa;padding: 10px;" class="content-block">
            <?php echo elgg_view('tricky_topic/list', array(
                    'tricky_topic' => $activity->tricky_topic,
                    'show_tags' => 'list'
                ));
            ?>
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
                                'href' => "action/activity/admin/users?activity_id={$activity->id}&act=remove_from_activity&id={$teacher->id}&role=teacher",
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
                    <?php echo elgg_view('activity/admin/add_teachers', array('entity' => $activity));?>
                </li>
            </ul>
        </div>
    </div>
    <div class="col-md-12">
        <hr>
        <?php echo elgg_view('output/url', array(
            'title' => elgg_echo('activity:delete'),
            'is_action' => true,
            'text' => elgg_echo('activity:delete'),
            'href' => "action/activity/remove?id=".$activity->id,
            'class' => 'btn btn-primary btn-danger remove-object'
        ));
        ?>
        <?php
        echo elgg_view('input/submit', array(
            'value' => elgg_echo('save'),
            'class' => "btn btn-primary pull-right",
        ));
        ?>
    </div>
</div>
