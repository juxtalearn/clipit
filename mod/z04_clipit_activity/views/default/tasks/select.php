<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   1/07/14
 * Last update:     1/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entities = elgg_extract('entities', $vars);
$filter = "";
if($filter = get_input("filter")){
    $filter = "+'&filter={$filter}'";
}
?>
<?php if($entities):?>
    <small class="show margin-bottom-5"><?php echo elgg_echo('task:select');?></small>
    <?php echo elgg_view('input/dropdown', array(
        'name' => 'task_id',
        'id' => 'task_id',
        'class' => 'form-control margin-bottom-20 pull-left',
        'style' => 'height: auto;width: auto;padding: 0;font-weight: bold;',
        'value' => get_input('task_id'),
        'onchange' => "location.href='?task_id='+this.value".$filter,
        'options_values' => $entities
    ));
    ?>
<?php endif;?>