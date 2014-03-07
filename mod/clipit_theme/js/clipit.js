
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
            $obj.toggleClass("fa-chevron-up fa-chevron-down");
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
            $(".events-more-link").attr("href", hrefString.replace(offset, totalEvents));

        }
    });
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
     * Register form validation
     */
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
    $("form[data-validate=true]").each(function(){
        var form_to = $(this);
        $(this).validate({
            errorElement: "span",
            errorPlacement: function(error, element) {
                error.appendTo($("label[for="+element.attr('name')+"]"));
            },
            onkeyup: false,
            onblur: false,
            submitHandler: function(form) {
                var button_submit = form_to.find("input[type=submit]");
                button_submit.button(elgg.echo("loading"));
                if ($(form).valid())
                    form.submit();
                else
                    button_submit.button(elgg.echo("loading"));
            }
        });
    });
    /**
     * wysihtml5 editor default options
     */
    // Load wysi each textarea
    $('.wysihtml5').wysihtml5();

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
                    label: "Yes"
                },
                cancel: {
                    label: "No"
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
        if(!form.data("validate")){
            $(this).button(elgg.echo("loading"));
        }
    });
});
