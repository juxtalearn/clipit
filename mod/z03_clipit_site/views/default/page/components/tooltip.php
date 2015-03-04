<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   20/02/2015
 * Last update:     20/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$text = elgg_extract('text', $vars);
$class = elgg_extract('class', $vars);
if(!$class){
    $class = 'text-muted';
}
?>
<i class="help-tooltip fa fa-question-circle <?php echo $class;?>"
   data-container="body" data-toggle="popover" data-trigger="hover"
   data-placement="bottom" data-content="<?php echo $text;?>">
</i>