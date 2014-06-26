<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/06/14
 * Last update:     24/06/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity_id = elgg_extract('entity_id', $vars);
$list = elgg_extract('list', $vars);
?>
<style>
.select-item{
    position: absolute;
    width: 100%;
    height: 100%;
    border: 1px solid #32b4e5;
    border-radius: 4px;
    z-index: 10;
    display: none;
    cursor: pointer;
}
.multimedia-block .selected{
    border: 3px solid #99cb00;
    display: block;
    opacity: 0.7;
}
.multimedia-block:hover .select-item{
    display: block;
}
</style>
<script>
$(function(){
    $("#attach_list .menu-list > li").click(function(){
        $("#attach_list .menu-list li").removeClass('selected');
        $(this).toggleClass('selected');
    });
    $(document).on("click", "#attach_list .attach-item", function(){
        $(this).toggleClass('selected');
        var type = $(this).closest('.multimedia-list > div').data("list");
        var count = $("#attach_list input[name='attach_"+ type +"[]']:checked").length;
        console.log(count);
        if($(this).hasClass('selected')){
            count++;
        } else {
            count--;
        }
        $("#"+type+"_count").text(count > 0 ? count : "");
    });
});
</script>
<div id="attach_list" style="display: none">
    <ul class="image-block menu-list">
        <li class="selected" data-menu="files">
            <h4>
            <span class="blue-lighter pull-right" id="files_count"></span>
            <?php echo elgg_view('output/url', array(
                'href'  => "javascript:;",
                'title' => elgg_echo('files'),
                'class' => 'element_attach_menu',
                'data-menu' => 'files',
                'text'  => elgg_echo('files')
            ));
            ?>
            </h4>
        </li>
        <li data-menu="videos">
            <h4>
                <span class="blue-lighter pull-right" id="videos_count"></span>
                <?php echo elgg_view('output/url', array(
                    'href'  => "javascript:;",
                    'title' => elgg_echo('videos'),
                    'class' => 'element_attach_menu',
                    'data-menu' => 'videos',
                    'text'  => elgg_echo('videos')
                ));
                ?>
            </h4>
        </li>
        <li data-menu="storyboards">
            <h4>
                <span class="blue-lighter pull-right" id="storyboards_count"></span>
                <?php echo elgg_view('output/url', array(
                    'href'  => "javascript:;",
                    'title' => elgg_echo('storyboards'),
                    'class' => 'element_attach_menu',
                    'data-menu' => 'storyboards',
                    'text'  => elgg_echo('storyboards')
                ));
                ?>
            </h4>
        </li>
    </ul>
    <div class="content-block" style="border-left: 1px solid #bae6f6;padding-left: 10px;">
        <div class="multimedia-list">
            <p id="attach-loading" style="display: none;"><span><i class="fa fa-spinner fa-spin"></i></span></p>
        </div>
    </div>
</div>