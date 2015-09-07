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
var files_task =
{
    'name': {
        'es': 'Actividad con archivos',
        'en': 'File activity'
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
    ]
};
task_template['files'] = files_task;

elgg.register_hook_handler('clipit:task:template', 'system', function(){
    return task_template;
});