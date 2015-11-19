<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   19/11/2015
 * Last update:     19/11/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$id = '0B9WHmENWg_ExUmJ3eDZ1blRRblk';
$view_type = 'grid';
$title = elgg_echo('press_kit');

$content = '<iframe src="https://drive.google.com/embeddedfolderview?id='.$id.'#'.$view_type.'" width="100%" height="500" frameborder="0"></iframe>';
$params = array(
    'content' => $content,
    'filter' => '',
    'title' => $title,
);
$body = elgg_view_layout('one_column', $params);

echo elgg_view_page($title, $body);