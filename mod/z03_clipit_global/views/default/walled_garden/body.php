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
            <img id="animated_banner" src="<?php echo $images_dir;?>/landing/graphic.gif">
        </div>
        <div class="clipit-message">
            <h1><?php echo elgg_echo('clipit:slogan');?></h1>
            <h4><?php echo elgg_echo('clipit:slogan:description');?></h4>
            <div class="btns">
                <?php echo elgg_view('output/url', array(
                    'href'  => "http://clipit.es/demo",
                    'class' => 'btn clipit-btn',
                    'target' => '_blank',
                    'title' => elgg_echo('try_out'),
                    'text'  => elgg_echo('try_out'),
                ));
                ?>
                <?php echo elgg_view('output/url', array(
                    'href'  => "connect",
                    'class' => 'btn clipit-btn',
                    'title' => elgg_echo('connect'),
                    'text'  => elgg_echo('connect'),
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
                <div class="clipit-slogan-icon animate fadeIn" data-delay="1500" data-icon="3">
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
                <img src="<?php echo $images_dir;?>/landing/section_5.png">
                <div>
                    <h3><span><?php echo elgg_echo('clipit:carrousel:define');?><i></i></span></h3>
                    <p class="blue text-lg"><?php echo elgg_echo('clipit:carrousel:define_rest');?></p>
                </div>
            </div>
            <div class="slide-content" data-cycle-pager-template="<a href=#><img src='<?php echo $images_dir;?>/landing/section_2.png'></a> ">
                <img src="<?php echo $images_dir;?>/landing/section_2.png">
                <div>
                    <h3><span><?php echo elgg_echo('clipit:carrousel:collaborate');?><i></i></span></h3>
                    <p class="blue text-lg"><?php echo elgg_echo('clipit:carrousel:collaborate_rest');?></p>
                </div>
            </div>
            <div class="slide-content" data-cycle-pager-template="<a href=#><img src='<?php echo $images_dir;?>/landing/section_4.png'></a> ">
                <img src="<?php echo $images_dir;?>/landing/section_4.png">
                <div>
                    <h3><span><?php echo elgg_echo('clipit:carrousel:evaluate');?><i></i></span></h3>
                    <p class="blue text-lg"><?php echo elgg_echo('clipit:carrousel:evaluate_rest');?></p>
                </div>
            </div>
            <div class="slide-content" data-cycle-pager-template="<a href=#><img src='<?php echo $images_dir;?>/landing/section_1.png'></a> ">
                <img src="<?php echo $images_dir;?>/landing/section_1.png">
                <div>
                    <h3><span><?php echo elgg_echo('clipit:carrousel:progress');?><i></i></span></h3>
                    <p class="blue text-lg"><?php echo elgg_echo('clipit:carrousel:progress_rest');?></p>
                </div>
            </div>
            <div class="slide-content" data-cycle-pager-template="<a href=#><img src='<?php echo $images_dir;?>/landing/section_3.png'></a> ">
                <img src="<?php echo $images_dir;?>/landing/section_3.png">
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
        <h2 class="text-center">Videos <span>recomendados</span></h2>
        <div class="videos row">
            <div class="main-video col-md-9 margin-bottom-10">
                <div>
                    <a class="cancel-video-view" style="display: none;" href="javascript:;">
                        <i class="fa fa-times"></i>
                    </a>
                    <div id="show-video" class="frame-container" style="display: none;"></div>
                    <div class="preview-video">
                        <div class="details-video">
                            <h3 class="margin-0">Clipit - Learning by teaching</h3>
                            <h4>
                                <a href="http://clipit.es">Create, learn, share</a>
                            </h4>
                        </div>
                        <div class="cursor-pointer play-video" data-video="https://www.youtube.com/watch?v=8lTAdtT1nFc">
                            <div>
                                <div>
                                    <a class="play-button" href="javascript:;">
                                        <i class="fa fa-play"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <img src="http://img.youtube.com/vi/8lTAdtT1nFc/maxresdefault.jpg" class="bg-video">
                    </div>
                    </div>
            </div>
            <div class="col-md-3 row more-videos">
                <div class="col-md-12 col-xs-4 margin-bottom-10" data-video="https://www.youtube.com/watch?v=o5ySYGOo5AI">
                    <a class="thumb-video" href="javascript:;">
                        <div class="bg-play">
                            <div>
                                <i class="fa fa-play-circle-o"></i>
                            </div>
                        </div>
                        <img src="http://img.youtube.com/vi/o5ySYGOo5AI/mqdefault.jpg" style="width: 100%;height: 100%;">
                    </a>
                </div>
                <div class="col-md-12 col-xs-4 margin-bottom-10" data-video="https://www.youtube.com/watch?v=FFZhCcTDMMY">
                    <a class="thumb-video" href="javascript:;">
                        <div class="bg-play">
                            <div>
                                <i class="fa fa-play-circle-o"></i>
                            </div>
                        </div>
                        <img src="http://img.youtube.com/vi/FFZhCcTDMMY/mqdefault.jpg" style="width: 100%;">
                    </a>
                </div>
                <div class="col-md-12 col-xs-4 margin-bottom-10" data-video="https://www.youtube.com/watch?v=Zk9J5xnTVMA">
                    <a class="thumb-video" href="javascript:;">
                        <div class="bg-play">
                            <div>
                                <i class="fa fa-play-circle-o"></i>
                            </div>
                        </div>
                        <img src="http://img.youtube.com/vi/Zk9J5xnTVMA/mqdefault.jpg" style="width: 100%;">
                    </a>
                </div>
                <div class="col-md-12 text-center overflow-hidden">
                    <div class="margin-top-10">
                        <?php echo elgg_view('output/url', array(
                            'href' => 'videos',
                            'class' => 'view-more-videos btn',
                            'text'  => 'Ver más videos',
                            'title' => 'Ver más videos'
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
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
                            'src' => $images_dir . "/social/twitter.png"
                        ))
                    ));
                    ?>
                    <?php echo elgg_view('output/url', array(
                        'href' => $account['facebook'],
                        'target' => '_blank',
                        'text'  => elgg_view('output/img', array(
                            'src' => $images_dir . "/social/facebook.png"
                        ))
                    ));
                    ?>
                    <?php echo elgg_view('output/url', array(
                        'href' => $account['linkedin'],
                        'target' => '_blank',
                        'text'  => elgg_view('output/img', array(
                            'src' => $images_dir . "/social/linkedin.png"
                        ))
                    ));
                    ?>
                    <?php echo elgg_view('output/url', array(
                        'href' => $account['youtube'],
                        'target' => '_blank',
                        'text'  => elgg_view('output/img', array(
                            'src' => $images_dir . "/social/youtube.png"
                        ))
                    ));
                    ?>
                    <?php echo elgg_view('output/url', array(
                        'href' => $account['vimeo'],
                        'target' => '_blank',
                        'text'  => elgg_view('output/img', array(
                            'src' => $images_dir . "/social/vimeo.png"
                        ))
                    ));
                    ?>
                </div>
            </div>
        </div>
    </div><!-- Container mid end-->
</div><!-- Social end-->
