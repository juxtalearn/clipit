<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   29/01/2015
 * Last update:     29/01/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$example = elgg_extract('entity', $vars);
$multimedia = array_merge(
    $example->video_array,
    $example->file_array
);
?>
<div class="row">
    <div class="col-md-6">
        <strong>
            <?php echo elgg_view('output/url', array(
                'href'  => "tricky_topics/examples/view/{$example->id}",
                'target' => '_blank',
                'title' => $example->name,
                'text'  =>  $example->name,
            ));
            ?>
        </strong>
        <small>
            <div><?php echo $example->description;?></div>
        </small>
        <small>
        <?php if(!empty($example->example_type_array)):?>
            <?php echo elgg_view('output/url', array(
                'href'  => 'javascript:;',
                'class' => 'margin-right-15 btn-reflection',
                'title' => elgg_echo('reflection_palette'),
                'text'  =>  '<i class="fa fa-th-list"></i> '.elgg_echo('reflection_palette').' ('.count($example->example_type_array).')',
            ));
            ?>
        <?php endif;?>
            <?php echo elgg_view('output/url', array(
                'href'  => "tricky_topics/examples/view/{$example->id}#resources",
                'target' => '_blank',
                'title' => elgg_echo('activity:stas'),
                'text'  =>  '<i class="fa fa-image"></i> '.elgg_echo('activity:stas').' ('.count($multimedia).')',
            ));
            ?>
        </small>
    </div>
    <div class="row col-md-6">
        <div class="col-md-7 text-truncate">
            <small class="show"><?php echo elgg_echo('location');?></small>
            <?php echo elgg_view('output/url', array(
                'href'  => set_search_input('tricky_topics/examples', array('location'=>$example->location)),
                'title' => $example->location,
                'text'  => $example->location,
            ));
            ?>
        </div>
        <div class="col-md-5 text-truncate">
            <small class="show"><?php echo elgg_echo('country');?></small>
            <?php echo elgg_view('output/url', array(
                'href'  => set_search_input('tricky_topics/examples', array('country'=>$example->country)),
                'title' => get_countries_list($example->country),
                'text'  => get_countries_list($example->country),
            ));
            ?>
        </div>
    </div>
</div>
<?php if(!empty($example->example_type_array)):?>
    <?php echo elgg_view('examples/reflection_item/summary', array('entities' => $example->example_type_array));?>
<?php endif;?>