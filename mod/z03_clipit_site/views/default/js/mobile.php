// <script>
$(document).ready(function() {

    var logoimagen = $('.navbar-brand');
    var espacioazul = $('.navbar-static-top');
    if (screen.width < 768) {

        espacioazul.append(logoimagen);
        logoimagen.find('img').css({
            "width": "90%",
            "height": "90%",
            "max-width": "150px",
            "position": "relative",
            "top": "8px"
        });
        $('.navbar-brand').addClass('col-xs-6');
        $('.navbar-blue .container').addClass('col-xs-6');
        espacioazul.find($('.container')).css({"max-width": "50%", "float": "right"});
        $('p.navbar-text').append('<i class="fa fa-search white"></i>');
        $('#activities').empty();
        $('#activities').append('<i class="fa fa-list-alt"></i>');
        $('.col-md-3 > .search-form').css({"top":"20","right":"-25px"});
        $('.top-account li:first a').remove();
        $('ul.top-account li:first').append('<a href="' + elgg.config.wwwroot + 'explore" title="Explorar" rel="nofollow" id="globo"><i class="fa fa-globe"></i></a>');
        var avatar_user = $('ul.top-account li a.avatar-user'),
            avatar_user_img = avatar_user.find('img');
        avatar_user.html(avatar_user_img);
        if (!$('.sticky-wrapper').find("img").hasClass('avatar-small')) {
            $('.sticky-wrapper').css({"display": "none"});
            $('.fa-search').css({"display": "none"});
        }
        $('.caret-down').remove();
        var hrefactivities = $('a.pull-right').attr("href");
        var empty = '';
        $('#activities').attr({'href': hrefactivities});
        $('#activities').attr({'data-toggle': empty});
        $('li > #authoring').remove();
        var hrefmensajes = elgg.get_site_url() + 'messages/inbox';
        $('.navbar-nav .message-options .fa-inbox').parent('a').attr("href", hrefmensajes);
        $('.navbar-nav').css({"margin": "7px 15px"});
        $('a.inbox-summary').attr({'href': hrefmensajes});
        $('a.inbox-summary').attr({'data-toggle': empty});


        var avatarcabecera=($('.navbar-nav .margin-right-10').html());
        $('.navbar-nav').prepend('<li>'+avatarcabecera+'</li><li class="separator">|</li>');
        $('.navbar-nav .margin-right-10').remove();

        var headercontent = $('#bs-navbar-collapse').html();
        $('#bs-navbar-collapse').remove();
        $('.navbar-header').append(headercontent);
        $('.col-sm-4:eq(1)').css({"float": "right"});
        $('.search-form').css({
            "visibility": "hidden",
            "position": "absolute",
            "z-index": "-1",
            "right": "15px",
            "width": "140px"
        });

        $(".fa-search").click(function () {
            if ($('.search-form').css("visibility") == "visible") {
                $('.search-form').css({"visibility": "hidden", "z-index": "-1"});
                $('.fa-times')[0].className = 'fa fa-search white';
            }
            else {
                $('.search-form').css({"visibility": "visible", "z-index": "10"});
                $('.fa-search')[1].className = 'fa fa-times white ';
            }
        });

        if ($('.elgg-sidebar').length != 0) {
            $(".navbar-toggle").css({"visibility": "visible"});
        }
        else {
            $(".navbar-toggle").css({"visibility": "hidden"});
        }


        var sideBar = $('.elgg-sidebar').html();
        $('.elgg-sidebar').remove();
        $('#navbar-sticky').append('<div class="elgg-sidebar"></div>');
        $('.elgg-sidebar').append(sideBar);

       var alto=( $(window).height())-12;
        $('.elgg-sidebar').css({
            "z-index": "1039", "position": "absolute", "bottom": "0px",
            "background-color": "#FFFFFF", "right": "-999px", "float": "right",
            "paddingBottom": "30px", "top": "-12px", "overflow-y": "scroll",
            "paddingTop": "10px", "width": "95%","height":alto
        });

        $('.navbar-blue').css({"z-index": "1039"})
        $('body').append('<div class="modal-backdrop fade in"></div>');
        $('.modal-backdrop').css({
            "display": "none", "opacity": "0.6", "z-index": "1029",
            "position": "fixed", "top": "0px", "bottom": "0px",
            "left": "0px", "right": "0px", "overflow": "hidden"
        });

        $('<i class="fa fa-times btn text-muted"></i>').prependTo(".elgg-sidebar");
        $('.elgg-sidebar > .fa-times').css({"left": "88%", "position": "relative"});
        $('.elgg-sidebar > .fa-times').click(function () {
            closeSidebar();});
        
        $(".navbar-toggle").click(function(){
                    openSidebar();});

        $('.modal-backdrop').click(function(){
                    closeSidebar();});
    function closeSidebar() {
        $(".elgg-sidebar").animate({right: "-999px"}, 500, function () {
            $(this).hide();
        });
        $('.modal-backdrop').css({"display": "none"});
        $("header").css({"position": ""});
        $("body").css({"overflow": ""});
    }

    function openSidebar() {
        $('.sticky-wrapper').css({"z-index": "1038"});
        $('.modal-backdrop').css({"display": "block"});
        $("header").css({"position": "relative"});
        $("body").css({"overflow": "hidden"});
        $(".elgg-sidebar").css({"display": "block"});
        $(".elgg-sidebar").animate({right: "0"},500);

    }

        $('ul.elgg-menu-filter.nav-tabs li').each(function(){
            var icon;
            switch(true){
                case $(this).hasClass('elgg-menu-item-files'):
                    icon = 'fa-file-text-o';
                    break;
                case $(this).hasClass('elgg-menu-item-videos'):
                    icon = 'fa-video-camera';
                    break;
                case $(this).hasClass('elgg-menu-item-storyboards'):
                    icon = 'fa-picture-o';
                    break;
                case $(this).hasClass('elgg-menu-item-enroll'):
                    icon = 'fa-clock-o';
                    break;
                case $(this).hasClass('elgg-menu-item-active'):
                    icon = 'fa-play';
                    break;
                case $(this).hasClass('elgg-menu-item-past'):
                    icon = 'fa-stop';
                    break;
            }
            if(icon)
                $(this).find('span').html($('<i/>').addClass( icon + ' fa margin-right-5'));
        });
    }//Fin del IF
});//Fin Function
