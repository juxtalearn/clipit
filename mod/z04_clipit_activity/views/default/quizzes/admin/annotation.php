<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   17/11/2014
 * Last update:     17/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$result = elgg_extract('result', $vars);
$question = elgg_extract('question', $vars);

echo elgg_view('input/hidden', array(
    'name' => 'entity-id',
    'id' => 'entity-id',
    'value' => $result->id
));
?>
<div class="bg-blue-lighter_4 margin-top-10" style="padding: 5px;">
    <?php if($question->option_type == ClipitQuizQuestion::TYPE_STRING):?>
    <div class="pull-right">
        <strong>
            <a class="margin-right-10">
                <i class="fa fa-check green"></i> Correct
            </a>
            <a>
                <i class="fa fa-times red"></i> Incorrect
            </a>
        </strong>
    </div>
    <?php endif;?>
    <i class="fa fa-user blue"></i>
    <?php echo elgg_view('output/url', array(
        'text' => 'Añadir anotación',
        'href' => 'javascript:;',
        'onclick' => "$(this).parent('div').find('.annotate').toggle();
                            $(this).parent('div').find('.annotate textarea').addClass('mceEditor')
                            tinymce_setup();
                            tinyMCE.activeEditor.focus();",
    ));
    ?>
    <?php if($result->description):?>
    <script>
        tinymce_setup();
    </script>
    <?php endif;?>
    <div class="annotate" style="<?php echo $result->description ? '': 'display:none';?>">
        <?php echo elgg_view("input/plaintext", array(
            'class' => 'form-control '. $result->description ? 'mceEditor': '',
            'value' => $result->description,
            'name' => 'annotation',
            'rows' => 5
        ));
        ?>
        <a class="btn btn-primary btn-xs pull-right save-annotation" style="margin: 10px;"><?php echo elgg_echo('save');?></a>
        <div class="clearfix"></div>
    </div>
</div>