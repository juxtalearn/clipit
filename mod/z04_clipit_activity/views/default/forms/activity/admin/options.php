<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   15/07/2015
 * Last update:     15/07/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
echo elgg_view('input/hidden' ,array(
    'name' => 'activity[id]',
    'value' => $entity->id
));
?>
<div class="row margin-bottom-10">
    <div class="col-xs-5">
        <label>Visibilidad de la actividad</label>
        <small>(Cualquier estudiante del sitio puede entrar a la actividad sólo si se encuentra en modo inscripción)</small>
    </div>
    <div class="col-xs-7">
        <label class="inline-block margin-right-20">
            <input type="radio"
                   name="activity[is_open]"
                <?php echo $entity->is_open ? 'checked':'';?>
                   value="1">
            <i class="fa fa-unlock text-muted"></i> Abierto
        </label>
        <label class="inline-block">
            <input type="radio"
                   name="activity[is_open]"
                <?php echo $entity->is_open ? '':'checked';?>
                   value="0">
            <i class="fa fa-lock text-muted"></i> Cerrado
        </label>
    </div>
</div>
<div class="text-right">
    <?php
    echo elgg_view('input/submit', array(
        'value' => elgg_echo('save'),
        'class' => "btn btn-primary",
    ));
    ?>
</div>