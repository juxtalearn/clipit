<?php echo elgg_view('login/extend', $vars); ?>

    <div class="form-group">
        <label for="exampleInputEmail1"><?php echo elgg_echo('loginusername'); ?></label>
        <input type="text" class="form-control" name="username" id="inputUsername" placeholder="<?php echo elgg_echo('loginusername'); ?>" required>
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1"><?php echo elgg_echo('password'); ?></label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="<?php echo elgg_echo('password'); ?>" required>
    </div>
    <div class="form-group">
        <label style="font-weight: normal;">
            <input type="checkbox" name="persistent" value="true" checked="true"> <?php echo elgg_echo('user:persistent'); ?>
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