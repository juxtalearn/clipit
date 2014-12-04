<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   03/11/2014
 * Last update:     03/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$id = elgg_extract('id', $vars);
$input_prefix = elgg_extract('input_prefix', $vars);
?>
<?php echo elgg_view("input/plaintext", array(
    'name'  => $input_prefix.'[question]['.$id.'][string]',
    'class' => 'form-control',
    'value' => $vars['checked'],
    'onclick'   => '$(this).addClass(\'mceEditor\');
                                        tinymce_setup();
                                        tinymce.execCommand(\'mceFocus\',false,this.id);',
    'rows'  => 1,
));
?>