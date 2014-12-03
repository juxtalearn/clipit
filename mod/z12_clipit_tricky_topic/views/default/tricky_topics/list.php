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
?>
    <script>
        $(function(){
            $("#add-tricky-topic").click(function(){
                $("#form-add-tricky-topic").toggle().find("input:first").focus();
            });
        });
    </script>
    <div class="margin-bottom-20">
        <?php echo elgg_view('output/url', array(
            'href'  => "javascript:;",
            'id'    => 'add-tricky-topic',
            'class' => 'btn btn-primary margin-bottom-10',
            'title' => elgg_echo('create'),
            'text'  => elgg_echo('create'),
        ));
        ?>
        <div class="row margin-0 margin-bottom-10" id="form-add-tricky-topic" style="display: none;background: #fafafa;padding: 10px;">
            <div class="form-group col-md-12 margin-top-10">
                <?php echo elgg_view("input/text", array(
                    'name' => 'new-tricky-topic',
                    'value' => $entity->name,
                    'class' => 'form-control',
                    'required' => true,
                    'placeholder' => elgg_echo('tricky_topic')
                ));
                ?>
                <hr class="margin-0 margin-top-10 margin-bottom-10">
                <small class="show margin-top-5"><?php echo elgg_echo("tags");?></small>
            </div>
            <div id="form-add-tags">
                <?php echo elgg_view("tricky_topic/add");?>
            </div>
            <div class="col-md-12">
                <div class="pull-right">
                    <?php echo elgg_view('output/url', array(
                        'href'  => "javascript:;",
                        'class' => 'btn btn-xs btn-border-blue btn-primary margin-right-10',
                        'title' => elgg_echo('cancel'),
                        'text'  => elgg_echo('cancel'),
                        'onclick' => '$(\'#add-tricky-topic\').click()',
                    ));
                    ?>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "javascript:;",
                        'class' => 'btn btn-xs btn-primary',
                        'title' => elgg_echo('create'),
                        'text'  => elgg_echo('create'),
                    ));
                    ?>
                </div>
                <?php echo elgg_view('output/url', array(
                    'href'  => "javascript:;",
                    'class' => 'btn btn-xs btn-primary',
                    'title' => elgg_echo('add'),
                    'text'  => '<i class="fa fa-plus"></i>' . elgg_echo('add'),
                    'id'    => 'add-tag'
                ));
                ?>
            </div>
        </div>
    </div>
    <table class="table table-striped">
        <tr>
            <th>Name</th>
            <th>Author/Date</th>
            <th>Tags</th>
            <th>Action</th>
        </tr>
        <?php
        foreach($tricky_topics as $tricky_topic):
            $user = array_pop(ClipitUser::get_by_id(array($tricky_topic->owner_id)));
//    $quizzes = ClipitTrickyTopic::get_quizzes($tricky_topic->id);
            ?>
            <tr>
                <td>
                    <strong>
                        <?php echo elgg_view('output/url', array(
                            'href'  => "tricky_topics/view/{$tricky_topic->id}",
                            'title' => $tricky_topic->name,
                            'text'  => $tricky_topic->name,
                        ));
                        ?>
                    </strong>
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
                    <?php echo elgg_view('tricky_topic/tags/view', array('tags' => $tricky_topic->tag_array, 'limit' => 5)); ?>
                </td>
                <td>
                    <?php if($user->id == elgg_get_logged_in_user_guid()):?>
                        <a class="btn btn-xs btn-primary">Edit</a>
                    <?php endif;?>
                </td>
            </tr>
        <?php endforeach;?>
    </table>
<?php echo clipit_get_pagination(array('count' => $count, 'limit' => 10)); ?>