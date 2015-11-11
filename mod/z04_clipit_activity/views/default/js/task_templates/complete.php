<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   07/07/2015
 * Last update:     07/07/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
?>
//<script>
var complete_task =
{
    'name': {
        'es': 'Actividad completa',
        'en': 'Full activity'
    },
    'description': {
        'es': 'Tareas que cubren una actividad completa',
        'en': 'Tasks covering a full activity'
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
            'task_type': 'quiz_take',
            'name': {
                'es': 'Hacer test',
                'en': 'Take quiz'
            },
            'description': {
                'es': 'Los alumnos deberán realizar un test',
                'en': 'Students must take a quiz'
            }
        },
        {
            'task_type': 'file_upload',
            'name': {
                'es': 'Publicar archivo',
                'en': 'Publish file'
            },
            'description': {
                'es': 'Cada grupo deberá subir y publicar un archivo',
                'en': 'Each group must upload and publish a file'
            },
            'feedback':{
                'task_type': 'file_feedback',
                'name': {
                    'es': 'Evaluar archivos',
                    'en': 'Evaluate files'
                },
                'description': {
                    'es': 'Los alumnos deberán ver y evaluar los archivos de los demás grupos',
                    'en': 'Students must review and evaluate the files from other groups'
                }
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
task_template['complete'] = complete_task;

elgg.register_hook_handler('clipit:task:template', 'system', function(){
    return task_template;
}, 1);