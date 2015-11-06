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
<div class="table-responsive-list" role="presentation">
<table class="table table-striped table-order" role="presentation">
    <thead role="presentation">
    <tr role="presentation">
        <?php
        foreach($table_orders as $title => $data):
            switch($title){
                case 'name': $class = 'col-md-5 col-xs-6'; break;
                case 'tricky_topic': $class = 'col-md-3 col-xs-3'; break;
            }
        ?>
            <th role="presentation" class="<?php echo $class;?>">
                <a href="<?php echo $data['href'];?>">
                    <i class="fa <?php echo $data['sort_icon'];?> blue margin-right-5" style="position: absolute;left: 0;margin-top: 3px;"></i>
                    <span class="margin-left-5"><?php echo $data['value'];?></span>
                </a>
            </th>
        <?php endforeach;?>
        <th role="presentation" class="col-md-2"><?php echo elgg_echo('author');?>-<?php echo elgg_echo('date');?></th>
        <th  role="presentation" class="col-md-2 hidden-xs"><?php echo elgg_echo("options");?></th>
    </tr>
    </thead>
    <tbody role="presentation">
    <?php
    foreach($examples as $example):
        $user = array_pop(ClipitUser::get_by_id(array($example->owner_id)));
        $tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($example->tricky_topic)));
    ?>
        <tr role="presentation">
            <td role="presentation" data-title="<?php echo elgg_echo('name');?>">
                <strong>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "tricky_topics/examples/view/{$example->id}",
                        'title' => $example->name,
                        'text'  =>  $example->name,
                    ));
                    ?>
                </strong>
                <div class="hidden-xs">
                    <?php echo elgg_view('tricky_topic/tags/view', array('tags' => $example->tag_array, 'limit' => 2, 'width' => '100%')); ?>
                </div>
            </td>
            <td role="presentation" data-title="<?php echo elgg_echo('tricky_topic');?>">
                <?php if($tricky_topic):?>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "tricky_topics/view/{$tricky_topic->id}",
                        'title' => $tricky_topic->name,
                        'text'  =>  $tricky_topic->name,
                    ));
                    ?>
                <?php endif;?>
            </td>
            <td role="presentation" data-title="<?php echo elgg_echo('author');?>">
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
                    <?php echo elgg_view('output/friendlytime', array('time' => $example->time_created));?>
                </small>
            </td>
            <td role="presentation" data-title="<?php echo elgg_echo('options');?>" class="hidden-xs hidden-sm">
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
</div>
<?php echo clipit_get_pagination(array('count' => $count, 'limit' => 10)); ?>