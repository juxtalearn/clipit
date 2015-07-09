<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   07/07/2015
 * Last update:     07/07/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
//<script>
var videos_task =
{
    'name': {
        'es': 'Actividad con videos',
        'en': 'Activity with videos'
    },
    'description': {
        'es': 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam semper accumsan sapien',
        'en': 'Lorem ipsum dolor si sapien'
    },
    'tasks': [
        {
            'task_type': 'resource_download',
            'name': {
                'es': 'Ver/Descargar materiales',
                'en': 'Review/Download materials'
            },
            'description': {
                'es': 'Los alumnos deberán ver/descargar los materiales proporcionados por el profesor',
                'en': 'Students must review/download materials provided by the teacher'
            }
        },
        {
            'task_type': 'video_upload',
            'name': {
                'es': 'Publicar vídeo',
                'en': 'Publish video'
            },
            'description': {
                'es': 'Cada grupo deberá subir y publicar un vídeo',
                'en': 'Each group must upload and publish a video'
            },
            'feedback':{
                'task_type': 'video_feedback',
                'name': {
                    'es': 'Evaluar vídeos',
                    'en': 'Evaluate videos'
                },
                'description': {
                    'es': 'Los alumnos deberán ver y evaluar los vídeos de los demás grupos',
                    'en': 'Students must review and evaluate the videos from other groups'
                }
            }
        },
    ]
};
task_template['videos'] = videos_task;

elgg.register_hook_handler('clipit:task:template', 'system', function(){
    return task_template;
});