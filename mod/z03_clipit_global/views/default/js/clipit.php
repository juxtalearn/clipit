elgg.provide('clipit');

/**
 * jQuery validator int messages
 */
jQuery.extend(jQuery.validator.messages, {
    required: "<?php echo elgg_echo('validation:required');?>",
    remote: "<?php echo elgg_echo('validation:remote');?>",
    email: "<?php echo elgg_echo('validation:email');?>",
    url: "<?php echo elgg_echo('validation:url');?>",
    date: "<?php echo elgg_echo('validation:date');?>",
    dateISO: "<?php echo elgg_echo('validation:dateISO');?>",
    number: "<?php echo elgg_echo('validation:number');?>",
    digits: "<?php echo elgg_echo('validation:digits');?>",
    creditcard: "<?php echo elgg_echo('validation:creditcard');?>",
    equalTo: "<?php echo elgg_echo('validation:equalTo');?>",
    accept: "<?php echo elgg_echo('validation:accept');?>",
    maxlength: jQuery.validator.format("<?php echo elgg_echo('validation:maxlength');?>"),
    minlength: jQuery.validator.format("<?php echo elgg_echo('validation:minlength');?>"),
    rangelength: jQuery.validator.format("<?php echo elgg_echo('validation:rangelength');?>"),
    range: jQuery.validator.format("<?php echo elgg_echo('validation:range');?>"),
    max: jQuery.validator.format("<?php echo elgg_echo('validation:max');?>"),
    min: jQuery.validator.format("<?php echo elgg_echo('validation:min');?>")
});

/**
 * TinyMce default configuration
 */
function tinymce_setup(specific_id){
    tinymce.init({
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
    },
    convert_urls: true,
    mode : "specific_textareas",
    editor_selector : /(mceEditor|wysihtml5|"+specific_id+")/,
    force_br_newlines : true,
    force_p_newlines : false,
    plugins: ["mention, autoresize, paste, autolink"],
    content_css : elgg.config.wwwroot+"mod/z03_clipit_global/vendors/tinymce/content.css",
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
    });
}

function get_tinymce_init(){
    return {
    script_url: elgg.config.wwwroot+"mod/z03_clipit_global/vendors/tinymce/tinymce.min.js",
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
    },
    convert_urls: true,
    mode : "specific_textareas",
    force_br_newlines : true,
    force_p_newlines : false,
    plugins: ["mention, autoresize, paste, autolink"],
    content_css : elgg.config.wwwroot+"mod/z03_clipit_global/vendors/tinymce/content.css",
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
    }
}
$(function(){
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
            var hrefString = $(".events-more-link").attr("href");
            var hrefArray  = hrefString.split("offset=");
            var offset = hrefArray[1];
            var totalEvents = $("ul.events > li.event").length;
            $(".events-more-link").attr("href", hrefString.replace("offset=" + offset, "offset=" + totalEvents));
        }
    });
    /**
     * Menu builder tracking
     * Right sidebar set active when href found register menu
     */
    var full_url = window.location.href;
    var urls_type = ['/view/', '?filter='];
    for(i in urls_type){
        var path = full_url.split(urls_type[i])
        var menu_item = $(".elgg-sidebar li a[href='"+ path[0] +"']");
        if(menu_item.length > 0){
            menu_item.parent("li").addClass("active");
        }
    }
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
    /**
    * Forgotpassword form validation
    */
    $(".elgg-form-user-requestnewpassword").validate({
        errorElement: "span",
        errorPlacement: function(error, element) {
        error.appendTo($("label[for="+element.attr('name')+"]"));
    },
        onkeyup: false,
        onblur: false,
        rules: {
        email: {
            remote: {
                url: "<?php echo elgg_get_site_url()?>action/user/check",
                    type: "POST",
                    data: {
                    email: function() {
                        return $( "input[name='email']" ).val();
                    },
                    __elgg_token: function() {
                        return $( "input[name='__elgg_token']" ).val();
                    },
                    __elgg_ts: function() {
                        return $( "input[name='__elgg_ts']" ).val();
                    }
                }
                }
        }
    },
        submitHandler: function(form) {
        if ($(form).valid()){
            $.post( ""+$(form).attr('action')+"", $(form).serialize(), function(){
                $(form).find("input[name=email]").prop("disabled",true);
                $(form).find("input[type=submit]")
                .after(
                    "<p class='text-info'>" +
                    "<img src='<?php echo elgg_get_site_url()?>mod/z03_clipit_global/graphics/ok.png'/>" +
                    " <strong><?php echo elgg_echo("user:forgotpassword:ok");?></strong></p>")
                        .remove();
                });
        }
    }
    });
    /**
     * Register form validation
     */
    $.validator.addMethod(
        "login_normalize",
        function(value, element) {
            var re = new RegExp(/^[a-zA-Z0-9_]*$/);
            re.test( element.value );
            return this.optional(element) || re.test(value);
        },
        "Use a valid username."
    );
    $(".elgg-form-register").validate({
        errorElement: "span",
        errorPlacement: function(error, element) {
            error.appendTo($("label[for="+element.attr('name')+"]"));
        },
        onkeyup: false,
        onblur: false,
        rules: {
            username: {
                required: true,
                minlength: 1,
                login_normalize: true,
                remote: {
                    url: elgg.config.wwwroot+"action/user/check",
                    type: "POST",
                    data: {
                        username: function() {
                            return $( "input[name='username']" ).val();
                        },
                        __elgg_token: function() {
                            return $( "input[name='__elgg_token']" ).val();
                        },
                        __elgg_ts: function() {
                            return $( "input[name='__elgg_ts']" ).val();
                        }
                    }
                }
            }
        },
        submitHandler: function(form) {
            if ($(form).valid())
                form.submit();
        }
    });
    /**
     * Form general validation
     */
    $("body").on("click", "form[data-validate=true]", function (e) {
        //$("form[data-validate=true]").each(function(){
        var form_to = $(this);
        $(this).validate({
            errorElement: "span",
            errorPlacement: function(error, element) {
                error.appendTo($("label[for='"+element.attr('name')+"']"));
            },
            //ignore: [], // DEBUG
            onkeyup: false,
            onblur: false,
            submitHandler: function(form) {
                var button_submit = form_to.find("input[type=submit]");
                button_submit.data("loading-text", "<?php echo elgg_echo('loading');?>...").button('loading');
                if ($(form).valid())
                    form.submit();
                else
                    button_submit.data("loading-text", "<?php echo elgg_echo('loading');?>...").button('loading');
            }
        });
    });
    /**
     * wysihtml5 editor default options
     */
        // Load wysi each textarea
    //$('.wysihtml5').wysihtml5();

    /**
     * Default confirm dialog to remove objects
     */
    $(".remove-object").click(function(e){
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
    });
    /**
     * Reply to user
     * check if form exists
     */
    $(".reply-to, .close-reply-to").click(function(){
        var reply_to_id = $(this).attr("id");
        var form_id = "#form-"+reply_to_id;
        var message = $(this).closest(".message");
        message.find("textarea").tinymce(get_tinymce_init());
        $(form_id).toggle("fast", function(){
            if($(form_id).is(':visible')){
                var offset = parseInt($(form_id).offset().top) - 50;
                $('html,body').animate({
                    scrollTop: offset}, 'slow');
            }
        });
    });
    /**
     * Button loading state
     * (input submit only)
     */

    $("body").on("click", "input[type=submit]", function(){
        // Check if form is validated
        var form = $(this).closest("form");
        var btn = $(this);
        if(!form.data("validate")){
            btn.data("loading-text", "<?php echo elgg_echo('loading');?>...").button('loading');
        }
    });
    if( $(".module-group_activity").length > 0) {
        elgg.get('ajax/view/dashboard/modules/activity_groups_status', {
            data: {
                entities: <?php echo json_encode(ClipitUser::get_activities(elgg_get_logged_in_user_guid()));?>
            },
            success: function (content) {
                $(".module-group_activity .elgg-body").html(content);
            }
        });
    }
    /**
     * jQuery send_msg function
     * Autocomplete user info
     * @param user    set default username value
     *
     */
    $.fn.extend({
        send_msg: function(username_data){
            if(!username_data){
                username_data = [];
            }
            $(this).tokenInput(elgg.config.wwwroot+"ajax/view/messages/search_to",
                {
                    hintText: "<?php echo elgg_echo("autocomplete:hint");?>",
                    noResultsText: "<?php echo elgg_echo("autocomplete:noresults");?>",
                    searchingText: "<?php echo elgg_echo("autocomplete:searching");?>",
                    zindex: 1052,
                    searchDelay: 0,
                    preventDuplicates: true,
                    animateDropdown: false,
                    propertyToSearch: "first_name",
                    prePopulate: username_data,
                    resultsFormatter: function(item){
                        var img = "<img class='img' src='" + item.avatar + "' title='" + item.first_name + "' height='25px' width='25px' />";
                        if(item.icon){
                            img = "<i class='img fa fa-"+ item.icon +"'></i>";
                        }
                        return "<li>" + img + "<div style='display: inline-block; padding-left: 10px;'><div class='title'>" + item.first_name + "</div><div class='sub-title'>" + item.username + "</div></div></li>" },
                    tokenFormatter: function(item) { return "<li>" + item.first_name + "</li>" }
                }
            );
        }
    });
    // default execute send_msg function
    $("input#compose").send_msg();

    /*
     * jQuery Shorten plugin
     *
     */
    (function($) {
        $.fn.shorten = function () {
            return this.each(function () {
                var element_shorten = $(this);
                var element_height = element_shorten.css("max-height");
                element_shorten.addClass("shorten");
                element_shorten.wrapInner("<div class='container-text'/>");
                var container = element_shorten.find('.container-text');
                var container_height = container.css("height");
                if(parseInt(container_height) < parseInt(element_height)){
                    return false;
                }
                var readmore_link = $("<a href='javascript:;' class='read-more'>Read more<strong>...</strong></a>");
                element_shorten.append(readmore_link);
                container.css("max-height",element_height);
                readmore_link.on("click", function(){
                    if (container.hasClass('full-content')) {
                        container.removeClass('full-content');
                        container.addClass('less-content');
                        $(this).text("Read more...");
                    } else {
                        container.addClass('full-content');
                        $(this).text("Less");
                    }
                });
            });
        }
    })(jQuery);
    ///
    $("[data-shorten=true]").shorten();
    /**
     * Tag-it for performance items
     *
     */
    $('ul#tags').each(function(){
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
                source: elgg.config.wwwroot+"ajax/view/publications/tags/search"
            },
            placeholderText: "<?php echo elgg_echo("tags:commas:separated");?>",
            singleField: true,
            singleFieldNode: that.closest("form").find("input[name=tags]")
        });
    });
    /**
     * Quote reference for discussion posts
     */
    $(document).on("click", ".quote-ref", function(){
        var quote_id = $(this).data("quote-ref");
        var parent = $(this).closest("div");
        var $obj = $(this);
        var quote_content = parent.find(".quote-content[data-quote-id="+quote_id+"]");

        if(quote_content.length == 0){
            $(this).addClass("active");
            $(this).after("<div class='quote-content' data-quote-id='"+quote_id+"'></div>");
            var quote_content = parent.find(".quote-content[data-quote-id="+quote_id+"]");
            quote_content.html("<a class='loading'><i class='fa fa-spinner fa-spin'></i> loading...</a>");
            var message_id = $(this).closest(".discussion-reply-msg").data("message-destination");
            elgg.get("ajax/view/discussion/quote", {
                data: { quote_id : quote_id, message_destination_id : message_id},
                success: function(data){
                quote_content.html(data);
            }
            });
        } else {
            parent.find(".quote-content[data-quote-id="+quote_id+"]").toggle(1,function(){
                $obj.toggleClass("active");
            });
        }
    });
    /*
     * Labels complete view  & labels form to create
     */
    $("#labels_view").click(function(){
        $('#add_labels').toggle().find('input[type=text]').focus();
        $(this).children(".fa").toggleClass("fa-minus");
        $('#label_list').toggleClass('text-truncate');
    });
    $('ul#labels').each(function(){
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
            placeholderText: "<?php echo elgg_echo("tags:commas:separated");?>",
            singleField: true,
            singleFieldNode: that.closest("form").find("input[name=labels]")
        });
    });
    ///
    tinymce_setup();
    /*
     * #int comment reference
     */
    $(".msg-quote").click(function (){
    var editor = tinyMCE.editors['mceEditor'];
    editor.execCommand('mceInsertContent', false, this.innerText+' ');
    var form = editor.formElement;

    $('html, body').animate({
        scrollTop: $(form).offset().top
        }, 50);
    });
    /**
     * Popover set default settings
     */
    $('body').on('click', function (e) {
        //did not click a popover toggle or popover
        if ($(e.target).data('toggle') !== 'popover'
            && $(e.target).parents('.popover.in').length === 0) {
            $('[data-toggle="popover"]').popover('hide');
        }
    });
    $('[rel=popover]').popover({
        html : true,
        content: function() {
        return $('#popover_content_wrapper').html();
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
});


