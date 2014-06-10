<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$spanish = array(
    'view'  => 'vista',
    // Activity
    'my_activities' => 'mis actividades',
    'activities:none' => 'no hay actividades...',
    'explore' => 'explorando',
    'past' => 'acabado',
    'activity:profile' => 'perfil',
    'activity:groups' => 'grupos',
    'activity:discussion' => 'discusión',
    'activity:stas' => 'materiales',
    'activity:publications' => 'publicaciones',
    'activity:join' => 'únete',
    'activity:actual_deadline' => 'actividad:actual_fecha límite',
    'activity:next_deadline' => 'próxima_fecha límite',
    'activity:quiz' => 'actividad:examen',
    'activity:teachers' => 'profesores',
    // Activity status
    'status:enroll' => 'matrículado',
    'status:active' => 'Activo',
    'status:closed' => 'Acabado',

    'group:join' => 'únete',
    'group:leave' => 'abandona',
    'group:leave:me' => 'abandona grupo',
    'group:join_to' => 'únete al grupo',
    'group:cantcreate' => 'no puedes crear un grupo.',
    'group:created' => 'grupo creado',
    'group:joined' => 'se ha unido al grupo!',
    'group:cantjoin' => 'no puede unirse al grupo',
    'group:left' => 'ha abandonado el grupo',
    'group:cantleave' => 'no puede dejar el grupo',
    'group:member:remove' => 'borrar del grupo',
    'group:member:cantremove' => 'no se puede borrar miembro del grupo',
    'group:member:removed' => 'borrado miembro del grupo',
    // Quizz
    'quiz' => 'Exámen',

    // Group tools
    'group:menu' => 'grupo: menú',
    'group:tools' => 'grupo:herramientas',
    'group:discussion' => 'discusiones',
    'group:files' => 'multimedia',
    'group:home' => 'grupo inicio',
    'group:activity_log' => 'registro actividad',
    'group:progress' => 'progresión',
    'group:edit' => 'grupo edición',
    'group:members' => 'miembros',
    // Discussion
    'discussions:none' => 'sin discusiones',
    'discussion:created' => 'discusión creada',
    'discussion:cantcreate' => 'no puedes crear una discusión',
    'discussion:edit' => 'editar tema',
    'discussion:title_topic' => 'título del tama',
    'discussion:text_topic' => 'texto del tema',
    // Multimedia
    'url'   => 'Url',
    'multimedia:files' => 'archivos',
    'multimedia:videos' => 'videos',
    'multimedia:storyboards' => 'guiones',
    'multimedia:links' => 'enlaces de interés',
    // Files
    'files' => 'archivos',
    'file' => 'archivo',
    'multimedia:file:description' => 'archivo: descripción',
    'multimedia:files:add' => 'añadir archivos',
    'file:nofile' => 'sin archivo',
    'file:removed' => 'el archivo ha sido borrado',
    'file:cantremove' => 'no se puede borrar el archivo',
    'file:edit' => 'editar archivo',
    'file:none' => "sin archivos",
    /* File types */
    'file:general' => 'archivo',
    'file:document' => 'documento',
    'file:image' => 'imagen',
    'file:video' => 'video',
    'file:audio' => 'audio',
    'file:compressed' => 'comprimir archivo',
    // Videos
    'videos' => 'Videos',
    'video' => 'Video',
    'videos:none' => 'sin videos',
    'video:url:error' => 'url incorrecta, video no encontrado',
    'video:edit' => 'editar video',
    'video:add' => 'añadir video',
    'video:url' => 'url del video',
    'video:title' => 'título del video',
    'video:tags' => 'etiquetas del video',
    'video:description' => 'descripcion del video',
    // Storyboards
    'storyboards:none' => 'sin guion',
    'multimedia:storyboards:add' => 'añadir guion',
    // Tricky Topic
    'tricky_topic' => 'concepto complicado',
    // Publications
    'publications:no_evaluated' => 'no evaluado',
    'publications:evaluated' => 'evaluado',
    'publications:rating' => 'calificacion',
    'publications:rating:name' => '%s\'s Calificacion',
    'publications:rating:list' => 'clasificaciones:lista',
    'publications:starsrequired' => 'requeridas estrellas de calificacion',
    'publications:cantrating' => 'no se puede calificar',
    'publications:rated' => 'evaluado',
    'publications:my_rating' => 'mi evaluacion',
    'publications:question:tricky_topic' => 'te ha ayudado este video a entender conceptos complicados?',
    'publications:question:sb' => 'porqué está/no está éste concepto correctamente explicado?',
    'publications:question:if_covered' => 'comprueba si cada concepto se ha  explicado en este video y explica por qué:',
    'input:no' => 'no',
    'input:yes' => 'si',
    'publish'   => 'público',
    'published'   => 'Publicado',
    'publish:to_activity'   => 'público %s en %s',
    'publish:video'   => 'video público',
    // Labels
    'labels' => 'etiquetas',
    // Tags
    'tags' => 'conceptos',
    'tags:commas:separated' => 'separado por comas',
    // Performance items
    'performance_items' => 'desarrollo artículos',
    'performance_item:select' => 'seleccionar los artículos a desarrollar',
    'performance_item:info' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus dapibus lacus at nisl pharetra faucibus dapibus lacus',
    // Tasks
    'activity:tasks' => 'Tareas',
    'activity:task' => 'Tareas',
);

add_translation('es', $spanish);
