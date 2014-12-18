<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   02/12/2014
 * Last update:     02/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$examples = elgg_extract('entities', $vars);
?>
<?php if($examples):?>
<table class="table">
    <thead>
    <tr>
        <th><?php echo elgg_echo('title');?></th>
        <th><?php echo elgg_echo('example:education_level');?></th>
        <th><i class="fa fa-globe"></i> <?php echo elgg_echo('country');?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($examples as $example):?>
    <tr>
        <td>
            <strong>
            <?php echo elgg_view('output/url', array(
                'href'  => "tricky_topics/examples/view/{$example->id}",
                'title' => $example->name,
                'text'  => $example->name,
            ));
            ?>
            </strong>
            <?php if($example->description):?>
            <small class="show">
                <?php echo $example->description;?>
            </small>
            <?php endif;?>
        </td>
        <td><?php echo elgg_echo('example:education_level:'.$example->education_level);?></td>
        <td><?php echo get_countries_list($example->country);?></td>
    </tr>
    <?php endforeach;?>
    </tbody>
</table>
<?php else: ?>
    <?php echo elgg_view('output/empty', array('value' => elgg_echo('examples:none')));;?>
<?php endif;?>