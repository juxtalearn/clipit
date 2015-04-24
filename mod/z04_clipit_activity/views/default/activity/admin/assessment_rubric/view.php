<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   06/10/2014
 * Last update:     06/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$languages_available = array('es', 'en', 'de', 'pt', 'sv');
$languages_available = array_combine($languages_available, $languages_available);
$languages_available = array_map('elgg_echo', $languages_available);
$current_language = get_current_language();
$performance_items = ClipitPerformanceItem::get_all(3);
?>
<small class="show margin-bottom-10">Cargar rúbrica existente</small>
<?php
echo elgg_view('input/dropdown', array(
    'name' => 'group-mode',
    'class' => 'form-control',
    'style' => 'width: auto;padding: 2px;',
    'value' => $activity->group_mode,
    'options_values' => array(
        ClipitActivity::GROUP_MODE_TEACHER => elgg_echo('activity:grouping_mode:teacher'),
        ClipitActivity::GROUP_MODE_STUDENT => elgg_echo('activity:grouping_mode:student'),
        ClipitActivity::GROUP_MODE_SYSTEM => elgg_echo('activity:grouping_mode:system'),
    )
));
?>
<hr>
<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <?php foreach($languages_available as $key => $language):?>
        <li role="presentation" class="<?php echo $current_language == $key ? 'active':'';?>">
            <a href="#<?php echo $key;?>" aria-controls="<?php echo $key;?>" role="tab" data-toggle="tab"><?php echo $language;?></a>
        </li>
    <?php endforeach;?>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <?php foreach($languages_available as $key => $language):?>
    <div role="tabpanel" class="tab-pane <?php echo $current_language == $key ? 'active':'';?>" id="<?php echo $key;?>">
        <ul class="margin-top-20">
            <?php
            $i = 0;
            $x = 0;
            $language = ClipitPerformanceItem::get_language_index($current_language);
            $categories = ClipitPerformanceItem::get_from_category(null, $current_language);
                foreach($categories as $category => $items):
            ?>
            <li class="list-item row margin-top-20">
                <div class="col-md-12">
                    <?php echo elgg_view("input/text", array(
                        'class' => 'form-control',
                        'placeholder' => elgg_echo('category'),
                        'value' => $category,
                    ));
                    ?>
                    <a data-toggle="collapse" href="#category_desc_<?php echo $i;?>" aria-expanded="false" class="show margin-top-10">
                        <strong>+ Descripción</strong>
                    </a>
                    <div class="collapse" id="category_desc_<?php echo $i;?>">
                        <?php echo elgg_view("input/plaintext", array(
                            'class' => 'form-control margin-top-20',
                            'placeholder' => elgg_echo('description'),
                            'style' => 'overflow-y: auto;resize: none;',
                            'rows' => 3,
                            'value' => $items[0]->item_description[$language],
                        ));
                        ?>
                    </div>
                    <hr>
                </div>
                <?php
                foreach($items as $item):?>
                <div class="col-md-6 margin-bottom-20">
                    <div class="col-md-12">
                        <?php echo elgg_view("input/text", array(
                            'class' => 'form-control rubric-textarea',
                            'placeholder' => elgg_echo('name'),
                            'value' => $item->item_name[$language],
                        ));
                        ?>
                        <a data-toggle="collapse" href="#item_desc_<?php echo $x;?>" aria-expanded="false" class="show margin-top-10">
                            <strong>+ Descripción</strong>
                        </a>
                        <div class="collapse" id="item_desc_<?php echo $x;?>">
                            <?php echo elgg_view("input/plaintext", array(
                                'class' => 'form-control margin-top-20',
                                'placeholder' => elgg_echo('description'),
                                'style' => 'overflow-y: auto;resize: none;',
                                'rows' => 3,
                                'value' => $item->item_description[$language],
                            ));
                            ?>
                        </div>
                    </div>
                </div>
                <?php $x++; endforeach;?>
            </li>
            <?php $i++; endforeach;?>
        </ul>
        <?php echo elgg_view('assessment_rubric/admin/view', array(
            'performance_items' => $performance_items,
            'language' => $key
        ));
        ?>
    </div>
    <?php endforeach;?>
</div>
<script>
    $(function(){
        // Autosize for textarea elements
        clipit.autosize($("textarea.rubric-textarea"));

        $('.add-rubric').click(function(e){
            var table = $(this).parent('.rubric-container').find('table'),
                rubric_clone = table.find('.rubric-edit:last').clone().appendTo(table);
            // clear all values from textarea and input text elements
            rubric_clone.find('textarea').val('');
            // set focus to first text element
            rubric_clone.find('textarea:first').focus();
        });
    });
</script>
<?php echo elgg_view('assessment_rubric/view');?>
