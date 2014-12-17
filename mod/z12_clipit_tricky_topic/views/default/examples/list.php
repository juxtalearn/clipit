<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   02/12/2014
 * Last update:     02/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$examples = elgg_extract('entities', $vars);
$count = elgg_extract('count', $vars);
?>
<div class="margin-bottom-20">
    <div class="pull-right">
        <?php echo elgg_view("page/components/print_button");?>
    </div>
    <?php echo elgg_view('output/url', array(
        'href'  => "tricky_topics/student_problems/create",
        'class' => 'btn btn-primary margin-bottom-10',
        'title' => elgg_echo('create'),
        'text'  => elgg_echo('create'),
    ));
    ?>
</div>
<table class="table">
    <thead>
    <tr>
        <th><?php echo elgg_echo('title');?>/<?php echo elgg_echo('tags');?></th>
        <th><?php echo elgg_echo('example:education_level');?></th>
        <th><i class="fa fa-globe"></i> <?php echo elgg_echo('country');?></th>
        <th>Author/Date</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach($examples as $example):
        $user = array_pop(ClipitUser::get_by_id(array($example->owner_id)));
    ?>
        <tr>
            <td>
                <strong>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "tricky_topics/student_problems/view/{$example->id}",
                        'title' => $example->name,
                        'text'  =>  $example->name,
                    ));
                    ?>
                </strong>
                <?php echo elgg_view('tricky_topic/tags/view', array('tags' => $example->tag_array, 'limit' => 5)); ?>
            </td>
            <td><?php echo elgg_echo('example:education_level:'.$example->education_level);?></td>
            <td><?php echo get_countries_list($example->country);?></td>
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
                    <?php echo elgg_view('output/friendlytime', array('time' => $example->time_created));?>
                </small>
            </td>
            <td>
                <?php if($user->id == elgg_get_logged_in_user_guid()):?>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "tricky_topics/student_problems/edit/{$example->id}",
                        'class' => 'btn btn-xs btn-primary',
                        'title' => elgg_echo('edit'),
                        'text'  => elgg_echo('edit'),
                    ));
                    ?>
                <?php endif;?>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
<?php echo clipit_get_pagination(array('count' => $count, 'limit' => 10)); ?>