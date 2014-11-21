<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   15/10/2014
 * Last update:     15/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
<li class="btn-landing">
    <?php echo elgg_view('output/url', array(
        'href'  => "http://clipit.es/demo",
        'title' => elgg_echo('try_out'),
        'text'  => elgg_echo('try_out')
    ));
    ?>
</li>
<li class="btn-landing">
    <?php echo elgg_view('output/url', array(
        'href'  => "connect",
        'title' => elgg_echo('connect'),
        'text'  => elgg_echo('connect')
    ));
    ?>
</li>
<li class="separator">|</li>
<li>
    <?php echo elgg_view('output/url', array(
        'href'  => "videos",
        'title' => elgg_echo('videos'),
        'text'  => elgg_echo('videos')
    ));
    ?>
</li>
