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
var storyboards_task =
{
    'name': {
        'es': 'Actividad con storyboards',
        'en': 'Activity with storyboards'
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
            'task_type': 'file_upload',
            'name': {
                'es': 'Publicar storyboard',
                'en': 'Publish storyboard'
            },
            'description': {
                'es': 'Cada grupo deberá subir y publicar un storyboard',
                'en': 'Each group must upload and publish a storyboard'
            },
            'feedback':{
                'task_type': 'file_feedback',
                'name': {
                    'es': 'Evaluar storyboards',
                    'en': 'Evaluate storyboards'
                },
                'description': {
                    'es': 'Los alumnos deberán ver y evaluar los storyboards de los demás grupos',
                    'en': 'Students must review and evaluate the storyboards from other groups'
                }
            }
        },
    ]
};
task_template['storyboards'] = storyboards_task;

elgg.register_hook_handler('clipit:task:template', 'system', function(){
    return task_template;
});