/*
 * Project Name:            ClipIt Theme
 * Project Description:     Theme for Elgg 1.8
 */

$(document).ready(function() {
    $(".elgg-button").addClass('btn').removeClass('elgg-button');
    //$(".elgg-button-submit").addClass('btn-success').removeClass("elgg-button-submit");
    $(".elgg-state-selected").addClass("active");
    $(".socia_login").click(function(e) {
        e.preventDefault();
        $("#sociaLogin").modal();
    });
    $(".socia_register").click(function(e) {
        e.preventDefault();
        $("#sociaRegister").modal();
    });
});