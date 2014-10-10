<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 25/02/14
 * Time: 10:41
 * To change this template use File | Settings | File Templates.
 */
$entity = elgg_extract('entity', $vars);

$body = elgg_view("input/hidden", array(
    'name' => 'entity-id',
    'value' => $entity->id,
));
// Attachment simulator
$body .='<div class="form-group">
    <label for="discussion-title">'.elgg_echo("discussion:title_topic").'</label>
    '.elgg_view("input/text", array(
        'name' => 'discussion-title',
        'class' => 'form-control',
        'required' => true
    )).'
</div>
<div class="form-group">
    <label for="discussion-text">'.elgg_echo("discussion:text_topic").'</label>
    '.elgg_view("input/plaintext", array(
        'name' => 'discussion-text',
        'class' => 'form-control wysihtml5',
        'rows'  => 6,
    )).'
</div>';

if($vars['attach_multimedia_group']){
    $body .= '
    <div class="col-md-12">
    '.elgg_view('output/url', array(
        'href'  => "javascript:;",
        'title' => "Attach group multimedia",
        'id' => 'attach_multimedia',
        'class' => 'show',
        'text'  => "<strong><i class='fa fa-image'></i> ".elgg_echo('multimedia:attach_group')."</strong>")).'
        '.elgg_view("multimedia/attach/list").'
    </div>';
}
// Attach simple file
$body .= elgg_view("multimedia/file/attach", array('entity' => $entity, 'class' => 'col-md-8'));

echo elgg_view("page/components/modal",
    array(
        "dialog_class"     => "modal-lg",
        "target"    => "create-new-topic",
        "title"     => elgg_echo("discussion:create"),
        "form"      => true,
        "body"      => $body,
        "cancel_button" => true,
        "ok_button" => elgg_view('input/submit',
            array(
                'value' => elgg_echo('create'),
                'class' => "btn btn-primary"
            ))
));
?>
<script>
$(function(){
//    $("#attach_multimedia").click(function(){
//        $("#attach_list").toggle();
//        $("#attach_list ul.menu-list > li[data-menu=files]").click();
//    });
    $("#attach_multimedia").click(function() {
        $("#attach_list").toggle();
        $("#attach_list").attach_multimedia({
            data: {
                list: $(this).data("menu"),
                entity_id: "<?php echo $entity->id;?>"
            }
        }).loadBy("files");
    });
//    $(document).on("click", "#attach_list ul.menu-list > li", function(){
//        var attach_list = $("#attach_list");
//        $("#attach_list .multimedia-list > div").hide();
//        var type = $(this).data('menu');
//        var content = $("#attach_list .multimedia-list");
//        var list = $("[data-list="+ type +"]");
//        if(list.length == 0){
//            $("#attach_list #attach-loading").show();
//            $.ajax({
//                type: "GET",
//                url: '<?php //echo elgg_get_site_url()."ajax/view/multimedia/attach/";?>//' + type,
//                data: { list: type, entity_id: "<?php //echo $entity->id;?>//" },
//                success: function(data){
//                    content.append(data);
//                    $("#attach_list #attach-loading").hide();
//                }
//            });
//        } else {
//            list.show();
//        }
//    });
});
</script>
<script>
    ///$(function(){


</script>