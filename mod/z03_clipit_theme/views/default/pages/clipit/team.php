<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   28/07/14
 * Last update:     28/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$images_dir = "mod/z03_clipit_theme/graphics/team/";
?>
<style>
.author-text{
    font-size: 12px;
    text-transform: uppercase;
    font-family: FuturaBoldRegular, Impact, 'Impact Bold', Helvetica, Arial, sans, sans-serif;
    color: inherit;
}
.author-description{
    font-size: 20px;
}
.twitter-color{
    color: #33CCFF;
}
.linkedin-color{
    color: #4875B4;
}
.youtube-color{
    color: #FF3333;
}
</style>
<div class="row margin-bottom-20">
    <div class="col-md-3 text-center">
        <?php echo elgg_view('output/img', array(
            'src' => "{$images_dir}llinas.png",
            'class' => 'img-circle'
        ));
        ?>
        <div class="margin-top-10 blue">
            <a class="author-text">Estefanía Martín</a>
            <i class="show">Lead investigator</i>
            <i class="show fa fa-chevron-down author-description"></i>
        </div>
    </div>
    <div class="col-md-3 text-center">
        <?php echo elgg_view('output/img', array(
            'src' => "{$images_dir}llinas.png",
            'class' => 'img-circle'
        ));
        ?>
        <div class="margin-top-10 blue">
            <a class="author-text">Pablo llinás</a>
            <i class="show">Technical Project Manager</i>
            <i class="show fa fa-chevron-down author-description"></i>
        </div>
    </div>
    <div class="col-md-3 text-center">
        <?php echo elgg_view('output/img', array(
            'src' => "{$images_dir}miguel.png",
            'class' => 'img-circle'
        ));
        ?>
        <div class="margin-top-10 blue">
            <a class="author-text">Miguel A. Gutiérrez</a>
            <i class="show">Senior Web Developer</i>
            <i class="show fa fa-chevron-down author-description"></i>
        </div>
    </div>
    <div class="col-md-3 text-center">
        <?php echo elgg_view('output/img', array(
            'src' => "{$images_dir}isi.png",
            'class' => 'img-circle'
        ));
        ?>
        <div class="margin-top-10 blue">
            <a class="author-text">Isidoro Hernán</a>
            <i class="show">Researcher</i>
            <i class="show fa fa-chevron-down author-description"></i>
        </div>
    </div>
</div>
<div class="row margin-bottom-20">
    <div class="col-md-3 text-center">
        <?php echo elgg_view('output/img', array(
            'src' => "{$images_dir}jaime.png",
            'class' => 'img-circle'
        ));
        ?>
        <div class="margin-top-10 yellow">
            <a class="author-text">Jaime Urquiza</a>
            <i class="show">Researcher</i>
            <i class="show fa fa-chevron-down author-description"></i>
        </div>
    </div>
    <div class="col-md-3 text-center">
        <?php echo elgg_view('output/img', array(
            'src' => "{$images_dir}manuel.png",
            'class' => 'img-circle'
        ));
        ?>
        <div class="margin-top-10 yellow">
            <a class="author-text">Manuel Gertrudix</a>
            <i class="show">Researcher</i>
            <i class="show fa fa-chevron-down author-description"></i>
        </div>
    </div>
    <div class="col-md-3 text-center">
        <?php echo elgg_view('output/img', array(
            'src' => "{$images_dir}manuel.png",
            'class' => 'img-circle'
        ));
        ?>
        <div class="margin-top-10 yellow">
            <a class="author-text">Gemma de Castro</a>
            <i class="show">Graphic Designer</i>
            <i class="show fa fa-chevron-down author-description"></i>
        </div>
    </div>
    <div class="col-md-3 text-center">
        <?php echo elgg_view('output/img', array(
            'src' => "{$images_dir}manuel.png",
            'class' => 'img-circle'
        ));
        ?>
        <div class="margin-top-10 yellow">
            <a class="author-text">Pablo A. Haya</a>
            <i class="show">Research Advisor</i>
            <i class="show fa fa-chevron-down author-description"></i>
        </div>
    </div>
</div>
<div class="row margin-bottom-20">
    <div class="col-md-3 text-center">
        <?php echo elgg_view('output/img', array(
            'src' => "{$images_dir}jorge.png",
            'class' => 'img-circle'
        ));
        ?>
        <div class="margin-top-10 red">
            <a class="author-text">Jorge J. Castellanos</a>
            <i class="show">Technical Advisor</i>
            <span class="fa-stack fa-md">
                <i class="fa fa-circle twitter-color fa-stack-2x"></i>
                <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
            </span>
            <span class="fa-stack fa-md">
                <i class="fa fa-circle youtube-color fa-stack-2x"></i>
                <i class="fa fa-youtube fa-stack-1x fa-inverse"></i>
            </span>
            <span class="fa-stack fa-md">
                <i class="fa fa-circle linkedin-color fa-stack-2x"></i>
                <i class="fa fa-linkedin fa-stack-1x fa-inverse"></i>
            </span>
            <i class="show fa fa-chevron-down author-description"></i>
        </div>
    </div>
</div>
<div class="row" style="background: #32b4e5;padding: 20px;">
    <h2 class="white">Intership</h2>
    <div class="col-md-3 text-center">
        <div style="width: 150px; height: 150px;background: #bae6f6;border-radius: 100px;margin: 0 auto;"></div>
        <div class="margin-top-10 white">
            <a class="author-text">Virginia del Castillo</a>
            <i class="show">Intership</i>
            <i class="show fa fa-chevron-down author-description"></i>
        </div>
    </div>
    <div class="col-md-3 text-center">
        <div style="width: 150px; height: 150px;background: #bae6f6;border-radius: 100px;margin: 0 auto;"></div>
        <div class="margin-top-10 white">
            <a class="author-text">Virginia del Castillo</a>
            <i class="show">Intership</i>
            <i class="show fa fa-chevron-down author-description"></i>
        </div>
    </div>
    <div class="col-md-3 text-center">
        <div style="width: 150px; height: 150px;background: #bae6f6;border-radius: 100px;margin: 0 auto;"></div>
        <div class="margin-top-10 white">
            <a class="author-text">Virginia del Castillo</a>
            <i class="show">Intership</i>
            <i class="show fa fa-chevron-down author-description"></i>
        </div>
    </div>
    <div class="col-md-3 text-center">
        <div style="width: 150px; height: 150px;background: #bae6f6;border-radius: 100px;margin: 0 auto;"></div>
        <div class="margin-top-10 white">
            <a class="author-text">Virginia del Castillo</a>
            <i class="show">Intership</i>
            <i class="show fa fa-chevron-down author-description"></i>
        </div>
    </div>
</div>