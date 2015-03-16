<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   10/09/14
 * Last update:     10/09/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$images_dir = elgg_extract('images_dir', $vars);
$account = elgg_extract('accounts', $vars);
?>
<!-- Jumbotron -->
<div class="jumbotron clipit-landing">
    <div class="container">
        <div class="pull-right clipit-img">
            <?php echo elgg_view('output/img', array(
                'id' => 'animated_banner',
                'src' => $images_dir . "/landing/graphic.gif",
                'alt' => elgg_echo('clipit:slogan')
            ));
            ?>
        </div>
        <div class="clipit-message">
            <h1><?php echo elgg_echo('clipit:slogan');?></h1>
            <h4><?php echo elgg_echo('clipit:slogan:description');?></h4>
            <div class="btns">
                <?php echo elgg_view('output/url', array(
                    'href'  => "http://clipit.es/demo",
                    'class' => 'btn clipit-btn',
                    'target' => '_blank',
                    'text'  => elgg_echo('try_out'),
                ));
                ?>
                <?php echo elgg_view('output/url', array(
                    'href'  => "sites",
                    'class' => 'btn clipit-btn',
                    'text'  => elgg_echo('sites'),
                ));
                ?>
            </div>
        </div>
    </div>
</div><!-- Jumbotron end-->

<div class="slogan">
    <div class="container">
        <div class="row">
            <div class="col-md-4 text-center">
                <div class="clipit-slogan-icon animate fadeIn" data-delay="100" data-icon="1">
                    <div class="bar bar-right" style="background: #FF2D00;"></div>
                    <div class="icon-circle" style="background-color: #FF2D00;background-image: url('<?php echo $images_dir;?>/landing/create.png');"></div>
                </div>
                <h3 class="blue-dark margin-bottom-15 margin-top-10"><?php echo elgg_echo('clipit:slogan:create');?></h3>
                <p class="blue-dark text-lg"><?php echo elgg_echo('clipit:slogan:create_rest');?></p>
            </div>
            <div class="col-md-4 text-center">
                <div class="clipit-slogan-icon animate fadeIn" data-delay="500" data-icon="2">
                    <div class="bar bar-left" style="background: #D8BA0B;"></div>
                    <div class="bar bar-right" style="background: #D8BA0B;"></div>
                    <div class="icon-circle" style="background-color: #D8BA0B;background-image: url('<?php echo $images_dir;?>/landing/learn.png');"></div>
                </div>
                <h3 class="blue-dark margin-bottom-15 margin-top-10"><?php echo elgg_echo('clipit:slogan:learn');?></h3>
                <p class="blue-dark text-lg"><?php echo elgg_echo('clipit:slogan:learn_rest');?></p>
            </div>
            <div class="col-md-4 text-center">
                <div class="clipit-slogan-icon animate fadeIn" data-delay="1000" data-icon="3">
                    <div class="bar bar-left" style="background: #0999CD;"></div>
                    <div class="icon-circle" style="background-color: #0999CD;background-image: url('<?php echo $images_dir;?>/landing/share.png');"></div>
                </div>
                <h3 class="blue-dark margin-bottom-15 margin-top-10"><?php echo elgg_echo('clipit:slogan:share');?></h3>
                <p class="blue-dark text-lg"><?php echo elgg_echo('clipit:slogan:share_rest');?></p>
            </div>
        </div>
    </div>
</div>
<!-- Slider -->
<div class="bg-triangles" style="background-image: url('<?php echo $images_dir;?>/landing/bg_triangles.png');"></div>
<div class="clipit-slider">
    <div class="container text-center">
        <div class="cycle-slideshow"
             data-cycle-fx=scrollHorz
             data-cycle-pause-on-hover="true"
             data-cycle-slides=">div.slide-content"
             data-cycle-pager="#per-slide-template"
             data-cycle-speed="200"
             data-cycle-timeout=0
             style="height: 400px;"
            >
            <!-- prev/next links -->
            <div class="slideshow-pag cycle-prev">
                <div>
                    <i class="fa fa-arrow-left icon"></i>
                </div>
            </div>
            <div class="slideshow-pag cycle-next">
                <div>
                    <i class="fa fa-arrow-right icon"></i>
                </div>
            </div>
            <div class="slide-content" data-cycle-pager-template="<a href=#><img src='<?php echo $images_dir;?>/landing/section_5.png'></a> ">
                <?php echo elgg_view('output/img', array(
                    'src' => $images_dir . "/landing/section_5.png",
                    'alt' => elgg_echo('clipit:carrousel:define')
                ));
                ?>
                <div>
                    <h3><span><?php echo elgg_echo('clipit:carrousel:define');?><i></i></span></h3>
                    <p class="blue text-lg"><?php echo elgg_echo('clipit:carrousel:define_rest');?></p>
                </div>
            </div>
            <div class="slide-content" data-cycle-pager-template="<a href=#><img src='<?php echo $images_dir;?>/landing/section_2.png'></a> ">
                <?php echo elgg_view('output/img', array(
                        'src' => $images_dir . "/landing/section_2.png",
                        'alt' => elgg_echo('clipit:carrousel:collaborate')
                    ));
                ?>
                <div>
                    <h3><span><?php echo elgg_echo('clipit:carrousel:collaborate');?><i></i></span></h3>
                    <p class="blue text-lg"><?php echo elgg_echo('clipit:carrousel:collaborate_rest');?></p>
                </div>
            </div>
            <div class="slide-content" data-cycle-pager-template="<a href=#><img src='<?php echo $images_dir;?>/landing/section_4.png'></a> ">
                <?php echo elgg_view('output/img', array(
                    'src' => $images_dir . "/landing/section_4.png",
                    'alt' => elgg_echo('clipit:carrousel:evaluate')
                ));
                ?>
                <div>
                    <h3><span><?php echo elgg_echo('clipit:carrousel:evaluate');?><i></i></span></h3>
                    <p class="blue text-lg"><?php echo elgg_echo('clipit:carrousel:evaluate_rest');?></p>
                </div>
            </div>
            <div class="slide-content" data-cycle-pager-template="<a href=#><img src='<?php echo $images_dir;?>/landing/section_1.png'></a> ">
                <?php echo elgg_view('output/img', array(
                    'src' => $images_dir . "/landing/section_1.png",
                    'alt' => elgg_echo('clipit:carrousel:progress')
                ));
                ?>
                <div>
                    <h3><span><?php echo elgg_echo('clipit:carrousel:progress');?><i></i></span></h3>
                    <p class="blue text-lg"><?php echo elgg_echo('clipit:carrousel:progress_rest');?></p>
                </div>
            </div>
            <div class="slide-content" data-cycle-pager-template="<a href=#><img src='<?php echo $images_dir;?>/landing/section_3.png'></a> ">
                <?php echo elgg_view('output/img', array(
                    'src' => $images_dir . "/landing/section_3.png",
                    'alt' => elgg_echo('clipit:carrousel:explore')
                ));
                ?>
                <div>
                    <h3><span><?php echo elgg_echo('clipit:carrousel:explore');?><i></i></span></h3>
                    <p class="blue text-lg"><?php echo elgg_echo('clipit:carrousel:explore_rest');?></p>
                </div>
            </div>
        </div>
        <!-- icons pager -->
        <div id=per-slide-template class="external"></div>
        <!-- icons pager end -->
    </div>
</div>
<!-- Slider end -->
<style>
</style>
<div class="clipit-videos">
    <div class="container">
        <h2 class="text-center"><?php echo elgg_echo('clipit:global:recommended');?></h2>
        <?php echo elgg_view('videos/recommended_videos');?>
    </div>
</div>
<!--Recommended videos-->

<!--Recommended videos end-->

<!--Social -->
<div class="follow-us">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 social-connect text-center">
                <h2><?php echo elgg_echo('follow_us');?></h2>
                <div class="social-icons">
                    <?php echo elgg_view('output/url', array(
                        'href' => $account['twitter'],
                        'target' => '_blank',
                        'text'  => elgg_view('output/img', array(
                            'src' => $images_dir . "/social/twitter.png",
                            'alt' => 'Twitter logo'
                        ))
                    ));
                    ?>
                    <?php echo elgg_view('output/url', array(
                        'href' => $account['facebook'],
                        'target' => '_blank',
                        'text'  => elgg_view('output/img', array(
                            'src' => $images_dir . "/social/facebook.png",
                            'alt' => 'Facebook logo'
                        ))
                    ));
                    ?>
                    <?php echo elgg_view('output/url', array(
                        'href' => $account['linkedin'],
                        'target' => '_blank',
                        'text'  => elgg_view('output/img', array(
                            'src' => $images_dir . "/social/linkedin.png",
                            'alt' => 'Linkedin logo'
                        ))
                    ));
                    ?>
                    <?php echo elgg_view('output/url', array(
                        'href' => $account['youtube'],
                        'target' => '_blank',
                        'text'  => elgg_view('output/img', array(
                            'src' => $images_dir . "/social/youtube.png",
                            'alt' => 'Youtube logo'
                        ))
                    ));
                    ?>
                    <?php echo elgg_view('output/url', array(
                        'href' => $account['vimeo'],
                        'target' => '_blank',
                        'text'  => elgg_view('output/img', array(
                            'src' => $images_dir . "/social/vimeo.png",
                            'alt' => 'Vimeo logo'
                        ))
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div><!-- Container mid end-->
</div><!-- Social end-->
