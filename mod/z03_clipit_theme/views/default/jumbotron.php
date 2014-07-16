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
        <p>
            <a class="btn btn-primary btn-lg" href="<?php $CONFIG->wwwroot;?>register" role="button"><?php echo elgg_echo('user:register');?></a>
            <a class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal-login" role="button"><?php echo elgg_echo('user:login');?></a>
        </p>
        <div class="container">
        <!-- Clipit blocks -->
        <div class="row">
            <div class="col-sm-4 bg-red block text-center">
                <div class="arrow">
                    <span class="red"></span>
                </div>
                <img src="<?php echo $vars['img_path'];?>crea.png">
                <h2>Create</h2>
            </div>
            <div class="col-sm-4 bg-yellow block text-center">
                <div class="arrow">
                    <span class="yellow"></span>
                </div>
                <img src="<?php echo $vars['img_path'];?>aprende.png">
                <h2>Learn</h2>
            </div>
            <div class="col-sm-4 bg-blue block text-center">
                <img src="<?php echo $vars['img_path'];?>comparte.png">
                <h2>Share</h2>
            </div>
        </div>
        <!-- Clipit blocks end -->
        </div>
    </div>
</div><!-- Jumbotron end-->