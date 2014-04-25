<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract('entity', $vars);
?>
<script>
$(function(){
//    $("#wrap").on("click", "#add-url", function(){
    $("#wrap").on("keyup", "#link-url", function(){
        var form = $(this).closest("form");
        //var query = form.find("input[name=web-url]").val();
        var query = form.serialize();
        var regex = /^(http:\/\/www\.|https:\/\/www\.|http:\/\/|https:\/\/)[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
        if(!regex.test($(this).val()))
            return false;
        form.find(".loading").show();
        form.find("#group-hide").hide();
        form.find("#link-favicon").hide();
        $.getJSON(elgg.config.wwwroot+"action/multimedia/links/extract_data?"+query, function (data) {
            //call process to show the result
            if(data){
                form.find(".loading").hide();
                form.find("#link-favicon").show();
                form.find("#group-hide").show();
//                $("#link").find("img").attr("src", data.favicon)
//                $("#link").find("h4").text(data.title);
//                $("#link").find("p").text(data.description);
//                $("#link").find("a > em").text(data.url_min);
                form.find("#link-favicon").attr("src", data.favicon);
                form.find("#link-title").val(data.title);
                form.find("#link-description").val(data.description);
            }
        });
        return false;
    });
});
</script>

<?php echo elgg_view_form('multimedia/links/add', array('data-validate'=> "true" ), array('entity'  => $entity)); ?>
<div class="block" style="margin-bottom: 10px;">
    <button type="button" data-toggle="modal" data-target="#add-url" class="btn btn-default">Add url</button>
</div>
<div id="link" style="border-bottom: 1px solid #bae6f6;margin-bottom: 10px;padding-bottom: 10px;">
    <img src="http://www.google.com/s2/favicons?domain=http://chemberger.wordpress.com/" style="float:left; margin-right: 10px;">
    <div style="overflow: hidden;">
        <div style="margin-bottom: 5px;">
            <h4 style="margin: 0;font-weight: bold; color: #32b4e5;">Finding An Empirical Formula And Molecular Formula</h4>
            <small>
                <a><em>chemberger.wordpress.com</em></a>
                · <abbr title="11 March 2014 @ 1:20pm">yesterday</abbr>
            </small>
        </div>
        <p style="color: #797979;overflow: hidden">
            It is also called molarity, amount-of-substance concentration, amount concentration, substance concentration, or simply concentration. The volume V in the definition c_i = n_i/V refers to the volume of the solution, not the volume of the solvent.
        </p>
    </div>
</div>

<div style="border-bottom: 1px solid #bae6f6;margin-bottom: 10px;padding-bottom: 10px;">
    <img src="http://www.google.com/s2/favicons?domain=en.wikipedia.org" style="float:left; margin-right: 10px;">
    <div style="overflow: hidden;">
        <div style="margin-bottom: 5px;">
            <h4 style="margin: 0;font-weight: bold; color: #32b4e5;">Molar concentration</h4>
            <small>
                <a><em>en.wikipedia.org</em></a>
                · <abbr title="11 March 2014 @ 1:20pm">yesterday</abbr>
            </small>
        </div>
        <img src="http://wps.prenhall.com/wps/media/objects/1053/1078985/images/AACGKPJ0.jpg" style="float: left;margin-right: 10px;width: 100px;">
        <p style="color: #797979;overflow: hidden">
            It is also called molarity, amount-of-substance concentration, amount concentration, substance concentration, or simply concentration. The volume V in the definition c_i = n_i/V refers to the volume of the solution, not the volume of the solvent.
        </p>
    </div>
</div>
<div style="border-bottom: 1px solid #bae6f6;margin-bottom: 10px;padding-bottom: 10px;">
    <img src="http://www.google.com/s2/favicons?domain=http://chemberger.wordpress.com/" style="float:left; margin-right: 10px;">
    <div style="overflow: hidden;">
        <div style="margin-bottom: 5px;">
            <h4 style="margin: 0;font-weight: bold; color: #32b4e5;">Finding An Empirical Formula And Molecular Formula</h4>
            <small>
                <a><em>chemberger.wordpress.com</em></a>
                · <abbr title="11 March 2014 @ 1:20pm">yesterday</abbr>
            </small>
        </div>
        <p style="color: #797979;overflow: hidden">
            It is also called molarity, amount-of-substance concentration, amount concentration, substance concentration, or simply concentration. The volume V in the definition c_i = n_i/V refers to the volume of the solution, not the volume of the solvent.
        </p>
    </div>
</div>
<div style="border-bottom: 1px solid #bae6f6;margin-bottom: 10px;padding-bottom: 10px;">
    <img src="http://www.google.com/s2/favicons?domain=http://www.biology4kids.com/" style="float:left; margin-right: 10px;">
    <div style="overflow: hidden;">
        <div style="margin-bottom: 5px;">
            <h4 style="margin: 0;font-weight: bold; color: #32b4e5;">Cells are the Starting Point</h4>
            <small>
                <a><em>biology4kids.com</em></a>
                · <abbr title="11 March 2014 @ 1:20pm">yesterday</abbr>
            </small>
        </div>
        <img src="http://www.biology4kids.com/files/art/cell_over1.gif" style="float: left;margin-right: 10px;width: 100px;">
        <p style="color: #797979;overflow: hidden">
            All living organisms on Earth are divided in pieces called cells. There are smaller pieces to cells that include proteins and organelles. There are also larger pieces called tissues and systems.
        </p>
    </div>
</div>