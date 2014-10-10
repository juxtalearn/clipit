<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   16/09/14
 * Last update:     16/09/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$id = get_input('id');
$body = elgg_view('assessment_rubric/view', array('entity_id' => $id));
echo elgg_view("page/components/modal",
    array(
        "dialog_class"     => "modal-lg",
        "remote"    => true,
        "target"    => "assessment-rubric",
        "title"     => 'Rúbrica',
        "form"      => false,
        "body"      => $body,
        "footer"    => false
    ));
