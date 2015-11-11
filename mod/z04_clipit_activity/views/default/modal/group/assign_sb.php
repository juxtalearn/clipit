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
$id = (int)get_input("group_id");
if($group = array_pop(ClipitGroup::get_by_id(array($id)))) {
    $body = elgg_view("page/components/modal",
        array(
            "dialog_class" => "modal-md",
            "remote" => true,
            "target" => "sb-group-{$group->id}",
            "title" => $group->name,
            "form" => true,
            "body" => elgg_view('activity/admin/groups/assign_sb',array('entity' => $group)),
            "cancel_button" => true,
            "ok_button" => elgg_view('input/submit',
                array(
                    'value' => elgg_echo('save'),
                    'class' => "btn btn-primary"
                ))
        ));
    echo elgg_view_form('activity/admin/assign_sb', array('body' => $body));
}