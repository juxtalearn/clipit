<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   13/06/14
 * Last update:     13/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
$elgg_user = new ElggUser($entity->id);
?>
<div class="row">
    <div class="col-md-3">
        <?php echo elgg_view('output/img', array(
            'src' => get_avatar($entity, 'large'),
            'style' => 'width: auto',
            'class' => 'avatar-large'
        ));?>
    </div>
    <div class="col-md-9">
        <ul>
            <?php
            $limit = 15;
            $recommended_events = ClipitEvent::get_by_object(array($entity->id), 0, 30);
            foreach ($recommended_events as $event_log){
                $content .= view_recommended_event($event_log);
            }
            echo $content;
            ?>
        </ul>
    </div>
</div>