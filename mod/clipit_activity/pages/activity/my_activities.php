<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 13/02/14
 * Time: 14:04
 * To change this template use File | Settings | File Templates.
 */


$user = elgg_get_logged_in_user_entity();
$my_groups_ids = ClipitUser::get_groups($user->guid);

$id_activities_array = array();
foreach($my_groups_ids as $group_id){
    $id_activities_array[] = ClipitGroup::get_activity($group_id);
}

$my_activities = ClipitActivity::get_by_id($id_activities_array);
$params_progress = array(
    'value' => 30,
    'width' => '100%'
);
$progress_bar = elgg_view("page/components/progressbar", $params_progress);

$params_list = array(
    'items'         => $my_activities,
    'pagination'    => false,
    'progress_bar'  => $progress_bar,
    'list_class'    => 'my-activities',
    'full_view'     => false,
);
$content = elgg_view("activities/list", $params_list);

$sidebar = '<div><h3>Last activity</h3><div style="
    border-left: 10px solid #bae6f6;
    margin-left: -5px;
">
  <ul style="
    padding-left: 10px;  background: #fff;
    padding: 10px;
    margin-left: 10px;
">

<li class="list-item">
  <div style="float: left;margin-right: 10px;margin-top: 5px;
    position: relative;
"><a style="
    background: #ed1e79;
    width: 22px;
    height: 22px;
    position: absolute;
    border-radius: 15px;
    border: 2px solid #fff;
    left: -5px;
    top: -5px;
"></a>
<img src="http://juxtalearn.org/sandbox/clipit02/mod/profile/icondirect.php?lastcache=1383038225&amp;joindate=1382956838&amp;guid=2564&amp;size=small">
</div>
<div style="overflow:hidden">
  <a class="text-truncate" style="
    font-weight: bold;
">Miguel Ángel Gutiérrez Moreno</a>
<small class="show" style="
    font-size: 85%;
"><i class="fa fa-comments" style="
    color: #C9C9C9;
"></i>
            Replied on the discussion <a>Os dejo aqui la sinopsis para que le echeis un ojo!!</a></small>
<small class="show" style="
"><abbr title="18 March 2014 @ 3:48pm">an hour ago</abbr></small></div>
      </li><li class="list-item">
  <div style="float: left;margin-right: 10px;margin-top: 5px;
    position: relative;
"><a style="
    background: #97bf0d;
    width: 22px;
    height: 22px;
    position: absolute;
    border-radius: 15px;
    border: 2px solid #fff;
    left: -5px;
    top: -5px;
"></a>
<img src="http://juxtalearn.org/sandbox/clipit02/mod/profile/icondirect.php?lastcache=1379258078&amp;joindate=1379257932&amp;guid=761&amp;size=small">
</div>
<div style="overflow:hidden">
  <a class="text-truncate" style="
    font-weight: bold;
">Miguel Ángel Gutiérrez Moreno</a>
<small class="show" style="
    font-size: 85%;
"><i class="fa fa-comments" style="
    color: #C9C9C9;
"></i>
            Replied on the discussion <a>Os dejo aqui la sinopsis para que le echeis un ojo!!</a></small>
<small class="show" style="
"><abbr title="18 March 2014 @ 3:48pm">an hour ago</abbr></small></div>
      </li>
<li class="list-item">
  <div style="float: left;margin-right: 10px;margin-top: 5px;
    position: relative;
"><a style="
    background: #ed1e79;
    width: 22px;
    height: 22px;
    position: absolute;
    border-radius: 15px;
    border: 2px solid #fff;
    left: -5px;
    top: -5px;
"></a>
<img src="http://juxtalearn.org/sandbox/clipit02/mod/profile/icondirect.php?lastcache=1380278114&amp;joindate=1379609605&amp;guid=1174&amp;size=small">
</div>
<div style="overflow:hidden">
  <a class="text-truncate" style="
    font-weight: bold;
">Kike Sanchez Werny</a>
<small class="show" style="
    font-size: 85%;
"><i class="fa fa-upload" style="
    color: #C9C9C9;
"></i>
            Uploaded the file&nbsp;</small><div style="
    margin-top: 5px;
    overflow: hidden;
"><i class="fa fa-file-o file-icon" style="
    font-size: 35px;
    color: #C9C9C9;
    float: left;
    margin-right: 5px;
"></i><div style="
    overflow: hidden;
">
                <small class="show" style="
    font-size: 85%;
">
                    <a>Cabecera - Grupo 9</a>

                    <b style="
    display: block;
">
                        PDF document
                    </b></small>
            </div></div>
<small class="show" style="
"><abbr title="18 March 2014 @ 3:48pm">an hour ago</abbr></small></div>
      </li>
<li class="list-item">
  <div style="float: left;margin-right: 10px;margin-top: 5px;
    position: relative;
"><a style="
    background: #ed1e79;
    width: 22px;
    height: 22px;
    position: absolute;
    border-radius: 15px;
    border: 2px solid #fff;
    left: -5px;
    top: -5px;
"></a>
<img src="http://juxtalearn.org/sandbox/clipit02/mod/profile/icondirect.php?lastcache=1383038225&amp;joindate=1382956838&amp;guid=2564&amp;size=small">
</div>
<div style="overflow:hidden">
  <a class="text-truncate" style="
    font-weight: bold;
">Miguel Ángel Gutiérrez Moreno</a>
<small class="show" style="
    font-size: 85%;
"><i class="fa fa-comments" style="
    color: #C9C9C9;
"></i>
            Replied on the discussion <a>Os dejo aqui la sinopsis para que le echeis un ojo!!</a></small>
<small class="show" style="
"><abbr title="18 March 2014 @ 3:48pm">an hour ago</abbr></small></div>
      </li>
<li class="list-item">
  <div style="float: left;margin-right: 10px;margin-top: 5px;
    position: relative;
"><a style="
    background: #ed1e79;
    width: 22px;
    height: 22px;
    position: absolute;
    border-radius: 15px;
    border: 2px solid #fff;
    left: -5px;
    top: -5px;
"></a>
<img src="http://juxtalearn.org/sandbox/clipit02/mod/profile/icondirect.php?lastcache=1383038225&amp;joindate=1382956838&amp;guid=2564&amp;size=small">
</div>
<div style="overflow:hidden">
  <a class="text-truncate" style="
    font-weight: bold;
">Miguel Ángel Gutiérrez Moreno</a>
<small class="show" style="
    font-size: 85%;
"><i class="fa fa-comments" style="
    color: #C9C9C9;
"></i>
            Replied on the discussion <a>Os dejo aqui la sinopsis para que le echeis un ojo!!</a></small>
<small class="show" style="
"><abbr title="18 March 2014 @ 3:48pm">an hour ago</abbr></small></div>
      </li></ul></div></div>';
$sidebar = elgg_view("activities/sidebar/feed", array('my_groups' => $my_groups_ids));
$selected_tab = 'all';
$filter = elgg_view('activities/filter', array('selected' => $selected_tab, 'entity' => $activity));
$params = array(
    'content' => $content,
    'title' => elgg_echo("my_activities"),
    'filter' => $filter,
    'sidebar' => $sidebar,
    'class' => 'sidebar-lg main-md'
);
$body = elgg_view_layout('content', $params);

echo elgg_view_page($title, $body);
