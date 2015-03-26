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
$multimedia = elgg_extract('multimedia', $vars);
$multimedia = array_filter($multimedia);
$button_value = elgg_extract('submit_value', $vars);
$tricky_topic_id = elgg_extract('tricky_topic', $vars);

$user_language = get_current_language();
$language_index = ClipitExampleType::get_language_index($user_language);
if($example) {
    $tags = ClipitTag::get_by_id($example->tag_array);
    echo elgg_view('input/hidden', array(
        'name' => 'entity-id',
        'value' => $example->id,
    ));

    $tricky_topic_id = $example->tricky_topic;
    if($example->tag_array){
        $tags_diff = array_diff(($example->tag_array), ClipitTrickyTopic::get_tags($example->tricky_topic));
    }
}
?>
<div class="margin-bottom-10" id="form-add-tricky-topic">
    <div class="col-md-7">
        <div class="form-group">
            <label for="title"><?php echo elgg_echo('name');?></label>
            <?php echo elgg_view("input/text", array(
                'name' => 'title',
                'class' => 'form-control',
                'required' => true,
                'value' => $example->name,
                'placeholder' => elgg_echo('title')
            ));
            ?>
        </div>
        <div class="form-group">
            <label><?php echo elgg_echo('description');?></label>
            <?php
            echo elgg_view('input/plaintext', array(
                'class' => 'form-control mceEditor',
                'value' => $example->description,
                'name' => 'description',
                'rows' => 9
            ));
            ?>
        </div>
        <div class="row">
            <div class="col-md-5">
                <label for="country"><?php echo elgg_echo('country');?></label>
                <?php echo elgg_view('page/components/countries',
                    array('style' => 'padding:5px;', 'value' => $example->country, 'required' => true));?>
            </div>
            <div class="col-md-7">
                <label for="location"><?php echo elgg_echo('location');?></label>
                <?php echo elgg_view('input/text', array(
                    'class' => 'form-control',
                    'name' => 'location',
                    'value' => $example->location,
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <?php echo elgg_view('examples/tricky_topics', array(
                'selected' => $tricky_topic_id,
                'tags' => $example->tag_array,
                'required' => false
            ));?>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="col-md-12 margin-top-20">
        <div class="form-group" style="background: #fafafa;padding: 10px;">
            <?php echo elgg_view('output/url', array(
                'href'  => "javascript:;",
                'onclick' => '$(this).parent(\'div\').find(\'.information_attach\').toggle()',
                'text'  => '<strong><i class="fa fa-image"></i> '.elgg_echo('material:attach').'</strong>',
            ));
            ?>
            <div class="information_attach margin-top-10" style="display: <?php echo !empty($multimedia) ? 'block': 'none'?>;">
<!--                <div class="form-group">-->
<!--                    --><?php //echo elgg_view("input/text", array(
//                        'name' => 'url[]',
//                        'class' => 'form-control',
//                        'placeholder' => elgg_echo('example:link_information'),
//                    ));
//                    ?>
<!--                </div>-->
                <div class="form-group">
<!--                    <label>--><?php //echo elgg_echo('resources');?><!--</label>-->
                    <div role="tabpanel">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs" role="tablist">
                            <li role="presentation" class="active">
                                <a href="#files" aria-controls="files" role="tab" data-toggle="tab">
                                    <?php echo elgg_echo('files');?> (<?php echo count($multimedia['files']);?>)
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#videos" aria-controls="videos" role="tab" data-toggle="tab">
                                    <?php echo elgg_echo('videos');?> (<?php echo count($multimedia['videos']);?>)
                                </a>
                            </li>
                            <li role="presentation">
                                <a href="#storyboards" aria-controls="storyboards" role="tab" data-toggle="tab">
                                    <?php echo elgg_echo('storyboards');?> (<?php echo count($multimedia['storyboards']);?>)
                                </a>
                            </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active form-group" id="files" style="background: #fff;padding: 10px;">
                                <div class="group-input margin-top-10">
                                    <div class="margin-bottom-20 clone-input">
                                        <a href="javascript:;" class="fa fa-trash-o red margin-right-10 remove-input" style="visibility: hidden;"></a>
                                        <?php echo elgg_view("input/file", array(
                                            'name' => 'file[]',
                                            'style' => 'display: inline-block;'
                                        ));
                                        ?>
                                        <i class="fa fa-check green correct" style="display: none;"></i>
                                    </div>
                                </div>
                                <div class="margin-left-20">
                                    <?php echo elgg_view('output/url', array(
                                        'href'  => "javascript:;",
                                        'class' => 'btn btn-sm btn-primary add-input',
                                        'title' => elgg_echo('add'),
                                        'text'  => '<i class="fa fa-plus"></i> ' . elgg_echo('add'),
                                    ));
                                    ?>
                                </div>
                                <?php if($files = $multimedia['files']): ?>
                                <hr>
                                <div class="margin-top-20">
                                    <?php
                                    $params = array(
                                        'files' => $files,
                                        'href' => $href,
                                        'view_comments' => false,
                                        'options' => true,
                                        'preview' => true
                                    );
                                    echo elgg_view('multimedia/file/list_summary', $params);
                                    ?>
                                </div>
                                <?php endif;?>
                            </div>
                            <div role="tabpanel" class="tab-pane form-group" id="videos" style="background: #fff;padding: 10px;">
                                <div class="group-input margin-top-10">
                                    <div class="margin-bottom-20 clone-input">
                                        <div id="panel_1" class="panel-group">
                                            <a href="javascript:;" class="fa fa-trash-o red margin-right-10 remove-input image-block"  style="visibility: hidden;"></a>
                                            <div class="content-block panel" style="box-shadow: none;">
                                            <div class="form-group margin-top-5">
                                                <?php echo elgg_view("input/text", array(
                                                    'name' => 'video_title[]',
                                                    'class' => 'form-control',
                                                    'placeholder' => elgg_echo('video:title'),
                                                    'required' => true
                                                ));
                                                ?>
                                            </div>
                                            <a data-parent="#panel_1" class="btn-sm btn btn-primary btn-border-blue margin-right-10" data-toggle="collapse" href="#collapse_1" aria-expanded="false">
                                                <?php echo elgg_echo('video:add:to_youtube');?>
                                            </a>
                                            <a data-parent="#panel_1" class="btn-sm btn btn-primary btn-border-blue margin-right-10" data-toggle="collapse" href="#collapse_2" aria-expanded="false">
                                                <?php echo elgg_echo('video:add:paste_url');?>
                                            </a>
                                            <div class="collapse margin-top-10" id="collapse_1" style="padding: 10px 0;">
                                                <?php echo elgg_view("input/file", array(
                                                    'name' => 'video[]',
                                                    'style' => 'display: inline-block;'
                                                ));
                                                ?>
                                                <i class="fa fa-check green correct" style="display: none;"></i>
                                            </div>
                                            <div class="collapse margin-top-10" id="collapse_2" style="padding: 10px 0;">
                                                <?php echo elgg_view("input/text", array(
                                                    'name' => 'video_url[]',
                                                    'class' => 'form-control',
                                                ));
                                                ?>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="margin-left-20">
                                    <?php echo elgg_view('output/url', array(
                                        'href'  => "javascript:;",
                                        'class' => 'btn btn-sm btn-primary add-input collapse-type',
                                        'title' => elgg_echo('add'),
                                        'text'  => '<i class="fa fa-plus"></i> ' . elgg_echo('add'),
                                    ));
                                    ?>
                                </div>
                                <?php if($videos = $multimedia['videos']): ?>
                                    <hr>
                                    <div class="margin-top-20">
                                        <?php
                                        $params = array(
                                            'videos' => $videos,
                                            'href' => $href,
                                            'view_comments' => false,
                                            'actions' => true,
                                            'preview' => true,
                                            'author_bottom' => true,
                                        );
                                        echo elgg_view('multimedia/video/list_summary', $params);
                                        ?>
                                    </div>
                                <?php endif;?>
                            </div>
                            <div role="tabpanel" class="tab-pane form-group" id="storyboards" style="background: #fff;padding: 10px;">
                                <div class="group-input margin-top-10">
                                    <div class="margin-bottom-20 clone-input">
                                        <a href="javascript:;" class="fa fa-trash-o red margin-right-10 remove-input"  style="visibility: hidden;"></a>
                                        <?php echo elgg_view("input/file", array(
                                            'name' => 'storyboard[]',
                                            'style' => 'display: inline-block;'
                                        ));
                                        ?>
                                        <i class="fa fa-check green correct" style="display: none;"></i>
                                    </div>
                                </div>
                                <div class="margin-left-20">
                                    <?php echo elgg_view('output/url', array(
                                        'href'  => "javascript:;",
                                        'class' => 'btn btn-sm btn-primary add-input',
                                        'title' => elgg_echo('add'),
                                        'text'  => '<i class="fa fa-plus"></i> ' . elgg_echo('add'),
                                    ));
                                    ?>
                                </div>
                                <?php if($storyboards = $multimedia['storyboards']): ?>
                                    <hr>
                                    <div class="margin-top-20">
                                        <?php
                                        $params = array(
                                            'entities' => $storyboards,
                                            'href' => $href,
                                            'view_comments' => false,
                                            'actions' => true,
                                            'preview' => true
                                        );
                                        echo elgg_view('multimedia/storyboard/list_summary', $params);
                                        ?>
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr/>
        <h4 class="margin-0"><?php echo elgg_echo('reflection_palette');?></h4>
        <span class="show margin-bottom-10 text-muted">
            <?php echo elgg_echo('reflection_palette:question');?>
        </span>
        <div role="tabpanel" class="margin-bottom-20">
            <div class="module-controls">
            <!-- Nav tabs -->
            <ul class="navs nav-tab tab-set " role="tablist">
                <?php
                $i = 1;
                foreach(ClipitExampleType::get_by_category(null, $user_language) as $category => $items):
                    $categories[$category] = $items;
                ?>
                    <li role="presentation" class=" <?php echo $i==1 ? 'active':'';?>">
                        <a
                            title="<?php echo $category;?>"
                            href="#<?php echo elgg_get_friendly_title($category);?>"
                            aria-controls="home" role="tab" data-toggle="tab">
                            <i class="fa fa-question-circle"
                               data-container="body" data-toggle="popover" data-trigger="hover"
                               data-placement="bottom" data-content="<?php echo $items[0]->category_description[$language_index];?>"></i>
                            <?php echo $category;?>
                        </a>
                    </li>
                <?php
                    $i++;
                endforeach;
                ?>
            </ul>
            </div>
            <!-- Tab panes -->
            <div class="tab-content">
                <?php
                $i = 1;
                foreach($categories as $category => $items):
                ?>
                <div role="tabpanel"
                     class="row tab-pane <?php echo $i==1 ? 'active':'';?>"
                     id="<?php echo elgg_get_friendly_title($category);?>"
                     style="padding: 10px;">

                    <div class="col-md-12">
                        <div class="margin-bottom-10 text-muted">
                            <?php echo elgg_echo('reflection_palette:tick');?>:
                        </div>
                        <?php
                        $z = 1;
                        foreach($items as $item):?>
                            <label id="<?php echo $z;?>">
                                <input type="checkbox"
                                       name="reflections[]"
                                       value="<?php echo $item->id;?>"
                                       <?php echo in_array($item->id, $example->example_type_array) ? 'checked': '';?>
                                       class="pull-left" style="margin-right: 5px;">
                                <div class="content-block cursor-pointer">
                                    <?php echo $item->item_name[$language_index]; ?>
                                    <div class="text-muted" style="font-weight: normal">
                                        <?php echo $item->item_description[$language_index]; ?>
                                    </div>
                                </div>
                            </label>
                        <?php
                        $z++;
                        endforeach;
                        ?>
                    </div>
                    <div class="col-md-7 hide">
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

            </div>

        </div>
        <div class="pull-right">
            <?php echo elgg_view('input/submit', array(
                'class' => 'btn btn-primary',
                'value'  => $button_value,
            ));
            ?>
        </div>
    </div>
</div>