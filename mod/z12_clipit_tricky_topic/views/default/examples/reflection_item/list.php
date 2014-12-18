<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   16/12/2014
 * Last update:     16/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$items = elgg_extract('entities', $vars);
$items = ClipitReflectionItem::get_by_id($items);
$user_language = get_current_language();
$language_index = ClipitReflectionItem::get_language_index($user_language);
foreach($items as $item) {
    $categories[$item->category[$language_index]] = $item->category_description[$language_index];
}
?>
<h4>Reflection palette: Why do students have this problem?</h4>
<div role="tabpanel" class="margin-bottom-20">

    <!-- Nav tabs -->
    <ul class="nav nav-tabs" role="tablist">
        <?php
        $i = 1;
        foreach($categories as $category => $description):
//            $categories[$category] = $items;
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
        $x=1;
        foreach($categories as $category => $description):
        ?>
        <div role="tabpanel" class="<?php echo $x==1 ? 'active':'';?> reflection-item tab-pane row" id="<?php echo elgg_get_friendly_title($category);?>" style="padding: 10px;">
            <div class="col-md-7">
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
            <div class="col-md-5">
                <div class="reflect-description">
                    <strong><?php echo $category;?></strong>
                    <p>
                        <?php echo $description;?>
                    </p>
                </div>
            </div>
        </div>
    <?php
    $x++;
    endforeach;
    ?>
    <div role="tabpanel" class="reflection-item tab-pane hide row" id="terminologyss" style="padding: 10px;">
        <div class="col-md-7">
            <strong>One term refers to multiple concepts</strong>
            <div class="text-muted margin-bottom-10">
                1_TEST_Different terms are used to refer to the same concept.
                e.g. voltage is also referred to as potential difference.
                Confusion between voltage and charge.
            </div>
            <strong>One term refers to multiple concepts</strong>
            <div class="text-muted margin-bottom-10">
                1_TEST_Different terms are used to refer to the same concept.
                e.g. voltage is also referred to as potential difference.
                Confusion between voltage and charge.
            </div>
        </div>
        <div class="col-md-5">
            <div class="reflect-description">
                <strong>Terminology</strong>
                <p>
                    Problems with use of language and scientific terms, inconsistent and overlapping terminology.
                </p>
            </div>

        </div>
    </div>
</div>