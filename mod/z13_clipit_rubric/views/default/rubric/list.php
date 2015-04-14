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

$language_index = ClipitPerformanceItem::get_language_index(get_current_language());
$options = true;
$select = false;
if(get_input('activity_create')){
    $input_prefix = get_input('input_prefix');
    $tricky_topic_id = get_input('tricky_topic');
    $rubriczes = ClipitQuiz::get_from_tricky_topic($tricky_topic_id);
    $options = false;
    $select = true;
}
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
        <th><?php echo elgg_echo('category');?></th>
        <th><?php echo elgg_echo('languages');?></th>
        <th></th>
    </tr>
    </thead>
    <?php
    foreach($rubrics as $rubric):
        $user = array_pop(ClipitUser::get_by_id(array($rubric->owner_id)));
        $questions = ClipitQuiz::get_quiz_questions($rubric->id);
        $tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($rubric->tricky_topic)));
    ?>
        <tr id="<?php echo $rubric->id;?>">
        <?php if($select):?>
            <td>
                <a class="btn btn-xs btn-primary btn-border-blue quiz-select">
                    <?php echo elgg_echo('select');?>
                </a>
                <?php echo elgg_view('input/hidden', array(
                    'name' => $input_prefix.'[quiz_id]',
                    'value' => $rubric->id,
                )); ?>
            </td>
        <?php endif;?>
            <td>
                <strong>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "rubrics/view/{$rubric->id}",
                        'title' => $rubric->item_name[$language_index],
                        'text'  => $rubric->item_name[$language_index],
                    ));
                    ?>
                </strong>
            </td>
            <td>
                <?php echo elgg_view('output/url', array(
                    'href'  => set_search_input('rubrics', array('category'=>$rubric->category[$language_index])),
                    'title' => $rubric->category[$language_index],
                    'text'  => $rubric->category[$language_index],
                ));
                ?>
            </td>
            <td>
                <small>
                    <?php
                    $i = 1;
                    $count_items = count($rubric->item_name);
                    foreach(performance_items_available_languages($rubric->item_name) as $language):
                        $comma = $i < $count_items ? ',':'';
                    ?>
                        <span><?php echo $language;?><?php echo $comma;?></span>
                    <?php $i++; endforeach;?>
                </small>
            </td>
            <td>
                <?php echo elgg_view('page/components/admin_options', array(
                    'entity' => $rubric,
                ));?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php echo clipit_get_pagination(array('count' => $count, 'limit' => 10)); ?>