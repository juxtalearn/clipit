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
?>
<div class="row">
    <div class="col-md-6">
        <strong>
            <?php echo elgg_view('output/url', array(
                'href'  => "tricky_topics/examples/view/{$example->id}",
                'title' => $example->name,
                'text'  =>  $example->name,
            ));
            ?>
        </strong>
        <small>
            <div><?php echo $example->description;?></div>
        </small>
        <small>
            <?php echo elgg_view('output/url', array(
                'href'  => 'javascript:;',
                'class' => 'margin-right-15 btn-reflection',
                'title' => 'Reflection palette',
                'text'  =>  '<i class="fa fa-th-list"></i> Reflection palette',
            ));
            ?>
            <?php echo elgg_view('output/url', array(
                'href'  => 'javascript:;',
                'title' => 'Resources',
                'text'  =>  '<i class="fa fa-image"></i> Resources (10)',
            ));
            ?>
        </small>
    </div>
    <div class="row col-md-6">
        <div class="col-md-7 text-truncate">
            <small class="show"><?php echo elgg_echo('location');?></small>
            <?php echo elgg_view('output/url', array(
                'href'  => "tricky_topics/examples?location={$example->location}",
                'title' => $example->location,
                'text'  => $example->location,
            ));
            ?>
        </div>
        <div class="col-md-5 text-truncate">
            <small class="show"><?php echo elgg_echo('country');?></small>
            <?php echo elgg_view('output/url', array(
                'href'  => "tricky_topics/examples?country={$example->country}",
                'title' => get_countries_list($example->country),
                'text'  => get_countries_list($example->country),
            ));
            ?>
        </div>
    </div>
</div>
<?php echo elgg_view('examples/reflection_item/summary', array('entities' => $example->reflection_item_array));?>
<div style="
    background: #fff;
    padding: 5px;
    display: none;
" class="col-md-12 reflection-list"><div style="
    background: #f1f2f7;
    padding: 10px;
    margin-bottom: 5px;
">

        <div class="row">
            <div class="col-md-6"><a class="blue c" style="
    display: block;
          ">Flawed causal reasoning </a><a style="
    display: block;
">Key characteristic conveys group membership</a><a style="
    display: block;
">Weak human-like or world-like analogy</a></div><div class="col-md-6"> <strong class="show">Intuitive Beliefs</strong><div class="content-block"><small>Informal, intuitive ways of thinking about the world. Strongly biased toward causal explanations</small></div></div></div>



    </div>
    <div style="
    background: #f1f2f7;
    padding: 10px;
    margin-bottom: 5px;
">

        <div class="row">
            <div class="col-md-6"><a style="
    display: block;
          ">Essential Concepts</a></div><div class="col-md-6"> <strong class="show">Intuitive Beliefs</strong><div class="content-block"><small>Informal, intuitive ways of thinking about the world. Strongly biased toward causal explanations</small></div></div></div>



    </div>
    <div style="
    background: #f1f2f7;
    padding: 10px;
    margin-bottom: 5px;
">

        <div class="row">
            <div class="col-md-6"><a style="
    display: block;
          ">Underpinning understandings</a><a style="
    display: block;
">Understanding of Scientific method, process and practice</a></div><div class="col-md-6"> <strong class="show">Intuitive Beliefs</strong><div class="content-block"><small>Informal, intuitive ways of thinking about the world. Strongly biased toward causal explanations</small></div></div></div>



    </div></div>
