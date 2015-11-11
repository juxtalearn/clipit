<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   7/07/14
 * Last update:     7/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
?>
<li <?php echo elgg_in_context('explore') ? 'class="active"': '';?>>
    <?php echo elgg_view('output/url', array(
        'href'  => "explore",
        'title' => elgg_echo('explore'),
        'id' => 'explore',
        'text'  => '<i class="fa fa-globe visible-xs visible-sm"></i>
                    <span class="hidden-xs hidden-sm">'.elgg_echo('explore'). '</span>'
    ));
    ?>
</li>
<li class="separator">|</li>