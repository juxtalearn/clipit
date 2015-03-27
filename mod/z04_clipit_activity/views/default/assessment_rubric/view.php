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
    'focus:1' => 'El material no trata ninguno de los conceptos clave asociados',
    'focus:2' => 'El material no se centra claramente en el tema y resulta confuso y/o equívoco.',
    'focus:3' => 'El material se centra en el tema pero no lo hace de forma clara.',
    'focus:4' => 'El material se centra claramente en el tema aunque no cubre todos los conceptos claves que lo definen.',
    'focus:5' => 'El material se centra claramente en el tema incluyendo todos los conceptos que lo definen.',
    'relevance' => 'Relevancia',
    'relevance:1' => 'El material utiliza información o ejemplos totalmente irrelevantes al tema a tratar.',
    'relevance:2' => 'El material no plantea adecuadamente la explicación del tema.',
    'relevance:3' => 'El material plantea adecuadamente la explicación del tema.',
    'relevance:4' => 'El material plantea la explicación del tema utilizando información o ejemplos relevantes.',
    'relevance:5' => 'El material plantea la explicación del tema utilizando información o ejemplos que va más alla de lo obvio o predecible.',
    'accuracy' => 'Exactitud',
    'accuracy:1' => 'No hay metáforas/ejemplos o toda la terminologia es incorrecta.',
    'accuracy:2' => 'Las metáforas/ejemplos empleadas son confusas y la terminología incorpora errores importantes que inducen a error.',
    'accuracy:3' => 'Las metáforas/ejemplos empleadas evocan solo en parte los conceptos que se quieren transmitir. La terminología que se emplea contiene algunas imprecisiones.',
    'accuracy:4' => 'Las metáforas/ejemplos empleadas evocan correctamente los conceptos que se quieren transmitir. La terminología que se emplea es precisa aunque hay algunos elementos podrían mejorarse.',
    'accuracy:5' => 'Las metáforas/ejemplos empleadas evocan correcta y creativamente los aspectos claves de los conceptos que se quieren transimitir. La terminología que se emplea es precisa',
    'understandable' => 'Comprensible',
    'understandable:1' => 'El material es totalmente incomprensible para un espectador no versado en la materia',
    'understandable:2' => 'El material es complejo y difícil de seguir para un espectador no versado en la materia.',
    'understandable:3' => 'El material presenta la idea con cierta claridad, aunque no resulta fácil de entender o seguir para espectadores no versados en la materia.',
    'understandable:4' => 'El material presenta la idea de forma adecuada, organizada y comprensible en términos generales, aunque hay aspectos que podrían mejorarse para que pudiesen comprenderlo mejor espectadores no versados en la materia.',
    'understandable:5' => 'El material presenta la idea de manera clara, bien organizada y comprensible por espectadores no versados en la materia. La narración mantiene al espectador atento al desarrollo de los contenidos.',
    // Audiovisual
    'prepro' => 'Pre-produccion',
    'prepro:1' => 'Ausencia total de pre-producción del vídeo',
    'prepro:2' => 'El vídeo no muestra el resultado esperado y guionizado. La producción es desorganizada y descuidada.',
    'prepro:3' => 'El vídeo se parece poco a la producción prevista, pues hay muchos elementos cambiados o desaparecidos. El guión es pobre y la planificación mejorable.',
    'prepro:4' => 'El vídeo está razonablemente cerca de la producción planificada y sólo hay discrepancias menores. Faltan pocos elementos esenciales de pre-producción. Bueno el guión y la planificación.',
    'prepro:5' => 'El vídeo responde al resultado esperado y definido en el guión, sin que falten elementos previstos en el mismo.',
    'image' => 'Imagen',
    'image:1' => 'No hay planificación visual.',
    'image:2' => 'La planificación visual y el uso de la cámara es incorrecta e inadecuada en relación al contenido de la historia.',
    'image:3' => 'La planificación visual y el uso de la cámara es correcta pero la historia podría contarse de una forma más adecuada con otros recursos.',
    'image:4' => 'La planificación visual y el uso de la cámara es adecuada.',
    'image:5' => 'La planificación visual y el uso de la cámara no sólo es adecuada sino que se ha utilizado de forma creativa y con calidad técnica.',
    'sound' => 'Sonido',
    'sound:1' => 'No hay sonido.',
    'sound:2' => 'El sonido no es claro, hay elementos fuera de lugar o es confuso.',
    'sound:3' => 'El sonido es claro, pero no está correctamente registrado o tratado y/o posee algunoserrores.',
    'sound:4' => 'El sonido es claro y comprensible y ayuda al desarrollo de la historia.',
    'sound:5' => 'El sonido es claro y comprensible y es utilizado creativamente para contar la historia.',
    'edition' => 'Edición-Montaje',
    'edition:1' => 'No se han incorporado los elementos minimos exigibles en la edición.',
    'edition:2' => 'La edición es pobre y presenta algunas dificultades notables.',
    'edition:3' => 'La edición presenta algunas deficiencias que distraen o que confunden sobre el contenido de la historia.',
    'edition:4' => 'La edición es correcta y adecuada.',
    'edition:5' => 'La edición es correcta, adecuada y presenta elementos creativos que ayudan a la historia.',
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
                <th class="col-md-2">
                </th>
                <th class="col-md-2">
                    Nulo
                    <div class="rating ratings readonly" data-score="1">
                        <?php echo star_rating_view(1);?>
                    </div>
                </th>
                <th class="col-md-2">
                    Pobre
                    <div class="rating ratings readonly" data-score="2">
                        <?php echo star_rating_view(2);?>
                    </div>
                </th>
                <th class="col-md-2">
                    Razonable
                    <div class="rating ratings readonly" data-score="3">
                        <?php echo star_rating_view(3);?>
                    </div>
                </th>
                <th class="col-md-2">
                    Bueno
                    <div class="rating ratings readonly" data-score="4">
                        <?php echo star_rating_view(4);?>
                    </div>
                </th>
                <th class="col-md-2">
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
