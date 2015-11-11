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
$tag = elgg_extract('entity', $vars);
$examples = elgg_extract('examples', $vars);
$tricky_topics = elgg_extract('tricky_topics', $vars);
$user = array_pop(ClipitUser::get_by_id(array($tag->owner_id)));
$is_linked = false;
$quizzes = ClipitQuiz::get_from_tricky_topic($tag->id);
$activities = ClipitActivity::get_from_tricky_topic($tag->id);
if(!empty($activities) || !empty($quizzes) ){
    $is_linked = true;
}
?>
<div class="margin-bottom-10">
    <div class="pull-right">
        <div class="margin-bottom-10">
            <div class="inline-block">
                <?php echo elgg_view('page/components/admin_options', array(
                    'entity' => $tag,
                    'user' => $user,
                    'is_linked' => $is_linked,
                ));?>
            </div>
            <span class="margin-left-10">
                <?php echo elgg_view("page/components/print_button");?>
            </span>
        </div>
        <small class="show">
            <?php echo elgg_view('output/friendlytime', array('time' => $tag->time_created));?>
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
        <?php if($tag->description):?>
            <small class="show"><?php echo elgg_echo('description');?></small>
            <?php echo $tag->description;?>
        <?php endif;?>
    </div>
</div>

<a name="tricky_topics"></a>
<div>
    <?php echo elgg_view('page/components/title_block', array('title' => elgg_echo('tricky_topics')));?>
    <?php echo elgg_view('tricky_topics/summary', array('entities' => $tricky_topics));?>
</div>

<a name="examples"></a>
<div class="margin-bottom-10">
    <?php echo elgg_view('page/components/title_block', array('title' => elgg_echo('examples')));?>
    <?php echo elgg_view('examples/summary', array('entities' => $examples));?>
</div>