<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/01/2015
 * Last update:     23/01/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$performance_items = elgg_extract('entities', $vars);
$user_logged = array_pop(ClipitUser::get_by_id(array($user_loggedin_id)));

foreach($performance_items as $performance_item_id):
    $performance_item = array_pop(ClipitPerformanceItem::get_by_id(array($performance_item_id)));
?>
    <div style="border-bottom: 1px solid #bae6f6;">
        <h5 class="text-truncate blue" style="margin: 5px 0;">
            <?php echo elgg_view('output/url', array(
                'title' => $performance_item->name,
                'href'  => "explore/search?by=performance_item&id=".$performance_item->id,
                'text'  => $performance_item->name,
            ));
            ?>
        </h5>
    </div>
<?php endforeach; ?>