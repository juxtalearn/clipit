<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   09/10/2014
 * Last update:     09/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
   @author          RIAS JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */

?>


<div class="learning_analytics_dashboard">
<?php

$params = array(
//'content' => "",#$orig_urjc_content,
'title' => $title,
'filter' => '',
'num_columns' =>2,
);
echo elgg_view_layout('la_widgets', $params);
?>



<div class="elgg-col elgg-col-2of3">
    <?php
    echo elgg_view('output/longtext', array(
        'id' => 'learning_analytics_dashboard-info',
        'class' => 'elgg-inner pam mhs mtn',
        'value' => elgg_echo("dashboard:nowidgets"),
        'show_access' => false,
    ));

    ?>
</div>

</div>