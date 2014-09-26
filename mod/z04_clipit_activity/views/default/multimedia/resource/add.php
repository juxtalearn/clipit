<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   25/09/2014
 * Last update:     25/09/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);

echo elgg_view("input/hidden", array(
    'name' => 'entity-id',
    'value' => $entity->id,
));
echo elgg_view("input/hidden", array(
    'name' => 'tags',
));
?>
<div class="row">
    <div class="col-md-12 add-video">
        <div class="video-info">
            <div class="form-group">
                <label for="video-title"><?php echo elgg_echo("resource:title");?></label>
                <?php echo elgg_view("input/text", array(
                    'name' => 'resource-title',
                    'id' => 'resource-title',
                    'class' => 'form-control',
                    'required' => true
                ));
                ?>
            </div>
            <div class="form-group">
                <label for="video-description"><?php echo elgg_echo("resource:description");?></label>
                <?php echo elgg_view("input/plaintext", array(
                    'name' => 'resource-description',
                    'class' => 'form-control mceEditor',
                    'id' => 'video-description',
                    'rows'  => 3,
                    'placeholder' => 'Set description...',
                    'style' => "width: 100%;"
                ));
                ?>
            </div>
        </div>
    </div>
</div>