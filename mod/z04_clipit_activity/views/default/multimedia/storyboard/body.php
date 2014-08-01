<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   14/07/14
 * Last update:     14/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$storyboard = elgg_extract('entity', $vars);
$file = elgg_extract('file', $vars);
?>
<?php echo elgg_view("multimedia/file/body", array('entity' => $file));?>