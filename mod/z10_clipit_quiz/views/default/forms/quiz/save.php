<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/01/2015
 * Last update:     23/01/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$user = array_pop(ClipitUser::get_by_id(array(elgg_get_logged_in_user_guid())));
$button_value = elgg_extract('submit_value', $vars);

$tricky_topics = ClipitTrickyTopic::get_all();
$owner_tt = array();
foreach($tricky_topics as $tricky_topic){
    $tt[$tricky_topic->id] = $tricky_topic->name;
    if($tricky_topic->owner_id == elgg_get_logged_in_user_guid()){
        $owner_tt[$tricky_topic->id] = $tricky_topic->name;
    }
}
$tt = array_diff($tt, $owner_tt);
?>
<div class="row margin-bottom-20">
<div class="col-md-7">
    <label><?php echo elgg_echo('author');?></label>
    <i class="fa fa-user blue"></i>
    <?php echo elgg_view('output/url', array(
        'href'  => "profile/{$user->login}",
        'title' => $user->name,
        'text'  => $user->name,
    ));
    ?>
</div>
<div class="col-md-5">
    <label><?php echo elgg_echo('tricky_topic');?></label>
    <select required="required" id="tricky-topic" class="form-control" name="tricky-topic" style="padding-top: 5px;padding-bottom: 5px;">
    <option value="">
        <?php echo elgg_echo('tricky_topic:select');?>
    </option>
    <?php if(count($owner_tt)>0):?>
        <optgroup label="<?php echo elgg_echo('tricky_topic:created_by_me');?>">
            <?php foreach($owner_tt as $value => $name):?>
                <option <?php echo $selected == $value ? 'selected' : '';?> value="<?php echo $value;?>">
                    <?php echo $name;?>
                </option>
            <?php endforeach;?>
        </optgroup>
    <?php endif;?>
    <?php if(count($tt)>0):?>
        <optgroup label="<?php echo elgg_echo('tricky_topic:created_by_others');?>">
            <?php foreach($tt as $value => $name):?>
                <option <?php echo $selected == $value ? 'selected' : '';?> value="<?php echo $value;?>">
                    <?php echo $name;?>
                </option>
            <?php endforeach;?>
        </optgroup>
    <?php endif;?>
</select>
</div>
</div>
<?php echo elgg_view('activity/admin/tasks/quiz/quiz');?>
<div class="text-right">
    <?php echo elgg_view('input/submit', array(
        'class' => 'btn btn-primary',
        'value'  => $button_value,
    ));
    ?>
</div>