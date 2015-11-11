<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   01/12/2014
 * Last update:     01/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$tags = elgg_extract('entities', $vars);
$table_orders = elgg_extract('table_orders', $vars);
$count = elgg_extract('count', $vars);
?>
<script>
    $(function() {
        $(".link-tricky-topic").click(
            {content: <?php echo json_encode(elgg_view_form('stumbling_blocks/link', array('data-validate' => 'true')));?>},
            clipit.tricky_topic.link
        );
    });
</script>
<style>
    .ln{
        opacity: 0.7;
    }
    .table tr:hover .ln{
        opacity: 1;
    }
</style>
<div class="pull-right margin-bottom-10">
    <?php echo elgg_view("page/components/print_button");?>
</div>
<div class="clearfix"></div>
<table class="table table-striped table-condensed table-order" role="presentation">
    <thead role="presentation">
    <tr role="presentation">
        <?php foreach($table_orders as $data):?>
            <th role="presentation">
                <a href="<?php echo $data['href'];?>">
                    <i class="fa <?php echo $data['sort_icon'];?> blue margin-right-5" style="position: absolute;left: 0;margin-top: 3px;"></i>
                    <span class="margin-left-10"><?php echo $data['value'];?></span>
                </a>
            </th>
        <?php endforeach;?>
        <th role="presentation"><i class="fa fa-sitemap"></i> <?php echo elgg_echo('tricky_topics');?></th>
        <th role="presentation"><?php echo elgg_echo('author');?>-<?php echo elgg_echo('date');?></th>
        <th role="presentation" style="width: 50px;"><?php echo elgg_echo('examples');?></th>
        <th role="presentation" style="width: 100px;"><?php echo elgg_echo("options");?></th>
    </tr>
    </thead>
    <?php foreach($tags as $tag):
        $user = array_pop(ClipitUser::get_by_id(array($tag->owner_id)));
        $examples = ClipitExample::get_by_tag(array($tag->id));
        ?>
        <tr role="presentation" class="list-item">
            <td role="presentation">
                <strong>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "tricky_topics/stumbling_blocks/view/{$tag->id}",
                        'title' => $tag->name,
                        'text'  => $tag->name,
                    ));
                    ?>
                </strong>
                <div>
                    <?php echo $tag->description;?>
                </div>
            </td>
            <td role="presentation">
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
                <strong class="ln">
                    <small>
                        <a href="javascript:;" id="<?php echo $tag->id;?>" class="link-tricky-topic">
                            + <?php echo elgg_echo('tricky_topic:link');?>
                        </a>
                    </small>
                    <div class="list-tricky-topic" style="display: none;"></div>
                </strong>
            </td>
            <td role="presentation">
                <small>
                    <div>
                        <?php if($user->id == elgg_get_logged_in_user_guid()):?>
                            <i class="fa-user fa blue"></i>
                        <?php endif;?>
                        <?php echo elgg_view('output/url', array(
                            'href'  => "profile/{$user->login}",
                            'title' => $user->name,
                            'text'  => $user->name,
                        ));
                        ?>
                    </div>
                    <?php echo elgg_view('output/friendlytime', array('time' => $tag->time_created));?>
                </small>
            </td>
            <td role="presentation" class="text-left">
                <?php if(count($examples)):?>
                <a href="javascript:;" class="show-examples btn btn-xs btn-border-blue" id="<?php echo $tag->id;?>">
                    <strong><?php echo count($examples);?></strong>
                    <i class="margin-left-5 fa fa-list"></i>
                </a>
                <?php endif;?>
            </td>
            <td role="presentation">
                <?php echo elgg_view('page/components/admin_options', array(
                    'entity' => $tag,
                    'user' => $user,
                    'is_linked' => $is_linked,
                ));
                ?>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php echo clipit_get_pagination(array('count' => $count)); ?>