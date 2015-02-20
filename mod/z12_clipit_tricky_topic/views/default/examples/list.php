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
$table_orders = elgg_extract('table_orders', $vars);
$count = elgg_extract('count', $vars);
?>
<div class="margin-bottom-20">
    <div class="pull-right">
        <?php echo elgg_view("page/components/print_button");?>
    </div>
    <?php echo elgg_view('output/url', array(
        'href'  => "tricky_topics/examples/create",
        'class' => 'btn btn-primary margin-bottom-10',
        'title' => elgg_echo('new'),
        'text'  => elgg_echo('new'),
    ));
    ?>
</div>
<table class="table table-striped table-order">
    <thead>
    <tr>
        <?php foreach($table_orders as $data):?>
            <th>
                <a href="<?php echo $data['href'];?>">
                    <i class="fa <?php echo $data['sort_icon'];?> blue margin-right-5" style="position: absolute;left: 0;margin-top: 3px;"></i>
                    <span class="margin-left-5"><?php echo $data['value'];?></span>
                </a>
            </th>
        <?php endforeach;?>
        <th><?php echo elgg_echo('author');?>-<?php echo elgg_echo('date');?></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach($examples as $example):
        $user = array_pop(ClipitUser::get_by_id(array($example->owner_id)));
        $tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($example->tricky_topic)));
    ?>
        <tr>
            <td>
                <strong>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "tricky_topics/examples/view/{$example->id}",
                        'title' => $example->name,
                        'text'  =>  $example->name,
                    ));
                    ?>
                </strong>
                <?php echo elgg_view('tricky_topic/tags/view', array('tags' => $example->tag_array, 'limit' => 5)); ?>
            </td>
            <td>
                <?php echo elgg_view('output/url', array(
                    'href'  => "tricky_topics/view/{$tricky_topic->id}",
                    'title' => $tricky_topic->name,
                    'text'  =>  $tricky_topic->name,
                ));
                ?>
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
                    <?php echo elgg_view('output/friendlytime', array('time' => $example->time_created));?>
                </small>
            </td>
            <td>
                <?php echo elgg_view('page/components/admin_options', array(
                    'entity' => $example,
                    'user' => $user,
                ));
                ?>
            </td>
        </tr>
    <?php endforeach;?>
    </tbody>
</table>
<?php echo clipit_get_pagination(array('count' => $count, 'limit' => 10)); ?>