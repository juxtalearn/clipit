<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   16/12/2014
 * Last update:     16/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$items = elgg_extract('entities', $vars);
$items = ClipitExampleType::get_by_id($items);
$user_language = get_current_language();
$language_index = ClipitExampleType::get_language_index($user_language);
foreach($items as $item) {
    $categories[$item->category[$language_index]] = $item->category_description[$language_index];
}
?>
<h4 class="margin-0"><?php echo elgg_echo('reflection_palette');?></h4>
<span class="text-muted show margin-bottom-10">
    <?php echo elgg_echo('reflection_palette:question');?>
</span>
<div role="presentation" class="margin-bottom-20">
    <div class="module-controls">
    <!-- Nav tabs -->
    <ul class="navs nav-tab tab-set" role="tablist">
        <?php
        $i = 1;
        foreach($categories as $category => $description):
            ?>
            <li role="presentation" class="<?php echo $i==1 ? 'active':'';?>">
                <a href="#<?php echo elgg_get_friendly_title($category);?>" aria-controls="home" role="tab" data-toggle="tab">
                    <?php echo $category;?>
                    <i class="fa fa-question-circle"
                       data-container="body" data-toggle="popover" data-trigger="hover"
                        data-placement="bottom" data-content="<?php echo $description;?>">
                    </i>
                </a>
            </li>
            <?php
            $i++;
        endforeach;
        ?>
    </ul>
    <!-- Tab panes -->
    </div>
    <div class="tab-content">
        <?php
        $x=1;
        foreach($categories as $category => $description):
        ?>
        <div role="presentation" class="<?php echo $x==1 ? 'active':'';?> reflection-item tab-pane row" id="<?php echo elgg_get_friendly_title($category);?>" style="padding: 10px;">
            <div class="col-md-12">
                <?php
                foreach($items as $item):
                    if($item->category[$language_index] == $category):
                ?>
                    <strong><?php echo $item->item_name[$language_index]; ?></strong>
                    <div class="text-muted margin-bottom-10">
                        <?php echo $item->item_description[$language_index]; ?>
                    </div>
                <?php
                    endif;
                endforeach;
                ?>
            </div>
        </div>
    <?php
    $x++;
    endforeach;
    ?>
</div>