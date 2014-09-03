<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   16/06/14
 * Last update:     16/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$groups = elgg_extract('entities', $vars);
$activity_id = elgg_extract('activity_id', $vars);
$user_id = elgg_get_logged_in_user_guid();

foreach($groups as $group_id){
    $group = array_pop(ClipitGroup::get_by_id(array($group_id)));
    $total_unread_posts = array_pop(ClipitPost::unread_by_destination(array($group_id), $user_id, true));

    elgg_register_menu_item('groups:admin_'.$group_id, array(
        'name' => 'group_dashboard',
        'text' => elgg_echo('group:home'),
        'href' => "clipit_activity/{$activity_id}/group/{$group_id}",
        'priority' => 100,
    ));
    elgg_register_menu_item('groups:admin_'.$group_id, array(
        'name' => 'group_discussion',
        'text' => elgg_echo('group:discussion'),
        'href' => "clipit_activity/{$activity_id}/group/{$group_id}/discussion",
        'badge' => $total_unread_posts > 0 ? $total_unread_posts : "",
        'priority' => 200,
    ));
    global $CONFIG;
    $dest = $CONFIG->menus['groups:admin_'.$group_id];
//    print_r($dest);
//    print_r(full_url());
    $full = full_url();
    //$full = 'http://jxl1.escet.urjc.es/clipit_dev/clipit_activity/4256/group/4260/discussion/view/4363';
    //print_r(explode("/view/", $full));
    $selected_items = array('/view/', '?filter=');
    $register = elgg_get_site_url()."clipit_activity/{$activity_id}/group/{$group_id}/discussion";
//    foreach($selected_items as $selected_item){
//        $path = explode($selected_item, $full);
//        print_r($path);
//        if($path[0] == $register){
//            echo "atm";
//        }
//    }

    elgg_register_menu_item('groups:admin_'.$group_id, array(
        'name' => 'group_files',
        'text' => elgg_echo('group:files'),
        'href' => "clipit_activity/{$activity_id}/group/{$group_id}/multimedia",
        'priority' => 300,
    ));
    $body .= '<ul class="nav nav-pills nav-stacked panel">';
    $body .= '<li>';
    $body .= elgg_view('output/url', array(
        'title' => $group->name,
        'href' => '#collapse_'.$group->id,
        'text'  => '<i class="pull-right fa fa-caret-down"></i>'. $group->name,
        'data-toggle' => 'collapse',
        'data-parent' => '#accordion'
    ));
    $body .= '</li>';
    $body .= elgg_view_menu('groups:admin_'.$group_id, array(
        'sort_by' => 'priority',
        'id' => 'collapse_'.$group->id,
        'class' => 'collapse'
    ));
    $body .= '</ul>';
}
?>

<?php echo elgg_view_module('aside',
    elgg_echo('activity:groups'),
    "<div id='accordion'>{$body}</div>", // Body
    array('class' => 'aside-tree'
    ));
?>
<script>
    <?php
    $full = full_url();
    $selected_items = array('/view/', '?filter=');
    foreach($selected_items as $selected_item){
        $path = explode($selected_item, $full);
    ?>
    var register_menu_item = '<?php echo $path[0];?>';
    var menu_item = $(".elgg-sidebar li a[href='"+ register_menu_item +"']");
    if(menu_item.length > 0){
        menu_item.parent("li").addClass("active");
    }
    console.log(register_menu_item);
    <?php
    }
 ?>
</script>