// <script>
elgg.provide('clipit.mobile');

var pantalla = document.documentElement.clientWidth;


clipit.mobile.init = function() {
    if (pantalla <=768) {
        clipit.shorten('.task-info .description', 100);
    }
}
elgg.register_hook_handler('init', 'system', clipit.mobile.init);
$(document).ready(mobileLoad);

$(window).on({
    orientationchange: function(e) {
        if(window.orientation==0){
            mobileLoad();
        }
        else{
            $('.modal-backdrop').hide();
                if($('body').hasClass('modal-open')){
                    $('body').removeClass('modal-open');
                }
            closeSidebar();
        }
        }
});
//window.addEventListener("orientationchange", function() {   // Announce the new orientation number
//    if(window.orientation==0){
//        mobileLoad();
//    }
//    else{
//        $('.modal-backdrop').hide();
//            if($('body').hasClass('modal-open')){
//                $('body').removeClass('modal-open');
//            }
//        closeSidebar();
//    }
//}, false);
$(document).ready(function(){
    if(window.screen.width <= 768){
        $('#responsive-mode').css({"display":"block"});
    }
});

function mobileLoad() {
    var pantalla = window.document.documentElement.clientWidth;
    if (pantalla <= 991) {
        var logoimagen = $('.navbar-brand');
        var espacioazul = $('.navbar-static-top');

        $('.nav a#explore').attr({'href': elgg.config.wwwroot + 'explore'})
        $('.nav a#activities').attr({'href': elgg.config.wwwroot + 'activities'}).removeAttr('data-toggle');
        $('.nav a#my_activities').attr({'href': elgg.config.wwwroot + 'activities'}).removeAttr('data-toggle');
        $('.nav a#authoring').attr({'href': elgg.config.wwwroot + 'tricky_topics'}).removeAttr('data-toggle');
        $('.nav a.inbox-summary').attr({'href': elgg.config.wwwroot + 'messages/inbox'}).removeAttr('data-toggle');

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
            $(".navbar-toggle").css({"display": "block"});
        }


        $(".navbar-toggle").click(function () {
            openSidebar();
        });

        $('.elgg-sidebar #close-sidebar').click(function () {
            closeSidebar();
        });
        $('.tags').each(function () {

            if(!$(this).parent('.popover-content'))
                $(this).find('a').css('maxWidth', '50%');
        });
        if ($('.groups-list').length > 0) {
            $('.groups-list .group-students').addClass('collapse');
        }


        $('#responsive-mode').click(function(){
            var mobile = $('#responsive-mode .responsive-mobile'),
                desktop = $('#responsive-mode .responsive-desktop');

            if($.cookie('desktop') == undefined){
                setCookie("desktop", 1, 30);
                mobile.show();
                desktop.hide();
                $('meta[name = "viewport"]').attr('content', 'width = 1200, initial-scale = 1');
            }
            else{
                $.cookie('desktop', null);
                desktop.show();
                mobile.hide();
                $('meta[name = "viewport"]').attr('content', 'width = device-width, initial-scale = 1');
            }

        });
    }
}
function closeSidebar() {
    $('.modal-backdrop').remove();
    $(".elgg-sidebar").animate({right: "-999px"}, 500, function () {
        $(this).hide();
    });
    $('.modal-backdrop').css({"display": "none"});
    $('body').removeClass('modal-open');
}

function openSidebar() {
    if($('body .modal-backdrop').length == 0){
        $('body').append('<div class="modal-backdrop fade in redimension"></div>');
        $('.modal-backdrop').css('background','#000');
        $(".elgg-sidebar").css({"display": "block"});
    }
    $(".elgg-sidebar").animate({right: "0"}, 500);
    $('.sticky-wrapper').css({"z-index": "1020"});
    $("body").addClass('modal-open');
    $('.modal-backdrop').click(function () {
        closeSidebar();
    });
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}



