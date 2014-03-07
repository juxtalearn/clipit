<?php
/**
 * Clipit forgotten password.
 *
 * @package Clipit
 * @subpackage Core
 */
?>
<script>
$(function(){
    $(".elgg-form-user-requestnewpassword").validate({
        errorElement: "span",
        errorPlacement: function(error, element) {
            error.appendTo($("label[for="+element.attr('name')+"]"));
        },
        onkeyup: false,
        onblur: false,
        rules: {
            email: {
                remote: {
                    url: "<?php echo elgg_get_site_url()?>action/user/check",
                    type: "POST",
                    data: {
                        email: function() {
                            return $( "input[name='email']" ).val();
                        },
                        __elgg_token: function() {
                            return $( "input[name='__elgg_token']" ).val();
                        },
                        __elgg_ts: function() {
                            return $( "input[name='__elgg_ts']" ).val();
                        }
                    }
                }
            }
        },
        submitHandler: function(form) {
            $(form).ajaxSubmit(function() {
                $(form).find("input[name=email]").prop("disabled",true);
                $(form).find("input[type=submit]")
                    .after(
                        "<p class='text-info'>" +
                            "<img src='<?php echo elgg_get_site_url()?>mod/clipit_theme/graphics/ok.png'/>" +
                            " <strong>Check your email to confirm your password reset.</strong></p>")
                    .remove();
            })
        }
    });
});
</script>
<div>
    <label for="email"><?php echo elgg_echo('loginusername'); ?></label>
    <?php echo elgg_view('input/text', array(
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