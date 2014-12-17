<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   01/12/2014
 * Last update:     01/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$example = elgg_extract('entity', $vars);
$user_language = get_current_language();
$language_index = ClipitReflectionItem::get_language_index($user_language);
?>
<div class="margin-bottom-10" id="form-add-tricky-topic">
    <div class="col-md-7">
        <div class="form-group">
            <label><?php echo elgg_echo('title');?></label>
            <?php echo elgg_view("input/text", array(
                'name' => 'title',
                'class' => 'form-control',
                'required' => true,
                'placeholder' => elgg_echo('title')
            ));
            ?>
        </div>
        <div class="form-group">
            <label><?php echo elgg_echo('description');?></label>
            <?php
            echo elgg_view('input/plaintext', array(
                'class' => 'form-control',
                'name' => 'description',
                'rows' => 9
            ));
            ?>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <label><?php echo elgg_echo('country');?></label>
                <?php echo elgg_view('page/components/countries',
                    array('style' => 'padding:5px;', 'value' => $tricky_topic->country));?>
            </div>
            <div class="col-md-6">
                <label><?php echo elgg_echo('location');?></label>
                <?php echo elgg_view('input/text', array(
                    'class' => 'form-control',
                    'name' => 'location',
                    'value' => $tricky_topic->location,
                    'required' => true
                ));
                ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo elgg_view('output/url', array(
                'href'  => "javascript:;",
                'onclick' => '$(this).parent(\'div\').find(\'.information_attach\').toggle()',
                'text'  => '<strong>+ Student problem information</strong>',
            ));
            ?>
            <div class="information_attach margin-top-10" style="display: none;">
                <div class="form-group">
                    <?php echo elgg_view("input/text", array(
                        'name' => 'url[]',
                        'class' => 'form-control',
                        'placeholder' => elgg_echo('example:link_information'),
                        'required' => true
                    ));
                    ?>
                </div>
                <div class="form-group">
                    <label><?php echo elgg_echo('resources');?></label>
                    <div role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#files" aria-controls="files" role="tab" data-toggle="tab">
                                    <?php echo elgg_echo('files');?>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#videos" aria-controls="videos" role="tab" data-toggle="tab">
                                    <?php echo elgg_echo('videos');?>
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#storyboards" aria-controls="storyboards" role="tab" data-toggle="tab">
                                    <?php echo elgg_echo('storyboards');?>
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="files" style="background: #fff;padding: 10px;">
                                <div class="margin-bottom-20">
                                    <div>
                                        <a class="fa fa-times red margin-right-10"></a>
                                        <?php echo elgg_view("input/file", array(
                                            'name' => 'file[]',
                                            'style' => 'display: inline-block;'
                                        ));
                                        ?>
                                    </div>
                                </div>
                                <div>
                                    <?php echo elgg_view('output/url', array(
                                        'href'  => "javascript:;",
                                        'class' => 'btn btn-xs btn-primary',
                                        'title' => elgg_echo('add'),
                                        'text'  => '<i class="fa fa-plus"></i>' . elgg_echo('add'),
                                        'id'    => 'add-tag'
                                    ));
                                    ?>
                                </div>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="videos" style="background: #fff;padding: 10px;">

                            </div>
                            <div role="tabpanel" class="tab-pane" id="storyboards" style="background: #fff;padding: 10px;">
                                <div class="margin-bottom-20">
                                    <div>
                                        <a class="fa fa-times red margin-right-10"></a>
                                        <?php echo elgg_view("input/file", array(
                                            'name' => 'storyboard[]',
                                            'style' => 'display: inline-block;'
                                        ));
                                        ?>
                                    </div>
                                </div>
                                <div>
                                    <?php echo elgg_view('output/url', array(
                                        'href'  => "javascript:;",
                                        'class' => 'btn btn-xs btn-primary',
                                        'title' => elgg_echo('add'),
                                        'text'  => '<i class="fa fa-plus"></i>' . elgg_echo('add'),
                                        'id'    => 'add-tag'
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label>
                <?php echo elgg_echo('tags');?>
            </label>
            <div class="form-add-tags form-group margin-top-10">
                <?php if($tags):?>
                    <?php foreach($tags as $tag):?>
                        <?php echo elgg_view("tricky_topic/add", array('value' => $tag->name));?>
                    <?php endforeach;?>
                <?php else: ?>
                    <?php echo elgg_view("tricky_topic/add");?>
                <?php endif;?>
            </div>
            <?php echo elgg_view('output/url', array(
                'href'  => "javascript:;",
                'class' => 'btn btn-xs btn-primary',
                'title' => elgg_echo('add'),
                'text'  => '<i class="fa fa-plus"></i>' . elgg_echo('add'),
                'id'    => 'add-tag',
            ));
            ?>
        </div>
        <div class="form-group">
            <label><?php echo elgg_echo('example:subject');?></label>
            <?php echo elgg_view("input/text", array(
                'name' => 'subject',
                'class' => 'form-control',
                'required' => true
            ));
            ?>
        </div>
        <div class="form-group">
            <label><?php echo elgg_echo('example:education_level');?></label>
            <?php
                $ed_levels = array();
                for($i = 1; $i <= 4; $i++){
                    $ed_levels[" ".elgg_echo('example:education_level:'.$i)] = $i;
                }
                echo elgg_view('input/radio', array(
                    'name' => "education-level",
                    'value' => $example ? $example->education_level : 'false',
                    'options' => $ed_levels,
                ));
            ?>
        </div>
    </div>
    <style>
        .reflection-item label{
            position: relative;
            margin-bottom: 0;
        }
        .reflection-item label:hover:after{
            content: "\f061";
            font: normal normal normal 14px/1 FontAwesome;
            position: absolute;
            color: #bae6f6;
            top: 5px;
            right: -12px;
        }
    </style>
    <script>
    $(function(){
        $(".reflection-item label").hover(function(){
            var container = $(this).closest(".reflection-item");
            container.find(".reflect-description").hide();
            container.find("[data-reflect_item="+$(this).attr("id")+"]").show();
        },function(){
            var container = $(this).closest(".reflection-item");
            container.find(".reflect-description").hide();
            container.find(".reflect-description:first").show();
        });
    });
    </script>
    <div class="col-md-12">
        <hr/>
        <h4>Reflection palette: Why do students have this problem? Select all that apply.</h4>
        <div role="tabpanel" class="margin-bottom-20">

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <?php
                $i = 1;
                foreach(ClipitReflectionItem::get_by_category(null, $user_language) as $category => $items):
                    $categories[$category] = $items;
                ?>
                    <li role="presentation" class="<?php echo $i==1 ? 'active':'';?>">
                        <a href="#<?php echo elgg_get_friendly_title($category);?>" aria-controls="home" role="tab" data-toggle="tab">
                            <?php echo $category;?>
                        </a>
                    </li>
                <?php
                    $i++;
                endforeach;
                ?>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <?php
                $i = 1;
                foreach($categories as $category => $items):
                ?>
                <div role="tabpanel"
                     class="reflection-item tab-pane row tab-pane <?php echo $i==1 ? 'active':'';?>"
                     id="<?php echo elgg_get_friendly_title($category);?>"
                     style="padding: 10px;">

                    <div class="col-md-5">
                        <div class="margin-bottom-10">Please tick all that apply:</div>
                        <?php
                        $z = 1;
                        foreach($items as $item):?>
                            <label id="<?php echo $z;?>">
                                <input type="checkbox" class="pull-left" style="margin-right: 5px;">
                                <div class="content-block">
                                    <?php echo $item->item_name[$language_index]; ?>
                                </div>
                            </label>
                        <?php
                        $z++;
                        endforeach;
                        ?>
                    </div>
                    <div class="col-md-7">
                        <div class="reflect-description" style="padding: 10px;margin: 0px 0px 10px;">
                            <strong><?php echo $category;?></strong>
                            <p>
                               <?php echo $items[0]->category_description[$language_index];?>
                            </p>
                        </div>
                        <?php
                        $x=1;
                        foreach($items as $item):?>
                            <div class="reflect-description bg-info" style="display: none" data-reflect_item="<?php echo $x;?>">
                                <?php echo $item->item_description[$language_index]; ?>
                            </div>
                        <?php
                            $x++;
                        endforeach;
                        ?>
                    </div>
                </div>
                    <?php
                    $i++;
                endforeach;
                ?>
                <div role="tabpanel" class="reflection-item tab-pane row" id="terminologys" style="padding: 10px;">
                    <div class="col-md-5">
                        <div class="margin-bottom-10">Please tick all that apply:</div>
                        <label id="1">
                            <input type="checkbox"> One term refers to multiple concepts
                        </label>
                        <label id="2">
                            <input type="checkbox"> One concept has many scientific names
                        </label>
                        <label id="3">
                            <input type="checkbox"> Scientific use of everyday language
                        </label>
                    </div>
                    <div class="col-md-7">
                        <div class="reflect-description" style="padding: 10px;margin: 0px 0px 10px;">
                            <strong>Terminology</strong>
                            <p>
                                Problems with use of language and scientific terms, inconsistent and overlapping terminology.
                            </p>
                        </div>
                        <div class="reflect-description bg-info" style="display: none" data-reflect_item="1">
                            1_TEST_Different terms are used to refer to the same concept.
                            e.g. voltage is also referred to as potential difference.
                            Confusion between voltage and charge.
                        </div>
                        <div class="reflect-description bg-info" style="display: none" data-reflect_item="2">
                            2_TEST_Different terms are used to refer to the same concept.
                            e.g. voltage is also referred to as potential difference.
                            Confusion between voltage and charge.
                        </div>
                        <div class="reflect-description bg-info" style="display: none" data-reflect_item="3">
                            3_TEST_Different terms are used to refer to the same concept.
                            e.g. voltage is also referred to as potential difference.
                            Confusion between voltage and charge.
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="essential-concepts">...</div>
                <div role="tabpanel" class="tab-pane" id="essential-concepts">...</div>
            </div>

        </div>
        <div class="pull-right">
            <?php echo elgg_view('input/submit', array(
                'class' => 'btn btn-primary',
                'value'  => elgg_echo('create'),
            ));
            ?>
        </div>
    </div>
</div>