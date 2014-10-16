<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   06/10/2014
 * Last update:     06/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
<table class="table margin-top-15">
    <tr class="active">
        <th>
        </th>
        <th>
            Nulo
            <div class="rating ratings readonly" data-score="1">
                <?php echo star_rating_view(1);?>
            </div>
        </th>
        <th>
            Pobre
            <div class="rating ratings readonly" data-score="2">
                <?php echo star_rating_view(2);?>
            </div>
        </th>
        <th>
            Razonable
            <div class="rating ratings readonly" data-score="3">
                <?php echo star_rating_view(3);?>
            </div>
        </th>
        <th>
            Bueno
            <div class="rating ratings readonly" data-score="4">
                <?php echo star_rating_view(4);?>
            </div>
        </th>
        <th>
            Excelente
            <div class="rating ratings readonly" data-score="5">
                <?php echo star_rating_view(5);?>
            </div>
        </th>
    </tr>
    <tr>
        <td>
            <?php echo elgg_view("input/text", array(
                'class' => 'form-control',
                'placeholder' => "Name",
            ));
            ?>
        </td>
        <td>
            <?php echo elgg_view("input/plaintext", array(
                'class' => 'form-control',
                'rows' => 6,
                'style' => 'padding: 5px;width: 120px;font-size: 13px;'
            ));
            ?>
        </td>
        <td>
            <?php echo elgg_view("input/plaintext", array(
                'class' => 'form-control',
                'rows' => 6,
                'style' => 'padding: 5px;width: 120px;font-size: 13px;'
            ));
            ?>
        </td>
        <td>
            <?php echo elgg_view("input/plaintext", array(
                'class' => 'form-control',
                'rows' => 6,
                'style' => 'padding: 5px;width: 120px;font-size: 13px;'
            ));
            ?>
        </td>
        <td>
            <?php echo elgg_view("input/plaintext", array(
                'class' => 'form-control',
                'rows' => 6,
                'style' => 'padding: 5px;width: 120px;font-size: 13px;'
            ));
            ?>
        </td>
        <td>
            <?php echo elgg_view("input/plaintext", array(
                'class' => 'form-control',
                'rows' => 6,
                'style' => 'padding: 5px;width: 120px;font-size: 13px;'
            ));
            ?>
        </td>
    </tr>
</table>