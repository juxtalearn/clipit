<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   01/12/2014
 * Last update:     01/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$tags = elgg_extract('entities', $vars);
$count = elgg_extract('count', $vars);
?>
<script>
$(function(){
    $(document).on("click", ".show-examples", function(){
        var tr = $(this).closest("tr")
        id = $(this).attr("id"),
            tr_example = $("[data-tag="+id+"]");
        if(tr_example.length > 0){
            tr_example.toggle();
            return false;
        }
        elgg.get('ajax/view/examples/summary',{
            data: {
                stumbling_block: id
            },
            success: function(content){
                var container = $("<tr/>")
                    .attr("data-tag", id)
                    .html( $('<td/>').attr("colspan", 4).html(content).css("padding", "10px") );
//                    .append('\
//                    <td class="text-center">\
//                        <i class="fa fa-level-down fa-rotate-90" style="font-size: 20px;"></i>\
//                    </td>');
                tr.after(container);
            }
        });
    });
    $(".link-tricky-topic").click(function(){
        $(this).toggle();
        var content = <?php echo json_encode(elgg_view_form('stumbling_blocks/link', array('data-validate' => 'true')));?>,
            container = $(this).closest("td").find(".list-tricky-topic");
        container.toggle().html(content);
        container.find("form .input-entity-id").val($(this).attr("id"));
        container.find('form option').each(function(){
            var text=$(this).text()
            if (text.length > 30)
                $(this).val(text).text(text.substr(0,30)+'…')
        })
    });
});
</script>
<div class="pull-right margin-bottom-10">
    <?php echo elgg_view("page/components/print_button");?>
</div>
<div class="clearfix"></div>
<table class="table table-striped table-condensed">
    <tr>
        <th><?php echo elgg_echo('name');?></th>
        <th>Author/Date</th>
        <th><i class="fa fa-sitemap"></i> <?php echo elgg_echo('tricky_topics');?></th>
        <th><?php echo elgg_echo('examples');?></th>
    </tr>
    <?php foreach($tags as $tag):
        $user = array_pop(ClipitUser::get_by_id(array($tag->owner_id)));
        $examples = ClipitExample::get_by_tags(array($tag->id));
        ?>
        <tr class="list-item">
            <td>
                <strong>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "explore/search?by=tag&id={$tag->id}",
                        'title' => $tag->name,
                        'text'  => $tag->name,
                    ));
                    ?>
                </strong>
                <div>
                    <?php echo $tag->description;?>
                </div>
            </td>
            <td>
                <small>
                    <div>
                    <i class="fa-user fa blue"></i>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "profile/{$user->login}",
                        'title' => $user->name,
                        'text'  => $user->name,
                    ));
                    ?>
                    </div>
                    <?php echo elgg_view('output/friendlytime', array('time' => $tricky_topic->time_created));?>
                </small>
            </td>
            <td>
                <ul>
                <?php foreach(ClipitTag::get_tricky_topics($tag->id) as $tricky_topic_id):
                    $tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($tricky_topic_id)));
                ?>
                    <li class="margin-left-15" style="list-style-type: square;">
                        <?php echo elgg_view('output/url', array(
                            'href'  => "tricky_topics/view/{$tricky_topic->id}",
                            'title' => $tricky_topic->name,
                            'text'  => $tricky_topic->name,
                        ));
                        ?>
                    </li>
                <?php endforeach;?>
                </ul>
                <div class="margin-top-5">
                <strong>
                    <small>
                        <a href="javascript:;" id="<?php echo $tag->id;?>" class="link-tricky-topic">
                            + <?php echo elgg_echo('tricky_topic:link');?>
                        </a>
                    </small>
                    <div class="list-tricky-topic" style="display: none;"></div>
                </strong>
            </td>
            <td class="text-left">
                <?php if(count($examples)):?>
                <a href="javascript:;" class="show-examples btn btn-xs btn-border-blue" id="<?php echo $tag->id;?>">
                    <strong><?php echo count($examples);?></strong>
                    <i class="margin-left-10 fa fa-th"></i>
                </a>
                <?php endif;?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php echo clipit_get_pagination(array('count' => $count)); ?>