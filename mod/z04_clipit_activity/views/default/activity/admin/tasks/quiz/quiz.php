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
$tricky_topics = elgg_extract('select_tricky_topic', $vars);

$tricky_topic = 0;
$tricky_topic = get_input('tricky_topic');
$input_prefix = elgg_extract('input_prefix', $vars);
//if($activity_id = elgg_extract('activity_id', $vars)){
//    $activity = array_pop(ClipitActivity::get_by_id(array($activity_id)));
//    $tricky_topic = $activity->tricky_topic;
//}


if($input_prefix) {
    $input_prefix = $input_prefix . "[quiz]";
} else {
    $input_prefix = 'quiz';
}

$questions = array(1);
if($entity = elgg_extract('entity', $vars)){
    $tricky_topic = $entity->tricky_topic;
    $questions = ClipitQuiz::get_quiz_questions($entity->id);
    echo elgg_view("input/hidden", array(
        'name' => $input_prefix.'[id]',
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
        'tricky_topic': <?php echo (int)$tricky_topic;?>,
        'input_prefix': '<?php echo $input_prefix;?>'
    });
});
</script>
<div class="quiz" data-quiz="<?php echo $id;?>">

<div class="row">
    <div class="col-md-7">
        <?php
        if($tricky_topics):
            $owner_tt = $tricky_topics['owner'];
            $tt = $tricky_topics['others'];
            $selected = $tricky_topic;
            ?>
            <div class="form-group">
                <label><?php echo elgg_echo('tricky_topic');?></label>
                <select
                    required="required"
                    class="form-control select-tricky_topic"
                    name="<?php echo $input_prefix;?>[tricky_topic]"
                    style="padding-top: 5px;padding-bottom: 5px;">

                    <option value="">
                        <?php echo elgg_echo('tricky_topic:select');?>
                    </option>
                    <?php if(count($owner_tt)>0):?>
                        <optgroup label="<?php echo elgg_echo('tricky_topic:created_by_me');?>">
                            <?php foreach($owner_tt as $value => $name):?>
                                <option <?php echo $selected == $value ? 'selected' : '';?> value="<?php echo $value;?>">
                                    <?php echo $name;?>
                                </option>
                            <?php endforeach;?>
                        </optgroup>
                    <?php endif;?>
                    <?php if(count($tt)>0):?>
                        <optgroup label="<?php echo elgg_echo('tricky_topic:created_by_others');?>">
                            <?php foreach($tt as $value => $name):?>
                                <option <?php echo $selected == $value ? 'selected' : '';?> value="<?php echo $value;?>">
                                    <?php echo $name;?>
                                </option>
                            <?php endforeach;?>
                        </optgroup>
                    <?php endif;?>
                </select>
            </div>
        <?php endif; ?>
        <div class="form-group">
            <label><?php echo elgg_echo('title');?></label>
            <?php echo elgg_view("input/text", array(
                'name' => "{$input_prefix}[title]",
                'class' => 'form-control',
                'value' => $entity->name
            ));
            ?>
        </div>
        <div class="form-group">
            <label><?php echo elgg_echo('description');?></label>
            <?php echo elgg_view("input/plaintext", array(
                'name'  => "{$input_prefix}[description]",
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
                'name' => $input_prefix.'[view]',
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
            <div class="row">
                <div class="col-md-4">
                    <small><?php echo elgg_echo('time:days');?></small>
                <?php
                    $time = $entity->max_time;
                    $days = range(0, 30);
                    echo elgg_view("input/dropdown", array(
                        'name' => $input_prefix.'[time][d]',
                        'style' => 'padding:5px;',
                        'class' => 'form-control margin-top-5',
                        'value' => $entity ? floor($time / 86000):'',
                        'options_values' => $days
                    ));
                ?>
                </div>
                <div class="col-md-4">
                    <small><?php echo elgg_echo('time:hours');?></small>
                    <?php
                    $hours = range(0, 24);
                    echo elgg_view("input/dropdown", array(
                        'name' => $input_prefix.'[time][h]',
                        'style' => 'padding:5px;',
                        'class' => 'form-control margin-top-5',
                        'value' => $entity ? floor($time / 3600):'1',
                        'options_values' => $hours
                    ));
                    ?>
                </div>
                <div class="col-md-4">
                    <small><?php echo elgg_echo('time:minutes');?></small>
                    <?php
                    $minutes = array_combine(range(0, 45, 15), range(0, 45, 15));
                    echo elgg_view("input/dropdown", array(
                        'name' => $input_prefix.'[time][m]',
                        'style' => 'padding:5px;',
                        'class' => 'form-control margin-top-5',
                        'value' => $entity ? floor(($time / 60) % 60):'',
                        'options_values' => $minutes,
                        'required' => true
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<ul class="questions">
    <?php if($entity):?>
        <?php
        $i = 1;
        $questions = ClipitQuizQuestion::get_by_id($questions, 0, 0, 'order');
        foreach($questions as $question):
            $question = array_pop(ClipitQuizQuestion::get_by_id(array($question->id)));
        ?>
            <?php echo elgg_view('activity/admin/tasks/quiz/question/list', array(
                'num' => $i,
                'tricky-topic' => $tricky_topic,
                'question' => isset($entity) ? $question : false,
                'input_prefix' => $input_prefix
            ));?>
        <?php
        $i++;
        endforeach;
        ?>
<!--    --><?php //else: ?>
<!--            --><?php //echo elgg_view('activity/admin/tasks/quiz/question', array(
//                'num' => 1,
//                'tricky-topic' => $tricky_topic,
//                'input_prefix' => $input_prefix
//            ));?>
    <?php endif;?>
</ul>
<div class="add-question" style="display: <?php echo $entity ? 'block' : 'none'?>;">
    <?php echo elgg_view('output/url', array(
        'href'  => "javascript:;",
        'class' => 'btn btn-primary create-question btn-sm',
        'text'  => '<i class="fa fa-plus"></i> '.elgg_echo('quiz:question:add'),
    ));
    ?>
<!--    --><?php //if($tricky_topic):?>
    <?php echo elgg_echo('or');?>
    <a class="btn btn-border-blue btn-primary from-tags btn-xs"><?php echo elgg_echo('quiz:select:from_tag');?></a>
    <div class="dynamic-table margin-top-20" style="display: none;">
        <i class="fa fa-spinner fa-spin blue fa-lg"></i>
    </div>
<!--    --><?php //endif;?>
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
