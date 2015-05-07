<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   06/05/2015
 * Last update:     06/05/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$rubric = elgg_extract('entity', $vars);
$input_prefix = elgg_extract('input_prefix', $vars);
$disabled = elgg_extract('disabled', $vars);
$user = elgg_extract('owner', $vars);
$id = elgg_extract('id', $vars);
?>
<div class="form-group performance-item" style="background: #fafafa;padding: 10px;">
    <?php if($disabled):?>
        <small class="pull-right">
            <?php if($input_prefix):?>
                <i class="fa fa-lock"></i>
            <?php endif;?>
            <?php echo elgg_echo('author');?>:
            <?php echo elgg_view('output/url', array(
                'href'  => "profile/{$user->login}",
                'title' => $user->name,
                'text'  => $user->name,
            ));
            ?>
        </small>
    <?php endif;?>
    <?php if($disabled):?>
            <p><strong><?php echo $rubric->name;?></strong></p>
        <?php else: ?>
            <?php echo elgg_view('output/url', array(
                'href'  => 'javascript:;',
                'title' => elgg_echo('delete'),
                'text'  => '',
                'class' => 'fa fa-times red pull-right remove-p',
                'style' => 'display: none;',
                'onclick' => '$(this).parent(\'.performance-item\').remove();'
            ));
            ?>
            <?php echo elgg_view("input/text", array(
                'name' => $input_prefix.'[name]',
                'class' => 'form-control',
                'style' => 'width: 95%;',
                'required' => true,
                'value' => $rubric->name,
                'disabled' => $disabled,
                'placeholder' => elgg_echo('name'),
            ));
            ?>
    <?php endif;?>
    <div class="margin-top-10">
        <a class="toggle" data-toggle="collapse" href="#item_category_desc_<?php echo $id;?>" aria-expanded="false" class="margin-right-10">
            <strong><?php echo $disabled?'':'+';?> <?php echo elgg_echo('description'); ?></strong>
        </a>
        <a class="toggle margin-left-10" data-toggle="collapse" href="#item_example_<?php echo $id;?>" aria-expanded="false">
            <strong><?php echo $disabled?'':'+';?> <?php echo elgg_echo('performance_item:example'); ?></strong>
        </a>
    </div>
    <div class="toggle-content collapse form-group" id="item_category_desc_<?php echo $id;?>">
        <?php if($disabled):?>
            <small><?php echo elgg_echo('description');?></small>
            <p><?php echo $rubric->description;?></p>
        <?php else:?>
        <label for="item-description[<?php echo $i;?>]"><?php echo elgg_echo('description');?></label>
        <?php echo elgg_view("input/plaintext", array(
            'name' => $input_prefix.'[description]',
            'value' => $rubric->description,
            'disabled' => $disabled,
            'class' => 'form-control',
            'style' => 'overflow-y: auto;resize: none;',
            'rows' => 3,
        ));
        ?>
        <?php endif;?>
    </div>
    <div class="toggle-content collapse form-group" id="item_example_<?php echo $id;?>">
        <?php if($disabled):?>
            <small><?php echo elgg_echo('performance_item:example');?></small>
            <p><?php echo $rubric->example;?></p>
        <?php else:?>
        <label for="item-example[<?php echo $i;?>]"><?php echo elgg_echo('performance_item:example');?></label>
        <?php echo elgg_view("input/text", array(
            'name' => $input_prefix.'[example]',
            'value' => $rubric->example,
            'disabled' => $disabled,
            'class' => 'form-control',
        ));
        ?>
        <?php endif;?>
    </div>
</div>