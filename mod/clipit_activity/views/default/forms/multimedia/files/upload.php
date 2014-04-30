<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
?>
<a class="btn btn-default" style="position: relative; overflow: hidden">
    Add files
    <input id="uploadfiles" multiple type="file" name="files[]">
</a>
<?php echo elgg_view("input/hidden", array(
    'name' => 'entity-id',
    'value' => $entity->id,
));?>
<?php
echo elgg_view("page/components/modal",
    array(
        "dialog_class"     => "modal-lg add-files-list",
        "target"    => "add-file",
        "title"     => elgg_echo("multimedia:files:add"),
        "form"      => true,
        "body"      => "",
        "cancel_button" => true,
        "ok_button" => elgg_view('input/submit',
            array(
                'value' => elgg_echo('add'),
                'class' => "btn btn-primary"
            ))
    ));
?>
