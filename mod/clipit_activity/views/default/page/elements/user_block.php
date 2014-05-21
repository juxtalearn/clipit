<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   9/05/14
 * Last update:     9/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$user = elgg_extract("entity", $vars);
$user_elgg = new ElggUser($user->id);
?>
<img class="pull-left" style="margin-right: 10px;" src="<?php echo $user_elgg->getIconURL('small');?>">
<div class="text-truncate">
    <?php echo elgg_view('output/url', array(
        'href'  => "profile/".$user->login,
        'title' => $user->name,
        'text'  => $user->name));
    ?>
    <div class="show">
        <?php echo elgg_view("messages/compose_icon", array('entity' => $user));?>
        <small>@<?php echo $user->login;?></small>
    </div>
</div>