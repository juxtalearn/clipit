<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 25/02/14
 * Time: 17:24
 * To change this template use File | Settings | File Templates.
 */
$group = elgg_extract("entity", $vars);
$activity_id = elgg_get_page_owner_guid();
?>
<div style="color: #999;margin-bottom: 20px;">
    <div class="pull-right">
        <b> Filter </b>
        <div style=" display: inline-block; margin-left: 10px; ">
            <select class="form-control" style="height: 23px;padding: 0;">
                <option>All</option>
                <option>Documents</option>
                <option>Videos</option>
            </select>
        </div>
    </div>
    <?php echo elgg_view_form('files/upload', array('data-validate'=> "true", 'enctype' => 'multipart/form-data' ), array('entity'  => $group)); ?>
    <button type="button" data-toggle="modal" data-target="#upload-files" class="btn btn-default">Upload files</button>
</div>

<div style="margin-bottom: 30px;color: #999;margin-left: 10px;">
    <div class="checkbox" style=" display: inline-block;margin: 0;">
        <label>
            <input type="checkbox" class="select-all"> Select all
        </label>
    </div>
    <div style=" display: inline-block; margin-left: 10px; ">
        <select name="set-option" class="form-control message-options" style="height: 20px;padding: 0;" disabled="">
            <option>[Options]</option>
            <option value="read">Download</option>
            <option value="unread">Publish</option>
        </select>
    </div>
    <div class="pull-right search-box">
        <input type="text" placeholder="Search">
        <div class="input-group-btn">
            <span></span>
            <button type="submit">
                <i class="fa fa-search"></i>
            </button>
        </div>
    </div>
</div>

<div class="row" style="display:none;margin-bottom: 10px;border-bottom: 1px solid #bae6f6; padding-bottom: 5px;">
    <div class="col-md-1 col-xs-1" style="text-align: right;">
        <input type="checkbox">
        <i class="fa fa-file-o" style=" font-size: 35px; color: #C9C9C9; "></i>
    </div>
    <div class="col-md-8">
        <h4 style="margin: 0;font-weight: bold;">
            <a href="http://juxtalearn.org/sandbox/clipit_befe/clipit_activity/74/group/discussion/view/187" title="20 Video Ideas For YouTube">File name lorem ipsum sit</a>
        </h4>
        <small class="show">
            <i>
                PDF document
                -
                <abbr title="10 March 2014 @ 11:41am">8 days ago</abbr>
            </i>
        </small>
        <p style="text-align: justify;margin:0;font-size: 13px;color: #666666;">
        1.	Vlog – Just talk to the camera about your day, or something funny or interesting that happened today or the other day.2.	Skit / Short Movie – Have a funny idea in your head? Write out a rough script, and make it a short film!3.	Artsy – Do you like to paint...
        </p>
    </div>
    <div class="col-md-3" style="text-align: center;">
        <a class="btn btn-default" style=" padding: 5px 10px; ">
            <i class="fa fa-download"></i>
        </a>
        <a class="btn btn-primary btn-sm" style="  padding: 5px 10px; background: #fff; color: #32b4e5; border: 1px solid #32b4e5;margin-left: 10px; ">
            <i class="fa fa-share"></i> Publish
        </a>
    </div>
</div>
<style>
    .table td{
        border-bottom: 1px solid #bae6f6;
        border-top: 0 !important;
    }
</style>
<table class="table files-table">
    <?php
        foreach(ClipitGroup::get_files($group->id) as $file_id):
            $file = array_pop(ClipitFile::get_by_id(array($file_id)));
    ?>
    <tr>
        <td>
            <input type="checkbox">
        </td>
        <td>
            <i class="fa fa-file-o file-icon"></i>
        </td>
        <td class="col-md-9 file-info">
            <h4>
                <?php echo elgg_view('output/url', array(
                    'href' => "clipit_activity/{$activity_id}/group/files/view/{$file->id}",
                    'title' => $file->name,
                    'text' => $file->name,
                    'is_trusted' => true
                    ));
                ?>
            </h4>
            <small class="show">
                <strong>
                    PDF document
                </strong>
            </small>
            <p>
               <?php echo $file->description; ?>
            </p>
            <small class="show file-user-info">
                <i>Uploaded by&nbsp;<a href="http://juxtalearn.org/sandbox/clipit_befe/profile/" title="Mario Sanchez" rel="nofollow">Mario Sanchez</a>                    <abbr title="6 March 2014 @ 2:54pm">12 days ago</abbr>                </i>
                <i class="pull-right">
                    Last post by
                    <a href="http://juxtalearn.org/sandbox/clipit_befe/profile/student_2" title="Mario Sanchez" rel="nofollow">Mario Sanchez</a> (<abbr title="18 March 2014 @ 3:48pm">just now</abbr>)
                </i>
            </small>
        </td>
        <td style=" vertical-align: middle; text-align: center; " class="col-md-3">
            <div>
                <a href="#create_reply" title="Create reply" class="btn btn-default btn-sm reply-button" rel="nofollow" style="
    padding: 5px 10px;  background: #fff;
    color: #32b4e5;  border: 1px solid #32b4e5;
"><span style="
    border-right: 1px solid #32b4e5;
    padding-right: 5px;
">5</span> Reply</a>
                <a class="btn btn-warning btn-sm" style="margin-left: 5px;padding: 5px 10px;      display: inline-block;">
                    <i class="fa fa-arrow-up"></i>
                </a>
                <div style="width: 35px;display: inline-block;float: right;">
                    <a class="btn btn-default" style=" padding: 5px 10px;">
                        <i class="fa fa-download"></i>
                    </a>
                    <small class="show text-truncate" style="margin-top: 3px;">303KB</small>
                </div>
            </div>
        </td>
    </tr>
    <?php endforeach; ?>
    <tr style="display: none;">
        <td>
            <input type="checkbox">
        </td>
        <td>
            <i class="fa fa-file-o" style=" font-size: 35px; color: #C9C9C9; "></i>
        </td>
        <td class="col-md-9">
            <div >
                <h4 style="margin: 0;font-weight: bold;">
                    <a href="http://juxtalearn.org/sandbox/clipit_befe/clipit_activity/74/group/discussion/view/187" title="20 Video Ideas For YouTube">File name lorem ipsum sit</a>
                </h4>
                <small class="show">
                    <b>
                        PDF document
                    </b>
                </small>
                <p style="text-align: justify;margin:0;font-size: 13px;color: #666666;">
                    1.	Vlog – Just talk to the camera about your day, or something funny or interesting that happened today or the other day.2.	Skit / Short Movie – Have a funny idea in your head? Write out a rough script, and make it a short film!3.	Artsy – Do you like to paint...
                </p>
                <small class="show" style="margin-top: 5px;">
                    <i>Uploaded by&nbsp;<a href="http://juxtalearn.org/sandbox/clipit_befe/profile/" title="Mario Sanchez" rel="nofollow">Mario Sanchez</a>                    <abbr title="6 March 2014 @ 2:54pm">12 days ago</abbr>                </i>
                    <i class="pull-right">
                        Last post by
                        <a href="http://juxtalearn.org/sandbox/clipit_befe/profile/student_2" title="Mario Sanchez" rel="nofollow">Mario Sanchez</a> (<abbr title="18 March 2014 @ 3:48pm">just now</abbr>)</i>
                </small>
            </div>
        </td>
        <td style=" vertical-align: middle; text-align: center; " class="col-md-3">
            <div>
                <a href="http://juxtalearn.org/sandbox/clipit_befe/clipit_activity/74/group/discussion/view/150#create_reply" title="Create reply" class="btn btn-default btn-sm reply-button" rel="nofollow" style="
    padding: 5px 10px;  background: #fff;
    color: #32b4e5;  border: 1px solid #32b4e5;
"><span style="
    border-right: 1px solid #32b4e5;
    padding-right: 5px;
">5</span> Reply</a>
                <div style="width: 35px;display: inline-block;float: right;">
                    <a class="btn btn-default" style=" padding: 5px 10px;">
                        <i class="fa fa-download"></i>
                    </a>
                    <small class="show text-truncate" style="margin-top: 3px;">303KB</small>
                </div>
            </div>
        </td>
    </tr>
</table>