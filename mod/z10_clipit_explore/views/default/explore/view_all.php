<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/06/14
 * Last update:     24/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$href = http_build_query(array(
    'by' => get_input('by'),
    'id' => get_input('id'),
    'text' => get_input('text'),
    'filter' => $vars['filter'],
    'activity' => get_input('activity'),
));
if(get_input('by')){
    $href = "/search?{$href}";
} else {
    $href = "?{$href}";
}
?>
<p class="text-right view-all" style="
    border-top: 1px solid #bae6f6;
    padding-top: 10px;
">
    <?php echo elgg_view('output/url', array(
        'href'  => "explore{$href}",
        'title' => elgg_echo('view_all'),
        'text'  => elgg_echo('view_all')));
    ?>
</p>