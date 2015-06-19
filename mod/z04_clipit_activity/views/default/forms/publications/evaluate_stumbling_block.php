<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   11/06/2015
 * Last update:     11/06/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$tag = elgg_extract('tag', $vars);
$rating = elgg_extract('rating', $vars);
$rating_tag = elgg_extract('rating_tag', $vars);
?>
<div class="checking margin-top-15" style="border-bottom: 1px solid #bae6f6;padding-bottom: 5px;margin-bottom: 5px;">
    <?php echo elgg_view('input/radio', array(
        'name' => "tag_rating[{$tag->id}][is_used]",
        'options' => array(
            elgg_echo("input:yes") => 1,
            elgg_echo("input:no") => 0
        ),
        'required' => true,
        'value' => $rating ? ($rating_tag[$tag->id]->is_used ? '1':'0'):'',
        'class' => 'input-radios-horizontal enable-comment blue pull-right',
    )); ?>
    <label for="tag_rating[<?php echo $tag->id; ?>][is_used]">
        <span class="text-muted">*</span>
        <?php echo $tag->name; ?>
    </label>
    <?php echo elgg_view("input/plaintext", array(
        'name'  => "tag_rating[{$tag->id}][comment]",
        'class' => 'form-control '.($rating ? 'mceEditor':''),
        'style' => $rating?'':'display:none;',
        'placeholder' => elgg_echo('publications:question:sb'),
        'onclick'   => !$rating ? '$(this).addClass(\'mceEditor\');
                                    clipit.tinymce();
                                    tinymce.execCommand(\'mceFocus\',false,this.id);': '',
        'value' => $rating_tag[$tag->id]->description,
        'rows'  => 1,
    ));
    ?>
</div>