<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   29/01/2015
 * Last update:     29/01/2015
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
<div style="
    background: #fff;
    padding: 5px;
    display: none;
" class="col-md-12 reflection-list">
<?php
    $x=1;
    foreach($categories as $category => $description):
        ?>


            <div style="
    background: #f1f2f7;
    padding: 10px;
    margin-bottom: 5px;
">

                <div class="row reflection-item">
                    <div class="col-md-6">
                        <?php
                        foreach($items as $item):
                            if($item->category[$language_index] == $category):
                        ?>
                            <label class="margin-bottom-5" id="<?php echo $item->id;?>" style="font-weight: normal;">
                                - <span class="blue cursor-default">
                                    <?php echo $item->item_name[$language_index]; ?>
                                </span>
                            </label>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                    <div class="col-md-6">
                        <div class="reflect-description">
                        <strong class="show"><?php echo $category;?></strong>
                        <div>
                            <small><?php echo $description;?></small>
                        </div>
                        </div>
                        <?php
                        foreach($items as $item):
                            if($item->category[$language_index] == $category):
                        ?>
                            <div class="reflect-description text-muted margin-bottom-10 bg-info" data-reflect_item="<?php echo $item->id;?>" style="display: none;">
                                <?php echo $item->item_description[$language_index]; ?>
                            </div>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>
        <?php
        $x++;
    endforeach;
    ?>
</div>