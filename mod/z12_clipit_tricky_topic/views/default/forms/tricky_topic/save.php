<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   03/12/2014
 * Last update:     03/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$user = array_pop(ClipitUser::get_by_id(array(elgg_get_logged_in_user_guid())));
$tricky_topic = elgg_extract('entity', $vars);
$button_value = elgg_extract('submit_value', $vars);
if($tricky_topic){
    $tags = ClipitTag::get_by_id($tricky_topic->tag_array);
    echo elgg_view('input/hidden', array(
        'name' => 'entity-id',
        'value' => $tricky_topic->id,
    ));
    if($parent_id = elgg_extract('clone', $vars)){
        echo elgg_view('input/hidden', array(
            'name' => 'clone',
            'value' => 'true',
        ));
    }
}
?>
<div class="row">
    <div class="col-md-7">
        <div class="form-group">
            <label><?php echo elgg_echo('author');?></label>
            <i class="fa fa-user blue"></i>
            <?php echo elgg_view('output/url', array(
                'href'  => "profile/{$user->login}",
                'title' => $user->name,
                'text'  => $user->name,
            ));
            ?>
        </div>
        <div class="form-group">
            <label><?php echo elgg_echo('title');?></label>
            <?php echo elgg_view('input/text', array(
                'class' => 'form-control',
                'name' => 'title',
                'value' => $tricky_topic->name,
                'required' => true
            ));
            ?>
        </div>
        <div class="form-group">
            <label><?php echo elgg_echo('description');?></label>
            <?php echo elgg_view('input/plaintext', array(
                'class' => 'form-control mceEditor',
                'name' => 'description',
                'value' => $tricky_topic->description
            ));
            ?>
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label>
                <?php echo elgg_echo('tags');?>
            </label>
            <div class="form-add-tags form-group margin-top-10">
                <?php if($tags):?>
                    <?php foreach($tags as $tag):?>
                        <?php echo elgg_view("tricky_topic/add", array('value' => $tag->name));?>
                    <?php endforeach;?>
                <?php else: ?>
                    <?php echo elgg_view("tricky_topic/add");?>
                <?php endif;?>
            </div>
            <?php echo elgg_view('output/url', array(
                'href'  => "javascript:;",
                'class' => 'btn btn-xs btn-primary',
                'title' => elgg_echo('add'),
                'text'  => '<i class="fa fa-plus"></i>' . elgg_echo('add'),
                'id'    => 'add-tag',
            ));
            ?>
        </div>
    </div>
</div>
<div class="text-right">
    <?php echo elgg_view('input/submit', array('value' => $button_value, 'class'=>'btn btn-primary')); ?>
</div>
