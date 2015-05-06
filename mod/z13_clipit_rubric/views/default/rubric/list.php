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
    $(document).on("click", "#create-rubric", function(){

    });
    $(document).on("click", ".show-questions", function(){
        var tr = $(this).closest("tr")
            id = $(this).attr("id"),
            tr_quiz = $("[data-quiz="+id+"]");
        if(tr_quiz.length > 0){
            tr_quiz.toggle();
            return false;
        }
        elgg.get('ajax/view/questions/summary',{
            data: {
                quiz: id
            },
            success: function(content){
                var container = $("<tr/>")
                    .attr("data-quiz", id)
                    .html( $('<td/>').attr("colspan", 5).html(content).css("padding", "10px") );
                tr.after(container);
            }
        });
    });
});
</script>
<table class="table table-striped">
    <thead>
    <tr>
        <?php if($select):?>
            <th style="width: 50px;"></th>
        <?php endif;?>
        <th><?php echo elgg_echo('title');?></th>
        <th><?php echo elgg_echo('last_added');?></th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <?php
    foreach($rubrics as $category => $items):
//        foreach($categories as $category => $items){
//            $item = array_pop($items);
//            $categories_data[$item->category[$i]] = array('name'=> $item->category[$i], 'description' =>$item->category_description[$i]);
//        }
        $user = array_pop(ClipitUser::get_by_id(array($rubric->owner_id)));
    ?>
        <tr id="<?php echo json_encode($category);?>">
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
                    'class' => 'show-questions btn btn-xs btn-border-blue',
                    'id' => $quiz->id,
                    'text'  => '<strong>'.count($items).'</strong>x<i class="margin-left-5 fa fa-list"></i>',
                ));
                ?>
            </td>
            <td>
                <?php echo elgg_view('page/components/admin_options', array(
                    'entity' => $items[0],
                ));?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php echo clipit_get_pagination(array('count' => $count, 'limit' => 10)); ?>