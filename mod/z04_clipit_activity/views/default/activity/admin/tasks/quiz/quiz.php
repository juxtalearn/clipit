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
elgg_load_js("jquery:dynatable");
$tricky_topics = elgg_extract('select_tricky_topic', $vars);

$tricky_topic = 0;
$tricky_topic = get_input('tricky_topic');
$input_prefix = elgg_extract('input_prefix', $vars);

if($input_prefix) {
    $input_prefix = $input_prefix . "[quiz]";
} else {
    $input_prefix = 'quiz';
}

$questions = array(1);

if($entity = elgg_extract('entity', $vars)){
    $tricky_topic = elgg_extract('tricky_topic', $vars);
    $questions = ClipitQuiz::get_quiz_questions($entity->id);
    echo elgg_view("input/hidden", array(
        'name' => $input_prefix.'[id]',
        'value' => $entity->id
    ));
    echo elgg_view("input/hidden", array(
        'name' => $input_prefix.'[tricky_topic]',
        'value' => $tricky_topic
    ));
}

$tags = ClipitTrickyTopic::get_tags($tricky_topic);
$id = uniqid();
?>
<script>
$(function(){
    clipit.quiz.create({
        'quiz': '.quiz[data-quiz=<?php echo $id;?>]',
        'tricky_topic': <?php echo (int)$tricky_topic;?>,
        'input_prefix': '<?php echo $input_prefix;?>'
    });
    <?php if($entity->description):?>
        clipit.tinymce();
    <?php endif;?>
});
</script>
<div class="quiz" data-quiz="<?php echo $id;?>">

    <div class="row" role="menu">
        <div class="col-md-7">
            <?php
            if($tricky_topics):
                $owner_tt = $tricky_topics['owner'];
                $tt = $tricky_topics['others'];
                $selected = $tricky_topic;
                ?>
                <div class="form-group">
                    <label for="<?php echo "{$input_prefix}[tricky_topic]";?>">
                        <?php echo elgg_echo('tricky_topic');?>
                    </label>
                    <select role="menuitem"
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
                <label for="<?php echo "{$input_prefix}[title]";?>"><?php echo elgg_echo('title');?></label>
                <?php echo elgg_view("input/text", array(
                    'name' => "{$input_prefix}[title]",
                    'class' => 'form-control',
                    'value' => $entity->name,
                    'autofocus' => true,
                    'required' => true,
                    'role' => 'menuitem',
                ));
                ?>
            </div>
            <div class="form-group">
                <label><?php echo elgg_echo('description');?></label>
                <?php echo elgg_view("input/plaintext", array(
                    'name'  => "{$input_prefix}[description]",
                    'class' => 'form-control '.($entity->description ? 'mceEditor' : ''),
                    'value' => $entity->description,
                    'onfocus' => $entity->description ? false : '$(this).addClass(\'mceEditor\');
                                    clipit.tinymce();
                                    tinymce.execCommand(\'mceFocus\',false,this.id);',
                    'rows'  => 1,
                    'aria-label' => "{$input_prefix}[description]",
                ));
                ?>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group">
                <label>
                    <?php echo elgg_view('page/components/tooltip', array('text' => elgg_echo('quiz:view_mode:tooltip')));?>
                    <?php echo elgg_echo('quiz:view_mode');?>
                </label>
                <?php echo elgg_view("input/dropdown", array(
                    'name' => $input_prefix.'[view]',
                    'style' => 'padding: 5px;',
                    'value' => $entity->view_mode,
                    'class' => 'form-control',
                    'aria-label' => elgg_echo('quiz:view_mode'),
                    'options_values' => array(
                        ClipitQuiz::VIEW_MODE_LIST => elgg_echo('quiz:view_page:'.ClipitQuiz::VIEW_MODE_LIST),
                        ClipitQuiz::VIEW_MODE_PAGED => elgg_echo('quiz:view_page:'.ClipitQuiz::VIEW_MODE_PAGED)
                    )
                ));
                ?>
            </div>
            <div class="form-group">
                <label>
                    <?php echo elgg_view('page/components/tooltip', array('text' => elgg_echo('quiz:max_time:tooltip')));?>
                    <?php echo elgg_echo('quiz:max_time');?>
                </label>
                <div class="row">
                    <div class="col-md-4">
                        <small><?php echo elgg_echo('time:days');?></small>
                    <?php
                        $time = $entity->max_time;
                        $days = range(0, 30);
                        echo elgg_view("input/dropdown", array(
                            'name' => $input_prefix.'[time][d]',
                            'label' => $input_prefix.'[time][d]',
                            'style' => 'padding:5px;',
                            'class' => 'form-control margin-top-5',
                            'value' => $entity ? floor($time / 86000):'',
                            'options_values' => $days,
                            'aria-label' => elgg_echo('quiz:max_time'),
                        ));
                    ?>
                    </div>
                    <div class="col-md-4">
                        <small><?php echo elgg_echo('time:hours');?></small>
                        <?php
                        $hours = range(0, 24);
                        echo elgg_view("input/dropdown", array(
                            'name' => $input_prefix.'[time][h]',
                            'label' => $input_prefix.'[time][h]',
                            'style' => 'padding:5px;',
                            'class' => 'form-control margin-top-5',
                            'value' => $entity ? floor(($time / 3600) % 24):'1',
                            'options_values' => $hours,
                            'aria-label' => elgg_echo('time:hours'),
                        ));
                        ?>
                    </div>
                    <div class="col-md-4">
                        <small><?php echo elgg_echo('time:minutes');?></small>
                        <?php
                        $minutes = array_combine(range(0, 55, 5), range(0, 55, 5));
                        echo elgg_view("input/dropdown", array(
                            'name' => $input_prefix.'[time][m]',
                            'label' => $input_prefix.'[time][m]',
                            'style' => 'padding:5px;',
                            'class' => 'form-control margin-top-5',
                            'value' => $entity ? floor(($time / 60) % 60):'',
                            'options_values' => $minutes,
                            'required' => true,
                            'aria-label' => elgg_echo('time:minutos'),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label><?php echo elgg_echo('quiz:target');?></label>
                <label style="font-weight: normal;">
                    <input type="radio" aria-label="<?php echo elgg_echo('clipit:activities');?>"
                           name="<?php echo $input_prefix;?>[target]"
                            <?php echo ($entity->target == ClipitQuiz::TARGET_CLIPIT || !$entity_target) ? 'checked':'';?>
                           value="<?php echo ClipitQuiz::TARGET_CLIPIT;?>">
                    <?php echo elgg_echo('quiz:target:clipit');?>
                </label>
                <label style="font-weight: normal;">
                    <input type="radio" aria-label="Large displays"
                           name="<?php echo $input_prefix;?>[target]"
                            <?php echo $entity->target == ClipitQuiz::TARGET_LARGEDISPLAY ? 'checked':'';?>
                           value="<?php echo ClipitQuiz::TARGET_LARGEDISPLAY;?>">
                    <?php echo elgg_echo('quiz:target:large_display');?>
                </label>
            </div>
        </div>
    </div>
    <ul class="questions">
        <?php if($entity):?>
            <?php
            $i = 1;
            $questions = ClipitQuizQuestion::get_by_id($questions, 0, 0, 'order');
            foreach($questions as $question):
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
        <a class="btn btn-border-blue btn-primary from-tags btn-sm margin-left-10">
            <?php echo elgg_echo('quiz:select:from_tag');?>
        </a>
        <div class="dynamic-table margin-top-20" style="display: none;">
            <i class="fa fa-spinner fa-spin blue fa-lg"></i>
        </div>
    <!--    --><?php //endif;?>
    </div>
</div>