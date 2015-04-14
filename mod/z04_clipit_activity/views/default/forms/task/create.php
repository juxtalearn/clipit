<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   21/07/14
 * Last update:     21/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity = elgg_extract('entity', $vars);
$id = elgg_extract('id', $vars);

$body = elgg_view("input/hidden", array(
    'name' => 'entity-id',
    'value' => $activity->id,
));
$body .= elgg_view("input/hidden", array(
    'name' => 'tricky-topic',
    'id' => 'tricky-topic',
    'value' => $activity->tricky_topic,
));

$body .= '<div class="task">';
$body .= elgg_view('activity/create/task', array('task_type' => 'upload', 'id' => $id, 'delete_task' => false));

$body .='
<ul class="feedback_form" style="margin-left: 20px;display: none">
    <li style="padding: 10px;background: #fafafa;" class="col-md-12">
        <div class="col-mds-12">
            <h4>'.elgg_echo('task:feedback').'</h4>
        </div>
        '.elgg_view('activity/create/task', array('task_type' => 'feedback', 'id' => $id)).'
    </li>
</ul>
';
$body .= '</div>';

echo elgg_view("page/components/modal",
    array(
        "dialog_class"     => "modal-lg",
        "target"    => "create-new-task",
        "title"     => elgg_echo("task:create"),
        "form"      => true,
        "body"      => $body,
        "cancel_button" => true,
        "ok_button" => elgg_view('input/submit',
            array(
                'value' => elgg_echo('create'),
                'class' => "btn btn-primary"
            ))
    ));