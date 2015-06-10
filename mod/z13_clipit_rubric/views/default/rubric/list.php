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
<table class="table table-striped">
    <thead>
    <tr>
        <?php if($select):?>
            <th style="width: 50px;"></th>
        <?php endif;?>
        <th><?php echo elgg_echo('author');?></th>
        <th><?php echo elgg_echo('last_added');?></th>
        <th></th>
        <th style="width: 100px;"></th>
    </tr>
    </thead>
    <tr></tr>
    <?php foreach($rubrics as $owner_id => $items):
        $owner_user = array_pop(ClipitUser::get_by_id(array($owner_id)));
    ?>
        <tr>
            <td>
                <?php echo elgg_view('output/url', array(
                    'href'  => "profile/".$owner_user->login,
                    'title' => $owner_user->name,
                    'text'  => '<i class="fa fa-user"></i> '.$owner_user->name,
                ));
                ?>
            </td>
            <td>
                <small>
                    <i class="fa fa-clock-o"></i>
                    <?php echo elgg_view('output/friendlytime', array('time' => $items[0]->time_created));?>
                </small>
            </td>
            <td>
                <?php if($owner_id == elgg_get_logged_in_user_guid()):?>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "rubrics/edit/".$owner_id,
                        'title' => $owner_user->name,
                        'class' => 'btn btn-xs btn-primary btn-border-blue',
                        'text'  => elgg_echo('edit'),
                    ));
                    ?>
                <?php endif;?>
            </td>
            <td class="text-right">
                <?php echo elgg_view('output/url', array(
                    'href'  => 'javascript:;',
                    'class' => 'show-items btn btn-xs btn-border-blue',
                    'text'  => '<strong>'.count($items).'</strong>x<i class="margin-left-5 fa fa-list"></i>',
                ));
                ?>
            </td>
        </tr>
        <tr style="display: none;">
            <td colspan="4" class="bg-white">
                <div style="overflow-y: auto;overflow-x: hidden;max-height: 450px;">
                    <?php echo elgg_view('rubric/items', array('entities' => $items));?>
                </div>
            </td>
        </tr>
    <?php endforeach;?>
</table>
</div>
<?php echo clipit_get_pagination(array('count' => $count, 'limit' => 10)); ?>