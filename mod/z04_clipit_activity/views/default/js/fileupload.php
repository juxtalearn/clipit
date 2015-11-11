<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/09/2014
 * Last update:     22/09/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */

$vendors_dir = elgg_get_plugins_path() . "z04_clipit_activity/vendors/fileupload/";
include("{$vendors_dir}tmpl.min.js");
include("{$vendors_dir}load-image.min.js");
include("{$vendors_dir}iframe-transport.js");
include("{$vendors_dir}fileupload.js");
include("{$vendors_dir}fileupload-process.js");
include("{$vendors_dir}fileupload-image.js");
include("{$vendors_dir}fileupload-validate.js");
include("{$vendors_dir}fileupload-ui.js");
?>
//<script>
elgg.provide('clipit.file');

clipit.file.getIcon = function(file_type, $icon){
    switch(file_type){
        case "application/pdf":
            $icon.css({'color': '#E20000'}).addClass('fa-file-pdf-o');
            break;
        // Microsoft Word
        case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
        case "application/msword":
            $icon.css({'color': '#26468F'}).addClass('fa-file-word-o');
            break;
        // Microsoft Excel
        case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet":
        case "application/vnd.ms-excel":
            $icon.css({'color': '#008D33'}).addClass('fa-file-excel-o');
            break;
        // Microsoft PowerPoint
        case "application/vnd.openxmlformats-officedocument.presentationml.presentation":
        case "application/vnd.ms-powerpoint":
            $icon.css({'color': '#DA4C13'}).addClass('fa-file-powerpoint-o');
            break;
        case "application/x-rar":
        case "application/zip":
            $icon.css({'color': '#EBAB3E'}).addClass('file-zip-o');
            break;
        default:
            $icon.css({'color': '#C9C9C9'}).addClass('fa-file-o');
            break;
    }
    // Other file types
    if(/video/.test(file_type)){
        $icon.css({'color': '#bae6f6'}).addClass('fa-file-video-o');
    } else if(/audio/.test(file_type)){
        $icon.css({'color': '#bae6f6'}).addClass('file-audio-o');
    }
    return $icon;
}
$.fn.attach_multimedia = function (options) {
    var defaults = {
        url: 'ajax/view/multimedia/attach/'
    }
    var opt =  $.extend({}, defaults, options);
    var $obj = $(this),
        $menu_list = $obj.find("ul.menu-list > li"),
        $content = $obj.find(".multimedia-list"),
        item = ".attach-item";
    var methods = {
        load: function(object){
            elgg.get(opt.url + object.data.type,{
                data: object.data,
                success: object.success
            });
        },
        loadAll: function(){
            $($menu_list).each(function(i, elem){
                var get_type = $(this).data("menu");
                methods.load({
                    data: $.extend({}, {type: get_type}, opt.data),
                    success: function(data){
                        $content.append(data);
                        $obj.find("#attach-loading").hide();
                        methods.setCount();
                        $obj.find(".multimedia-list > div").hide();
                        $obj.find(".multimedia-list > div[data-list="+opt.default_list+"]").show();
                    }
                });
            });
        },
        loadBy: function(name){
            $obj.find(".multimedia-list > div").hide();
            var list = $obj.find("[data-list="+ name +"]");
            if(list.length == 0){
                $obj.find("#attach-loading").show();
                methods.load({
                    data: $.extend({}, {type: name}, opt.data),
                    success: function(data){
                        $content.append(data);
                        $obj.find("#attach-loading").hide();
                        methods.setCount();
                    }
                });
            } else {
                list.show();
            }
        },
        count: function($object){
            return $object.find(".attach-block.selected").length;
        },
        setCount: function(){
            var list = $obj.find(".multimedia-list > div");
            $(list).each(function(i, elem){
                var type = $(this).data("list");
                var count = methods.count($(this));
                $obj.find("#"+type+"_count").text(count > 0 ? count : "");
            });
        }
    };
    /* Event: click menu */
    $menu_list.on("click",function(){
        methods.setCount();
        $menu_list.removeClass('selected');
        $(this).toggleClass('selected');
        $obj.find(".multimedia-list > div").hide();
        var type = $(this).data("menu");
        methods.loadBy(type);
    });
    $obj.on("click", item, function(){
        var block = $(this).parent(".multimedia-block").find(".attach-block").toggleClass('selected');
        methods.setCount();
    });
    return methods;
};