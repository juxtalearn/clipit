<?php
/**
 * Elgg login form
 *
 * @package Elgg
 * @subpackage Core
 */
?>

<div>
    <label><?php echo elgg_echo('loginusername'); ?></label>
    <?php echo elgg_view('input/text', array(
        'name' => 'username',
        'class' => 'form-control input-lg',
        'placeholder' => 'hello@email.com'
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

    <ul class="elgg-menu elgg-menu-general mtm">
        <?php
        if (elgg_get_config('allow_registration')) {
            echo '<li><a class="registration_link" href="' . elgg_get_site_url() . 'register">' . elgg_echo('register') . '</a></li>';
        }
        ?>
        <li><a class="forgot_link" href="<?php echo elgg_get_site_url(); ?>forgotpassword">
                <?php echo elgg_echo('user:password:lost'); ?>
            </a></li>
    </ul>
</div>
