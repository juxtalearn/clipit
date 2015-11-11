<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/02/2015
 * Last update:     23/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
global $CONFIG;
$lang = $CONFIG->language;
?>
<style>
    .btn-large{
        padding: 15px;
        font-size: 16px;
    }

</style>
<script>
    $(function(){
        $("#teacher").click(function(){
            $("input[name=username]").val("teacher");
            $("input[name=password]").val("teacher");
            $(this).closest("form").submit();
        });
        $("#student").click(function(){
            $("input[name=username]").val("student");
            $("input[name=password]").val("student");
            $(this).closest("form").submit();
        });
    });
</script>
<?php if($lang == 'es'):?>
    <div class="btn-group" data-toggle="buttons">
        <label class="btn btn-primary btn-border-blue btn-large" id="teacher">
            <input type="radio" name="options" id="option1" checked=""><i class="fa fa-user"></i> Acceder como Profesor
        </label>
        <label class="btn btn-primary btn-border-blue btn-large" id="student">
            <input type="radio" name="options" id="option2"><i class="fa fa-users"></i> Acceder como Estudiante
        </label>
    </div>
<?php endif;?>
<?php if($lang == 'en'):?>
    <div class="btn-group" data-toggle="buttons">
        <label class="btn btn-primary btn-border-blue btn-large" id="teacher">
            <input type="radio" name="options" id="option1" checked=""><i class="fa fa-user"></i> Connect as teacher
        </label>
        <label class="btn btn-primary btn-border-blue btn-large" id="student">
            <input type="radio" name="options" id="option2"><i class="fa fa-users"></i> Connect as student
        </label>
    </div>
<?php endif;?>

<div style="display: none">
    <?php echo elgg_view_form('demo/login_admin');?>
</div>