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
        <th><?php echo elgg_echo('title');?></th>
        <th><?php echo elgg_echo('last_added');?></th>
        <th></th>
        <th style="width: 100px;"></th>
    </tr>
    </thead>
    <tr></tr>
    <?php foreach($rubrics as $category => $items):?>
        <tr>
            <td>
                <strong>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "rubrics/view/?name=".json_encode(($category)),
                        'title' => $category,
                        'text'  => $category,
                    ));
                    ?>
                </strong>
            </td>
            <td>
                <small>
                    <i class="fa fa-clock-o"></i>
                    <?php echo elgg_view('output/friendlytime', array('time' => $items[0]->time_created));?>
                </small>
            </td>
            <td class="text-right">
                <?php echo elgg_view('output/url', array(
                    'href'  => 'javascript:;',
                    'class' => 'show-items btn btn-xs btn-border-blue',
                    'text'  => '<strong>'.count($items).'</strong>x<i class="margin-left-5 fa fa-list"></i>',
                ));
                ?>
            </td>
            <td class="text-right">
                <?php echo elgg_view('output/url', array(
                    'href'  => 'rubrics/edit?name='.json_encode($category),
                    'class' => 'btn btn-xs btn-primary btn-border-blue',
                    'text'  => elgg_echo('edit'),
                ));
                ?>
            </td>
        </tr>
        <tr style="display: none;">
            <td colspan="4">
                <div class="row">
                    <?php foreach($items as $item):?>
                        <div class="col-md-3 margin-bottom-15 text-truncate">
                            <span title="<?php echo $item->name;?>"><?php echo $item->name;?></span>
                        </div>
                    <?php endforeach;?>
                </div>
            </td>
        </tr>
    <?php endforeach;?>
</table>
</div>
<?php echo clipit_get_pagination(array('count' => $count, 'limit' => 10)); ?>