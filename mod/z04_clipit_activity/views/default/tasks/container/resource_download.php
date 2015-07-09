<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   08/07/2015
 * Last update:     08/07/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$attach = elgg_extract('params', $vars);
$attach['id'] = elgg_extract('id', $vars);
$entity = elgg_extract('entity', $vars);
$input_array = elgg_extract('input_array', $vars);
?>
<?php if($entity->task_type == ClipitTask::TYPE_RESOURCE_DOWNLOAD):?>
    <script>
        $(function(){
            $("[data-attach='<?php echo $attach['id'];?>']").attach_multimedia({
                'default_list': "files",
                data:{
                    'list': $(this).data("menu"),
                    'entity_id': "<?php echo $entity->activity;?>",
                    'selected': <?php echo $attach['selected'];?>,
                    'input_prefix': '<?php echo 'task'.$input_array;?>',
                }
            }).loadAll();
        });
    </script>
    <?php echo elgg_view("multimedia/attach/list", $attach);?>
<?php elseif(!$entity):?>
    <?php echo elgg_view("multimedia/attach/list", $attach);?>
<?php endif;?>