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
    $tags = ClipitTag::get_by_id($tricky_topic->tag_array, 0, 0, 'name');
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
            <label for="title"><?php echo elgg_echo('name');?></label>
            <?php echo elgg_view('input/text', array(
                'class' => 'form-control',
                'name' => 'title',
                'value' => $tricky_topic->name,
                'autofocus' => true,
                'required' => true,
                'aria-label' => elgg_echo('name'),
            ));
            ?>
        </div>
        <div class="form-group">
            <label><?php echo elgg_echo('description');?></label>
            <?php echo elgg_view('input/plaintext', array(
                'class' => 'form-control mceEditor',
                'name' => 'description',
                'value' => $tricky_topic->description,
                'aria-label' => elgg_echo('description'),
            ));
            ?>
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-add-tags form-group prototype-container" data-prototype="<?php echo htmlentities(elgg_view("tricky_topics/tags/add"));?>">
            <label for="tag[]"><?php echo elgg_echo('tags');?></label>
            <div class="prototype-content form-group margin-top-10">
                <?php if($tags):?>
                    <?php foreach($tags as $tag):?>
                        <?php echo elgg_view("tricky_topics/tags/add", array('value' => $tag->name));?>
                    <?php endforeach;?>
                <?php else: ?>
                    <?php echo elgg_view("tricky_topics/tags/add");?>
                <?php endif;?>
            </div>
            <?php echo elgg_view('output/url', array(
                'href'  => "javascript:;",
                'class' => 'btn btn-xs btn-primary prototype-add',
                'title' => elgg_echo('add'),
                'text'  => '<i class="fa fa-plus"></i> ' . elgg_echo('add'),
                'id'    => 'add-tag',
            ));
            ?>
        </div>
        <div class="form-group">
            <label for="education_level"><?php echo elgg_echo('education_level');?></label>
            <?php echo elgg_view("input/dropdown", array(
                'name' => 'education_level',
                'style' => 'padding: 5px',
                'value' => $tricky_topic->education_level,
                'class' => 'form-control',
                'options_values' => get_education_levels(),
                'required' => true,
                'aria-label' => elgg_echo('education_level'),
            ));
            ?>
        </div>
        <div class="form-group">
            <label for="subject"><?php echo elgg_echo('tricky_topic:subject');?></label>
            <?php echo elgg_view("input/text", array(
                'name' => 'subject',
                'value' => $tricky_topic->subject,
                'class' => 'form-control input-subject',
                'required' => true,
                'aria-label' => elgg_echo('tricky_topic:subject'),
            ));
            ?>
        </div>
    </div>
</div>

<div class="text-right margin-top-10">
    <?php echo elgg_view('input/submit', array('value' => $button_value, 'class'=>'btn btn-primary')); ?>
</div>
