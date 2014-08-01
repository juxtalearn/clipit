<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   25/07/14
 * Last update:     25/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$status = elgg_extract('status', $vars);
?>
<?php if($status):?>
    <i class="fa fa-check green"></i>
<?php else: ?>
    <i class="fa fa-times red"></i>
<?php endif;?>