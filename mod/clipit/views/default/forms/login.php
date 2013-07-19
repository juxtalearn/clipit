<?php
/**
 * Elgg login form
 *
 * @package Elgg
 * @subpackage Core
 */
?>

<?php echo elgg_view('login/extend', $vars); ?>

<div class="jxl-login">
    <label class="row-jxl-login" for="inputUsername"><?php echo elgg_echo('loginusername'); ?></label>
    <input class="row-jxl-login input-jxl-login" type="text" name="username" id="inputUsername" placeholder="<?php echo elgg_echo('loginusername'); ?>" required>
    <label class="row-jxl-login" for="inputPassword"><?php echo elgg_echo('password'); ?></label>
    <input class="row-jxl-login input-jxl-login" type="password" name="password" id="inputPassword" placeholder="<?php echo elgg_echo('password'); ?>" required>
    <div class="row-jxl-login">
        <label>
            <input type="checkbox" name="persistent" value="true" checked="true">
            <?php echo elgg_echo('user:persistent'); ?>
        </label>
        <div>
            <button type="submit" class="elgg-button elgg-button-submit btn-jxl-login"><?php echo elgg_echo('login'); ?></button>
        </div>
        <div>
            <a class="row-jxl-login elgg-button elgg-button-special btn-jxl-login" href="<?php echo elgg_get_site_url(); ?>register"><?php echo elgg_echo('register'); ?></a>
        </div>
        <div>
            <a class="row-jxl-login elgg-button elgg-button-cancel btn-jxl-login" href="<?php echo elgg_get_site_url(); ?>forgotpassword"><?php echo elgg_echo('user:password:lost'); ?></a>
        </div>
    </div>
</div>

<br/>

<?php
if (isset($vars['returntoreferer'])) {
    echo elgg_view('input/hidden', array('name' => 'returntoreferer', 'value' => 'true'));
}
?>