<script>
$(function(){
    // Auto focus, username input
    $('#modal-login').on('shown.bs.modal', function () {
        $('#inputUsername').focus();
    });
});
</script>
<!-- Jumbotron -->
<div class="jumbotron" style="background-image: url(<?php echo $vars['bg_img'];?>)">
    <div class="text-center">
        <h1><?php echo $vars['main_message'];?></h1>
        <p class="slogan">
            <?php echo $vars['second_message'];?>
        </p>
        <p>
            <a class="btn btn-primary btn-lg" href="<?php $CONFIG->wwwroot;?>register" role="button"><?php echo elgg_echo('user:register');?></a>
            <a class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal-login" role="button"><?php echo elgg_echo('user:login');?></a>
        </p>
    </div>
</div><!-- Jumbotron end-->