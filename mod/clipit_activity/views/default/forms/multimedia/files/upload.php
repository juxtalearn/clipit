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
<?php echo elgg_view("input/hidden", array(
        'name' => 'entity-id',
        'value' => $entity->id,
    ));
?>
<a class="btn btn-default" style="position: relative; overflow: hidden">
    Add files
    <input id="uploadfiles" multiple type="file" name="files[]">
</a>
<?php echo elgg_view('input/submit', array('value' => elgg_echo('upload'))); ?>