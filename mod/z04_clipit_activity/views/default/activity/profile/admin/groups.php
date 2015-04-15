<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   8/09/14
 * Last update:     8/09/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$groups = elgg_extract('entities', $vars);
?>
<script>
    $(function(){
        $(document).on("click", "#panel-expand-all",function(){
            $(".expand").parent(".panel").find(".panel-collapse").collapse('show');
            $(".group-info").click();
        });
        $(document).on("click", "#panel-collapse-all",function(){
            $(".expand").parent(".panel").find(".panel-collapse").collapse('hide');
        });
        $(document).on("click", ".group-info",function(){
            var content = $(this).parent(".panel").find(".group-content");
            var gr_id = $(this).data("group");
            if(content.is(':empty')){
                content.html('<i class="fa fa-spinner fa-spin fa-2x blue"></i>');
                elgg.get( "ajax/view/activity/admin/groups/info",{
                    data: {
                        'entity': gr_id
                    },
                    success: function( data ) {
                        content.html(data);
                    }
                });
            }
        });
        var container = $('.groups-admin .group');
        elgg.get("ajax/view/activity/admin/groups/info", {
            dataType: "json",
            data: {
                'entities': <?php echo json_encode($groups);?>
            },
            success: function (output) {
                $.each(output, function (group, data) {
                    container.find('[data-group="'+group+'"] .progressbar-mini div').css('width', data + '%')
                    container.find('[data-group="'+group+'"] .progress-count').text(data + '%');
                });
            }
        });
    });
</script>
<div class="groups-admin">
<?php
$groups = ClipitGroup::get_by_id($groups, 0, 0, 'name');
natural_sort_properties($groups, 'name');
if($groups):
?>
    <p>
        <?php echo elgg_view('output/url', array(
            'title' => elgg_echo('expand:all'),
            'text' => elgg_echo('expand:all'),
            'href' => "javascript:;",
            'id' => 'panel-expand-all',
        ));
        ?>
        <span class="text-muted">|</span>
        <?php echo elgg_view('output/url', array(
            'title' => elgg_echo('collapse:all'),
            'text' => elgg_echo('collapse:all'),
            'href' => "javascript:;",
            'id' => 'panel-collapse-all',
        ));
        ?>
    </p>
    <div class="panel-group" id="gr_accordion">
        <?php foreach($groups as $group):?>
            <div class="panel panel-blue group">
                <div class="panel-heading expand group-info" data-group="<?php echo $group->id;?>">
                    <small class="pull-right">
                        <div class="progressbar-mini progressbar-blue inline-block">
                            <div data-value=""></div>
                        </div>
                        <strong class="inline-block blue margin-left-5 progress-count">
                            <i class="fa fa-spinner fa-spin"></i>
                        </strong>
                    </small>
                    <h4 class="margin-0">
                        <a data-toggle="collapse" class="show" data-parent="#gr_accordion" href="#gr_<?php echo $group->id;?>">
                            <strong><?php echo $group->name;?></strong>
                        </a>
                    </h4>
                </div>
                <div id="gr_<?php echo $group->id;?>" class="panel-collapse collapse">
                    <div class="panel-body group-content"></div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
<?php else:?>
    <?php echo elgg_view('output/empty', array('value' => elgg_echo('groups:none')));?>
<?php endif;?>
</div>