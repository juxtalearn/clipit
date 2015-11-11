<?php
$context = elgg_get_context();
$url = $CONFIG->url;
$images_dir = elgg_extract('images_dir', $vars);
?>
<nav class="navbar navbar-default" id="navbar-sticky" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <?php echo elgg_view('output/url', array(
                'href' => "/",
                'class' => 'navbar-brand',
                'title' => 'Clipit '. elgg_echo("home"),
                'text'  => elgg_view('output/img', array(
                    'src' => $images_dir . "/icons/clipit_logo.png"
                ))
            ));
            ?>
        </div>
        <div class="collapse navbar-collapse" id="bs-navbar-collapse">
            <ul class="nav navbar-nav navbar-right top-account">
                <?php echo elgg_view("navigation/menu/walled_garden");?>
            </ul>
        </div>
    </div>
</nav>