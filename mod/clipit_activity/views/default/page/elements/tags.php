<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   19/05/14
 * Last update:     19/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$tags = elgg_extract("tags", $vars);
if(!$tags): ?>
    <span class="empty">no tags added</span>
<?php endif; ?>
<?php
foreach($tags as $tag_id):
    $tag = array_pop(ClipitTag::get_by_id(array($tag_id)));
?>
    <?php echo elgg_view('output/url', array(
    'href'  => "explore/".$tag->name,
    'title' => $tag->name,
    'text'  => $tag->name,
    'class' => 'label label-primary'
    ));
    ?>
<?php endforeach; ?>