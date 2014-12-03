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
        elgg.get('ajax/view/examples/list',{
            data: {
                stumbling_block: id
            },
            success: function(content){
                var container = $("<tr/>")
                    .attr("data-tag", id)
                    .html( $('<td/>').attr("colspan", 3).html(content) )
                    .append('\
                    <td class="text-center">\
                        <i class="fa fa-level-down fa-rotate-90" style="font-size: 20px;"></i>\
                    </td>');
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
<div class="row">
    <div class="col-md-5">
        Form
    </div>
    <div class="col-md-12">
        <table class="table table-striped table-condensed">
            <tr>
                <th>Name</th>
                <th>Author/Date</th>
                <th><i class="fa fa-sitemap"></i> Tricky topics</th>
                <th>Example</th>
            </tr>
            <?php foreach($tags as $tag):
                $user = array_pop(ClipitUser::get_by_id(array($tag->owner_id)));
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
                                <a href="javascript:;" id="<?php echo $tag->id;?>" class="link-tricky-topic">+ Link Tricky Topic</a>
                            </small>
<!--                                <small><a class="btn btn-xs btn-primary"><i class="fa fa-plus"></i> Add</a></small>-->
                            <div class="list-tricky-topic" style="display: none;"></div>
                        </strong>
                    </td>
                    <td class="text-left">
                            <a href="javascript:;" class="show-examples" id="<?php echo $tag->id;?>">
                                10
                            </a>
<!--                        <a class="show">-->
<!--                            10 Files </i>-->
<!--                        </a>-->
<!--                        <a>10 Url</a>-->
<!--                        <a class="btn btn-xs btn-border-blue">View</a>-->
                    </td>
                </tr>
            <?php endforeach;?>
        </table>
    </div>
</div>
<?php echo clipit_get_pagination(array('count' => $count)); ?>