<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   17/07/2015
 * Last update:     17/07/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$user_id = elgg_get_logged_in_user_guid();
function notification_view($notification){
//    $notification = array_pop(ClipitNotification::get_by_id(array($notification_id)));
    if($notification->destination) {
        $object = ClipitSite::lookup($notification->destination);
        $entity = array_pop($object['subtype']::get_by_id(array($notification->destination)));
    }
    $params = array(
        'icon' => 'fa-comment',
        'title' => 'Han comentado tu video',
        'owner' => $notification->owner_id,
        'destination_link' => $entity->name,
//            elgg_view('output/url', array(
//                'href'  => $entity->id,
//                'title' => $entity->name,
//                'text'  => $entity->name
//            )),
        'href' => 'view/18372'
    );
    $object_owner = ClipitSite::lookup($params['owner']);
    switch($object_owner['subtype']){
        case 'ClipitUser':
            $user = array_pop(ClipitUser::get_by_id(array($params['owner'])));
            $params['owner_info'] = elgg_view('output/img', array(
                'src' => get_avatar($user, 'small'),
                'class' => 'avatar-tiny image-block margin-top-5',
                'alt' => 'Avatar'
            ));
            break;
    }
    $output = '
    <!--<div class="clearfix"></div>-->
    <li style="border-bottom: 1px solid #bae6f6;width: 350px;">
        <a>
        '.$params['owner_info'].'
        <div class="content-block">
            <small>
                <span class="pull-right" style="margin-top: 3px;">'.elgg_view('output/friendlytime', array('time' => $notification->time_created)).'</span>
                <i class="fa '.$params['icon'].' blue" style="margin-right: 2px;padding: 0;font-size: 14px;float: none !important;"></i>
                '.$params['title'].'<br>';
            if($params['destination_link']) {
                $output .= '<strong class="blue">' . $params['destination_link'] . '</strong>';
            }
    $output .= '
            </small>
        </div>
        </a>
    </li>
    ';
    return $output;
}
function notification_get_by_target($user_id = null){
    if(!$user_id){
        $user_id = elgg_get_logged_in_user_guid();
    }
    $item = array();
    foreach(ClipitNotification::get_all() as $notification){
        if(in_array($user_id, $notification->target_array)){
            $item[] = $notification;
        }
    }
    return $item;
}

$notifications = notification_get_by_target();
$notifications_count = count($notifications);
?>
<li <?php echo elgg_in_context('notifications') ? 'class="active"': '';?>>
    <a id="notifications" class="inbox-summary" role="button" data-toggle="dropdown" href="javascript:;" title="<?php echo elgg_echo('messages:inbox');?>">
        <?php if($notifications_count > 0): ?>
            <span class="badge"><?php echo $notifications_count; ?></span>
        <?php endif; ?>
        <i class="fa fa-exclamation-triangle"></i>
    </a>
    <ul id="menu_notifications" class="dropdown-menu" role="menu" aria-labelledby="notifications">
        <?php
        foreach($notifications as $notification) {
            echo notification_view($notification);
        }
        ?>
<!--        --><?php //echo notification_view(14829);?>
    </ul>
</li>
<li class="separator">|</li>