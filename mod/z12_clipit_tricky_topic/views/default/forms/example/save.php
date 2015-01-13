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
$button_value = elgg_extract('submit_value', $vars);
$user_language = get_current_language();
$language_index = ClipitReflectionItem::get_language_index($user_language);
if($example) {
    $tags = ClipitTag::get_by_id($example->tag_array);
    echo elgg_view('input/hidden', array(
        'name' => 'entity-id',
        'value' => $example->id,
    ));
}
?>
<div class="margin-bottom-10" id="form-add-tricky-topic">
    <div class="col-md-7">
        <div class="form-group">
            <label><?php echo elgg_echo('title');?></label>
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
                'class' => 'form-control',
                'value' => $example->description,
                'name' => 'description',
                'rows' => 9
            ));
            ?>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                <label><?php echo elgg_echo('country');?></label>
                <?php echo elgg_view('page/components/countries',
                    array('style' => 'padding:5px;', 'value' => $example->country));?>
            </div>
            <div class="col-md-6">
                <label><?php echo elgg_echo('location');?></label>
                <?php echo elgg_view('input/text', array(
                    'class' => 'form-control',
                    'name' => 'location',
                    'value' => $example->location,
                    'required' => true
                ));
                ?>
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
                'text'  => '<i class="fa fa-plus"></i> ' . elgg_echo('add'),
                'id'    => 'add-tag',
            ));
            ?>
        </div>
        <div class="form-group">
            <label><?php echo elgg_echo('example:subject');?></label>
            <?php echo elgg_view("input/text", array(
                'name' => 'subject',
                'value' => $example->subject,
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
        $(document).on("click", ".add-input", function(){
            var container = $(this).closest(".form-group").find(".group-input"),
                input_clone = container.find('.clone-input:last').clone();
            input_clone.find('input').val('');
            input_clone.find('.remove-input').show();

            if($(this).hasClass('collapse-type')){
                input_clone.find(".in").removeClass('in').addClass('collapse');
                $( input_clone.find('[data-toggle="collapse"]') ).each(function(){
                    var btn_collapse = $(this),
                        num = (btn_collapse.attr('href').replace('#collapse_', ''));
                    var container_collapse = input_clone.find('#collapse_'+ num);
                    container_collapse.attr('id', 'collapse_' + (num+1) );
                    btn_collapse.attr('href', '#collapse_' + (num+1) );
                });
                var num_panel = parseInt(input_clone.find('.panel-group').attr('id').replace('panel_', ''));
                input_clone.find('.panel-group').attr('id', 'panel_' + (num_panel+1) );
                input_clone.find('[data-toggle="collapse"]').attr('data-parent', '#panel_' + (num_panel+1) );
            }

            container.append(input_clone);
        });
        $(document).on("click", ".remove-input", function(){
            $(this).closest('.clone-input').remove();
        });
    });
    </script>
    <div class="col-md-12">
        <div class="form-group">
            <?php echo elgg_view('output/url', array(
                'href'  => "javascript:;",
                'onclick' => '$(this).parent(\'div\').find(\'.information_attach\').toggle()',
                'text'  => '<strong>+ '.elgg_echo('material:attach').'</strong>',
            ));
            ?>
            <div class="information_attach margin-top-10" style="display: none;">
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
                                        <a href="javascript:;" class="fa fa-times red margin-right-10 remove-input" style="display: none;"></a>
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
                                        'class' => 'btn btn-xs btn-primary add-input',
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
                                            <a href="javascript:;" class="fa fa-times red margin-right-10 remove-input image-block" style="display: none;"></a>
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
                                            <a data-parent="#panel_1" class="btn-xs btn btn-primary btn-border-blue margin-right-10" data-toggle="collapse" href="#collapse_1" aria-expanded="false">
                                                <?php echo elgg_echo('video:add:to_youtube');?>
                                            </a>
                                            <a data-parent="#panel_1" class="btn-xs btn btn-primary btn-border-blue margin-right-10" data-toggle="collapse" href="#collapse_2" aria-expanded="false">
                                                <?php echo elgg_echo('video:add:paste_url');?>
                                            </a>
                                            <div class="collapse margin-top-10" id="collapse_1" style="padding: 10px 0;">
                                                <?php echo elgg_view("input/file", array(
                                                    'name' => 'video[]',
                                                    'style' => 'display: inline-block;'
                                                ));
                                                ?>
                                            </div>
                                            <div class="collapse margin-top-10" id="collapse_2" style="padding: 10px 0;">
                                                <?php echo elgg_view("input/text", array(
                                                    'name' => 'video_url[]',
                                                    'class' => 'form-control',
                                                    'placeholder' => elgg_echo('example:link_information'),
                                                ));
                                                ?>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <?php echo elgg_view('output/url', array(
                                        'href'  => "javascript:;",
                                        'class' => 'btn btn-xs btn-primary add-input collapse-type',
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
                                        <a href="javascript:;" class="fa fa-times red margin-right-10 remove-input" style="display: none;"></a>
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
                                        'class' => 'btn btn-xs btn-primary add-input',
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
        <h4><?php echo elgg_echo('reflection_palette:question');?></h4>
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
                                <input type="checkbox"
                                       name="reflections[]"
                                       value="<?php echo $item->id;?>"
                                       <?php echo in_array($item->id, $example->reflection_item_array) ? 'checked': '';?>
                                       class="pull-left" style="margin-right: 5px;">
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