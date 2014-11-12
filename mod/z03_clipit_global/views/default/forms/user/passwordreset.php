<?php
/**
 * Reset user password form
 */

echo elgg_autop(elgg_echo('user:resetpassword:reset_password_confirm'));

echo elgg_view('input/hidden', array(
	'name' => 'u',
	'value' => $vars['guid'],
));

echo elgg_view('input/hidden', array(
	'name' => 'c',
	'value' => $vars['code'],
));




/**
 * Reset user password form
 *
 * @package Elgg
 * @subpackage Core
 */
?>

<div>
    <label for="password"><?php echo elgg_echo('user:resetpassword:newpassword'); ?></label>
    <?php
    echo elgg_view('input/password', array(
        'name' => 'password',
        'class' => 'form-control input-lg',
        'data-rule-equalto' => '#password2',
        'data-rule-required' => 'true'
    ));
    ?>
</div>
<div>
    <label for="password2"><?php echo elgg_echo('user:resetpassword:newpasswordagain'); ?></label>
    <?php
    echo elgg_view('input/password', array(
        'name' => 'password2',
        'id' => 'password2',
        'class' => 'form-control input-lg',
    ));
    ?>
</div>
<div class="elgg-foot">
<?php echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('user:resetpassword:newpassword'), 'class'=>'btn btn-primary btn-lg')); ?>
</div>
