<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 25/02/14
 * Time: 17:24
 * To change this template use File | Settings | File Templates.
 */
?>
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
    <div class="pull-right" style="margin-right: 30px;">
        <b> Filter </b>
        <div style=" display: inline-block; margin-left: 10px; ">
            <select class="form-control" style="height: 23px;padding: 0;">
                <option>Date</option>
                <option>unread</option>
                <option>***</option>
            </select>
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
<table class="table">
    <tr>
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
        </td>
        <td style=" vertical-align: middle; text-align: center; " class="col-md-3">
            <div>
                <a class="btn btn-default" style=" padding: 5px 10px; ">
                    <i class="fa fa-download"></i>
                </a>
                <a class="btn btn-primary btn-sm" style="  padding: 5px 10px; background: #fff; color: #32b4e5; border: 1px solid #32b4e5;margin-left: 10px; ">
                    <i class="fa fa-share"></i> Publish
                </a>
            </div>
        </td>
    </tr>
</table>