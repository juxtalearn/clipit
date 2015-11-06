<?php echo elgg_view('login/extend', $vars); ?>

    <div class="form-group">
        <label for="username"><?php echo elgg_echo('user:username:login'); ?></label>
        <input type="text" aria-label="username" class="form-control" name="username" id="input-login" placeholder="<?php echo elgg_echo('loginusername'); ?>" required>
    </div>
    <div class="form-group">
        <label for="password"><?php echo elgg_echo('password'); ?></label>
        <input type="password" aria-label="password" name="password" id="input-password" class="form-control" placeholder="<?php echo elgg_echo('password'); ?>" required>
    </div>
    <div class="form-group">
        <label style="font-weight: normal;">
            <input type="checkbox" name="persistent" value="true"> <?php echo elgg_echo('user:persistent'); ?>
        </label>
    </div>
    <input type="submit" class="btn btn-primary" value="<?php echo elgg_echo("login");?>"/>
    <p class="link">
        <a href="<?php echo elgg_get_site_url(); ?>forgotpassword"><?php echo elgg_echo('user:forgotpassword'); ?></a>
    </p>
<?php
if (isset($vars['returntoreferer'])) {
    echo elgg_view('input/hidden', array('name' => 'returntoreferer', 'value' => 'true'));
}
?>