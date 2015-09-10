<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   18/12/2014
 * Last update:     18/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$selected = elgg_extract('selected', $vars);
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
<div id="select-tricky-topic">
    <div class="form-group">
        <label for="tricky-topic"><?php echo elgg_echo("activity:select:tricky_topic");?></label>
        <select required="required" id="tricky-topic" class="form-control" name="tricky-topic" style="padding-top: 5px;padding-bottom: 5px;">
            <option value="">
                <?php echo elgg_echo('tricky_topic:select');?>
            </option>
            <?php if(count($owner_tt)>0):?>
                <optgroup label="<?php echo elgg_echo('tricky_topic:created_by_me');?>">
                    <?php foreach($owner_tt as $value => $name):?>
                        <option <?php echo $selected == $value ? 'selected' : '';?> value="<?php echo $value;?>">
                            <?php echo $name;?>
                        </option>
                    <?php endforeach;?>
                </optgroup>
            <?php endif;?>
            <?php if(count($tt)>0):?>
                <optgroup label="<?php echo elgg_echo('tricky_topic:created_by_others');?>">
                    <?php foreach($tt as $value => $name):?>
                        <option <?php echo $selected == $value ? 'selected' : '';?> value="<?php echo $value;?>">
                            <?php echo $name;?>
                        </option>
                    <?php endforeach;?>
                </optgroup>
            <?php endif;?>
        </select>
    </div>
    <div class="row margin-0 margin-bottom-10" id="tricky_topic_view" style="display: none;background: #fafafa;padding: 10px;"></div>
</div>
<div>
    <?php echo elgg_echo('or:create');?>
    <?php echo elgg_view('output/url', array(
        'href'  => "javascript:;",
        'title' => elgg_echo('tricky_topic'),
        'text'  => elgg_echo('tricky_topic'),
        'id'    => 'add-tricky-topic'
    ));
    ?>
</div>
<div class="row margin-0 margin-bottom-10" id="form-add-tricky-topic" style="display: none;background: #fafafa;padding: 10px;">
    <div class="form-group col-md-12 margin-top-10">
        <div class="form-group">
            <label for="tricky-topic-title"><?php echo elgg_echo('tricky_topic');?></label>
            <?php echo elgg_view("input/text", array(
                'name' => 'tricky-topic-title',
                'class' => 'form-control',
                'required' => true,
            ));
            ?>
        </div>
        <label for="tricky-topic-description"><?php echo elgg_echo('description');?></label>
        <?php echo elgg_view("input/plaintext", array(
            'name' => 'tricky-topic-description',
            'class' => 'form-control',
            'rows' => 1,
            'onclick' => 'javascript:this.rows=5;'
        ));
        ?>
        <hr class="margin-0 margin-top-10 margin-bottom-10">
        <div class="form-add-tags prototype-container" data-prototype="<?php echo htmlentities(elgg_view("tricky_topics/tags/add"));?>">
            <label class="margin-top-5 margin-bottom-10"><?php echo elgg_echo("tags");?></label>
            <div class="prototype-content">
                <?php echo elgg_view("tricky_topics/tags/add");?>
            </div>
            <?php echo elgg_view('output/url', array(
                'href'  => "javascript:;",
                'class' => 'btn btn-xs btn-primary prototype-add',
                'title' => elgg_echo('add'),
                'text'  => '<i class="fa fa-plus"></i>' . elgg_echo('add'),
                'id'    => 'add-tag'
            ));
            ?>
        </div>
        <div class="clearfix"></div>
        <div class="form-group row margin-top-10">
            <div class="col-md-6">
                <label class="margin-top-5 margin-bottom-10"><?php echo elgg_echo("education_level");?></label>
                <?php echo elgg_view("input/dropdown", array(
                    'name' => 'tricky-topic-education_level',
                    'style' => 'padding: 5px',
                    'class' => 'form-control',
                    'options_values' => get_education_levels(),
                    'required' => true
                ));
                ?>
            </div>
            <div class="col-md-6">
                <label class="margin-top-5 margin-bottom-10"><?php echo elgg_echo("tricky_topic:subject");?></label>
                <?php echo elgg_view("input/text", array(
                    'name' => 'tricky-topic-subject',
                    'class' => 'form-control',
                    'required' => true,
                ));
                ?>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <hr>
    <div class="pull-right">
        <?php echo elgg_view('output/url', array(
            'href'  => "javascript:;",
            'class' => 'btn btn-xs btn-primary margin-right-5',
            'id' => 'save-tricky-topic',
            'title' => elgg_echo('save'),
            'text'  => elgg_echo('save'),
        ));
        ?>
        <?php echo elgg_view('output/url', array(
            'href'  => "javascript:;",
            'class' => 'btn btn-xs btn-border-blue btn-primary',
            'title' => elgg_echo('cancel'),
            'text'  => elgg_echo('cancel'),
            'onclick' => '$(\'#add-tricky-topic\').click()',
        ));
        ?>
    </div>
    <?php echo elgg_view("input/hidden", array(
        'name' => 'activity-tricky-topic',
        'value' => 'true'
    ));
    ?>
</div>
