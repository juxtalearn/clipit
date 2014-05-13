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
$teachers = elgg_extract("teachers", $vars);
?>
<h3 style="color: #32b4e5; margin-top: 5px;">Teachers</h3>
<ul style="background: #fff; padding: 10px;">
    <?php foreach($teachers as $teacher_id):
        $teacher = array_pop(ClipitUser::get_by_id(array($teacher_id)));
    ?>
    <li class="list-item">
        <?php echo elgg_view("page/elements/user_block", array('entity' => $teacher)); ?>
    </li>
    <?php endforeach; ?>
</ul>
