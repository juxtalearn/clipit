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
var quizzes_task =
{
    'name': {
        'es': 'Actividad de test',
        'en': 'Quiz activity'
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
            'task_type': 'quiz_take',
            'name': {
                'es': 'Hacer test',
                'en': 'Take quiz'
            },
            'description': {
                'es': 'Los alumnos deberán realizar un test',
                'en': 'Students must take a quiz'
            }
        }
    ]
};
task_template['quizzes'] = quizzes_task;

elgg.register_hook_handler('clipit:task:template', 'system', function(){
    return task_template;
});