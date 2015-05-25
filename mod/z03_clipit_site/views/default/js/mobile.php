// <script>
elgg.provide('clipit.mobile');
clipit.mobile.init = function() {
    if (document.documentElement.clientWidth <=768 ) {
        clipit.shorten('.task-info .description', 100);
    }
}
elgg.register_hook_handler('init', 'system', clipit.mobile.init);
$(document).ready(mobileLoad);
window.addEventListener("orientationchange", function() {
    // Announce the new orientation number
    if(window.orientation==0){
        mobileLoad();
    }
}, false);

function mobileLoad() {
    if (document.documentElement.clientWidth <= 768) {
        var logoimagen = $('.navbar-brand');
        var espacioazul = $('.navbar-static-top');

        $('.nav a#explore').attr({'href': elgg.config.wwwroot + 'explore'})
        $('.nav a#activities').attr({'href': elgg.config.wwwroot + 'activities'}).removeAttr('data-toggle');
        $('.nav a#authoring').attr({'href': elgg.config.wwwroot + 'tricky_topics'}).removeAttr('data-toggle');
        $('.nav a.inbox-summary').attr({'href': elgg.config.wwwroot + 'messages/inbox'}).removeAttr('data-toggle');
//        $('li > #authoring').remove();
        //#3 collapse
        $(".navbar-blue .fa-search").click(function () {
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




        var alto = ( $(window).height());
        var top = (($(".navbar-default").height()) * 0.8);

        $(".navbar-toggle").click(function () {
            openSidebar();
        });

        $('.elgg-sidebar #close-sidebar').click(function () {
            closeSidebar();
        });
        function closeSidebar() {
            $('.modal-backdrop').remove();
            $(".elgg-sidebar").animate({right: "-999px"}, 500, function () {
                $(this).hide();
            });
            $('.modal-backdrop').css({"display": "none"});
            $('body').removeClass('modal-open');
        }

        function openSidebar() {
            $('body').append('<div class="modal-backdrop fade in"></div>');
            $(".elgg-sidebar").animate({right: "0"}, 500);
            $('.sticky-wrapper').css({"z-index": "1020"});
            $('.modal-backdrop').css({"display": "block"});
            $("body").addClass('modal-open');
            $(".elgg-sidebar").css({"display": "block"});
            $('.modal-backdrop').click(function () {
                closeSidebar();
            });
            if ($('.navbar-default').hasClass('navbar-fixed-top')) {
                $('.elgg-sidebar').css({"height": alto, "margin-top": "0px"});
            }
            else {
                $('.elgg-sidebar').css({"height": (alto - (top))});
            }

        }

        $('ul.elgg-menu-filter.nav-tabs li').each(function () {
            var icon;
            switch (true) {
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
            if (icon)
                $(this).find('span').html($('<i/>').addClass(icon + ' fa margin-right-5'));
        });
        $('.tags').each(function () {
            $(this).find('a').css('maxWidth', '50%');
            $(this).find('a:gt(1)').hide();
        });
        if ($('.groups-list').length > 0) {
            $('.groups-list .group-students').addClass('collapse');
        }

    }//Fin del IF

}