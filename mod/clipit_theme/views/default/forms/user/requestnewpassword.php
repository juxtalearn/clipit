<?php
/**
 * Clipit forgotten password.
 *
 * @package Clipit
 * @subpackage Core
 */
?>

<div>
    <label for="email"><?php echo elgg_echo('loginusername'); ?></label>
    <?php
    echo elgg_view('input/text', array(
        'name' => 'email',
        'class' => 'form-control input-lg',
        'placeholder' => 'hello@email.com',
        'data-rule-email' => 'true',
        'data-rule-required' => 'true',
        'data-msg-remote' => elgg_echo('user:email:notfound')
    ));
    ?>
</div>
<?php echo elgg_view('input/captcha'); ?>
<?php echo elgg_view('input/submit', array('value' => elgg_echo('user:password:lost'), 'class'=>'btn btn-primary btn-lg')); ?>