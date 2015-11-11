<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   27/11/2014
 * Last update:     27/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$example = elgg_extract('entity', $vars);
$multimedia = elgg_extract('multimedia', $vars);
$user = array_pop(ClipitUser::get_by_id(array($example->owner_id)));
$tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($example->tricky_topic)));
?>
<div class="margin-bottom-10">
    <div class="pull-right">
        <div class="margin-bottom-10">
            <div class="inline-block">
                <?php echo elgg_view('page/components/admin_options', array(
                    'entity' => $example,
                    'user' => $user,
                ));
                ?>
            </div>
            <span class="margin-left-10">
                <?php echo elgg_view("page/components/print_button");?>
            </span>
        </div>
        <small class="show">
            <?php echo elgg_view('output/friendlytime', array('time' => $example->time_created));?>
        </small>
    </div>
    <small class="show"><?php echo elgg_echo('author');?></small>
    <i class="fa-user fa blue"></i>
    <?php echo elgg_view('output/url', array(
        'href'  => "profile/{$user->login}",
        'title' => $user->name,
        'text'  => $user->name,
    ));
    ?>
    <div class="clearfix"></div>
</div>

<?php if($example->description):?>
    <small class="show"><?php echo elgg_echo('description');?></small>
    <?php echo $example->description;?>
<?php endif;?>

<div class="row">
    <div class="col-md-9">
        <div class="margin-bottom-10">
            <small class="show"><?php echo elgg_echo('tricky_topic');?></small>
            <?php echo elgg_view('output/url', array(
                'href'  => "tricky_topics/view/{$example->tricky_topic}",
                'title' => $tricky_topic->name,
                'text'  => $tricky_topic->name,
            ));
            ?>
        </div>
        <div class="margin-bottom-10">
            <small class="show"><?php echo elgg_echo('tags');?></small>
            <?php echo elgg_view('tricky_topic/tags/view', array('tags' => $example->tag_array)); ?>
        </div>
    </div>
    <div class="col-md-3">
        <div class="margin-bottom-10">
            <small class="show"><?php echo elgg_echo('location');?></small>
            <?php echo elgg_view('output/url', array(
                'href'  => set_search_input('tricky_topics/examples', array('location'=>$example->location)),
                'title' => $example->location,
                'text'  => $example->location,
            ));
            ?>
        </div>
        <div class="margin-bottom-10">
            <small class="show"><?php echo elgg_echo('country');?></small>
            <?php echo elgg_view('output/url', array(
                'href'  => set_search_input('tricky_topics/examples', array('country'=>$example->country)),
                'title' => get_countries_list($example->country),
                'text'  => get_countries_list($example->country),
            ));
            ?>
        </div>
    </div>
</div>
<hr>
<?php
if(!empty($example->example_type_array)):
    echo elgg_view('examples/reflection_item/list', array('entities' => $example->example_type_array));
endif;
?>
<a name="resources"></a>
<div>
    <?php echo elgg_view('page/components/title_block', array('title' => elgg_echo('activity:stas')));?>
    <div role="presentation">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#files" aria-controls="files" role="tab" data-toggle="tab">
                    <?php echo elgg_echo('files');?> (<?php echo count($multimedia['files']);?>)
                </a>
            </li>
            <li role="presentation">
                <a href="#videos" aria-controls="videos" role="tab" data-toggle="tab">
                    <?php echo elgg_echo('videos');?> (<?php echo count($multimedia['videos']);?>)
                </a>
            </li>
        </ul>
        <style>
            .filter-by-tags > a{
                padding: 10px !important;
                display: inline-block;
            }
        </style>
        <!-- Tab panes -->
        <div class="tab-content">
            <div role="presentation" class="tab-pane active" id="files">
                <div class="margin-top-20">
                    <?php
                    $params = array(
                        'add_files' => false,
                        'entities' => $multimedia['files'],
                        'href' => $href,
                        'options' => false,
                    );
                    if($multimedia['files']) {
                        echo elgg_view('multimedia/file/list_summary', $params);
                    } else {
                        echo elgg_view('output/empty', array('value' => elgg_echo('file:none')));
                    }
                    ?>
                </div>
            </div>
            <div role="presentation" class="tab-pane" id="videos">
                <div class="margin-top-20">
                    <?php
                    $params = array(
                        'videos' => $multimedia['videos'],
                        'href' => $href,
                        'view_comments' => false,
                        'options' => false,
                        'author_bottom' => true,
                    );
                    if($multimedia['videos']) {
                        echo elgg_view('multimedia/video/list_summary', $params);
                    } else {
                        echo elgg_view('output/empty', array('value' => elgg_echo('videos:none')));
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>