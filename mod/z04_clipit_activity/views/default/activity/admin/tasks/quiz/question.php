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
<?php if($num !== false):?>
<li class="question row margin-bottom-10" data-id="<?php echo $id;?>">
<?php endif; ?>
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
                'aria-label'=> elgg_echo('delete'),
            ));
            ?>
        </div>
    </div>
    <?php endif;?>
    <?php echo elgg_view("input/hidden", array(
        'name' => $input_prefix.'[question]['.$id.'][order]',
        'value' => $num,
        'class' => 'input-order'
    )); ?>
    <div class="<?php echo $num !== false ? "col-xs-11":"" ?>">
        <div style="padding: 10px; background: #fafafa;">
        <?php if($num !== false):?>
            <i class="fa fa-arrows-v text-muted pull-right reorder-question"></i>
        <?php endif; ?>
        <?php
        $types = array(
            '' => elgg_echo('select:type'),
            ClipitQuizQuestion::TYPE_SELECT_MULTI => elgg_echo('quiz:question:type:'.ClipitQuizQuestion::TYPE_SELECT_MULTI),
            ClipitQuizQuestion::TYPE_SELECT_ONE => elgg_echo('quiz:question:type:'.ClipitQuizQuestion::TYPE_SELECT_ONE),
            ClipitQuizQuestion::TYPE_NUMBER => elgg_echo('quiz:question:type:'.ClipitQuizQuestion::TYPE_NUMBER),
            ClipitQuizQuestion::TYPE_TRUE_FALSE => elgg_echo('quiz:question:type:'.ClipitQuizQuestion::TYPE_TRUE_FALSE),
        );
        ?>
        <div class="form-group row" style="padding: 10px;">
            <div class="form-group col-md-12">
                <label for="<?php echo $input_prefix.'[question]['.$id.'][title]';?>">
                    <?php echo elgg_echo('quiz:question:statement');?>
                </label>
                <?php echo elgg_view("input/text", array(
                    'name' => $input_prefix.'[question]['.$id.'][title]',
                    'class' => 'form-control',
                    'value' => $question->name,
                    'required' => true
                ));
                ?>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label><?php echo elgg_echo('quiz:question:additional_info');?></label>
                    <?php echo elgg_view("input/plaintext", array(
                        'name' => $input_prefix.'[question]['.$id.'][description]',
                        'value' => $question->description,
                        'class' => 'form-control '.($question ? 'mceEditor':''),
                        'onfocus'   => '$(this).addClass(\'mceEditor\');
                                        clipit.tinymce();
                                        tinymce.execCommand(\'mceFocus\',false,this.id);',
                        'rows'  => 1,
                    ));
                    ?>
                </div>
                <div class="margin-bottom-10">
                    <label class="pull-right">
                        <?php echo elgg_view('output/url', array(
                            'href'  => "javascript:;",
                            'class' => 'add-result',
                            'data-toggle' => 'collapse',
                            'data-target' => '#image_'.$id,
                            'text'  => '<i class="fa fa-image"></i> '.elgg_echo('quiz:question:add_image'),
                        ));
                        ?>
                    </label>
                    <label class="inline">
                        <?php echo elgg_view('output/url', array(
                            'href'  => "javascript:;",
                            'class' => 'add-result text-truncate',
                            'data-toggle' => 'collapse',
                            'data-target' => '#video_'.$id,
                            'text'  => '<i class="fa fa-youtube-play"></i> '.elgg_echo('quiz:question:add_video'),
                        ));
                        ?>
                    </label>
                    <?php
                    if($question->image):
                    $image = array_pop(ClipitFile::get_by_id(array($question->image)));
                    ?>
                    <div class="margin-top-10 margin-bottom-10 overflow-hidden question-image">
                    <div class="multimedia-preview image-block">
                        <?php echo elgg_view('output/url', array(
                            'href'  => $image->url,
                            'title' => $image->name,
                            'text'  => elgg_view("multimedia/file/preview", array('file'  => $image))
                        ));
                        ?>
                    </div>
                    <div class="content-block">
                        <?php echo elgg_view('output/url', array(
                            'href'  => 'javascript:;',
                            'class'  => 'btn btn-xs btn-border-red',
                            'data-toggle' => 'collapse',
                            'data-target' => '#image_'.$id,
                            'onclick' => '$(this).closest(\'.question-image\').remove();',
                            'title' => elgg_echo('quiz:question:remove_image'),
                            'text'  => elgg_echo('quiz:question:remove_image')
                        ));
                        ?>
                    </div>
                    <?php echo elgg_view("input/hidden", array(
                        'name' => $input_prefix.'[question]['.$id.'][image][url]',
                        'value' => $question->image,
                    ));
                    ?>
                    </div>
                    <?php endif;?>
                    <div class="collapse margin-bottom-20" id="image_<?php echo $id;?>">
                        <div class="clearfix"></div>
                        <small class="show"><?php echo elgg_echo('quiz:question:add_image:valid_extension');?>: jpg, jpeg, gif, png</small>
                        <label for="<?php echo $input_prefix.'[question]['.$id.'][image]';?>"></label>
                        <?php echo elgg_view("input/file", array(
                            'name' => $input_prefix.'[question]['.$id.'][image]',
                            'data-rule-extension' => 'png|jpe?g|gif',
                        ));
                        ?>
                    </div>
                    <div class="<?php echo $question->video ? 'in':'collapse';?> margin-bottom-10" id="video_<?php echo $id;?>">
                        <label for="<?php echo $input_prefix.'[question]['.$id.'][video]';?>"></label>
                        <?php echo elgg_view("input/text", array(
                            'name' => $input_prefix.'[question]['.$id.'][video]',
                            'class' => 'form-control',
                            'value' => $question->video,
                            'placeholder' => 'Video URL',
                            'data-rule-url' => 'true'
                        ));
                        ?>
                    </div>
                </div>
                <div class="clearfix"></div>
                <hr class="margin-0 margin-bottom-5">
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
                        $limit = 6;
                        for($i=1;$i<=$limit;$i++):
                        ?>
                            <span class="cursor-pointer"
                                  style="left: <?php echo ( $limit !== 1 ) ? ( $i - 1 ) / ( $limit - 1 ) * 100 : 0;?>%;">
                                <?php echo $i;?>
                            </span>
                        <?php endfor;?>
                    </div>
                </div>
                <div class="select-tags">
                    <?php if($tricky_topic):?>
                        <?php echo elgg_view('tricky_topic/list', array(
                            'tricky_topic' => $tricky_topic,
                            'tags' => $tags,
                            'tag_label' => elgg_echo('tags:related'),
                            'show_tags' => 'checkbox',
                            'input_name' => $input_prefix.'[question]['.$id.'][tags][]'
                        )); ?>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="<?php echo $input_prefix.'[question]['.$id.'][type]';?>">
                        <?php echo elgg_echo('quiz:question:type');?>
                    </label>
                    <?php echo elgg_view("input/dropdown", array(
                        'name' => $input_prefix.'[question]['.$id.'][type]',
                        'style' => 'padding: 5px;',
                        'aria-label' => $input_prefix.'[question]['.$id.'][type]',
                        'value' => $question ? $question->option_type: false,
                        'class' => 'form-control select-question-type',
                        'options_values' => $types,
                        'required' => true
                    ));
                    ?>
                </div>
                <div class="show-question" id="<?php echo $id;?>"
                     data-question="<?php echo ClipitQuizQuestion::TYPE_SELECT_ONE;?>"
                     style="display: <?php echo $question->option_type == ClipitQuizQuestion::TYPE_SELECT_ONE ? 'block':'none';?>;">
                    <div class="show text-muted margin-bottom-10">
                        <input type="radio" checked disabled style="margin: 0;margin-right: 10px;vertical-align: middle;">
                        <?php echo elgg_echo('quiz:question:answer:select');?>
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
                            $i = 1;
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
                <div class="show-question" id="<?php echo $id;?>"
                     data-question="<?php echo ClipitQuizQuestion::TYPE_SELECT_MULTI;?>"
                     style="display: <?php echo $question->option_type == ClipitQuizQuestion::TYPE_SELECT_MULTI ? 'block':'none';?>">
                    <div class="show text-muted margin-bottom-10">
                        <input type="checkbox" checked disabled style="margin: 0;margin-right: 10px;vertical-align: middle;">
                        <?php echo elgg_echo('quiz:question:answers:select');?>
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
                            $i = 1;
                            if($question->option_type == ClipitQuizQuestion::TYPE_SELECT_MULTI):
                                foreach($options as $key => $value):
                            ?>
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
                            'text'  => '<i class="fa fa-plus"></i> '.elgg_echo('quiz:question:result:add'),
                        ));
                        ?>
                    </strong>
                </div>
                <div class="show-question" id="<?php echo $id;?>"
                     data-question="<?php echo ClipitQuizQuestion::TYPE_NUMBER;?>"
                     style="display: <?php echo $question->option_type == ClipitQuizQuestion::TYPE_NUMBER ? 'block':'none';?>">
                    <?php echo elgg_view('activity/admin/tasks/quiz/types/number',
                        array(
                            'id' => $id,
                            'checked' => $question->option_type == ClipitQuizQuestion::TYPE_NUMBER ? end($question->validation_array) :'',
                            'input_prefix' => $input_prefix
                            ));
                    ?>
                </div>
                <div class="show-question" id="<?php echo $id;?>"
                     data-question="<?php echo ClipitQuizQuestion::TYPE_TRUE_FALSE;?>"
                     style="display: <?php echo $question->option_type == ClipitQuizQuestion::TYPE_TRUE_FALSE ? 'block':'none';?>;">
                    <div class="show text-muted margin-bottom-10">
                        <?php echo elgg_echo('quiz:question:answer:select');?>
                    </div>
                    <?php echo elgg_view('activity/admin/tasks/quiz/types/true_false',
                        array(
                            'id' => $id,
                            'checked' => $question->option_type == ClipitQuizQuestion::TYPE_TRUE_FALSE ? $question->validation_array : '',
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
                        <th><?php echo elgg_echo('examples:related:stumbling_block');?></th>
                        <th class="text-right">
                            <?php echo elgg_view('output/url', array(
                                'href'  => "javascript:;",
                                'class' => 'fa fa-chevron-down close-table blue',
                                'text'  => '',
                            ));
                            ?>
                        </th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
            <!-- Examples related to Stumbling Blocks end -->
        </div>
    </div>
<?php if($num !== false):?>
</li>
<?php endif; ?>
