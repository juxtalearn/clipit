<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   27/11/2014
 * Last update:     27/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$rubrics = elgg_extract('entities', $vars);
$count = elgg_extract('count', $vars);
$select = get_input('select');

$options = true;
$select = false;
?>
<div class="margin-bottom-20">
    <div class="pull-right">
        <?php echo elgg_view("page/components/print_button");?>
    </div>
    <?php echo elgg_view('output/url', array(
        'href'  => 'rubrics/create',
        'class' => 'btn btn-primary margin-bottom-10',
        'title' => elgg_echo('new'),
        'text'  => elgg_echo('new'),
    ));
    ?>
</div>
<script>
$(function(){
    $(document).on("click", ".show-items", function(){
        var tr = $(this).closest("tr");
        tr.next('tr').toggle();

    });
});
</script>
<div class="table-responsive">
<table class="table table-striped" style="table-layout: fixed">
    <thead>
    <tr>
        <?php if($select):?>
            <th style="width: 50px;"></th>
        <?php endif;?>
        <th><?php echo elgg_echo('title');?></th>
        <th><?php echo elgg_echo('author');?>-<?php echo elgg_echo('date');?></th>
        <th style="width: 100px;"><?php echo elgg_echo('rubric:items');?></th>
        <?php if(!$select):?>
        <th style="width: 150px;"><?php echo elgg_echo('options');?></th>
        <?php endif;?>
    </tr>
    </thead>
    <tr></tr>
    <?php foreach($rubrics as $rubric):
        $owner_user = array_pop(ClipitUser::get_by_id(array($rubric->owner_id)));
        $rubric_items = ClipitRubricItem::get_by_id($rubric->rubric_item_array, 0, 0, 'time_created', false);
    ?>
        <tr>
            <?php if($select):?>
            <td>

            </td>
            <?php endif;?>
            <td>
                <strong>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "rubrics/view/{$rubric->id}",
                        'title' => $rubric->name,
                        'text'  => $rubric->name,
                    ));
                    ?>
                </strong>
            </td>
            <td>
                <small>
                    <div>
                        <i class="fa-user fa blue"></i>
                        <?php echo elgg_view('output/url', array(
                            'href'  => "profile/{$owner_user->login}",
                            'title' => $owner_user->name,
                            'text'  => $owner_user->name,
                        ));
                        ?>
                    </div>
                    <?php echo elgg_view('output/friendlytime', array('time' => $rubric->time_created));?>
                </small>
            </td>
            <td class="text-right">
                <?php echo elgg_view('output/url', array(
                    'href'  => 'javascript:;',
                    'class' => 'show-items btn btn-xs btn-border-blue',
                    'text'  => '<strong>'.count($rubric_items).'</strong>x<i class="margin-left-5 fa fa-list"></i>',
                ));
                ?>
            </td>
            <?php if(!$select):?>
            <td data-title="<?php echo elgg_echo('options');?>" class="hidden-xs hidden-sm">
                <?php echo elgg_view('page/components/admin_options', array(
                    'entity' => $rubric,
                    'user' => $owner_user
                ));?>
            </td>
            <?php endif;?>
        </tr>
        <tr style="display: none;">
            <td colspan="4" class="bg-white">
                <div style="overflow-y: auto;overflow-x: hidden;max-height: 450px;">
                    <?php echo elgg_view('rubric/items', array('entities' => $rubric_items));?>
                </div>
            </td>
        </tr>
    <?php endforeach;?>
</table>
</div>
<?php echo clipit_get_pagination(array('count' => $count, 'limit' => 10)); ?>