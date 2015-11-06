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
$tricky_topics = elgg_extract('entities', $vars);
$count = elgg_extract('count', $vars);
$table_orders = elgg_extract('table_orders', $vars);
$page = 'tricky_topics';
?>
<?php if($tricky_topics):?>
<table class="table table-striped table-order" role="presentation">
    <thead role="presentation">
    <tr role="presentation" class="title_order">
        <th role="presentation"><?php echo elgg_echo('name');?></th>
        <th role="presentation"><?php echo elgg_echo('education_level');?></th>
        <th role="presentation"><?php echo elgg_echo('tricky_topic:subject');?></th>
        <th role="presentation"><?php echo elgg_echo('author');?>-<?php echo elgg_echo('date');?></th>
    </tr>
    </thead>
    <?php
    foreach($tricky_topics as $tricky_topic):
        $user = array_pop(ClipitUser::get_by_id(array($tricky_topic->owner_id)));
        $is_linked = false;
        $quizzes = ClipitQuiz::get_from_tricky_topic($tricky_topic->id);
        $activities = ClipitActivity::get_from_tricky_topic($tricky_topic->id);
        if(!empty($activities) || !empty($quizzes) ){
            $is_linked = true;
        }
    ?>
    <tr role="presentation">
        <td role="presentation">
            <strong>
                <?php echo elgg_view('output/url', array(
                    'href'  => "tricky_topics/view/{$tricky_topic->id}",
                    'title' => $tricky_topic->name,
                    'text'  => $tricky_topic->name,
                ));
                ?>
            </strong>
            <?php echo elgg_view('tricky_topic/tags/view', array('tags' => $tricky_topic->tag_array, 'limit' => 3)); ?>
        </td>
        <td role="presentation">
            <?php echo elgg_view('output/url', array(
                'href'  => set_search_input($page, array('education_level'=>$tricky_topic->education_level)),
                'title' => elgg_echo('filter_by', array(elgg_echo('education_level:'.$tricky_topic->education_level))),
                'text'  => elgg_echo('education_level:'.$tricky_topic->education_level),
            ));
            ?>
        </td>
        <td role="presentation">
            <?php echo elgg_view('output/url', array(
                'href'  => set_search_input($page, array('subject'=>$tricky_topic->subject)),
                'title' => $tricky_topic->subject,
                'text'  => $tricky_topic->subject,
            ));
            ?>
        </td>
        <td role="presentation">
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
    </tr>
    <?php endforeach;?>
</table>
<?php else: ?>
    <?php echo elgg_view('output/empty', array('value' => elgg_echo('tricky_topics:none')));;?>
<?php endif;?>