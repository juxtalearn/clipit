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

$tricky_topic = 0;
$tricky_topic = get_input('tricky_topic');
$input_task = elgg_extract('input_task', $vars);
if($activity_id = elgg_extract('activity_id', $vars)){
    $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
    $tricky_topic = $activity->tricky_topic;
}
$questions = array(1);
if($entity = elgg_extract('entity', $vars)){
    $questions = ClipitQuiz::get_quiz_questions($entity->id);
    echo elgg_view("input/hidden", array(
        'name' => 'quiz[id]',
        'value' => $entity->id
    ));
}

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
$tags = ClipitTrickyTopic::get_tags($tricky_topic);
$id = uniqid();
?>
<script>
    $(function(){
        $(".quiz[data-quiz=<?php echo $id;?>]").quiz({
            'tricky_topic': <?php echo (int)$tricky_topic;?>
        });
    });
</script>
<div class="quiz" data-quiz="<?php echo $id;?>">
<div class="row" role="presentation">
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
                'name'  => "{$input_task}quiz[description]",
                'class' => 'form-control '.($entity->description ? 'mceEditor' : ''),
                'value' => $entity->description,
                'onclick' => $entity->description ? false : '$(this).addClass(\'mceEditor\');
                                        clipit.tinymce();
                                        tinymce.execCommand(\'mceFocus\',false,this.id);',
                'rows'  => 1,
            ));
            ?>
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label><?php echo elgg_echo('quiz:view_mode');?></label>
            <?php echo elgg_view("input/dropdown", array(
                'name' => $input_task.'quiz[view]',
                'aria-label' => $input_task.'quiz[view]',
                'style' => 'padding: 5px;',
                'value' => $entity->view_mode,
                'class' => 'form-control',
                'options_values' => array(
                    ClipitQuiz::VIEW_MODE_LIST => elgg_echo('quiz:view_page:'.ClipitQuiz::VIEW_MODE_LIST),
                    ClipitQuiz::VIEW_MODE_PAGED => elgg_echo('quiz:view_page:'.ClipitQuiz::VIEW_MODE_PAGED)
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
                    'name' => $input_task.'quiz[time][d]',
                    'aria-label' => $input_task.'quiz[time][d]',
                    'style' => 'width: 30%;display: inline-block;padding:5px;',
                    'class' => 'form-control',
                    'value' => $entity ? floor($time / 86000):'',
                    'options_values' => array_merge(array('Days'), $days)
                ));
                ?>
                <?php
                $hours = range(1, 24);
                echo elgg_view("input/dropdown", array(
                    'name' => $input_task.'quiz[time][h]',
                    'aria-label' => $input_task.'quiz[time][h]',
                    'style' => 'width: 30%;display: inline-block;padding:5px;',
                    'class' => 'form-control',
                    'value' => $entity ? floor($time / 3600):'',
                    'options_values' => array_merge(array('Hours'), $hours)
                ));
                ?>
                <?php
                $minutes = range(1, 60);
                echo elgg_view("input/dropdown", array(
                    'name' => $input_task.'quiz[time][m]',
                    'aria-label' => $input_task.'quiz[time][m]',
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
                'tricky-topic' => $tricky_topic,
                'question' => isset($entity) ? $question : false
            ));?>
        <?php
        $i++;
        endforeach;
        ?>
    <?php else: ?>
            <?php echo elgg_view('activity/admin/tasks/quiz/question', array(
                'num' => 1,
                'tricky-topic' => $tricky_topic
            ));?>
    <?php endif;?>
</div>
<div>
    <?php echo elgg_view('output/url', array(
        'href'  => "javascript:;",
        'class' => 'btn btn-primary create-question btn-xs',
        'text'  => '<i class="fa fa-plus"></i> '.elgg_echo('quiz:question:add'),
    ));
    ?>
    <?php if($tricky_topic):?>
    <?php echo elgg_echo('or');?>
    <a class="btn btn-border-blue btn-primary from-tags btn-xs"><?php echo elgg_echo('quiz:select:from_tag');?></a>
    <div class="dynamic-table margin-top-20" style="display: none;">
        <i class="fa fa-spinner fa-spin blue fa-lg"></i>
    </div>
    <?php endif;?>
</div>
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
        width: 60% !important;
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
