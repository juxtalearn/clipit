!function($, wysi) {
    "use strict";

    var tpl = {
        "font-styles": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li class='dropdown'>" +
                "<a class='btn btn-default dropdown-toggle" + size + "' data-toggle='dropdown' href='#'>" +
                "<i class='fa fa-font'></i>&nbsp;<span class='current-font'>" + locale.font_styles.normal + "</span>&nbsp;<i class='fa fa-angle-down'></i>" +
                "</a>" +
                "<ul class='dropdown-menu'>" +
                "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='div' tabindex='-1'>" + locale.font_styles.normal + "</a></li>" +
                "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h1' tabindex='-1'>" + locale.font_styles.h1 + "</a></li>" +
                "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h2' tabindex='-1'>" + locale.font_styles.h2 + "</a></li>" +
                "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h3' tabindex='-1'>" + locale.font_styles.h3 + "</a></li>" +
                "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h4'>" + locale.font_styles.h4 + "</a></li>" +
                "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h5'>" + locale.font_styles.h5 + "</a></li>" +
                "<li><a data-wysihtml5-command='formatBlock' data-wysihtml5-command-value='h6'>" + locale.font_styles.h6 + "</a></li>" +
                "</ul>" +
                "</li>";
        },

        "emphasis": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li>" +
                "<div class='btn-group'>" +
                "<a class='btn btn-default" + size + "' data-wysihtml5-command='bold' title='CTRL+B' tabindex='-1'>" + locale.emphasis.bold + "</a>" +
                "<a class='btn btn-default" + size + "' data-wysihtml5-command='italic' title='CTRL+I' tabindex='-1'>" + locale.emphasis.italic + "</a>" +
                "<a class='btn btn-default" + size + "' data-wysihtml5-command='underline' title='CTRL+U' tabindex='-1'>" + locale.emphasis.underline + "</a>" +
                "</div>" +
                "</li>";
        },

        "lists": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li>" +
                "<div class='btn-group'>" +
                "<a class='btn btn-default" + size + "' data-wysihtml5-command='insertUnorderedList' title='" + locale.lists.unordered + "' tabindex='-1'><i class='fa fa-list-ul'></i></a>" +
                "<a class='btn btn-default" + size + "' data-wysihtml5-command='insertOrderedList' title='" + locale.lists.ordered + "' tabindex='-1'><i class='fa fa-list-ol'></i></a>" +
                "<a class='btn btn-default" + size + "' data-wysihtml5-command='Outdent' title='" + locale.lists.outdent + "' tabindex='-1'><i class='fa fa-indent'></i></a>" +
                "<a class='btn btn-default" + size + "' data-wysihtml5-command='Indent' title='" + locale.lists.indent + "' tabindex='-1'><i class='fa fa-dedent'></i></a>" +
                "</div>" +
                "</li>";
        },

        "link": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li>" +
                "<div class='bootstrap-wysihtml5-insert-link-modal modal fade'>" +
                " <div class='modal-dialog'>" +
                " <div class='modal-content'>" +
                "<div class='modal-header'>" +
                "<a class='close' data-dismiss='modal'></a>" +
                "<h4 class='modal-title'>" + locale.link.insert + "</h4>" +
                "</div>" +
                "<div class='modal-body'>" +
                "<input type='text' value='http://' class='bootstrap-wysihtml5-insert-link-url1 form-control large'>" +
                "<label style='margin-top:5px;'> <input type='checkbox' class='bootstrap-wysihtml5-insert-link-target' checked>" + locale.link.target + "</label>" +
                "</div>" +
                "<div class='modal-footer'>" +
                "<a href='#' class='btn btn-default' data-dismiss='modal'>" + locale.link.cancel + "</a>" +
                "<a href='#' class='btn btn-primary' data-dismiss='modal'>" + locale.link.insert + "</a>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "<a class='btn btn-default" + size + "' data-wysihtml5-command='createLink' title='" + locale.link.insert + "' tabindex='-1'><i class='fa fa-share-square-o'></i></a>" +
                "</li>";
        },

        "image": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li>" +
                "<div class='bootstrap-wysihtml5-insert-image-modal modal fade'>" +
                "<div class='modal-dialog'>" +
                "<div class='modal-content'>" +
                "<div class='modal-header'>" +
                "<a class='close' data-dismiss='modal'></a>" +
                "<h4 class='modal-title'>" + locale.image.insert + "</h4>" +
                "</div>" +
                "<div class='modal-body'>" +
                "<input type='text' value='http://' class='bootstrap-wysihtml5-insert-image-url form-control large'>" +
                "</div>" +
                "<div class='modal-footer'>" +
                "<a href='#' class='btn btn-default' data-dismiss='modal'>" + locale.image.cancel + "</a>" +
                "<a href='#' class='btn btn-primary' data-dismiss='modal'>" + locale.image.insert + "</a>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "<a class='btn btn-default" + size + "' data-wysihtml5-command='insertImage' title='" + locale.image.insert + "' tabindex='-1'><i class='fa fa-picture-o'></i></a>" +
                "</li>";
        },
        "video": function(locale) {
            return "<li>" +
                "<div class='bootstrap-wysihtml5-insert-video-modal modal fade'>" +
                "<div class='modal-dialog'>" +
                "<div class='modal-content'>" +
                "<div class='modal-header'>" +
                "<a class='close' data-dismiss='modal'></a>" +
                "<h4 class='modal-title'>" + locale.video.insert + "</h4>" +
                "</div>" +
                "<div class='modal-body'>" +
                "<input type='text' data-wysihtml5-dialog-field='src' value='http://' class='bootstrap-wysihtml5-insert-video-url form-control large'>" +
                "<div class='control-group form-inline'>" +
                "<label class='video-error hide'>" + locale.video.invalid + "</label>" +
                "</div>" +
                "</div>" +
                "<div class='modal-footer'>" +
                "<a href='#' class='btn btn-default' data-dismiss='modal'>" + locale.video.cancel + "</a>" +
                "<a href='#' class='btn btn-primary' data-dismiss='modal'>" + locale.video.insert + "</a>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "<a class='btn btn-default' data-wysihtml5-command='insertVideo' title='" + locale.video.insert + "'><i class='fa fa-youtube'></i></a>" +
                "</li>";
        },
        "attach": function(locale) {
            return "<li>" +
                "<div class='bootstrap-wysihtml5-insert-video-modal modal fade'>" +
                "<div class='modal-dialog'>" +
                "<div class='modal-content'>" +
                "<div class='modal-header'>" +
                "<a class='close' data-dismiss='modal'></a>" +
                "<h4 class='modal-title'>" + locale.video.insert + "</h4>" +
                "</div>" +
                "<div class='modal-body'>" +
                "<input type='text' data-wysihtml5-dialog-field='src' value='http://' class='bootstrap-wysihtml5-insert-video-url form-control large'>" +
                "<div class='control-group form-inline'>" +
                "<label class='video-error hide'>" + locale.video.invalid + "</label>" +
                "</div>" +
                "</div>" +
                "<div class='modal-footer'>" +
                "<a href='#' class='btn btn-default' data-dismiss='modal'>" + locale.video.cancel + "</a>" +
                "<a href='#' class='btn btn-primary' data-dismiss='modal'>" + locale.video.insert + "</a>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "<a class='btn btn-default' data-wysihtml5-command='insertAttach' title='" + locale.video.insert + "'><i class='fa fa-files-o'></i> Attach</a>" +
                "</li>";
        },
        "html": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li>" +
                "<div class='btn-group'>" +
                "<a class='btn btn-default" + size + "' data-wysihtml5-action='change_view' title='" + locale.html.edit + "' tabindex='-1'><i class='fa fa-pencil'></i></a>" +
                "</div>" +
                "</li>";
        },

        "color": function(locale, options) {
            var size = (options && options.size) ? ' btn-'+options.size : '';
            return "<li class='dropdown'>" +
                "<a class='btn btn-default dropdown-toggle" + size + "' data-toggle='dropdown' href='#' tabindex='-1'>" +
                "<span class='current-color'>" + locale.colours.black + "</span>&nbsp;<i class='fa fa-angle-down'></i>" +
                "</a>" +
                "<ul class='dropdown-menu'>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='black'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='black'>" + locale.colours.black + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='silver'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='silver'>" + locale.colours.silver + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='gray'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='gray'>" + locale.colours.gray + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='maroon'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='maroon'>" + locale.colours.maroon + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='red'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='red'>" + locale.colours.red + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='purple'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='purple'>" + locale.colours.purple + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='green'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='green'>" + locale.colours.green + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='olive'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='olive'>" + locale.colours.olive + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='navy'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='navy'>" + locale.colours.navy + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='blue'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='blue'>" + locale.colours.blue + "</a></li>" +
                "<li><div class='wysihtml5-colors' data-wysihtml5-command-value='orange'></div><a class='wysihtml5-colors-title' data-wysihtml5-command='foreColor' data-wysihtml5-command-value='orange'>" + locale.colours.orange + "</a></li>" +
                "</ul>" +
                "</li>";
        }
    };

    var templates = function(key, locale, options) {
        return tpl[key](locale, options);
    };


    var Wysihtml5 = function(el, options) {
        this.el = el;
        var toolbarOpts = options || defaultOptions;
        for(var t in toolbarOpts.customTemplates) {
            tpl[t] = toolbarOpts.customTemplates[t];
        }
        this.toolbar = this.createToolbar(el, toolbarOpts);
        this.editor =  this.createEditor(options);

        window.editor = this.editor;

        $('iframe.wysihtml5-sandbox').each(function(i, el){
            $(el.contentWindow).off('focus.wysihtml5').on({
                'focus.wysihtml5' : function(){
                    $('li.dropdown').removeClass('open');
                }
            });
        });
    };

    Wysihtml5.prototype = {

        constructor: Wysihtml5,

        createEditor: function(options) {
            options = options || {};

            // Add the toolbar to a clone of the options object so multiple instances
            // of the WYISYWG don't break because "toolbar" is already defined
            options = $.extend(true, {}, options);
            options.toolbar = this.toolbar[0];

            var editor = new wysi.Editor(this.el[0], options);
            // resize
            editor.on('load', function() {
                // The wysiwyg editor is in the DOM. It's safe to make the plugin call
                $(editor.composer.iframe).wysihtml5_size_matters();
            });

            // Onkeydown check video url
            editor.observe(editor.composer.element.ownerDocument,"keydown", function () {
                console.log("down");
            });
            editor.observe(this.element, "keydown", function(event) {
               console.log("key");
            });
//            editor.observe("newword:composer", function() {
//                console.log("dasm");
//            });
            editor.observe("paste",function(event){
                var that = this;
//                console.log(that.composer.element);
//                console.log(this.composer.sandbox);
//                this.composer.selection.executeAndRestore(function() {
//                    //console.log(that.composer.element);
//                });
//                editor.composer.commands.exec("insertVideo", { src: "http://www.youtube.com/embed/Hx_rRirV2vc", width: '398', height: '224' });

            });
//            editor.observe("paste:composer",function(event){
//                var text = this.getValue();
//                function linkifyYouTubeURLs(text) {
//
//                    var re = /https?:\/\/(?:[0-9A-Z-]+\.)?(?:youtu\.be\/|youtube(?:-nocookie)?\.com\S*[^\w\s-])([\w-]{11})(?=[^\w-]|$)(?![?=&+%\w.-]*(?:['"][^<>]*>|<\/a>))[?=&+%\w.-]*/ig;
//                    return text.replace(re,
//                        '<a href="http://www.youtube.com/watch?v=$1">YouTube link: $1</a>');
//                }
//                this.textarea.setValue(linkifyYouTubeURLs(text));
//            });
//            editor.observe("paste:composer", function(event) {
//                var value = this.getValue();
//                var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
//                var match = p.exec(value);
//                //console.log(match);
//            });
            if(options && options.events) {
                for(var eventName in options.events) {
                    editor.on(eventName, options.events[eventName]);
                }
            }
            return editor;
        },

        createToolbar: function(el, options) {
            var self = this;
            var toolbar = $("<ul/>", {
                'class' : "wysihtml5-toolbar",
                'style': "display:none"
            });
            var culture = options.locale || defaultOptions.locale || "en";
            for(var key in defaultOptions) {
                var value = false;

                if(options[key] !== undefined) {
                    if(options[key] === true) {
                        value = true;
                    }
                } else {
                    value = defaultOptions[key];
                }

                if(value === true) {
                    toolbar.append(templates(key, locale[culture], options));

                    if(key === "html") {
                        this.initHtml(toolbar);
                    }

                    if(key === "link") {
                        this.initInsertLink(toolbar);
                    }

                    if(key === "image") {
                        this.initInsertImage(toolbar);
                    }
                    if(key === "video") {
                        this.initInsertVideo(toolbar);
                    }
                }
            }

            if(options.toolbar) {
                for(key in options.toolbar) {
                    toolbar.append(options.toolbar[key]);
                }
            }

            toolbar.find("a[data-wysihtml5-command='formatBlock']").click(function(e) {
                var target = e.target || e.srcElement;
                var el = $(target);
                self.toolbar.find('.current-font').text(el.html());
            });

            toolbar.find("a[data-wysihtml5-command='foreColor']").click(function(e) {
                var target = e.target || e.srcElement;
                var el = $(target);
                self.toolbar.find('.current-color').text(el.html());
            });

            this.el.before(toolbar);

            return toolbar;
        },

        initHtml: function(toolbar) {
            var changeViewSelector = "a[data-wysihtml5-action='change_view']";
            toolbar.find(changeViewSelector).click(function(e) {
                toolbar.find('a.btn').not(changeViewSelector).toggleClass('disabled');
            });
        },

        initInsertImage: function(toolbar) {
            var self = this;
            var insertImageModal = toolbar.find('.bootstrap-wysihtml5-insert-image-modal');
            var urlInput = insertImageModal.find('.bootstrap-wysihtml5-insert-image-url');
            var insertButton = insertImageModal.find('a.btn-primary');
            var initialValue = urlInput.val();
            var caretBookmark;

            var insertImage = function() {
                var url = urlInput.val();
                urlInput.val(initialValue);
                self.editor.currentView.element.focus();
                if (caretBookmark) {
                    self.editor.composer.selection.setBookmark(caretBookmark);
                    caretBookmark = null;
                }
                self.editor.composer.commands.exec("insertImage", url);
            };

            urlInput.keypress(function(e) {
                if(e.which == 13) {
                    insertImage();
                    insertImageModal.modal('hide');
                }
            });

            insertButton.click(insertImage);

            insertImageModal.on('shown', function() {
                urlInput.focus();
            });

            insertImageModal.on('hide', function() {
                self.editor.currentView.element.focus();
            });

            toolbar.find('a[data-wysihtml5-command=insertImage]').click(function() {
                var activeButton = $(this).hasClass("wysihtml5-command-active");

                if (!activeButton) {
                    self.editor.currentView.element.focus(false);
                    caretBookmark = self.editor.composer.selection.getBookmark();
                    insertImageModal.appendTo('body').modal('show');
                    insertImageModal.on('click.dismiss.modal', '[data-dismiss="modal"]', function(e) {
                        e.stopPropagation();
                    });
                    return false;
                }
                else {
                    return true;
                }
            });
        },

        initInsertLink: function(toolbar) {
            var self = this;
            var insertLinkModal = toolbar.find('.bootstrap-wysihtml5-insert-link-modal');
            var urlInput = insertLinkModal.find('.bootstrap-wysihtml5-insert-link-url');
            var targetInput = insertLinkModal.find('.bootstrap-wysihtml5-insert-link-target');
            var insertButton = insertLinkModal.find('a.btn-primary');
            var initialValue = urlInput.val();
            var caretBookmark;

            var insertLink = function() {
                var url = urlInput.val();
                urlInput.val(initialValue);
                self.editor.currentView.element.focus();
                if (caretBookmark) {
                    self.editor.composer.selection.setBookmark(caretBookmark);
                    caretBookmark = null;
                }

                var newWindow = targetInput.prop("checked");
                self.editor.composer.commands.exec("createLink", {
                    'href' : url,
                    'target' : (newWindow ? '_blank' : '_self'),
                    'rel' : (newWindow ? 'nofollow' : '')
                });
            };
            var pressedEnter = false;

            urlInput.keypress(function(e) {
                if(e.which == 13) {
                    insertLink();
                    insertLinkModal.modal('hide');
                }
            });

            insertButton.click(insertLink);

            insertLinkModal.on('shown', function() {
                urlInput.focus();
            });

            insertLinkModal.on('hide', function() {
                self.editor.currentView.element.focus();
            });

            toolbar.find('a[data-wysihtml5-command=createLink]').click(function() {
                var activeButton = $(this).hasClass("wysihtml5-command-active");

                if (!activeButton) {
                    self.editor.currentView.element.focus(false);
                    caretBookmark = self.editor.composer.selection.getBookmark();
                    insertLinkModal.appendTo('body').modal('show');
                    App.initUniform(); //initialize uniform checkboxes
                    insertLinkModal.on('click.dismiss.modal', '[data-dismiss="modal"]', function(e) {
                        e.stopPropagation();
                    });
                    return false;
                }
                else {
                    return true;
                }
            });
        },
        initInsertVideo: function(toolbar) {
            var self = this;
            var insertVideoModal = toolbar.find('.bootstrap-wysihtml5-insert-video-modal');
            var urlInput = insertVideoModal.find('.bootstrap-wysihtml5-insert-video-url');
            var insertButton = insertVideoModal.find('a.btn-primary');
            var errorSpan = insertVideoModal.find('.video-error');
            function ytVidId(url) {
                var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
                return (url.match(p)) ? RegExp.$1 : false;
            }
            var insertVideo = function() {
                errorSpan.hide();
                //urlInput.parent().removeClass('error');
                var linkUrl = urlInput.val();
                var embedUrl = linkUrl;

                if ( ytVidId(linkUrl) ) {
                    var linkParams = ytVidId(linkUrl);
                    embedUrl = '//www.youtube.com/embed/' + linkParams.split('&')[0];

                    urlInput.val(linkUrl);
                    self.editor.currentView.element.focus();
                    self.editor.composer.commands.exec("insertVideo", { src: embedUrl, width: '398', height: '224' });
                } else {
                    errorSpan.show();
                    //urlInput.parent().addClass('error');
                    return false;
                }
            };

            urlInput.keypress(function(e) {
                if(e.which == 13) {
                    insertVideo();
                    insertVideoModal.modal('hide');
                }
            });

            insertButton.click(insertVideo);

            insertVideoModal.on('shown', function() {
                urlInput.focus();
            });

            insertVideoModal.on('hide', function() {
                self.editor.currentView.element.focus();
            });

            toolbar.find('a[data-wysihtml5-command=insertVideo]').click(function() {
                insertVideoModal.appendTo('body').modal('show');
                insertVideoModal.on('click.dismiss.modal', '[data-dismiss="modal"]', function(e) {
                    e.stopPropagation();
                });
                return false;
            });
        }
    };

    // these define our public api
    var methods = {
        resetDefaults: function() {
            $.fn.wysihtml5.defaultOptions = $.extend(true, {}, $.fn.wysihtml5.defaultOptionsCache);
        },
        bypassDefaults: function(options) {
            return this.each(function () {
                var $this = $(this);
                $this.data('wysihtml5', new Wysihtml5($this, options));
            });
        },
        shallowExtend: function (options) {
            var settings = $.extend({}, $.fn.wysihtml5.defaultOptions, options || {}, $(this).data());
            var that = this;
            return methods.bypassDefaults.apply(that, [settings]);
        },
        deepExtend: function(options) {
            var settings = $.extend(true, {}, $.fn.wysihtml5.defaultOptions, options || {});
            var that = this;
            return methods.bypassDefaults.apply(that, [settings]);
        },
        init: function(options) {
            var that = this;
            return methods.shallowExtend.apply(that, [options]);
        }
    };

    $.fn.wysihtml5 = function ( method ) {
        if ( methods[method] ) {
            return methods[method].apply( this, Array.prototype.slice.call( arguments, 1 ));
        } else if ( typeof method === 'object' || ! method ) {
            return methods.init.apply( this, arguments );
        } else {
            $.error( 'Method ' +  method + ' does not exist on jQuery.wysihtml5' );
        }
    };

    $.fn.wysihtml5.Constructor = Wysihtml5;

    var defaultOptions = $.fn.wysihtml5.defaultOptions = {
        "font-styles": false,
        "color": false,
        "emphasis": true,
        "lists": true,
        "video": true,
        "image": true,
        "attach": true,
        "html": false,
        "link": false,

        events: {},
        parserRules: {
            classes: {
                // (path_to_project/lib/css/wysiwyg-color.css)
                "wysiwyg-color-silver" : 1,
                "wysiwyg-color-gray" : 1,
                "wysiwyg-color-white" : 1,
                "wysiwyg-color-maroon" : 1,
                "wysiwyg-color-red" : 1,
                "wysiwyg-color-purple" : 1,
                "wysiwyg-color-fuchsia" : 1,
                "wysiwyg-color-green" : 1,
                "wysiwyg-color-lime" : 1,
                "wysiwyg-color-olive" : 1,
                "wysiwyg-color-yellow" : 1,
                "wysiwyg-color-navy" : 1,
                "wysiwyg-color-blue" : 1,
                "wysiwyg-color-teal" : 1,
                "wysiwyg-color-aqua" : 1,
                "wysiwyg-color-orange" : 1
            },
            tags: {
                "b":  {},
                "strong":  {},
                "em":  {},
                "i":  {},
                "p": {},
                "br": {},
                "ol": {},
                "ul": {},
                "li": {},
                "h1": {},
                "h2": {},
                "h3": {},
                "h4": {},
                "h5": {},
                "h6": {},
                "blockquote": {},
                "u": 1,
                "img": {
                    "check_attributes": {
                        "width": "numbers",
                        "alt": "alt",
                        "src": "url",
                        "height": "numbers"
                    }
                },
                "a":  {
                    check_attributes: {
                        'href': "url", // important to avoid XSS
                        'target': 'alt',
                        'rel': 'alt'
                    }
                },
                "iframe": {
                    "check_attributes": {
                        "src":"url",
                        "width":"numbers",
                        "height":"numbers"
                    },
                    "set_attributes":{
                        "frameborder":"0"
                    }
                },
                "span": 1,
                "div": 1,
                // to allow save and edit files with code tag hacks
                "code": 1,
                "pre": 1
            }
        },
        stylesheets: [elgg.config.wwwroot+"mod/z03_clipit_theme/vendors/wysihtml5/wysihtml5-default.css"], // (path_to_project/lib/css/wysiwyg-color.css)
        locale: "en"
    };

    if (typeof $.fn.wysihtml5.defaultOptionsCache === 'undefined') {
        $.fn.wysihtml5.defaultOptionsCache = $.extend(true, {}, $.fn.wysihtml5.defaultOptions);
    }

    var locale = $.fn.wysihtml5.locale = {
        en: {
            font_styles: {
                normal: "Normal text",
                h1: "Heading 1",
                h2: "Heading 2",
                h3: "Heading 3",
                h4: "Heading 4",
                h5: "Heading 5",
                h6: "Heading 6"
            },
            emphasis: {
                bold: "B",
                italic: "I",
                underline: "U"
            },
            lists: {
                unordered: "Unordered list",
                ordered: "Ordered list",
                outdent: "Outdent",
                indent: "Indent"
            },
            link: {
                insert: "Insert link",
                cancel: "Cancel",
                target: "Open link in new window"
            },
            image: {
                insert: "Insert image",
                cancel: "Cancel"
            },
            video: {
                insert: "Insert YouTube Video",
                cancel: "Cancel",
                invalid: "invalid video URL"
            },
            html: {
                edit: "Edit HTML"
            },
            colours: {
                black: "Black",
                silver: "Silver",
                gray: "Grey",
                maroon: "Maroon",
                red: "Red",
                purple: "Purple",
                green: "Green",
                olive: "Olive",
                navy: "Navy",
                blue: "Blue",
                orange: "Orange"
            }
        }
    };

}(window.jQuery, window.wysihtml5);


/** Insert Video Functions
 *
 */

(function(wysihtml5) {
    var NODE_NAME = "IFRAME";

    wysihtml5.commands.insertVideo = {
        /**
         * @example
         *    // either ...
         *    wysihtml5.commands.insertVideo.exec(composer, 'insertVideo', 'http://www.youtube.com/embed/Hx_rRirV2vc');
         *    // ... or ...
         *    wysihtml5.commands.insertVideo.exec(composer, 'insertVideo', { src: 'http://www.youtube.com/embed/Hx_rRirV2vc', width: '560', height: '315' });
         */
        exec: function(composer, command, value) {
            value = typeof(value) === "object" ? value : { src: value };
            var doc   = composer.doc,
                video = this.state(composer),
                i,
                parent;

            if (video) {
                // Video already selected, set the caret before it and delete it
                composer.selection.setBefore(video);
                parent = video.parentNode;
                parent.removeChild(video);

                // and it's parent <a> too if it hasn't got any other relevant child nodes
                wysihtml5.dom.removeEmptyTextNodes(parent);
                if (parent.nodeName === "A" && !parent.firstChild) {
                    composer.selection.setAfter(parent);
                    parent.parentNode.removeChild(parent);
                }

                // firefox and ie sometimes don't remove the video handles, even though the video was removed
                wysihtml5.quirks.redraw(composer.element);
                return;
            }

            video = doc.createElement(NODE_NAME);

            for (i in value) {
                video[i] = value[i];
            }
            console.log(video);
            composer.selection.insertNode(video);
            if (wysihtml5.browser.hasProblemsSettingCaretAfterImg()) {
                textNode = doc.createTextNode(wysihtml5.INVISIBLE_SPACE);
                composer.selection.insertNode(textNode);
                composer.selection.setAfter(textNode);
            } else {
                composer.selection.setAfter(video);
            }
        },

        state: function(composer) {
            var doc = composer.doc,
                selectedNode,
                text,
                videosInSelection;

            if (!wysihtml5.dom.hasElementWithTagName(doc, NODE_NAME)) {
                return false;
            }

            selectedNode = composer.selection.getSelectedNode(doc);
            if (!selectedNode) {
                return false;
            }

            if (selectedNode.nodeName === NODE_NAME) {
                // This works perfectly in IE
                return selectedNode;
            }

            if (selectedNode.nodeType !== wysihtml5.ELEMENT_NODE) {
                return false;
            }

            text = composer.selection.getText(doc);
            text = wysihtml5.lang.string(text).trim();
            if (text) {
                return false;
            }

            videosInSelection = composer.selection.getNodes(doc, wysihtml5.ELEMENT_NODE, function(node) {
                return node.nodeName === "IFRAME";
            });

            if (videosInSelection.length !== 1) {
                return false;
            }

            return videosInSelection[0];
        },

        value: function(composer) {
            var video = this.state(composer);
            return video && video.src;
        }
    };
}(wysihtml5));

(function(wysihtml5) {
    wysihtml5.commands.insertEmbedVideo = {
        /**
         * @example
         *    wysihtml5.commands.insertEmbedVideo.exec(element, "insertEmbedVideo", "<iframe width="560" height="315" src="http://www.youtube.com/embed/dJfSS0ZXYdo" frameborder="0" allowfullscreen></iframe>");
         */
        exec: function(element, command, value) {
            var code = value.src,
                attributes = {
                    src: wysihtml5.commands.getAttributeValue.exec(code,"src"),
                    width: wysihtml5.commands.getAttributeValue.exec(code,"width"),
                    height: wysihtml5.commands.getAttributeValue.exec(code,"height")
                },
                obj = (Object.create) ? Object.create(attributes) : new Object(attributes); //Object.create doesn't work in IE8
            wysihtml5.commands.insertVideo.exec(element, command, obj);
        },

        state: function(element) {
            wysihtml5.commands.insertVideo.state(element);
        },

        value: function(element) {
            wysihtml5.commands.insertVideo.value(element);
        }
    };
}(wysihtml5));

(function(wysihtml5) {
    wysihtml5.commands.getAttributeValue = {
        exec: function (code,attr){
            return code.substring(parseInt(code.indexOf(attr))+attr.length + 2,code.length).split("\" ")[0];
        }
    };
}(wysihtml5));

// Resize function
(function() {
    (function($) {
        var Wysihtml5SizeMatters;

        Wysihtml5SizeMatters = (function() {
            function Wysihtml5SizeMatters(iframe) {
                this.$iframe = $(iframe);
                this.$body = this.findBody();
                this.addBodyStyles();
                this.setupEvents();
                this.adjustHeight();
            }

            Wysihtml5SizeMatters.prototype.addBodyStyles = function() {
                this.$body.css('overflow', 'hidden');
                return this.$body.css('min-height', 0);
            };

            Wysihtml5SizeMatters.prototype.setupEvents = function() {
                var _this = this;

                return this.$body.on('keyup keydown paste change focus', function() {
                    return _this.adjustHeight();
                });
            };

            Wysihtml5SizeMatters.prototype.adjustHeight = function() {
                return this.$iframe.css('min-height', this.$body.height() + this.extraBottomSpacing());
            };

            Wysihtml5SizeMatters.prototype.extraBottomSpacing = function() {
                return parseInt(this.$body.css('line-height')) || this.estimateLineHeight();
            };

            Wysihtml5SizeMatters.prototype.estimateLineHeight = function() {
                return parseInt(this.$body.css('font-size')) * 1.14;
            };

            Wysihtml5SizeMatters.prototype.findBody = function() {
                return this.$iframe.contents().find('body');
            };

            return Wysihtml5SizeMatters;

        })();
        return $.fn.wysihtml5_size_matters = function() {
            return this.each(function() {
                var wysihtml5_size_matters;

                wysihtml5_size_matters = $.data(this, 'wysihtml5_size_matters');
                if (!wysihtml5_size_matters) {
                    return wysihtml5_size_matters = $.data(this, 'wysihtml5_size_matters', new Wysihtml5SizeMatters(this));
                }
            });
        };
    })($);

}).call(this);