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
$tricky_topic = elgg_extract('entity', $vars);
$tt_parent = elgg_extract('tricky_topic_parent', $vars);
$multimedia = elgg_extract('multimedia', $vars);
$examples = elgg_extract('examples', $vars);
$user = array_pop(ClipitUser::get_by_id(array($tricky_topic->owner_id)));
$is_linked = false;
$quizzes = ClipitQuiz::get_from_tricky_topic($tricky_topic->id);
$activities = ClipitActivity::get_from_tricky_topic($tricky_topic->id);
if(!empty($activities) || !empty($quizzes) ){
    $is_linked = true;
}
?>
<div class="margin-bottom-10">
    <div class="pull-right">
        <div class="margin-bottom-10">
            <div class="inline-block">
                <?php echo elgg_view('page/components/admin_options', array(
                    'entity' => $tricky_topic,
                    'user' => $user,
                    'is_linked' => $is_linked,
                ));?>
            </div>
            <span class="margin-left-10">
                <?php echo elgg_view("page/components/print_button");?>
            </span>
        </div>
        <small class="show">
            <?php echo elgg_view('output/friendlytime', array('time' => $tricky_topic->time_created));?>
        </small>
    </div>
    <div class="inline-block">
        <small class="show"><?php echo elgg_echo('author');?></small>
        <i class="fa-user fa blue"></i>
        <?php echo elgg_view('output/url', array(
            'href'  => "profile/{$user->login}",
            'title' => $user->name,
            'text'  => $user->name,
        ));
        ?>
    </div>
    <?php
    if($tt_parent):
        $tt_parent = array_pop(ClipitTrickyTopic::get_by_id(array($tt_parent)));
    ?>
    <div class="inline-block margin-left-20">
        <small class="show">
            <i class="fa fa-sitemap"></i>
            <?php echo elgg_echo('tricky_topic:duplicate_from');?>
        </small>
        <?php echo elgg_view('output/url', array(
            'href'  => "tricky_topics/view/{$tt_parent->id}",
            'title' => $tt_parent->name,
            'text'  => $tt_parent->name,
        ));
        ?>
    </div>
    <?php endif;?>
    <div class="clearfix"></div>
</div>

<div class="row">
    <div class="col-md-12">
        <?php if($tricky_topic->description):?>
            <small class="show"><?php echo elgg_echo('description');?></small>
            <?php echo $tricky_topic->description;?>
        <?php endif;?>
    </div>
</div>

<div class="row">
    <div class="col-md-7">
        <small class="show"><?php echo elgg_echo('tags');?></small>
        <?php echo elgg_view('tricky_topic/tags/view', array('tags' => $tricky_topic->tag_array)); ?>
    </div>
    <div class="col-md-2">
        <small class="show"><?php echo elgg_echo('education_level');?></small>
        <?php echo elgg_view('output/url', array(
            'href'  => set_search_input('tricky_topics', array('education_level'=>$tricky_topic->education_level)),
            'title' => elgg_echo('education_level:'.$tricky_topic->education_level),
            'text'  => elgg_echo('education_level:'.$tricky_topic->education_level),
        ));
        ?>
    </div>
    <div class="col-md-3">
        <small class="show"><?php echo elgg_echo('tricky_topic:subject');?></small>
        <?php echo elgg_view('output/url', array(
            'href'  => set_search_input('tricky_topics', array('subject'=>$tricky_topic->subject)),
            'title' => $tricky_topic->subject,
            'text'  => $tricky_topic->subject,
        ));
        ?>
    </div>
</div>
<a name="examples"></a>
<div class="margin-bottom-10">
    <?php echo elgg_view('page/components/title_block', array('title' => elgg_echo('examples')));?>
    <?php echo elgg_view('examples/summary', array('entities' => $examples));?>
    <?php echo elgg_view('output/url', array(
        'class' => 'btn btn-xs btn-primary',
        'href'  => "tricky_topics/examples/create?tricky_topic_id={$tricky_topic->id}",
        'title'  => elgg_echo('example:create'),
        'text'  => elgg_echo('example:create'),
    ));
    ?>
</div>
<a name="resources"></a>
<div>
    <?php echo elgg_view('page/components/title_block', array('title' => elgg_echo('tricky_topic:resources')));?>
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
        <div role="presentation" class="tab-pane active form-group" id="files">
            <div class="margin-top-20">
                <?php
                echo elgg_view_form('tricky_topic/resources', array(
                    'body' => elgg_view('forms/attachments/files',
                        array('submit' => true, 'entity_id' => $tricky_topic->id)),
                    'class' => 'gray-block',
                    'enctype' => 'multipart/form-data'
                ));
                ?>
                <hr>
                <?php
                $params = array(
                    'add_files' => false,
                    'entities' => $multimedia['files'],
                    'href' => $href,
                    'options' => true,
                    'preview' => true
                );
                if($multimedia['files']) {
                    echo elgg_view('multimedia/file/list_summary', $params);
                } else {
                    echo elgg_view('output/empty', array('value' => elgg_echo('file:none')));
                }
                ?>
            </div>
        </div>
        <div role="presentation" class="tab-pane form-group" id="videos">
            <div class="margin-top-20">
                <?php
                echo elgg_view_form('tricky_topic/resources', array(
                    'body' => elgg_view('forms/attachments/videos',
                        array('submit' => true, 'entity_id' => $tricky_topic->id)),
                    'class' => 'gray-block',
                    'enctype' => 'multipart/form-data'
                ));
                ?>
                <hr>
                <?php
                $params = array(
                    'videos' => $multimedia['videos'],
                    'href' => $href,
                    'view_comments' => false,
                    'actions' => true,
                    'options' => false,
                    'author_bottom' => true,
                    'preview' => true
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