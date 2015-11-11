<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   03/11/2014
 * Last update:     03/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$id = elgg_extract('id', $vars);
$num = elgg_extract('num', $vars);
$id_input = uniqid('input_');
$input_prefix = elgg_extract('input_prefix', $vars);
?>
<div class="margin-bottom-20 result">
    <label class="inline-block" style="padding-right: 10px;">
        <input
            type="radio" <?php echo $vars['checked'] == true ? 'checked' : '';?>
            name="<?php echo $input_prefix;?>[question][<?php echo $id;?>][select_one][correct]"
            value="<?php echo $num;?>"
            required="true"
            class="inline-block">
    </label>
    <?php echo elgg_view('output/url', array(
        'href'  => "javascript:;",
        'class' => 'remove-answer fa fa-times red pull-right margin-top-10',
        'text'  => '',
        'aria-label' => elgg_echo('delete'),
    ));
    ?>
    <?php echo elgg_view("input/text", array(
        'name' => $input_prefix.'[question]['.$id.'][select_one]['.$id_input.'][value]',
        'class' => 'form-control inline-block answer-result',
        'style' => 'width: 85%',
        'placeholder' => elgg_echo('quiz:question:answer').' '.$num,
        'value' => $vars['value'],
        'required' => true
    ));
    ?>
</div>