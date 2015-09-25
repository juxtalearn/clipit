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
?>
<?php echo elgg_view('output/img', array(
    'src' => get_avatar($user, 'small'),
    'alt' => elgg_echo('profile:avatar:from', array($user->name)),
    'class' => 'pull-left margin-right-10 avatar-tiny'
));?>
<div class="text-truncate">
    <?php if($vars['mail'] !== false): ?>
        <?php echo elgg_view("messages/compose_icon", array('entity' => $user));?>
    <?php endif;?>
    <?php echo elgg_view('output/url', array(
        'href'  => "profile/".$user->login,
        'title' => $user->name,
        'text'  => $user->name,
    ));
    ?>
</div>