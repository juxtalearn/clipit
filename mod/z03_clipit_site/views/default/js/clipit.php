//<script>
elgg.provide('clipit');
// Mute jQuery migrate logging
jQuery.migrateMute = true;

clipit.init = function() {
    $('form[data-validate]').each(function(){
        if($(this).find('input, select').filter('[required]')) {
            $(this).find('input[required], select[required]').prev('label:not(:empty)').addClass('label-asterisk');
            var btn = $(this).find('input[type="submit"]');
            btn.parent('div').prepend('<small class="pull-left required-message" style="line-height: 30px;margin-right: 20px;">'+elgg.echo('input:required:information')+'</small>');
        }
    });
    /**
     * jQuery validator int messages
     */
    jQuery.extend(jQuery.validator.messages, {
        required: elgg.echo('validation:required'),
        remote: elgg.echo('validation:remote'),
        email: elgg.echo('validation:email'),
        url: elgg.echo('validation:url'),
        date: elgg.echo('validation:date'),
        dateISO: elgg.echo('validation:dateISO'),
        number: elgg.echo('validation:number'),
        digits: elgg.echo('validation:digits'),
        creditcard: elgg.echo('validation:creditcard'),
        equalTo: elgg.echo('validation:equalTo'),
        accept: elgg.echo('validation:accept'),
        maxlength: jQuery.validator.format(elgg.echo('validation:maxlength')),
        minlength: jQuery.validator.format(elgg.echo('validation:minlength')),
        rangelength: jQuery.validator.format(elgg.echo('validation:rangelength')),
        range: jQuery.validator.format(elgg.echo('validation:range')),
        max: jQuery.validator.format(elgg.echo('validation:max')),
        min: jQuery.validator.format(elgg.echo('validation:min')),
        extension: elgg.echo('validation:creditcard')
    });
    clipit.validationCustomMethods();

    $.datepicker.regional = {
        monthNames: JSON.parse(elgg.echo('calendar:month_names')),
        monthNamesShort: JSON.parse(elgg.echo('calendar:month_names_short')),
        dayNames: JSON.parse(elgg.echo('calendar:day_names')),
        dayNamesShort: JSON.parse(elgg.echo('calendar:day_names_short')),
        dayNamesMin: JSON.parse(elgg.echo('calendar:day_names_min')),
        weekHeader: 'Sm',
        firstDay: 1 // Monday
    };
    $.datepicker.setDefaults($.datepicker.regional);
    // set active to registered menu
    clipit.isActiveMenu();
    // TinyMCE init by default
    clipit.tinymce();
    // Validation request new password
    $(".elgg-form-user-requestnewpassword").validate(clipit.formForgotpasswordValidation());
    $(".elgg-form-register").validate(clipit.formRegisterValidation());
    $("body").on("click", "input[type=submit]", clipit.submitLoading);
    // discussion reply button
    $(".reply-to, .close-reply-to").click(clipit.replyTo);
    // Read more/less shorten plugin
    clipit.shorten('[data-shorten=true]');
    // Form validation
    $("body").on("click", "form[data-validate=true]", clipit.formValidation);
    // Remove object confirmation
    $(".remove-object").click(clipit.removeObject);
    // Tags from list
    $('ul#tags').each(clipit.tagList);
    // Labels from list
    $('ul#labels').each(clipit.labelList);
    // HTML5 autofocus inside a modal
    $(document).on('shown.bs.modal', function (e) {
        $('[autofocus]', e.target).focus();
    });
    // Clone elements
    /**
     * HTML code:
     * <element class="prototype-container" data-prototype="htmlentities(ELEMENT-TO-CLONE)?>>
     *     <element class="prototype-content">  </element>
     * </element>
    */
     $(document).on("click", ".prototype-add", clipit.prototype_clone);
};
elgg.register_hook_handler('init', 'system', clipit.init);
/**
 * TinyMce default configuration
 */

clipit.tinymce = function(id){
    tinymce.init(clipit.tinymce.init(id));
};
clipit.tinymce.init = function(id){
    return {
        setup : function(ed) {
            ed.on("init",function() {
                $(".mce-ico").addClass("fa");
                // mce icons
                $(".mce-i-bullist").addClass("fa-list-ul");
                $(".mce-i-numlist").addClass("fa-list-ol");
                $(".mce-i-outdent").addClass("fa-outdent");
                $(".mce-i-indent").addClass("fa-indent");
                $(".mce-i-underline").addClass("fa-underline");
                $(".mce-i-italic").addClass("fa-italic");
                $(".mce-i-bold").addClass("fa-bold");
            });

            ed.on('change', function(e) {
                tinyMCE.triggerSave();
            });
            ed.on('focus', function(e) {
                $(ed.editorContainer).addClass('focused');
            });
            ed.on('blur', function(e) {
                $(ed.editorContainer).removeClass('focused');
            });
        },
        convert_urls: true,
        mode : "specific_textareas",
        formats : {
            underline : {inline : 'u', exact : true}
        },
        editor_selector : /(mceEditor|wysihtml5|"+id+")/,
        force_br_newlines : true,
        force_p_newlines : false,
        plugins: ["mention, autoresize, paste, autolink"],
        content_css : elgg.config.wwwroot+"mod/z03_clipit_site/vendors/tinymce/content.css",
        valid_styles : 'text-align',
        paste_remove_spans: true,
        verify_html: true,
        paste_text_sticky : true,
        paste_retain_style_properties : 'none',
        inline_styles : false,
        paste_remove_styles: true,
        paste_auto_cleanup_on_paste: true,
        paste_strip_class_attributes: true,
        paste_remove_styles_if_webkit: true,
        invalid_elements: 'img,h1,h2',
        autoresize_min_height: 150,
        autoresize_max_height: 400,
        mentions: {
            delay: 0,
            source: function (query, process, delimiter) {
                // Do your ajax call
                // When using multiple delimiters you can alter the query depending on the delimiter used
                if (delimiter === '@') {
                    $.getJSON(elgg.config.wwwroot+"ajax/view/messages/search_to?q="+query, function (data) {
                        //call process to show the result
                        if(data){
                            process(data);
                        }
                    });
                }
            },
            delimiter: '@',
            queryBy: 'first_name',
            render: function(item) {
                var img = "<img class='img' src='" + item.avatar + "' title='" + item.first_name + "' height='25px' width='25px' />";
                return "<li class='text-truncate'>" + img + "<div class='block'><div class='title'>" + item.first_name + "</div><div class='sub-title'>" + item.username + "</div></div></li>";
            },
            renderDropdown: function() {
                //add twitter bootstrap dropdown-menu class
                return '<ul class="rte-autocomplete dropdown-menu mention-autocomplete"><li class="loading"><i class="fa fa-spinner fa-spin"></i></li></ul>';
            },

            insert: function(item) {
                return item.username;
            }
        },
        menubar: false,
        statusbar: false,
        toolbar: "bold italic underline | bullist numlist | outdent indent"
    };
};
clipit.autosize = function(element){
    this.element = element;
    this.$element = $(element);
    var height = this.$element.outerHeight();
    var diff = parseInt(this.$element.css('paddingBottom')) +
        parseInt(this.$element.css('paddingTop'));

    if (this.$element.val().replace(/\s/g, '').length > 0) {
        this.$element.height(this.element.scrollHeight - diff);
    }

    // keyup is required for IE to properly reset height when deleting text
    this.$element.on('input keyup', function(event) {
        var $window = $(window);
        var currentScrollPosition = $window.scrollTop();

        $(this)
            .height(0)
            .height(this.scrollHeight - diff);

        $window.scrollTop(currentScrollPosition);
    });
};
// mock Globalize numberFormat for mins and secs using jQuery spinner ...
if (!window.Globalize) window.Globalize = {
    format: function(number, format) {
        number = String(this.parseFloat(number, 10) * 1);
        format = (m = String(format).match(/^[nd](\d+)$/)) ? m[1] : 2;
        for (i = 0; i < format - number.length; i++)
            number = '0'+number;
        return number;
    },
    parseFloat: function(number, radix) {
        return parseFloat(number, radix || 10);
    }
};
clipit.datetimepickerDefaultControlType = {
    create: function (tp_inst, obj, unit, val, min, max, step) {
        $('<input class=\"ui-timepicker-input form-control\" value=\"' + val + '\">')
            .appendTo(obj)
            .spinner({
                min: min,
                max: max,
                step: step,
                numberFormat: 'd2',
                change: function (e, ui) { // key events
                    // don't call if api was used and not key press
                    if (e.originalEvent !== undefined)
                        tp_inst._onTimeChange();
                    tp_inst._onSelectHandler();
                },
                spin: function (e, ui) { // spin events
                    tp_inst.control.value(tp_inst, obj, unit, ui.value);
                    tp_inst._onTimeChange();
                    tp_inst._onSelectHandler();
                }
            });

        return obj;
    },
    options: function(tp_inst, obj, unit, opts, val){
        if(typeof(opts) == 'string' && val !== undefined)
            return obj.find('.ui-timepicker-input').spinner(opts, val);
        return obj.find('.ui-timepicker-input').spinner(opts);
    },
    value: function (tp_inst, obj, unit, val) {
        if (val !== undefined)
            return obj.find('.ui-timepicker-input').spinner('value', val);
        return obj.find('.ui-timepicker-input').spinner('value');
    }
};
clipit.datetimepickerDefault = function(data) {
    return $.extend({
        controlType: clipit.datetimepickerDefaultControlType,
        dateFormat: 'dd/mm/y',
        timeFormat: 'HH:mm',
        stepMinute: 15,
        minuteMin: 0,
        timeText: elgg.echo('time'),
        closeText: elgg.echo('ok'),
        onClose: function (text, inst) {
            var that = $(this);
            if($(this).hasClass('input-task-start')){
                var $task_end = $(this).closest('.task').find('.input-task-end'),
                    task_start_val = $(this).val();
                $task_end.datetimepicker( "option", "minDate", that.datetimepicker('getDate'));
                $task_end.datetimepicker( "option", "minDateTime", that.datetimepicker('getDate'));
                $task_end.val($task_end.val());
            }
        }
    }, data);
};
/**
 * Forgotpassword form validation
 */
clipit.formForgotpasswordValidation = function(e) {
    return {
        errorElement: "span",
        errorPlacement: function (error, element) {
            error.appendTo($("label[for=" + element.attr('name') + "]"));
        },
        onkeyup: false,
        onblur: false,
        rules: {
            email: {
                remote: {
                    url: elgg.config.wwwroot + "action/user/check",
                    type: "POST",
                    data: {
                        email: function () {
                            return $("input[name='email']").val();
                        },
                        __elgg_token: function () {
                            return $("input[name='__elgg_token']").val();
                        },
                        __elgg_ts: function () {
                            return $("input[name='__elgg_ts']").val();
                        }
                    }
                }
            }
        },
        submitHandler: function (form) {
            if ($(form).valid()) {
                $.post("" + $(form).attr('action') + "", $(form).serialize(), function () {
                    $(form).find("input[name=email]").prop("disabled", true);
                    $(form).find("input[type=submit]")
                        .after(
                        "<p class='text-info'>" +
                        "<img src='" + elgg.config.wwwroot + "mod/z03_clipit_site/graphics/ok.png'/>" +
                        " <strong>"+elgg.echo("user:forgotpassword:ok")+"</strong></p>")
                        .remove();
                });
            }
        }
    }
};
clipit.formRegisterValidation = function(e){
  return {
      errorElement: "span",
      errorPlacement: function (error, element) {
          error.appendTo($("label[for=" + element.attr('name') + "]"));
      },
      onkeyup: false,
      onblur: false,
      rules: {
          username: {
              required: true,
              minlength: 1,
              login_normalize: true,
              remote: {
                  url: elgg.config.wwwroot + "action/user/check",
                  type: "POST",
                  data: {
                      username: function () {
                          return $("input[name='username']").val();
                      },
                      __elgg_token: function () {
                          return $("input[name='__elgg_token']").val();
                      },
                      __elgg_ts: function () {
                          return $("input[name='__elgg_ts']").val();
                      }
                  }
              }
          }
      },
      submitHandler: function (form) {
          if ($(form).valid())
              form.submit();
      }
  };
};
clipit.validationCustomMethods = function(){
    $.validator.addMethod(
        "login_normalize",
        function(value, element) {
            var re = new RegExp(/^[a-zA-Z0-9_.]*$/);
            re.test( element.value );
            return this.optional(element) || re.test(value);
        },
        elgg.echo('validation:login_normalize')
    );
    $.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please check your input."
    );
    $.validator.addMethod("extension", function(value, element, param) {
        param = typeof param === "string" ? param.replace(/,/g, "|") : "png|jpe?g|gif";
        return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
    }, $.validator.format(elgg.echo('validation:extension')));
};
/**
 * Form general validation
 */
clipit.formValidation = function() {
    tinyMCE.triggerSave();
    //$("form[data-validate=true]").each(function(){
    var form_to = $(this);
    $(this).validate({
        errorElement: "span",
        errorPlacement: function (error, element) {
            error.appendTo($("label[for='" + element.attr('name') + "']"));
        },
        //ignore: [], // DEBUG
        ignore: ":hidden:not(.mceEditor, .hidden-validate)",
        focusInvalid: true,
        onkeyup: false,
        onblur: false,
        submitHandler: function (form) {
            var button_submit = form_to.find("input[type=submit]");
            button_submit.data("loading-text", elgg.echo('loading')+"...").button('loading');
            if ($(form).valid())
                form.submit();
            else
                button_submit.data("loading-text", elgg.echo('loading')+"...").button('loading');
        }
    }).focusInvalid = function () {
        // put focus on tinymce on submit validation
        if (this.settings.focusInvalid) {
            try {
                var toFocus = $(this.findLastActive() || this.errorList.length && this.errorList[0].element || []);

                if (toFocus.is("textarea")) {
                    tinyMCE.get(toFocus.attr("id")).focus();
                } else {
                    toFocus.filter(":visible").focus();
                }
            } catch (e) {
                // ignore IE throwing errors when focusing hidden elements
            }
        }
    };
};
/**
 * wysihtml5 editor default options
 */
// Load wysi each textarea
//$('.wysihtml5').wysihtml5();

/**
 * Default confirm dialog to remove objects
 */
clipit.removeObject = function(e){
    e.preventDefault();
    var link = $(this).attr("href");
    var confirmOptions = {
        title: elgg.echo("question:areyousure"),
        buttons: {
            confirm: {
                label: elgg.echo("input:yes")
            },
            cancel: {
                label: elgg.echo("input:no"),
                className: "btn-border-blue btn-default"
            }
        },
        message: elgg.echo("deleteconfirm"),
        callback: function(result) {
            if (result) {
                document.location.href = link;  // if result, "set" the document location
            }
        }
    };
    bootbox.confirm(confirmOptions);
};
/**
 * Reply to user
 * check if form exists
 */
clipit.replyTo = function(){
    var reply_to_id = $(this).attr("id");
    var form_id = "#form-"+reply_to_id;
    var message = $(this).closest(".message");
    message.find("textarea").tinymce(clipit.tinymce.init());
    $(form_id).toggle("fast", function(){
        if($(form_id).is(':visible')){
            var offset = parseInt($(form_id).offset().top) - 50;
            $('html,body').animate({
                scrollTop: offset}, 'slow');
            tinyMCE.activeEditor.focus();
        }
    });
};
/**
 * Button loading state
 * (input submit only)
 */
clipit.submitLoading = function(e){
    // Check if form is validated
    var form = $(this).closest("form");
    var btn = $(this);
    if(!form.data("validate")){
        btn.data("loading-text", elgg.echo('loading')+"...").button('loading');
    }
};
clipit.loadActivityGroupStatus = function(entity){
    var content = $('[data-entity="'+entity+'"]').find('.chart-js');
    if(content.find('svg').length == 0) {
        elgg.get('ajax/view/dashboard/modules/group_status_data', {
            data: {'entity': entity, 'type': 'activity_group_status'},
            success: function (data) {
                content.html(data);
            }
        });
    }
};
clipit.loadGroupStatus = function(entities){
    var container = $('.module-activity_status');
    elgg.get('ajax/view/dashboard/modules/group_status_data', {
        data: {'entities': entities, 'type': 'group_status'},
        dataType: 'json',
        success: function (data) {
            $.each(data, function(group, progress){
                $('[data-group-id='+group+']').css('width', progress + '%').find('span').html(progress + '%');
            });
        }
    });
};
///
/**
 * Tag-it for performance items
 *
 */
clipit.tagList = function(e){
    that = $(this);
    $(this).tagit({
        allowSpaces: true,
        removeConfirmation: true,
        onTagExists: function(event, ui){
            $(ui.existingTag).fadeIn("slow", function() {
                $(this).addClass("selected");
            }).fadeOut("slow", function() {
                $(this).removeClass("selected");
            });
        },
        autocomplete: {
            delay: 0,
            source: elgg.config.wwwroot+"ajax/view/stumbling_blocks/search"
        },
        placeholderText: elgg.echo("tags:commas:separated"),

        singleField: true,
        singleFieldNode: that.closest("form").find("input[name=tags]")
    });
};
/**
 * Menu builder tracking
 * Right sidebar set active when href found is registered in ElggMenu
 */
clipit.isActiveMenu = function() {
    var full_url = window.location.href;
    var urls_type = ['/view/', '?filter=', '/edit/', '/create/', '?s=', '&'];
    for (i in urls_type) {
        var path = full_url.split(urls_type[i])
        var menu_item = $(".elgg-sidebar li a[href='" + path[0] + "']");
        if (menu_item.length > 0) {
            menu_item.parent("li").addClass("active");
        }
    }
};

clipit.labelList = function(e){
    that = $(this);
    $(this).tagit({
        allowSpaces: true,
        removeConfirmation: true,
        onTagExists: function(event, ui){
            $(ui.existingTag).fadeIn("slow", function() {
                $(this).addClass("selected");
            }).fadeOut("slow", function() {
                $(this).removeClass("selected");
            });
        },
        autocomplete: {
            delay: 0,
            source: elgg.config.wwwroot+"ajax/view/publications/labels/search"
        },
        placeholderText: elgg.echo("tags:commas:separated"),

        singleField: true,
        singleFieldNode: that.closest("form").find("input[name=labels]")
    });
};

/*
 * jQuery Shorten plugin
 *
 */
clipit.shorten = function(element, height, message_more, message_less){
    if(!message_more){
        message_more = elgg.echo('read_more');
    }
    if(!message_less){
        message_less = elgg.echo('read_less');
    }
    return $(element).each(function () {
        var element_shorten = $(this);
        if(!height){
            var element_height = element_shorten.css("max-height");
        } else {
            var element_height = height;
        }
//        var element_height = element_shorten.css("max-height");
        element_shorten.addClass("shorten");
        element_shorten.wrapInner("<div class='container-text'/>");
        var container = element_shorten.find('.container-text');
        var container_height = container.css("height");
        if(parseInt(container_height) < parseInt(element_height)){
            return false;
        }
        var readmore_link = $("<a href='javascript:;' class='read-more'>"+message_more+"<strong>...</strong></a>");
        element_shorten.append(readmore_link);
        container.css("max-height",element_height);
        readmore_link.on("click", function(){
            if (container.hasClass('full-content')) {
                container.removeClass('full-content');
                container.addClass('less-content');
                $(this).text(message_more+"...");
            } else {
                container.addClass('full-content');
                $(this).text(message_less);
            }
        });
    });
};
clipit.prototype_clone = function(){
    var container = $(this).closest('.prototype-container'),
        content = container.find('.prototype-content');
    content.append( container.data('prototype') );
};

$(function(){
    // jQuery fileupload widget
    $.blueimp.fileupload.prototype.options.messages = {
        maxNumberOfFiles: elgg.echo('fileupload:maxnumber'),
        acceptFileTypes: elgg.echo('fileupload:acceptfiles'),
        maxFileSize: elgg.echo('fileupload:maxfile'),
        minFileSize: elgg.echo('fileupload:minfile')
    };
    /**
     * Panel expand/collapse all function
     */
    $(document).on("click", ".panel-expand-all",function(){
        $(this).closest('.tab-pane, .panel-group').find(".panel-collapse").collapse('show');
    });
    $(document).on("click", ".panel-collapse-all",function(){
        $(this).closest('.tab-pane, .panel-group').find(".panel-collapse").collapse('hide');
    });
    /**
     * Collapse function
     */
    $(".fa.collapse").click(function(event) {
        event.preventDefault();
        var $obj = $(this);
        var element_parent = $(this).closest(".elgg-module-widget");
        $(element_parent).find(".elgg-body").toggle("fast", function(){
            // complete
            $obj.toggleClass("fa-plus fa-minus");
        });
    });
    /*
     * Navbar sticky
     */
    $('#navbar-sticky').waypoint('sticky',{
        stuckClass: 'navbar-fixed-top'
    });
    /*
     * Infinite scrolling in student events
     */
    $('ul.events').waypoint('infinite', {
        items: 'li.event',
        more: '.events-more-link',
        loadingClass: 'events-loading',
        onAfterPageLoad:function(){
            var $button = $('.events-more-link'),
                hrefString = $button.attr("href"),
                hrefArray  = hrefString.split("offset="),
                offset = hrefArray[1],
                totalEvents = $("ul.events > li.event").length;
            $button.attr("href", hrefString.replace("offset=" + offset, "offset=" + totalEvents));
            if(totalEvents > 10){
                $button
                    .css({
                        textTransform: 'uppercase'
                    })
                    .addClass('view-more-events show btn btn-primary btn-sm btn-border-blue')
                    .removeClass('events-more-link')
                    .on('click', function(e){
                        e.preventDefault();
                        var that = $(this),
                            href = that.attr('href');
                        that.css('backgroundColor','transparent');
                        var loading = $('<i/>')
                            .css({
                                position: 'absolute',
                                padding: '5px',
                                fontSize: '20px',
                                marginLeft: '10px',
                                zIndex: '2'
                            })
                            .addClass('loading fa fa-spinner fa-spin blue');
                        that.before(loading);
                        elgg.get(href, {
                            success: function(data){
                                $button.css('backgroundColor','white');
                                loading.remove();
                                $('ul.events').append($(data).html());
                                var hrefArray  = href.split("offset="),
                                    offset = hrefArray[1],
                                    totalEvents = $("ul.events > li.event").length;
                                that.attr("href", href.replace("offset=" + offset, "offset=" + totalEvents));
                                if($(data).find('.event').length == 0){
                                    $button.remove();
                                }
                            }
                        });
                    });
            }
        }
    });

    /**
     * Collapse in tree menu
     */
    var isSelected = $("#accordion").find("li.active");
    if(isSelected){
        isSelected.parent("ul").addClass("in").prev().find("a").css("opacity", 0.7);
    }

    /**
     * Toggle menu
     */
    $(".toggle-menu-link").click(function(event) {
        event.preventDefault();
        var id_menu = this.id;
        id_menu.replace("/[^a-z0-9\-]/i", "-");
        $("ul.elgg-menu-"+id_menu).toggle("fast");
    });


    /*
     * Labels complete view  & labels form to create
     */
    $("#labels_view").click(function(){
        $('#add_labels').toggle().find('input[type=text]').focus();
        $(this).children(".fa").toggleClass("fa-minus");
    });


    /**
     * Popover set default settings
     */
    $('[data-toggle="popover"][data-trigger="hover"]').popover({trigger: 'hover'});
    $('[data-toggle="popover"][data-trigger="click"]').popover({trigger: 'click'});
    $('body').on('click', function (e) {
        //did not click a popover toggle or popover
        if ($(e.target).data('toggle') !== 'popover'
            && $(e.target).parents('.popover.in').length === 0) {
            $('[data-toggle="popover"]').popover('hide');
            $('.popover').hide();
        }
    });
    $('[rel=popover]').popover({
        html : true,
        content: function() {
            var popover_content = $(this).closest(".tags").find('.popover_content_wrapper');
            return popover_content.html();
        }
    });
    /*
     * Format file size
     *
     */
    function formatFileSize(bytes) {
    if (typeof bytes !== 'number') {
        return '';
    }
        if (bytes >= 1000000000) {
            return (bytes / 1000000000).toFixed(2) + ' GB';
        }
        if (bytes >= 1000000) {
            return (bytes / 1000000).toFixed(2) + ' MB';
        }
        return (bytes / 1000).toFixed(2) + ' KB';
    }
    $.fn.bootstrapResponsiveTabs = function(options) {

        var settings = $.extend({
            // These are the defaults.
            minTabWidth: "80",
            maxTabWidth: "150"
        }, options );

        // Helper function to debounce window resize events
        var wait_for_repeating_events = (function () {
            var timers = {};
            return function (callback, timeout, timer_name) {
                if (!timer_name) {
                    timer_name = "default timer"; //all calls without a uniqueID are grouped as "default timer"
                }
                if (timers[timer_name]) {
                    clearTimeout(timers[timer_name]);
                }
                timers[timer_name] = setTimeout(callback, timeout);
            };
        })();

        // Helper function to sort tabs base on their original index positions
        var sort_tabs = function ($tabsContainer) {
            var $tabs = $tabsContainer.find(".js-tab");
            $tabs.sort(function(a,b){
                return +a.getAttribute('tab-index') - +b.getAttribute('tab-index');
            });
            $tabsContainer.detach(".js-tab").append($tabs);
        }


        // Main functions for each instantiated responsive tabs
        this.each(function() {

            $container = $(this);

            var ResponsiveTabs;
            ResponsiveTabs = (function () {
                function ResponsiveTabs() {

                    TABS_OBJECT = this;
                    TABS_OBJECT.activeTabId = 1;
                    TABS_OBJECT.tabsHorizontalContainer = $container;

                    TABS_OBJECT.tabsHorizontalContainer.addClass("responsive-tabs").wrap("<div class='responsive-tabs-container clearfix' role='tabpanel' aria-label='tabpanel'></div>");

                    // Update tabs
                    var update_tabs = function () {

                        var menuWidth = TABS_OBJECT.tabsHorizontalContainer.width();

                        // Determine which tabs to show/hide
                        var $tabs = TABS_OBJECT.tabsHorizontalContainer.children('li');
                        $tabs.width("100%");

                        var defaultTabWidth = $tabs.first().width();
                        var numTabs = $tabs.length;

                        var numVisibleHorizontalTabs = (Math.floor(menuWidth / defaultTabWidth))+1; // Offset by 1 to catch half cut-off tabs
                        var numVisibleVerticalTabs = numTabs - numVisibleHorizontalTabs;

                        for(var i = 0; i < $tabs.length; i++){
                            var horizontalTab = $tabs.eq(i);
                            var tabId = horizontalTab.attr("tab-id");
                            var verticalTab = TABS_OBJECT.tabsVerticalContainer.find(".js-tab[tab-id=" + tabId + "]");
                            var isVisible = i < numVisibleHorizontalTabs;

                            horizontalTab.toggleClass('hidden', !isVisible);
                            verticalTab.toggleClass('hidden', isVisible);
                        }

                        // Set new dynamic width for each tab based on calculation above
                        var tabWidth = 100 / numVisibleHorizontalTabs;
                        var tabPercent = tabWidth + "%";
                        $tabs.width(tabPercent);

                        // Toggle the Tabs dropdown if there are more tabs than can fit in the tabs horizontal container
                        var hasVerticalTabs = (numVisibleVerticalTabs > 0)
                        TABS_OBJECT.tabsVerticalContainer.toggleClass("hidden", !hasVerticalTabs)
                        TABS_OBJECT.tabsVerticalContainer.siblings(".dropdown-toggle").find(".count").text("Tabs " + "(" + numVisibleVerticalTabs + ")");

                        // Make 'active' tab always visible in horizontal container
                        // and hidden in vertical container

                        activeTab = TABS_OBJECT.tabsHorizontalContainer.find(".js-tab[tab-id=" + TABS_OBJECT.activeTabId + "]");
                        activeTabCurrentIndex = activeTab.index();
                        activeTabDefaultIndex = activeTab.attr("tab-index");
                        lastVisibleHorizontalTab = TABS_OBJECT.tabsHorizontalContainer.find(".js-tab:visible").last();
                        lastVisibleTabIndex = lastVisibleHorizontalTab.index()

                        lastHiddenVerticalTab = TABS_OBJECT.tabsVerticalContainer.find(".js-tab.hidden").last();
                        activeVerticalTab = TABS_OBJECT.tabsVerticalContainer.find(".js-tab[tab-index=" + activeTabCurrentIndex + "]");

                        if (activeTabCurrentIndex >= numVisibleHorizontalTabs) {
                            activeTab.insertBefore(lastVisibleHorizontalTab);
                            activeTab.removeClass("hidden");
                            lastVisibleHorizontalTab.addClass("hidden");

                            lastHiddenVerticalTab.removeClass("hidden");
                            activeVerticalTab.addClass("hidden");
                        }

                        if ((activeTabCurrentIndex < activeTabDefaultIndex) && (activeTabCurrentIndex < lastVisibleTabIndex)) {
                            activeTab.insertAfter(lastVisibleHorizontalTab);
                        }
                        if(TABS_OBJECT.tabsHorizontalContainer.find('.js-tab.hidden').length == 0){
                            TABS_OBJECT.tabsHorizontalContainer.siblings(".tabs-dropdown").hide();
                        } else{
                            TABS_OBJECT.tabsHorizontalContainer.siblings(".tabs-dropdown").show();
                        }
                    }

                    // SETUP
                    var setup = function () {
                        // Reset all tabs for calc function
                        var totalWidth = 0;
                        var $tabs      = TABS_OBJECT.tabsHorizontalContainer.children('li');

                        // Stop function if there are no tabs in container
                        if ($tabs.length === 0) {
                            return;
                        }

                        // Mark each tab with a 'tab-id' for easy access
                        $tabs.each(function(i) {
                            tabIndex = $(this).index();
                            $(this)
                                .addClass("js-tab")
                                .attr("tab-id", i+1)
                                .attr("tab-index", tabIndex)
                                .find('> a').addClass('text-truncate');
                        });

                        // Attach a dropdown to the right of the tabs bar
                        // This will be toggled if tabs can't fit in a given viewport size

                        TABS_OBJECT.tabsHorizontalContainer.after("<div class='nav navbar-nav navbar-right dropdown tabs-dropdown js-tabs-dropdown'> \
              <a href='#' class='dropdown-toggle' data-toggle='dropdown'><i class='fa fa-caret-down'></i></a> \
              <ul class='dropdown-menu' role='menu'> \
              </ul> \
            </div>");

                        // Clone each tab into the dropdown
                        TABS_OBJECT.tabsVerticalContainer = TABS_OBJECT.tabsHorizontalContainer.siblings(".tabs-dropdown").find(".dropdown-menu");
                        $tabs.clone().appendTo(TABS_OBJECT.tabsVerticalContainer);

                        // Add min and max width to horizontal tabs only
                        $tabs.each(function(i) {
                            $(this)
                                .css("min-width", settings.minTabWidth + "px")
                                .css("max-width", settings.maxTabWidth + "px");
                        });

                        // Update tabs
                        update_tabs();
                    }()


                    /**
                     * Change Tab
                     */
                    change_tab = function (e) {
                        TABS_OBJECT.tabsHorizontalContainer.parents(".responsive-tabs-container").on("click", ".js-tab", function(e) {

                            // Set 'activeTabId' property from clicked tab
                            var target = $(e.target);
                            TABS_OBJECT.activeTabId = $(this).attr("tab-id");

                            // Update tab 'active' class for horizontal container if tab is clicked
                            // from dropdown. Otherwise Bootstrap handles the normal 'active' class placement.
                            var verticalTabSelected = target.parents(".dropdown-menu").length > 0
                            if (verticalTabSelected) {
                                TABS_OBJECT.tabsHorizontalContainer.find(".js-tab").removeClass("active");
                                TABS_OBJECT.tabsHorizontalContainer.find(".js-tab[tab-id=" + TABS_OBJECT.activeTabId + "]").addClass("active");
                            }

                            TABS_OBJECT.tabsVerticalContainer.find(".js-tab").removeClass("active");

                            // Call 'sort_tabs' to re-arrange tabs based on their original index positions
                            // Call 'update_tabs' to resize tabs and determine which one to show/hide
                            sort_tabs(TABS_OBJECT.tabsHorizontalContainer);
                            sort_tabs(TABS_OBJECT.tabsVerticalContainer);
                            update_tabs();
                        });
                    }()

                    // Update tabs on window resize
                    $(window).resize(function() {
                        wait_for_repeating_events(function(){
                            update_tabs();
                        }, 300, "Resize Tabs");
                    });
                }

                return ResponsiveTabs();
            })();
        });
    };
    $('.nav.nav-tabs').bootstrapResponsiveTabs({
        minTabWidth: 200,
        maxTabWidth: 300
    });
});


