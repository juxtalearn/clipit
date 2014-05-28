<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   16/05/14
 * Last update:     16/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
$parent_id = elgg_extract('parent_id', $vars);

// Load tinyMCE in textarea
$body = "<script>$(function(){tinymce_setup(); $('ul#tags').each(performance_tags);});</script>";
$body .= '<div class="bg-info">Cuidadin.... bla bla bla</div>';
$body .= elgg_view("input/hidden", array(
    'name' => 'entity-id',
    'value' => $entity->id,
));
$body .= elgg_view("input/hidden", array(
    'name' => 'parent-id',
    'value' => $parent_id,
));
$tags = $entity->tag_array;
$tag_value = array();
foreach($tags as $tag_id){
    $tag = array_pop(ClipitTag::get_by_id(array($tag_id)));
    $tag_value[] = $tag->name;
}
$tags_value = implode(", ", $tag_value);
$body .= elgg_view("input/hidden", array(
    'name' => 'tags',
    'id' => 'input_tags',
    'value' => $tags_value
));
$body .= '<div class="row">';
$body .= '
<div class="col-md-4">
    <img src="'.$entity->preview.'" class="img-responsive"><br>
    <h5 class="blue"><strong>Select performance items</strong></h5>
    <div class="multiple-check form-control">
        <a href="javascript:;"><h4>- Learning</h4></a>
            <div class="check-group">';
foreach(ClipitPerformanceItem::get_all() as $performance_item){
    $body .= '<label for="pi_'.$performance_item->id.'_'.$entity->id.'">
                <input type="checkbox" name="performance_items[]" value="'.$performance_item->id.'" id="pi_'.$performance_item->id.'_'.$entity->id.'">
                <span>'.$performance_item->name.'</span>
              </label>';
}
$body .='
            </div>
    </div>
</div>
';
?>
<script>
$(function(){


});
</script>

<?
$body .= '<div class="col-md-8">';
$body .='
<div class="form-group">
    <label for="video-title">'.elgg_echo("video:url") .'</label>
    <a href="'.$entity->url.'" target="_blank">'.$entity->url.'</a>
    <hr style="margin: 10px 0;">
    <label for="video-title">'.elgg_echo("video:title").'</label>
    '.elgg_view("input/text", array(
        'name' => 'video-title',
        'value' => $entity->name,
        'class' => 'form-control',
        'required' => true
    )).'
</div>
<div class="form-group">
    <label for="video-title">'.elgg_echo("video:tags").'</label>
    <ul id="tags"></ul>
</div>
<div class="form-group">
    <label for="video-description">'.elgg_echo("video:description").'</label>
    '.elgg_view("input/plaintext", array(
        'name'  => 'video-description',
        'value' => $entity->description,
        'id'    => 'publish-'.$entity->id,
        'class' => 'form-control mceEditor',
        'required' => true,
        'rows'  => 6,
    )).'
</div>';
$body .= "</div>"; // .col-md-8
$body .= "</div>"; // .row

echo elgg_view("page/components/modal",
    array(
        "dialog_class"     => "modal-lg",
        "remote"    => true,
        "target"    => "publish-video-{$entity->id}",
        "title"     => elgg_echo("publish:video"),
        "form"      => true,
        "body"      => $body,
        "cancel_button" => true,
        "ok_button" => elgg_view('input/submit',
            array(
                'value' => elgg_echo('publish'),
                'class' => "btn btn-primary"
            ))
    ));
?>
