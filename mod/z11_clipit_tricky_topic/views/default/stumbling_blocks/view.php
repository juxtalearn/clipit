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
?>
<script>
$(function(){
    $(".link-tricky-topic").click(function(){
        $(this).toggle();
        var content = <?php echo json_encode(elgg_view_form('stumbling_blocks/link'));?>;
//        $(content).find('.input-entity-id').val($(this).attr("id"));
//        $(content).find("input").val("TEST");
        var p = $.parseJSON(JSON.stringify(<?php echo json_encode(elgg_view_form('stumbling_blocks/link'));?>));
        console.log($(p).find("input"));
        $(this).closest("td").find(".list-tricky-topic").toggle().html(content);
    });
});
</script>
<div class="row">
    <div class="col-md-5">
        Form
    </div>
    <div class="col-md-12">
<!--        <ul>-->
<!--        --><?php //foreach(ClipitTag::get_all() as $tag):
//            $user = array_pop(ClipitUser::get_by_id(array($tag->owner_id)));
//        ?>
<!--            <li class="list-item">-->
<!--                <a class="label label-primary">--><?php //echo $tag->name;?><!--</a>-->
<!--                <small class="show margin-top-10">-->
<!--                    <i class="fa-user fa blue"></i>-->
<!--                    --><?php //echo elgg_view('output/url', array(
//                        'href'  => "profile/{$user->login}",
//                        'title' => $user->name,
//                        'text'  => $user->name,
//                    ));
//                    ?>
<!--                    --><?php //echo elgg_view('output/friendlytime', array('time' => $tricky_topic->time_created));?>
<!--                </small>-->
<!--            </li>-->
<!--        --><?php //endforeach;?>
<!--        </ul>-->
        <table class="table table-striped">
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
                                <a><?php echo $tricky_topic->name;?></a>
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
                        <small>
                            <a>10 Examples</a>
<!--                        <a class="show">-->
<!--                            10 Files </i>-->
<!--                        </a>-->
<!--                        <a>10 Url</a>-->
                        </small>
<!--                        <a class="btn btn-xs btn-border-blue">View</a>-->
                    </td>
                </tr>
            <?php endforeach;?>
        </table>
    </div>
</div>