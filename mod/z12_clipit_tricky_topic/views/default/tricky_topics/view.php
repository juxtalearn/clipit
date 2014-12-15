<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   27/11/2014
 * Last update:     27/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$tricky_topic = elgg_extract('entity', $vars);
$multimedia = elgg_extract('multimedia', $vars);
$user = array_pop(ClipitUser::get_by_id(array($tricky_topic->owner_id)));
?>
<div class="margin-bottom-10">
    <div class="pull-right">
    <small class="show">
        <?php echo elgg_view('output/friendlytime', array('time' => $tricky_topic->time_created));?>
    </small>
    <?php if($user->id == elgg_get_logged_in_user_guid()):?>
        <div class="margin-top-10">
            <?php echo elgg_view('output/url', array(
                'href'  => "tricky_topics/edit/{$tricky_topic->id}",
                'class' => 'btn btn-xs btn-primary',
                'title' => elgg_echo('tricky_topic:edit'),
                'text'  => elgg_echo('tricky_topic:edit'),
            ));
            ?>
        </div>
    <?php endif;?>
    </div>
    <small class="show"><?php echo elgg_echo('author');?></small>
    <i class="fa-user fa blue"></i>
    <?php echo elgg_view('output/url', array(
        'href'  => "profile/{$user->login}",
        'title' => $user->name,
        'text'  => $user->name,
    ));
    ?>
</div>
<div class="clearfix"></div>
<?php if($tricky_topic->description):?>
    <small><?php echo elgg_echo('description');?></small>
    <p><?php echo $tricky_topic->description;?></p>
<?php endif;?>
<small class="show"><?php echo elgg_echo('tags');?></small>
<?php echo elgg_view('tricky_topic/tags/view', array('tags' => $tricky_topic->tag_array)); ?>
<div>
    <?php echo elgg_view('page/components/title_block', array('title' => 'Student problems'));?>
    <?php echo elgg_view('examples/summary', array('entity' => $tricky_topic->examples_array, 'tricky_topic' => $tricky_topic->id));?>
</div>
<div>
    <?php echo elgg_view('page/components/title_block', array('title' => 'Teaching Activity'));?>
    <table class="table" style="display: none;">
        <thead>
            <tr>
                <th></th>
                <th>Title</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <i class="fa fa-youtube-play blue"></i>
                </td>
                <td>
                    <strong><a>Name</a></strong>
                    <div>
                        Students fail to understand that the motion
                        of the electron is not free. The electron is bound to the
                        atom by the attractive force of the
                    </div>
                </td>
                <td>
                </td>
            </tr>
            <tr>
                <td>
                    <i class="fa fa-youtube-play blue"></i>
                </td>
                <td>
                    <strong><a>Name</a></strong>
                </td>
                <td>
                    <i class="fa fa-download blue"></i>
                </td>
            </tr>
        </tbody>
    </table>
    <div role="tabpanel">

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
            <li role="presentation">
                <a href="#storyboards" aria-controls="storyboards" role="tab" data-toggle="tab">
                    <?php echo elgg_echo('storyboards');?> (<?php echo count($multimedia['storyboards']);?>)
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
            <div role="tabpanel" class="tab-pane active" id="files">
                <div class="margin-top-20">
                    <?php
                    $params = array(
                        'add_files' => false,
                        'files' => $multimedia['files'],
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
            <div role="tabpanel" class="tab-pane" id="videos">
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
            <div role="tabpanel" class="tab-pane" id="storyboards">
                <div class="margin-top-20">
                    <?php
                    $params = array(
                        'entities' => $multimedia['storyboards'],
                        'href' => $href,
                        'view_comments' => false,
                        'options' => false,
                    );
                    if($multimedia['storyboards']) {
                        echo elgg_view('multimedia/storyboard/list_summary', $params);
                    } else {
                        echo elgg_view('output/empty', array('value' => elgg_echo('storyboards:none')));
                    }
                    ?>
                </div>
            </div>
        </div>

    </div>
</div>