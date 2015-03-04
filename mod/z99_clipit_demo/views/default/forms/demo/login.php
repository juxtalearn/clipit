<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/02/2015
 * Last update:     23/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
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
<div style="display: none;">
    <div>
        <label><?php echo elgg_echo('loginusername'); ?></label>
        <?php echo elgg_view('input/text', array(
            'name' => 'username',
            'class' => 'form-control input-lg',
        ));
        ?>
    </div>
    <div>
        <label><?php echo elgg_echo('password'); ?></label>
        <?php echo elgg_view('input/password',
            array(
                'name' => 'password',
                'class' => 'form-control input-lg'
            ));
        ?>
    </div>
    <div>
        <label style="margin: 10px 0px 0px">
            <input type="checkbox" name="persistent" value="true" />
            <?php echo elgg_echo('user:persistent'); ?>
        </label>
    </div>
    <?php echo elgg_view('login/extend', $vars); ?>
    <div class="elgg-foot">
        <?php echo elgg_view('input/submit', array('value' => elgg_echo('login'), 'class'=>'btn btn-primary btn-lg')); ?>

        <?php
        if (isset($vars['returntoreferer'])) {
            echo elgg_view('input/hidden', array('name' => 'returntoreferer', 'value' => 'true'));
        }
        ?>

    </div>
</div>
