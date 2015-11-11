<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   02/12/2014
 * Last update:     02/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$examples = elgg_extract('entities', $vars);
if(!$examples){
    $stumbling_block = get_input('stumbling_block');
    $examples = ClipitExample::get_by_tag(array($stumbling_block));
}
?>
<?php if($examples):?>
<table class="table">
    <thead>
    <tr>
        <th><?php echo elgg_echo('name');?></th>
        <th><?php echo elgg_echo('location');?></th>
        <th><?php echo elgg_echo('country');?></th>
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
        <td>
            <?php echo elgg_view('output/url', array(
                'href'  => set_search_input('tricky_topics/examples', array('location'=>$example->location)),
                'title' => $example->location,
                'text'  => $example->location,
            ));
            ?>
        </td>
        <td>
            <?php echo elgg_view('output/url', array(
                'href'  => set_search_input('tricky_topics/examples', array('country'=>$example->country)),
                'title' => get_countries_list($example->country),
                'text'  => get_countries_list($example->country),
            ));
            ?>
        </td>
    </tr>
    <?php endforeach;?>
    </tbody>
</table>
<?php else: ?>
    <?php echo elgg_view('output/empty', array('value' => elgg_echo('examples:none')));;?>
<?php endif;?>