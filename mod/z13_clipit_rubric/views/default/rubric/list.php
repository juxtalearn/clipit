<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   27/11/2014
 * Last update:     27/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$rubrics = elgg_extract('entities', $vars);
$count = elgg_extract('count', $vars);

$options = true;
$select = false;
if($select = get_input('select')){
    $input_prefix = get_input('input_prefix');
    $rubrics = ClipitRubric::get_all();
    $options = false;
}
?>
<div class="margin-bottom-20">
    <div class="pull-right">
        <?php echo elgg_view("page/components/print_button");?>
    </div>
    <?php echo elgg_view('output/url', array(
        'href'  => 'rubrics/create',
        'class' => 'btn btn-primary',
        'target' => $select?'_blank':'',
        'title' => elgg_echo('new'),
        'text'  => elgg_echo('new'),
    ));
    ?>
    <?php if($select):?>
        <?php echo elgg_view('output/url', array(
            'href'  => 'javascript:;',
            'class' => 'btn rubric-refresh',
            'title' => elgg_echo('refresh'),
            'text'  => '<i class="fa fa-refresh"></i> '.elgg_echo('refresh'),
        ));
        ?>
        <label for="<?php echo $input_prefix;?>[rubric][id]"></label>
        <?php echo elgg_view('input/hidden', array(
            'name' => $input_prefix.'[rubric]',
            'class' => 'input-rubric-id',
            'required' => true,
            'data-msg-required' => elgg_echo('task:rubric:select:required')
        ));
        ?>
    <?php endif;?>
</div>
<script>
$(function(){
    $(document).on("click", ".show-items", function(){
        var tr = $(this).closest("tr")
            id = $(this).attr("id"),
            tr_rubric = $("[data-rubric="+id+"]");
        if(tr_rubric.length > 0){
            tr_rubric.toggle();
            return false;
        }
        var container =
            $("<tr/>").attr("data-rubric", id).html(
                $('<td/>').attr("colspan", 4)
                    .html('<i class="fa fa-spinner fa-spin fa-2x blue"/>')
                    .css({"padding": "10px", "overflowY": "auto", "overflowX": "hidden", "maxHeight": "450px"})
            );
        tr.after(container);
        elgg.get('ajax/view/rubric/items',{
            data: {
                'entity_id': id
            },
            success: function(content){
                container.find('td').html(content);
            }
        });
    });
});
</script>
<div class="table-responsive">
<table class="table table-striped" style="table-layout: fixed" role="presentation">
    <thead role="presentation">
        <tr role="presentation">
            <?php if($select):?>
                <th style="width: 120px;"></th>
            <?php endif;?>
            <th role="presentation"><?php echo elgg_echo('name');?></th>
            <th role="presentation"><?php echo elgg_echo('author');?>-<?php echo elgg_echo('date');?></th>
            <th role="presentation" style="width: 100px;"><?php echo elgg_echo('rubric:items');?></th>
            <?php if(!$select):?>
            <th role="presentation" style="width: 150px;"><?php echo elgg_echo('options');?></th>
            <?php endif;?>
        </tr>
    </thead>
    <?php
    foreach($rubrics as $rubric):
        if($rubric->cloned_from == 0):
            $owner_user = array_pop(ClipitUser::get_by_id(array($rubric->owner_id)));
    ?>
        <tr role="presentation" id="<?php echo $rubric->id;?>">
            <?php if($select):?>
            <td role="presentation">
                <a class="btn btn-xs btn-primary btn-border-blue rubric-select">
                    <?php echo elgg_echo('select');?>
                </a>
            </td>
            <?php endif;?>
            <td role="presentation">
                <strong>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "rubrics/view/{$rubric->id}",
                        'title' => $rubric->name,
                        'text'  => $rubric->name,
                    ));
                    ?>
                </strong>
            </td>
            <td role="presentation">
                <small>
                    <div>
                        <?php if($owner_user->id == elgg_get_logged_in_user_guid()):?>
                            <i class="fa-user fa blue"></i>
                        <?php endif;?>
                        <?php echo elgg_view('output/url', array(
                            'href'  => "profile/{$owner_user->login}",
                            'title' => $owner_user->name,
                            'text'  => $owner_user->name,
                        ));
                        ?>
                    </div>
                    <?php echo elgg_view('output/friendlytime', array('time' => $rubric->time_created));?>
                </small>
            </td>
            <td role="presentation" class="text-right">
                <?php echo elgg_view('output/url', array(
                    'href'  => 'javascript:;',
                    'class' => 'show-items btn btn-xs btn-border-blue',
                    'id' => $rubric->id,
                    'text'  => '<strong>'.count($rubric->rubric_item_array).'</strong>x<i class="margin-left-5 fa fa-list"></i>',
                ));
                ?>
            </td>
            <?php if(!$select):?>
            <td role="presentation" data-title="<?php echo elgg_echo('options');?>" class="hidden-xs hidden-sm">
                <?php echo elgg_view('page/components/admin_options', array(
                    'entity' => $rubric,
                    'user' => $owner_user
                ));?>
            </td>
            <?php endif;?>
        </tr>
        <?php endif;?>
    <?php endforeach;?>
</table>
</div>
<?php echo clipit_get_pagination(array('count' => $count, 'limit' => 10)); ?>