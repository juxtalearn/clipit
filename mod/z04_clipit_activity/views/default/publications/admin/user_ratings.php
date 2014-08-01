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
$user = array_pop(ClipitUser::get_by_id(array($user_id)));
$user_rating = false;
?>
<?php foreach(ClipitRating::get_by_owner(array($user->id)) as $ratings):?>
    <?php foreach($ratings as $rating):
        $key = array_search($rating->target, $entities_ids);
        if($key !== false):
            $entity_id = $entities_ids[$key];
            $user_rating = true;
    ?>
        <ul>
            <?php
            $object = ClipitSite::lookup($entity_id);
            $entity = array_pop($object['subtype']::get_by_id(array($entity_id)));
            switch($object['subtype']){
                case "ClipitStoryboard":
                    $file = array_pop(ClipitFile::get_by_id(array($entity->file)));
                    $entity_preview = elgg_view("multimedia/file/preview", array('file'  => $file));
                    break;
                case "ClipitVideo":
                    $entity_preview = '<div class="img-preview"><img src="'.$entity->preview.'"></div>';
                    break;
            }
            $activity_id = $entity::get_activity($entity->id);
            ?>
            <?php echo elgg_view('publications/admin/rating',
            array(
                'rating' => $rating,
                'href' => "clipit_activity/{$activity_id}/publications",
                'entity' => $entity,
                'entity_preview' => $entity_preview
            ));
            ?>
        <?php endif;?>
    <?php endforeach;?>
    </ul>
<?php endforeach;?>
<?php if(!$user_rating):?>
    <?php echo elgg_view('output/empty', array('value' => elgg_echo('ratings:none')));?>
<?php endif;?>