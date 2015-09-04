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
        'href'  => '/videos',
        'text'  => elgg_echo('videos')
    ));
    ?>
</li>
<li class="btn-landing">
    <?php echo elgg_view('output/url', array(
        'href'  => 'trickytopics',
        'text'  => elgg_echo('tricky_topics')
    ));
    ?>
</li>
<li class="margin-left-15">
    <?php echo elgg_view('output/url', array(
        'href'  => "sites",
        'text'  => elgg_echo('sites')
    ));
    ?>
</li>
<!--<li class="separator">|</li>-->
<!--<li>-->
<!--    --><?php //echo elgg_view('output/url', array(
//        'href'  => 'public_activities',
//        'text'  => elgg_echo('activities')
//    ));
//    ?>
<!--</li>-->
<li class="separator">|</li>
<li>
    <?php echo elgg_view('output/url', array(
        'href'  => "http://clipit.es/demo",
        'text'  => elgg_echo('try_out')
    ));
    ?>
</li>
