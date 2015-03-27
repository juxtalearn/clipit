<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   27/03/2015
 * Last update:     27/03/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$items = elgg_extract('performance_items', $vars);
$language = elgg_extract('language', $vars);
$language = ClipitPerformanceItem::get_language_index($language);
?>
<style>
    table td textarea, table td{
        font-size: 13px;
    }
    table td{
        padding-bottom: 15px !important;
        padding-top: 15px !important;
    }
</style>
<div class="rubric-container">
    <div class="table-responsive-list">
        <table class="table margin-top-20">
            <tr class="active">
                <th class="col-md-2"></th>
                <th class="col-md-2">
                    <?php echo elgg_echo('rating:stars:1'); ?>
                    <div class="rating ratings readonly" data-score="1">
                        <?php echo star_rating_view(1); ?>
                    </div>
                </th>
                <th class="col-md-2">
                    <?php echo elgg_echo('rating:stars:5'); ?>
                    <div class="rating ratings readonly" data-score="2">
                        <?php echo star_rating_view(2); ?>
                    </div>
                </th>
                <th class="col-md-2">
                    <?php echo elgg_echo('rating:stars:3'); ?>
                    <div class="rating ratings readonly" data-score="3">
                        <?php echo star_rating_view(3); ?>
                    </div>
                </th>
                <th class="col-md-2">
                    <?php echo elgg_echo('rating:stars:4'); ?>
                    <div class="rating ratings readonly" data-score="4">
                        <?php echo star_rating_view(4); ?>
                    </div>
                </th>
                <th class="col-md-2">
                    <?php echo elgg_echo('rating:stars:5'); ?>
                    <div class="rating ratings readonly" data-score="5">
                        <?php echo star_rating_view(5); ?>
                    </div>
                </th>
            </tr>
            <?php foreach($items as $item):?>
            <tr class="rubric-edit">
                <td data-title="<?php echo elgg_echo('name'); ?>">
                    <?php echo elgg_view("input/plaintext", array(
                        'class' => 'form-control rubric-textarea',
                        'placeholder' => elgg_echo('name'),
                        'rows' => 1,
                        'value' => $item->item_name[$language],
                        'style' => 'min-height: 0.5em;resize: none;'
                    ));
                    ?>
                </td>
                <td data-title="<?php echo elgg_echo('rating:stars:1'); ?>">
                    <?php echo elgg_view("input/plaintext", array(
                        'class' => 'form-control rubric-textarea',
                        'rows' => 6,
                        'value' => $item->item_description[$language],
                        'style' => 'padding: 5px;font-size: 13px;'
                    ));
                    ?>
                </td>
                <td data-title="<?php echo elgg_echo('rating:stars:2'); ?>">
                    <?php echo elgg_view("input/plaintext", array(
                        'class' => 'form-control rubric-textarea',
                        'rows' => 6,
                        'value' => $item->item_description[$language],
                        'style' => 'padding: 5px;font-size: 13px;'
                    ));
                    ?>
                </td>
                <td data-title="<?php echo elgg_echo('rating:stars:3'); ?>">
                    <?php echo elgg_view("input/plaintext", array(
                        'class' => 'form-control rubric-textarea',
                        'rows' => 6,
                        'value' => $item->item_description[$language],
                        'style' => 'padding: 5px;font-size: 13px;'
                    ));
                    ?>
                </td>
                <td data-title="<?php echo elgg_echo('rating:stars:4'); ?>">
                    <?php echo elgg_view("input/plaintext", array(
                        'class' => 'form-control rubric-textarea',
                        'rows' => 6,
                        'value' => $item->item_description[$language],
                        'style' => 'padding: 5px;font-size: 13px;'
                    ));
                    ?>
                </td>
                <td data-title="<?php echo elgg_echo('rating:stars:5'); ?>">
                    <?php echo elgg_view("input/plaintext", array(
                        'class' => 'form-control rubric-textarea',
                        'rows' => 6,
                        'value' => $item->item_description[$language],
                        'style' => 'padding: 5px;font-size: 13px;'
                    ));
                    ?>
                </td>
            </tr>
            <?php endforeach;?>
        </table>
    </div>
    <?php echo elgg_view('output/url', array(
        'href' => "javascript:;",
        'class' => 'btn btn-xs btn-primary add-rubric',
        'text' => '<i class="fa fa-plus"></i> Añadir criterio',
    ));
    ?>
</div>
<style>
    textarea{
        overflow-y: hidden;
        min-height: 9em;
    }
</style>