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
$tricky_topics = ClipitTrickyTopic::get_all();
$owner_tt = array();
foreach($tricky_topics as $tricky_topic){
    $tt[$tricky_topic->id] = $tricky_topic->name;
    if($tricky_topic->owner_id == elgg_get_logged_in_user_guid()){
        $owner_tt[$tricky_topic->id] = $tricky_topic->name;
    }
}
$tt = array_diff($tt, $owner_tt);
?>
<script>
    $(function(){
        $(".chosen-select").chosen({disable_search_threshold: 1});
    });
</script>
<div class="row margin-bottom-10" id="form-add-tricky-topic" style="background: #fafafa;padding: 10px;">
    <div class="form-group col-md-12 margin-top-10">
        <?php echo elgg_view("input/text", array(
            'name' => 'title',
            'class' => 'form-control',
            'required' => true,
            'placeholder' => elgg_echo('title')
        ));
        ?>
    </div>
    <div class="col-md-7">
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
        <div class="form-group">
            <label><?php echo elgg_echo('tags');?></label>
            <select name="tags[]" data-placeholder="<?php echo elgg_echo('click_add');?>" style="width:100%;" multiple class="chosen-select" tabindex="8">
                <option value=""></option>
                <?php foreach(ClipitTag::get_all() as $tag):?>
                    <option value="<?php echo $tag->id;?>"><?php echo $tag->name;?></option>
                <?php endforeach;?>
            </select>
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
                <label><?php echo elgg_echo('attach');?></label>
                <?php echo elgg_view("input/file", array(
                    'name' => 'file[]',
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label><?php echo elgg_echo('tricky_topics');?></label>
            <select required="required" id="tricky-topic" class="form-control" name="tricky-topic" style="padding-top: 5px;padding-bottom: 5px;">
                <option value="<?php echo $value;?>">
                    <?php echo elgg_echo('tricky_topic:select');?>
                </option>
                <?php if(count($owner_tt)>0):?>
                    <optgroup label="<?php echo elgg_echo('tricky_topic:created_by_me');?>">
                        <?php foreach($owner_tt as $value => $name):?>
                            <option value="<?php echo $value;?>">
                                <?php echo $name;?>
                            </option>
                        <?php endforeach;?>
                    </optgroup>
                <?php endif;?>
                <?php if(count($tt)>0):?>
                    <optgroup label="<?php echo elgg_echo('tricky_topic:created_by_others');?>">
                        <?php foreach($tt as $value => $name):?>
                            <option value="<?php echo $value;?>">
                                <?php echo $name;?>
                            </option>
                        <?php endforeach;?>
                    </optgroup>
                <?php endif;?>
            </select>
        </div>
        <hr class="margin-0" />
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
            <?php echo elgg_view("input/text", array(
                'name' => 'education-level',
                'class' => 'form-control',
                'required' => true
            ));
            ?>
        </div>
        <div class="form-group">
            <label><?php echo elgg_echo('example:location');?></label>
            <?php echo elgg_view("input/text", array(
                'name' => 'location',
                'class' => 'form-control',
                'placeholder' => 'Example University, Country'
            ));
            ?>
        </div>
    </div>
    <div class="col-md-12">
        <div class="pull-right">
            <?php echo elgg_view('output/url', array(
                'href'  => "javascript:;",
                'class' => 'btn btn-border-blue btn-primary margin-right-10',
                'title' => elgg_echo('cancel'),
                'text'  => elgg_echo('cancel'),
                'onclick' => '$(\'#add-tricky-topic\').click()',
            ));
            ?>
            <?php echo elgg_view('input/submit', array(
                'class' => 'btn btn-primary',
                'value'  => elgg_echo('create'),
            ));
            ?>
        </div>
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