<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   03/11/2014
 * Last update:     03/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$activity = elgg_extract('entity', $vars);
$questions = array(1);
if($entity = elgg_extract('entity', $vars)){
    $questions = ClipitQuiz::get_quiz_questions($entity->id);
    echo elgg_view("input/hidden", array(
        'name' => 'quiz[id]',
        'value' => $entity->id
    ));
}
$activity = array_pop(ClipitActivity::get_by_id(array(478)));
function get_questions_from_tag($tag){
    $return_array = array();
    $all_items = ClipitQuizQuestion::get_all(0, 0, "", true, true); // Get all item ids, not objects
    foreach($all_items as $item_id) {
        $item_tags = (array)ClipitQuizQuestion::get_tags((int)$item_id);
        if(array_search($tag, $item_tags) !== false) {
            $return_array[] = $item_id;
        }
    }
    return $return_array;
}
$tags = ClipitTrickyTopic::get_tags($activity->tricky_topic);
?>
<script>
    $(".tags-select").chosen({disable_search_threshold: 1});
    $(".questions-select").chosen().change(function(){
        elgg.get('ajax/view/activity/admin/tasks/quiz/add_type',{
            data: {
                type: "question",
                question: $(this).val(),
                tricky_topic: $("#create-question").data("tricky_topic"),
                num: $(".question").length + 1
            },
            success: function(content){
                $(".questions").append(content);
                $('.questions-select')
                    .val('')
                    .trigger('chosen:updated');
            }
        });
    });
</script>
<div class="row">
    <div class="col-md-7">
        <div class="form-group">
            <label>Title</label>
            <?php echo elgg_view("input/text", array(
                'name' => 'quiz[title]',
                'class' => 'form-control',
                'value' => $entity->name
            ));
            ?>
        </div>
        <div class="form-group">
            <label>Description</label>
            <?php echo elgg_view("input/plaintext", array(
                'name'  => "quiz[description]",
                'class' => 'form-control '.($entity->description ? 'mceEditor' : ''),
                'value' => $entity->description,
                'onclick' => $entity->description ? false : '$(this).addClass(\'mceEditor\');
                                        tinymce_setup();
                                        tinymce.execCommand(\'mceFocus\',false,this.id);',
                'rows'  => 1,
            ));
            ?>
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label>Tipo de vista del cuestionario</label>
            <?php echo elgg_view("input/dropdown", array(
                'name' => 'quiz[view]',
                'style' => 'padding: 5px;',
                'value' => $entity->view_mode,
                'class' => 'form-control',
                'options_values' => array(
                    ClipitQuiz::VIEW_MODE_LIST => 'En una página',
                    ClipitQuiz::VIEW_MODE_PAGED => 'En varias páginas'
                )
            ));
            ?>
        </div>
        <div class="form-group">
            <label>Máximo de tiempo para hacer el exámen</label>
            <div>
                <?php
                $time = $entity->max_time;
                $days = range(1, 30);
                echo elgg_view("input/dropdown", array(
                    'name' => 'quiz[time][d]',
                    'style' => 'width: 30%;display: inline-block;padding:5px;',
                    'class' => 'form-control',
                    'value' => $entity ? floor($time / 86000):'',
                    'options_values' => array_merge(array('Days'), $days)
                ));
                ?>
                <?php
                $hours = range(1, 24);
                echo elgg_view("input/dropdown", array(
                    'name' => 'quiz[time][h]',
                    'style' => 'width: 30%;display: inline-block;padding:5px;',
                    'class' => 'form-control',
                    'value' => $entity ? floor($time / 3600):'',
                    'options_values' => array_merge(array('Hours'), $hours)
                ));
                ?>
                <?php
                $minutes = range(1, 60);
                echo elgg_view("input/dropdown", array(
                    'name' => 'quiz[time][m]',
                    'style' => 'width: 30%;display: inline-block;padding:5px;',
                    'class' => 'form-control',
                    'value' => $entity ? floor(($time / 60) % 60):'',
                    'options_values' => array_merge(array('Minutes'), $minutes)
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<div class="questions">
    <?php if($entity):?>
        <?php
        $i = 1;
        foreach($questions as $question_id):
            $question = array_pop(ClipitQuizQuestion::get_by_id(array($question_id)));
        ?>
            <?php echo elgg_view('activity/admin/tasks/quiz/question/list', array(
                'num' => $i,
                'tricky-topic' => $activity->tricky_topic,
                'question' => isset($entity) ? $question : false
            ));?>
        <?php
        $i++;
        endforeach;
        ?>
    <?php else: ?>
            <?php echo elgg_view('activity/admin/tasks/quiz/question', array(
                'num' => 1,
                'tricky-topic' => $activity->tricky_topic
            ));?>
    <?php endif;?>
</div>
<div>
    <?php echo elgg_view('output/url', array(
        'href'  => "javascript:;",
        'id' => 'create-question',
        'data-tricky_topic' => $activity->tricky_topic,
        'class' => 'btn btn-primary',
        'text'  => '<i class="fa fa-plus"></i> Create a question',
    ));
    ?>
    <?php if($activity):?>
    or
    <select name="tags[]" data-placeholder="<?php echo elgg_echo('click_add');?>" style="width:auto;" class="questions-select" tabindex="-1">
        <option value=""></option>
        <?php
        $tags = ClipitTrickyTopic::get_tags($activity->tricky_topic);
        foreach($tags as $tag_id):
            $tag = array_pop(ClipitTag::get_by_id(array($tag_id)));
            $questions_tag = ClipitQuizQuestion::get_by_id(get_questions_from_tag($tag->id));
        ?>
        <optgroup label="<?php echo $tag->name;?>">
            <?php foreach($questions_tag as $question_tag):?>
                <option value="<?php echo $question_tag->id;?>"><?php echo $question_tag->name;?></option>
            <?php endforeach;?>
        </optgroup>
        <?php endforeach;?>
    </select>
    <?php endif;?>
</div>
<style>
    .chosen-container-single{
        padding: 1px 10px;
        box-shadow: 0 0 0 4px rgba(225,235,240,0.5) !important;
        border: 1px solid #eff4f7;
        margin-left: 10px;
        position: relative;
        height: 35px;
        cursor: default;
        max-width: 60% !important;
    }
    .chosen-container-single .chosen-drop{
        top: auto;
        bottom: 40px;
    }
    .chosen-container-single:after {
        content: "\f0d7";
        font: normal normal normal 14px/1 FontAwesome;
        right: 10px;
        top: 10px;
        position: absolute;
    }
    .chosen-container-single > .chosen-single{
        color: #000;
        line-height: 30px;
        font-size: 15px;
        text-decoration: none !important;
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .chosen-container-single .chosen-search{
        margin: 5px;
    }
    .chosen-container-single .chosen-search:after {
        content: "\f002";
        position: absolute;
        right: 15px;
        font: normal normal normal 14px/1 FontAwesome;
        top: 12px;
        color: #bbb;
    }
    .chosen-container-single .chosen-search input{
        width: 100%;
        border: 1px solid #ccc;
    }
    .tags-question-select .chosen-container-multi{
        width: 100% !important;
    }
</style>
