<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   16/09/14
 * Last update:     16/09/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity_id = elgg_extract('entity_id', $vars);
$object = ClipitSite::lookup($entity_id);
//$entity = $object['subtype']::get_by_id(array($entity_id));
$entity_class = $object['subtype'];

$spanish = array(
    // Concept
    'focus' => 'Foco',
    'focus:1' => 'El material no trata ningunos de los conceptos clave asociados',
    'focus:2' => 'El material no se centra claramente en el tema y resulta confuso y/o equívoco.',
    'focus:3' => 'El material se centra en el tema pero no lo hace de forma clara.',
    'focus:4' => 'El material se centra claramente en el tema aunque no cubre todos los aspectos claves que lo definen.',
    'focus:5' => 'El material se centra claramente en el tema incluyendo todos los conceptos que lo definen.',
    'relevance' => 'Relevancia',
    'relevance:1' => '...',
    'relevance:2' => 'El material no plantea adecuadamente la explicación del tema.',
    'relevance:3' => 'El material plantea adecuadamente la explicación del tema.',
    'relevance:4' => 'El material plantea la explicación del tema utilizando un.',
    'relevance:5' => 'El material plantea la explicación del tema utilizando un.',
    'accuracy' => 'Exactitud',
    'accuracy:1' => 'El material no trata ningunos de los conceptos clave asociados',
    'accuracy:2' => 'El material no se centra claramente en el tema y resulta confuso y/o equívoco.',
    'accuracy:3' => 'El material se centra en el tema pero no lo hace de forma clara.',
    'accuracy:4' => 'El material se centra claramente en el tema aunque no cubre todos los aspectos claves que lo definen.',
    'accuracy:5' => 'El material se centra claramente en el tema incluyendo todos los conceptos que lo definen.',
    'understandable' => 'Comprensible',
    'understandable:1' => '...',
    'understandable:2' => 'El material no plantea adecuadamente la explicación del tema.',
    'understandable:3' => 'El material plantea adecuadamente la explicación del tema.',
    'understandable:4' => 'El material plantea la explicación del tema utilizando un.',
    'understandable:5' => 'El material plantea la explicación del tema utilizando un.',
    // Audiovisual
    'prepro' => 'Pre-produccion',
    'prepro:1' => '...',
    'prepro:2' => 'El material no plantea adecuadamente la explicación del tema.',
    'prepro:3' => 'El material plantea adecuadamente la explicación del tema.',
    'prepro:4' => 'El material plantea la explicación del tema utilizando un.',
    'prepro:5' => 'El material se centra claramente en el tema incluyendo todos los conceptos que lo definen.',
    'image' => 'Imagen',
    'image:1' => '...',
    'image:2' => 'El material no plantea adecuadamente la explicación del tema.',
    'image:3' => 'El material plantea adecuadamente la explicación del tema.',
    'image:4' => 'El material plantea la explicación del tema utilizando un.',
    'image:5' => 'El material se centra claramente en el tema incluyendo todos los conceptos que lo definen.',
    'sound' => 'Sonido',
    'sound:1' => 'El material no plantea adecuadamente la explicación del tema.',
    'sound:2' => 'El material no plantea adecuadamente la explicación del tema.',
    'sound:3' => 'El material plantea adecuadamente la explicación del tema.',
    'sound:4' => 'El material plantea la explicación del tema utilizando un.',
    'sound:5' => 'El material plantea la explicación del tema utilizando un.',
    'edition' => 'Edición-Montaje',
    'edition:1' => '...',
    'edition:2' => 'El material no plantea adecuadamente la explicación del tema.',
    'edition:3' => 'El material plantea adecuadamente la explicación del tema.',
    'edition:4' => 'El material plantea la explicación del tema utilizando un.',
    'edition:5' => 'El material se centra claramente en el tema incluyendo todos los conceptos que lo definen.',

);
add_translation('en', $spanish);
?>
<ul class="nav nav-tabs" role="tablist">
    <li class="active"><a href="#concept" role="tab" data-toggle="tab">Concepto</a></li>
    <?php if($entity_class == 'ClipitVideo'):?>
    <li><a href="#audiovisual" role="tab" data-toggle="tab">Audiovisual</a></li>
    <?php endif;?>
</ul>
<div class="tab-content">

<div class="tab-pane active table-responsive" id="concept">
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
        <td><strong><?php echo elgg_echo('focus');?></strong></td>
        <td><?php echo elgg_echo('focus:1');?></td>
        <td><?php echo elgg_echo('focus:2');?></td>
        <td><?php echo elgg_echo('focus:3');?></td>
        <td><?php echo elgg_echo('focus:4');?></td>
        <td><?php echo elgg_echo('focus:5');?></td>
    </tr>
    <tr>
        <td><strong><?php echo elgg_echo('relevance');?></strong></td>
        <td><?php echo elgg_echo('relevance:1');?></td>
        <td><?php echo elgg_echo('relevance:2');?></td>
        <td><?php echo elgg_echo('relevance:3');?></td>
        <td><?php echo elgg_echo('relevance:4');?></td>
        <td><?php echo elgg_echo('relevance:5');?></td>
    </tr>
    <tr>
        <td><strong><?php echo elgg_echo('accuracy');?></strong></td>
        <td><?php echo elgg_echo('accuracy:1');?></td>
        <td><?php echo elgg_echo('accuracy:2');?></td>
        <td><?php echo elgg_echo('accuracy:3');?></td>
        <td><?php echo elgg_echo('accuracy:4');?></td>
        <td><?php echo elgg_echo('accuracy:5');?></td>
    </tr>
    <tr>
        <td><strong><?php echo elgg_echo('understandable');?></strong></td>
        <td><?php echo elgg_echo('understandable:1');?></td>
        <td><?php echo elgg_echo('understandable:2');?></td>
        <td><?php echo elgg_echo('understandable:3');?></td>
        <td><?php echo elgg_echo('understandable:4');?></td>
        <td><?php echo elgg_echo('understandable:5');?></td>
    </tr>
</table>
</div>
<?php if($entity_class == 'ClipitVideo'):?>
<div class="tab-pane table-responsive" id="audiovisual">
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
        <td><strong><?php echo elgg_echo('prepro');?></strong></td>
        <td><?php echo elgg_echo('prepro:1');?></td>
        <td><?php echo elgg_echo('prepro:2');?></td>
        <td><?php echo elgg_echo('prepro:3');?></td>
        <td><?php echo elgg_echo('prepro:4');?></td>
        <td><?php echo elgg_echo('prepro:5');?></td>
    </tr>
    <tr>
        <td><strong><?php echo elgg_echo('image');?></strong></td>
        <td><?php echo elgg_echo('image:1');?></td>
        <td><?php echo elgg_echo('image:2');?></td>
        <td><?php echo elgg_echo('image:3');?></td>
        <td><?php echo elgg_echo('image:4');?></td>
        <td><?php echo elgg_echo('image:5');?></td>
    </tr>
    <tr>
        <td><strong><?php echo elgg_echo('sound');?></strong></td>
        <td><?php echo elgg_echo('sound:1');?></td>
        <td><?php echo elgg_echo('sound:2');?></td>
        <td><?php echo elgg_echo('sound:3');?></td>
        <td><?php echo elgg_echo('sound:4');?></td>
        <td><?php echo elgg_echo('sound:5');?></td>
    </tr>
    <tr>
        <td><strong><?php echo elgg_echo('edition');?></strong></td>
        <td><?php echo elgg_echo('edition:1');?></td>
        <td><?php echo elgg_echo('edition:2');?></td>
        <td><?php echo elgg_echo('edition:3');?></td>
        <td><?php echo elgg_echo('edition:4');?></td>
        <td><?php echo elgg_echo('edition:5');?></td>
    </tr>
</table>
</div>
<?php endif;?>


</div> <!-- Tab content end-->
