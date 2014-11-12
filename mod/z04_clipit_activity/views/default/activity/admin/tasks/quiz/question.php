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
$id = uniqid('question_');
$num = elgg_extract('num', $vars);
$tricky_topic = elgg_extract('tricky-topic', $vars);
$question = false;
$tt_tags = ClipitTrickyTopic::get_tags($tricky_topic);

if($question_id = get_input('question')){
    $question = array_pop(ClipitQuizQuestion::get_by_id(array($question_id)));
}elseif($question = elgg_extract('question', $vars)){
    // nothing
}

if($question){
    $options = array_filter($question->option_array);
    $tags = $question->tag_array;
    ?>
    <script>
        $("[data-id='<?php echo $id;?>'] .show-question[data-question='<?php echo $question->option_type;?>']").show();
        $("[data-id='<?php echo $id;?>'] textarea").click();
    </script>
    <?php
    echo elgg_view("input/hidden", array(
        'name' => 'question['.$id.'][id_parent]',
        'value' => $question->id,
    ));
}
?>

<div class="question row margin-bottom-10" data-id="<?php echo $id;?>">
    <?php if($num !== false):?>
    <div class="col-xs-1 text-right">
        <h3 class="text-muted margin-0 question-num">
            <?php echo $num;?>.
        </h3>
        <div class="margin-top-10">
            <?php echo elgg_view('output/url', array(
                'href'  => "javascript:;",
                'class' => 'btn btn-xs btn-border-red remove-question',
                'text'  => elgg_echo('delete'),
            ));
            ?>
        </div>
    </div>
    <?php endif;?>
    <div class="<?php echo $num !== false ? "col-xs-11":"" ?>">
        <div style="padding: 10px; background: #fafafa;">
        <?php
        $types = array(
            '' => 'Select',
            ClipitQuizQuestion::TYPE_SELECT_MULTI => 'Multiple choice',
            ClipitQuizQuestion::TYPE_SELECT_ONE => 'One choice',
            ClipitQuizQuestion::TYPE_STRING => 'Long question',
            ClipitQuizQuestion::TYPE_NUMBER => 'Numeric question',
            ClipitQuizQuestion::TYPE_TRUE_FALSE => 'True or false',
        );
        ?>
        <div class="form-group row" style="padding: 10px;">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Título de la pregunta</label>
                    <?php echo elgg_view("input/text", array(
                        'name' => 'question['.$id.'][title]',
                        'class' => 'form-control',
                        'value' => $question->name,
                        'required' => true
                    ));
                    ?>
                </div>
                <div class="form-group">
                    <label>Enunciado</label>
                    <?php echo elgg_view("input/plaintext", array(
                        'name' => 'question['.$id.'][description]',
                        'value' => $question->description,
                        'class' => 'form-control',
                        'onclick'   => '$(this).addClass(\'mceEditor\');
                                        tinymce_setup();
                                        tinymce.execCommand(\'mceFocus\',false,this.id);',
                        'rows'  => 1,
                    ));
                    ?>
                </div>
                <div class="form-group">
                    <label><?php echo elgg_echo('difficulty');?></label>
                    <div class="difficulty-slider" id="<?php echo mt_rand(0,500);?>">
                        <?php
                            echo elgg_view("input/hidden", array(
                                'name' => 'question['.$id.'][difficulty]',
                                'value' => $question ? $question->difficulty : 1
                            ));
                        ?>
                        <?php for($i=1;$i<=10;$i++):?>
                            <span class="cursor-pointer" style="left: <?php echo ( 10 !== 1 ) ? ( $i - 1 ) / ( 10 - 1 ) * 100 : 0;?>%;"><?php echo $i;?></span>
                        <?php endfor;?>
                    </div>
                </div>
                <?php if($tt_tags):?>
                <div class="form-group tags-question-select">
                    <label><?php echo elgg_echo('tags');?></label>
                    <select name="question[<?php echo $id;?>][tags][]" data-placeholder="<?php echo elgg_echo('click_add');?>" style="width:100%;" multiple class="tags-select" tabindex="8">
                        <option value=""></option>
                        <?php
                        foreach($tt_tags as $tag_id):
                            $tag = array_pop(ClipitTag::get_by_id(array($tag_id)));
                            ?>
                            <option <?php echo in_array($tag_id, $tags) ? "selected" : "";?> value="<?php echo $tag->id;?>"><?php echo $tag->name;?></option>
                        <?php endforeach;?>
                    </select>
                </div>
                <?php endif;?>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tipo de pregunta</label>
                    <?php echo elgg_view("input/dropdown", array(
                        'name' => 'question['.$id.'][type]',
                        'style' => 'padding: 5px;',
                        'value' => $question ? $question->option_type: false,
                        'class' => 'form-control select-question-type',
                        'options_values' => $types,
                        'required' => true
                    ));
                    ?>
                </div>
                <div class="show-question" id="<?php echo $id;?>" data-question="<?php echo ClipitQuizQuestion::TYPE_SELECT_ONE;?>" style="display: none;">
                    <div class="show text-muted margin-bottom-10">
                        <input type="radio" checked disabled style="margin: 0;margin-right: 10px;vertical-align: middle;"> Select the correct answer
                    </div>
                    <hr class="margin-0 margin-bottom-20">
                    <div class="results">
                        <?php if(!$question):?>
                            <?php for($i = 1; $i <= 3; $i++):?>
                                <?php echo elgg_view('activity/admin/tasks/quiz/types/select_one', array('id' => $id, 'num' => $i));?>
                            <?php endfor;?>
                        <?php else: ?>
                            <?php
                            $i = 0;
                            if($question->option_type == ClipitQuizQuestion::TYPE_SELECT_ONE):
                                foreach($options as $key => $value):?>
                                    <?php echo elgg_view('activity/admin/tasks/quiz/types/select_one',
                                        array('id' => $id, 'num' => $i, 'value' => $value, 'checked' => $question->validation_array[$key]));?>
                                    <?php
                                    $i++;
                                endforeach;
                            endif;
                            ?>
                        <?php endif;?>
                    </div>
                    <strong>
                        <?php echo elgg_view('output/url', array(
                            'href'  => "javascript:;",
                            'class' => 'add-result',
                            'text'  => '<i class="fa fa-plus"></i> Add Result',
                        ));
                        ?>
                    </strong>
                </div>
                <div class="show-question" id="<?php echo $id;?>" data-question="<?php echo ClipitQuizQuestion::TYPE_SELECT_MULTI;?>" style="display: none;">
                    <div class="show text-muted margin-bottom-10">
                        <input type="checkbox" checked disabled style="margin: 0;margin-right: 10px;vertical-align: middle;"> Select the correct answer
                    </div>
                    <hr class="margin-0 margin-bottom-20">
                    <div class="results">
                        <?php if(!$question):?>
                            <?php for($i = 1; $i <= 3; $i++):?>
                                <?php echo elgg_view('activity/admin/tasks/quiz/types/select_multi', array('id' => $id, 'num' => $i));?>
                            <?php endfor;?>
                        <?php else: ?>
                            <?php
                            $i = 0;
                            if($question->option_type == ClipitQuizQuestion::TYPE_SELECT_MULTI):
                                foreach($options as $key => $value):?>
                                    <?php echo elgg_view('activity/admin/tasks/quiz/types/select_multi',
                                        array('id' => $id, 'num' => $i, 'value' => $value, 'checked' => $question->validation_array[$key]));?>
                            <?php
                                    $i++;
                                endforeach;
                            endif;
                            ?>
                        <?php endif;?>
                    </div>
                    <strong>
                        <?php echo elgg_view('output/url', array(
                            'href'  => "javascript:;",
                            'id' => 'add-result',
                            'text'  => '<i class="fa fa-plus"></i> Add Result',
                        ));
                        ?>
                    </strong>
                </div>
                <div class="show-question" id="<?php echo $id;?>" data-question="<?php echo ClipitQuizQuestion::TYPE_STRING;?>" style="display: none;">
                    <?php echo elgg_view('activity/admin/tasks/quiz/types/string', array('id' => $id, 'checked' => end($question->validation_array)));?>
                </div>
                <div class="show-question" id="<?php echo $id;?>" data-question="<?php echo ClipitQuizQuestion::TYPE_NUMBER;?>" style="display: none;">
                    <?php echo elgg_view('activity/admin/tasks/quiz/types/number', array('id' => $id, 'checked' => end($question->validation_array)));?>
                </div>
                <div class="show-question" id="<?php echo $id;?>" data-question="<?php echo ClipitQuizQuestion::TYPE_TRUE_FALSE;?>" style="display: none;">
                    <?php echo elgg_view('activity/admin/tasks/quiz/types/true_false', array('id' => $id, 'checked' => end($question->validation_array)));?>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>