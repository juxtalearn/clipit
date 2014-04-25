<?php
/**
 * Elgg register form
 *
 * @package Elgg
 * @subpackage Core
 */

$password = $password2 = '';
$username = get_input('u');
$email = get_input('e');
$name = get_input('n');

if (elgg_is_sticky_form('register')) {
    extract(elgg_get_sticky_values('register'));
    elgg_clear_sticky_form('register');
}

?>
    <div class="mtm">
        <label for="name"><?php echo elgg_echo('name'); ?></label>
        <?php
        echo elgg_view('input/text', array(
            'name' => 'name',
            'value' => $name,
            'class' => 'form-control input-lg',
            'placeholder' => 'Juan García',
            'data-rule-required' => 'true',
            'data-rule-minlength' => '6'
        ));
        ?>
    </div>
    <div>
        <label for="email"><?php echo elgg_echo('email'); ?></label>
        <?php
        echo elgg_view('input/text', array(
            'name' => 'email',
            'value' => $email,
            'class' => 'form-control input-lg',
            'placeholder' => 'hello@email.com',
            'data-rule-email' => 'true',
            'data-rule-required' => 'true'
        ));
        ?>
    </div>
    <div>
        <label for="username"><?php echo elgg_echo('username'); ?></label>
        <?php
        echo elgg_view('input/text', array(
            'name' => 'username',
            'value' => $username,
            'class' => 'form-control input-lg',
            'placeholder' => 'juangarcia',
            'data-msg-remote' => elgg_echo('registration:userexists'),
            //'data-rule-remote' => elgg_get_site_url().'action/register'
        ));
        ?>
    </div>
    <div>
        <label for="password"><?php echo elgg_echo('password'); ?></label>
        <?php
        echo elgg_view('input/password', array(
            'name' => 'password',
            'value' => $password,
            'class' => 'form-control input-lg',
            'id' => 'password',
            'data-rule-required' => 'true'
        ));
        ?>
    </div>
    <div>
        <label for="password2"><?php echo elgg_echo('passwordagain'); ?></label>
        <?php
        echo elgg_view('input/password', array(
            'name' => 'password2',
            'value' => $password2,
            'id' => 'password2',
            'oncopy' => 'return false',
            'autocomplete' => 'off',
            'ondrag' => 'return false',
            'ondrop' => 'return false',
            'onpaste' => 'return false',
            'data-rule-required' => 'true',
            'data-rule-equalto' => '#password',
            'class' => 'form-control input-lg',
        ));
        ?>
    </div>

<?php
// view to extend to add more fields to the registration form
echo elgg_view('register/extend', $vars);

// Add captcha hook
echo elgg_view('input/captcha', $vars);

echo '<div class="elgg-foot">';
echo elgg_view('input/hidden', array('name' => 'friend_guid', 'value' => $vars['friend_guid']));
echo elgg_view('input/hidden', array('name' => 'invitecode', 'value' => $vars['invitecode']));
echo elgg_view('input/submit', array('name' => 'submit', 'value' => elgg_echo('register'), 'class'=>'btn btn-primary btn-lg'));
echo '</div>';
