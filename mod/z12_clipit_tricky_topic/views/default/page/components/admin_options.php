<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   20/02/2015
 * Last update:     20/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity = elgg_extract('entity', $vars);
$user_owner = elgg_extract('user', $vars);
$user_loggedin = elgg_extract('user_loggedin', $vars);
$is_linked = elgg_extract('is_linked', $vars);

$object = ClipitSite::lookup($entity->id);
$cache = elgg_get_metadata_cache();
$is_owner = ($user_owner->id == elgg_get_logged_in_user_guid() || $cache->load(elgg_get_logged_in_user_guid(), 'role') == ClipitUser::ROLE_ADMIN) ? true:false;

$options_list = array();
$owner_options = false;
$locked = false;
$duplicate = true;
$dropdown = true;
$edit = true;
$remove = true;
switch($object['subtype']){
    case 'ClipitTrickyTopic':
        if($is_owner){
            $owner_options = true;
            $href = array(
                'edit' => 'tricky_topics/edit/'.$entity->id,
                'remove' => elgg_add_action_tokens_to_url(elgg_normalize_url('action/tricky_topic/remove?id='.$entity->id), true),
            );
            if($is_linked){
                $locked = true;
                $href['remove'] = false;
            }
            $href['publish'] = false;
            if(!in_array($entity->id, ClipitSite::get_pub_tricky_topics())) {
                $href['publish'] = elgg_add_action_tokens_to_url(elgg_normalize_url('action/publications/publish?id=' . $entity->id), true);
                $locked = false;
            } else {
                $locked = true;
            }
        }
        $href['duplicate'] = 'tricky_topics/create/'.$entity->id;
        break;
    case 'ClipitTag':
        $duplicate = false;
        $edit = false;
        if($is_owner){
            $owner_options = true;
            $href = array(
                'remove' => elgg_add_action_tokens_to_url(elgg_normalize_url('action/stumbling_blocks/remove?id='.$entity->id), true),
            );
        } else {
            $dropdown = false;
        }
        break;
    case 'ClipitExample':
        $duplicate = false;
        if($is_owner){
            $owner_options = true;
            $href = array(
                'edit' => 'tricky_topics/examples/edit/'.$entity->id,
                'remove' => elgg_add_action_tokens_to_url(elgg_normalize_url('action/example/remove?id='.$entity->id), true),
            );
        } else {
            $dropdown = false;
        }
        break;
    case 'ClipitQuiz':
        if($is_owner){
            $owner_options = true;
            $href = array(
                'edit' => 'quizzes/edit/'.$entity->id,
                'remove' => elgg_add_action_tokens_to_url(elgg_normalize_url('action/quiz/remove?id='.$entity->id), true),
            );
        }
        $href['duplicate'] = 'quizzes/create/'.$entity->id;
        break;
    case 'ClipitPerformanceItem':
        $duplicate = false;
        $remove = false;
        $owner_options = true;
        $href = array(
            'edit' => 'rubrics/edit/?name='.json_encode($entity->category),
        );
        break;
    case 'ClipitRubric':
        $owner_options = true;
        if($is_owner){
            $owner_options = true;
            $href = array(
                'edit' => 'rubrics/edit/'.$entity->id,
                'remove' => elgg_add_action_tokens_to_url(elgg_normalize_url('action/rubric/remove?id='.$entity->id), true),
            );
        } else {
            $edit = false;
            $remove = false;
        }
        $href['duplicate'] = 'rubrics/create/'.$entity->id;
        break;
    case 'ClipitActivity':
        $duplicate = false;
        if($is_owner){
            $owner_options = true;
            $href = array(
                'edit' => 'clipit_activity/'.$entity->id.'/admin',
                'remove' => elgg_add_action_tokens_to_url(elgg_normalize_url('action/activity/remove?id='.$entity->id), true),
            );
        } else {
            $dropdown = false;
        }
        break;
}
if($duplicate) {
    $options_list[] = array(
        'attr' => array('href' => elgg_normalize_url($href['duplicate'])),
        'text' => elgg_echo('duplicate'),
        'icon' => 'copy',
    );
}
$item_class = false;
if($owner_options){
    $edit_icon = 'pencil';
    $remove_icon = 'trash-o';
    $remove_class = 'remove remove-object';
    if($locked) {
        $remove_icon = 'ban';
        $remove_class = false;
        $item_class = 'disabled';
    }
    if($edit) {
        $options_list[] = array(
            'attr' => array('href' => elgg_normalize_url($href['edit'])),
            'text' => elgg_echo('edit'),
            'icon' => $edit_icon,
        );
    }
    if($href['publish']) {
        $options_list[] = array(
            'attr' => array('data-toggle' => 'modal', 'data-target' => '#publish-'.$entity->id),
            'text' => elgg_echo('send:to_site'),
            'icon' => 'globe',
            'item_class' => "cursor-pointer ".$item_class
        );
    }
    if($remove) {
        $options_list[] = array(
            'attr' => array('href' => $href['remove'], 'class' => $remove_class),
            'text' => elgg_echo('remove'),
            'icon' => $remove_icon,
            'item_class' => $item_class
        );
    }
}

if($dropdown) {
    $options = array(
        'button' => '<button data-toggle="dropdown" class="btn-options btn btn-xs"><b>' . elgg_echo("options") . '</b> <b class="caret"></b></button>',
        'options' => $options_list,
    );

    echo elgg_view("page/components/dropdown", $options);
}