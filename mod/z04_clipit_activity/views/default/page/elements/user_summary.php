<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   1/09/14
 * Last update:     1/09/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$user = elgg_extract('user', $vars);

$admin = array();
if(hasTeacherAccess($user->role)){
    $admin = array(
        'class' => 'admin-owner',
        'icon' => '<i class="fa fa-user"></i> ',
        'title' => elgg_echo('teacher'). ": "
    );
}
echo elgg_view('output/url', array(
    'href'  => "profile/".$user->login,
    'title' => $admin['title'] . $user->name,
    'class' => $admin['class'],
    'text'  => $admin['icon'] . $user->name
));