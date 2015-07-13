<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/07/14
 * Last update:     24/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entities_ids = get_input('entities_ids');
$user_id = get_input('user_id');
$user_rating = false;
?>
<ul>
<?php
foreach($entities_ids as $entity_id):
    $object = ClipitSite::lookup($entity_id);
    $entity = array_pop($object['subtype']::get_by_id(array($entity_id)));
    $activity_id = $entity::get_activity($entity->id);

    $rating = ClipitRating::get_user_rating_for_target($user_id, $entity_id);
    if($rating):
        $user_rating = true;
        echo elgg_view('publications/admin/rating',
        array(
            'rating' => $rating,
            'href' => "clipit_activity/{$activity_id}/publications",
            'entity' => $entity,
            'entity_preview' => $entity_preview
        ));
    endif;
endforeach;?>
</ul>
<?php if(!$user_rating):?>
    <?php echo elgg_view('output/empty', array('value' => elgg_echo('ratings:none')));?>
<?php endif;?>