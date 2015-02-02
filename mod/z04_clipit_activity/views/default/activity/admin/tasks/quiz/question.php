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
$input_prefix = elgg_extract('input_prefix', $vars);
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
    if($vars['parent']){
        echo elgg_view("input/hidden", array(
            'name' => $input_prefix.'[question]['.$id.'][id_parent]',
            'value' => $question->id,
        ));
    } else {
        echo elgg_view("input/hidden", array(
            'name' => $input_prefix.'[question]['.$id.'][id]',
            'value' => $question->id,
        ));
    }
}
?>

<li class="question row margin-bottom-10" data-id="<?php echo $id;?>">
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
    <?php echo elgg_view("input/hidden", array(
        'name' => $input_prefix.'[question]['.$id.'][order]',
        'value' => $num,
        'class' => 'input-order'
    )); ?>

    <?php endif;?>
    <div class="<?php echo $num !== false ? "col-xs-11":"" ?>">
        <div style="padding: 10px; background: #fafafa;">
        <i class="fa fa-reorder text-muted pull-right"></i>
        <?php
        $types = array(
            '' => 'Select',
            ClipitQuizQuestion::TYPE_SELECT_MULTI => 'Multiple choice',
            ClipitQuizQuestion::TYPE_SELECT_ONE => 'One choice',
            ClipitQuizQuestion::TYPE_NUMBER => 'Numeric question',
            ClipitQuizQuestion::TYPE_TRUE_FALSE => 'True or false',
        );
        ?>
        <div class="form-group row" style="padding: 10px;">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Título de la pregunta</label>
                    <?php echo elgg_view("input/text", array(
                        'name' => $input_prefix.'[question]['.$id.'][title]',
                        'class' => 'form-control',
                        'value' => $question->name,
                        'required' => true
                    ));
                    ?>
                </div>
                <div class="form-group">
                    <label>Enunciado</label>
                    <?php echo elgg_view("input/plaintext", array(
                        'name' => $input_prefix.'[question]['.$id.'][description]',
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
                    <div class="difficulty-slider">
                        <?php
                            echo elgg_view("input/hidden", array(
                                'name' => $input_prefix.'[question]['.$id.'][difficulty]',
                                'value' => $question ? $question->difficulty : 1
                            ));
                        ?>
                        <?php
                        $limit = 5;
                        for($i=1;$i<=$limit;$i++):
                        ?>
                            <span class="cursor-pointer"
                                  style="left: <?php echo ( $limit !== 1 ) ? ( $i - 1 ) / ( $limit - 1 ) * 100 : 0;?>%;">
                                <?php echo $i;?>
                            </span>
                        <?php endfor;?>
                    </div>
                </div>
                <?php echo elgg_view('tricky_topic/list', array(
                    'tricky_topic' => 2868,
                    'tags' => $tags,
                    'show_tags' => 'checkbox',
                ));
                ?>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tipo de pregunta</label>
                    <?php echo elgg_view("input/dropdown", array(
                        'name' => $input_prefix.'[question]['.$id.'][type]',
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
                                <?php echo elgg_view('activity/admin/tasks/quiz/types/select_one',
                                    array(
                                        'id' => $id,
                                        'num' => $i,
                                        'input_prefix' => $input_prefix
                                    ));
                                ?>
                            <?php endfor;?>
                        <?php else: ?>
                            <?php
                            $i = 0;
                            if($question->option_type == ClipitQuizQuestion::TYPE_SELECT_ONE):
                                foreach($options as $key => $value):?>
                                    <?php echo elgg_view('activity/admin/tasks/quiz/types/select_one',
                                        array(
                                            'id' => $id,
                                            'num' => $i,
                                            'value' => $value,
                                            'checked' => $question->validation_array[$key],
                                            'input_prefix' => $input_prefix
                                        ));
                                    ?>
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
                            'text'  => '<i class="fa fa-plus"></i> '.elgg_echo('quiz:question:result:add'),
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
                                <?php echo elgg_view('activity/admin/tasks/quiz/types/select_multi',
                                    array(
                                        'id' => $id,
                                        'num' => $i,
                                        'input_prefix' => $input_prefix
                                    ));?>
                            <?php endfor;?>
                        <?php else: ?>
                            <?php
                            $i = 0;
                            if($question->option_type == ClipitQuizQuestion::TYPE_SELECT_MULTI):
                                foreach($options as $key => $value):?>
                                    <?php echo elgg_view('activity/admin/tasks/quiz/types/select_multi',
                                        array(
                                            'id' => $id,
                                            'num' => $i,
                                            'value' => $value,
                                            'checked' => $question->validation_array[$key],
                                            'input_prefix' => $input_prefix
                                        ));?>
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
                <div class="show-question" id="<?php echo $id;?>" data-question="<?php echo ClipitQuizQuestion::TYPE_NUMBER;?>" style="display: none;">
                    <?php echo elgg_view('activity/admin/tasks/quiz/types/number',
                        array(
                            'id' => $id,
                            'checked' => end($question->validation_array),
                            'input_prefix' => $input_prefix
                            ));
                    ?>
                </div>
                <div class="show-question" id="<?php echo $id;?>" data-question="<?php echo ClipitQuizQuestion::TYPE_TRUE_FALSE;?>" style="display: none;">
                    <?php echo elgg_view('activity/admin/tasks/quiz/types/true_false',
                        array(
                            'id' => $id,
                            'checked' => $question->validation_array,
                            'input_prefix' => $input_prefix
                        ));
                    ?>
                </div>
            </div>

        </div>
            <!-- Examples related to Stumbling Blocks -->
            <table class="table bg-white examples-list" style="display: none;border: 1px solid #bae6f6;">
                <thead>
                    <tr>
                        <th>Examples related to Stumbling blocks</th>
                        <th class="text-right">
                            <?php echo elgg_view('output/url', array(
                                'href'  => "javascript:;",
                                'class' => 'fa fa-times close-table red',
                                'text'  => '',
                            ));
                            ?>
                        </th>
                    </tr>
                </thead>
                <tbody>
                <tr data-example="" style="display: none;">
                <td style="padding-top: 10px;" colspan="2">
                    <div class="row">
                        <div class="col-md-6 text-truncate">
                            <strong>
                                <a href="http://clipit.es/dev/tricky_topics/examples/view/3075" title="Esto es usable" rel="nofollow">Esto es usable</a>
                            </strong>
                            <small>
                                <p>Concepto de como entienden los usuarios la usabilidad</p>
                            </small>
                        </div>
                        <div class="row col-md-6">
                            <div class="margin-bottom-10 col-md-7 text-truncate">
                                <small class="show">Location</small>
                                <a href="http://clipit.es/dev/tricky_topics/examples?subject=Universidad Autonoma" title="Universidad Autonoma" rel="nofollow">Universidad Autonoma de Madrid</a>
                            </div>
                            <div class="margin-bottom-10 col-md-5 text-truncate">
                                <small class="show">Country</small>
                                <a href="http://clipit.es/dev/tricky_topics/examples?subject=Universidad Autonoma" title="Spain" rel="nofollow">Spain</a>
                            </div>
                        </div>
                    </div>

                <div style="
    background: #fff;
    padding: 5px;
    display: none;
" class="col-md-12"><div style="
    background: #d6f0fa;
    padding: 10px;
    margin-bottom: 5px;
">

                        <div class="row">
                            <div class="col-md-6"><a style="
    display: block;
          ">Flawed causal reasoning </a><a style="
    display: block;
">Key characteristic conveys group membership</a><a style="
    display: block;
">Weak human-like or world-like analogy</a></div><div class="col-md-6"> <strong class="show">Intuitive Beliefs</strong><div class="content-block"><small>Informal, intuitive ways of thinking about the world. Strongly biased toward causal explanations</small></div></div></div>



                    </div>
                    <div class="margin-top-10" style="
    margin-left: 20px;
    display: none;
"><div><strong>
                                Underpinning understandings
                            </strong><div class="text-muted margin-bottom-10">
                                Understanding that the student is expected to know already. e.g. to do the calculations related to Avogadro’s number in Chemistry assumes a math understanding of powers of ten and ratios. Learning about genetic drift assumes an understanding of natural selection.                    </div></div>
                        <div><strong>
                                Underpinning understandings
                            </strong><div class="text-muted margin-bottom-10">
                                Understanding that the student is expected to know already. e.g. to do the calculations related to Avogadro’s number in Chemistry assumes a math understanding of powers of ten and ratios. Learning about genetic drift assumes an understanding of natural selection.                    </div></div><div><strong>
                                Underpinning understandings
                            </strong><div class="text-muted margin-bottom-10">
                                Understanding that the student is expected to know already. e.g. to do the calculations related to Avogadro’s number in Chemistry assumes a math understanding of powers of ten and ratios. Learning about genetic drift assumes an understanding of natural selection.                    </div></div>
                    </div>
                    <div style="
    background: #d6f0fa;
    padding: 10px;
    margin-bottom: 5px;
">

                        <div class="row">
                            <div class="col-md-6"><a style="
    display: block;
          ">Essential Concepts</a></div><div class="col-md-6"> <strong class="show">Intuitive Beliefs</strong><div class="content-block"><small>Informal, intuitive ways of thinking about the world. Strongly biased toward causal explanations</small></div></div></div>



                    </div>
                    <div style="
    background: #d6f0fa;
    padding: 10px;
    margin-bottom: 5px;
">

                        <div class="row">
                            <div class="col-md-6"><a style="
    display: block;
          ">Underpinning understandings</a><a style="
    display: block;
">Understanding of Scientific method, process and practice</a></div><div class="col-md-6"> <strong class="show">Intuitive Beliefs</strong><div class="content-block"><small>Informal, intuitive ways of thinking about the world. Strongly biased toward causal explanations</small></div></div></div>



                    </div></div>


                </td>



                </tr>
                </tbody>
            </table>
            <!-- Examples related to Stumbling Blocks end -->
        </div>
    </div>
</li>

<script>
$(function(){
    $(document).on('click', '.select-all-tags', function(){
        var container = $(this).parent('div'),
            isChecked = $(this).prop('checked');
        container.find('input[type=checkbox]').click();
        container.find('input[type=checkbox]').prop('checked', isChecked);
    });
    $('.question').on('click', '.examples-list .btn-reflection', function(){
        $(this).closest('td').find('.reflection-list').toggle();
    });
    $('.question').on('click', '.close-table', function(){
        $(this).closest('.examples-list').hide();
    });
    $('.question').on('click', '.tags-list input[type=checkbox]', function(){
        var stumbling_block = $(this).val(),
            question = $(this).closest('.question'),
            table = question.find('.examples-list');
        if(!$(this).is(':checked')) {
            table.find('tr[data-stumbling_block=' + stumbling_block + ']').remove();
            if(table.find('tr[data-example]').is(':visible') == 0){
//            if(table.find('tr[data-example]').length == 0){
                table.find('.close-table').click();
            }
        } else {
            elgg.getJSON('ajax/view/questions/examples', {
                data: {
                    'stumbling_block': stumbling_block
                },
                success: function (data) {
                    if(data.length > 0){
                        table.fadeIn();
                    }
                    $.each(data, function (i, item) {
                        if (table.find('tr[data-example=' + item.example + ']').length == 0) {
                            table.append(
                                $('<tr/>')
                                    .attr({
                                        'data-example': item.example,
                                        'data-stumbling_block': stumbling_block
                                    })
                                    .append('<td style="padding-top: 10px;" colspan="2">' + item.content + '</td>')
                            );
                        }
                    });
                }
            });
        }
    });
});
</script>