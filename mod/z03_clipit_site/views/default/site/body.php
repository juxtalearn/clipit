<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   10/09/14
 * Last update:     10/09/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$images_dir = elgg_extract('images_dir', $vars);
$account = elgg_extract('accounts', $vars);
?>
<!-- Login modal box -->
<?php echo elgg_view('walled_garden/login_box');?>
<!-- Login modal box end -->
<script>
    $(function(){
        // Auto focus, username input
        $('#modal-login').on('shown.bs.modal', function () {
            $('#input-login').focus();
        });
    });
</script>
<!-- Jumbotron -->
<div class="jumbotron" style="background-image: url('<?php echo $images_dir;?>/bg_img.jpg')">
    <div class="text-center">
        <h1><?php echo elgg_echo('clipit:slogan');?></h1>
        <p>
            <?php if (elgg_get_config('allow_registration')): ?>
            <?php echo elgg_view('output/url', array(
                'href'  => "register",
                'role' => 'button',
                'class' => 'btn btn-primary btn-lg',
                'text'  => elgg_echo('user:register')
            ));
            ?>
            <?php endif;?>
            <?php echo elgg_view('output/url', array(
                'role' => 'button',
                'class' => 'btn btn-primary btn-lg',
                'data-toggle' => 'modal',
                'data-target' => '#modal-login',
                'text'  => elgg_echo('user:login')
            ));
            ?>
        </p>
        <div class="container">
            <!-- Clipit blocks -->
            <div class="row">
                <div class="col-sm-4 bg-red block text-center">
                    <div class="arrow">
                        <span class="red"></span>
                    </div>
                    <img alt="<?php echo elgg_echo('clipit:slogan:create');?>" src="<?php echo $images_dir;?>crea.png">
                    <h2><?php echo elgg_echo('clipit:slogan:create');?></h2>
                </div>
                <div class="col-sm-4 bg-yellow block text-center">
                    <div class="arrow">
                        <span class="yellow"></span>
                    </div>
                    <img alt="<?php echo elgg_echo('clipit:slogan:learn');?>" src="<?php echo $images_dir;?>aprende.png">
                    <h2><?php echo elgg_echo('clipit:slogan:learn');?></h2>
                </div>
                <div class="col-sm-4 bg-blue block text-center">
                    <img alt="<?php echo elgg_echo('clipit:slogan:share');?>" src="<?php echo $images_dir;?>comparte.png">
                    <h2><?php echo elgg_echo('clipit:slogan:share');?></h2>
                </div>
            </div>
            <!-- Clipit blocks end -->
        </div>
    </div>
</div><!-- Jumbotron end-->
<div class="container">
    <!-- Social -->
    <div class="row">
        <div class="col-sm-12 social-connect text-center">
            <h2><?php echo elgg_echo('follow_us');?></h2>
            <div class="social-icons">
                <?php echo elgg_view('output/url', array(
                    'href' => $account['twitter'],
                    'target' => '_blank',
                    'text'  => elgg_view('output/img', array(
                        'src' => $images_dir . "social/twitter.png",
                        'alt' => "Twitter",
                    ))
                ));
                ?>
                <?php echo elgg_view('output/url', array(
                    'href' => $account['facebook'],
                    'target' => '_blank',
                    'text'  => elgg_view('output/img', array(
                        'src' => $images_dir . "social/facebook.png",
                        'alt' => "Facebook",
                    ))
                ));
                ?>
                <?php echo elgg_view('output/url', array(
                    'href' => $account['linkedin'],
                    'target' => '_blank',
                    'text'  => elgg_view('output/img', array(
                        'src' => $images_dir . "social/linkedin.png",
                        'alt' => "Linkedin",
                    ))
                ));
                ?>
                <?php echo elgg_view('output/url', array(
                    'href' => $account['youtube'],
                    'target' => '_blank',
                    'text'  => elgg_view('output/img', array(
                        'src' => $images_dir . "social/youtube.png",
                        'alt' => "Youtube",
                    ))
                ));
                ?>
            </div>
        </div>
    </div><!-- Social end-->
</div><!-- Container mid end-->
