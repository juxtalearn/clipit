<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract("entity", $vars);
$videos = ClipitActivity::get_videos($entity->id);
$rating = "blabla";
$content = elgg_view('multimedia/video/list', array(
    'entity'    => $entity,
    'videos'    => $videos,
    'href'      => "clipit_activity/74/publications",
    'rating'    => $rating
));
echo $content;
?>
<div class="row" style="
    margin-bottom: 10px;
    border-bottom: 1px solid #bae6f6;
    padding-bottom: 10px;
">
    <a href="">
        <div class="col-lg-4">
            <div style="
    position: relative;
"><div style="
    position: absolute;
    margin: 10px;
    z-index: 2;
"><div class="rating" style="
    color: #e7d333;
    border-radius: 3px;
    background: rgba(0,0,0,0.3);
    padding: 0 5px;
    font-size: 12px;
    display: inline-block;
">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-half-o"></i>
                        <i class="fa fa-star-o"></i>
                    </div>
                </div><img src="http://b.vimeocdn.com/ts/346/458/346458615_640.jpg" style="
    width: 100%;
"><span class="label" style="
    background: rgba(0,0,0,0.5);
    border-radius: 2px;
    color: #fff;
    border: 0;
    margin-top: 5px;
    bottom: 0;
    position: absolute;
    right: 0;
    margin: 5px;
">3:45</span></div>



        </div>
    </a>
    <div class="col-lg-8">
        <h4 class="text-truncate" style="
    margin: 0;
"><a href="" style="
    font-weight: bold;
">Lorem ipsum dolor sit amet, consectetur adipiscing elit. </a></h4><div style="
    margin: 5px 0;
">

            <span class="label label-primary" style="
    display: inline-block;
    color: #97bf0d;
    border: 1px solid #97bf0d;
">Gravitación universal y campo gravitatorio</span>

<span class="label label-primary" style="
    display: inline-block;
    color: #97bf0d;  border: 1px solid #97bf0d;
">Trabajo y Potencia</span> <span class="label label-primary" style="
    display: inline-block;
    color: #97bf0d;  border: 1px solid #97bf0d;
">Cinética</span></div><div style="
    color: #666666;
    height: 65px;
    overflow: hidden;
">
            Echando un vistazo al grupo, he visto que el tema sobre el que tenemos que hablar es Flexibilidad - Capacidad de personalización... os agradecería si fueseis capaces de darnos una breve explicación de qué es exactamente ese concepto porque supongo que es algo que estáis dando en vuestra asignatura.
        </div><div style="
    margin-top: 8px;
">
            <small>Created by <a href="http://juxtalearn.org/sandbox/clipit_befe/profile/" title="Mario Sanchez" rel="nofollow">Los manolos</a><span style="
    float: right;
">
<a> 10 <i class="fa fa-comment"></i></a> <abbr title="11 April 2014 @ 10:56am" style="
">12 days ago</abbr></span>
            </small>
        </div>
    </div>
</div>
<!-- -->
<div class="row" style="
    margin-bottom: 10px;
    border-bottom: 1px solid #bae6f6;
    padding-bottom: 10px;
">
    <div style="
    position: relative;
" class="col-lg-4">
  <span class="label label-primary" style="
    position:absolute;
    margin: 10px;
    background: rgba(0,0,0,0.3);  border-radius: 4px;
    color: #fff;
    border: 0;
">2/18 comments</span>

        <img src="http://b.vimeocdn.com/ts/432/509/432509421_640.jpg" style="
    width: 100%;
">
    </div>
    <div class="col-lg-8">
        <h4 style="
    margin: 0;
"><a style="
    font-weight: bold;
">Lorem ipsum dolor sit amet, consectetur adipiscing elit. </a></h4><div style="
    margin: 5px 0;
">

            <div class="rating" style="
    color: #e7d333;
    float: right;
    border-radius: 3px;
    background: #f1f2f7;
    padding: 0 5px;
">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-half-o"></i>
                <i class="fa fa-star-o"></i>
            </div><span class="label label-primary" style="
    display: inline-block;
    color: #97bf0d;
    border: 1px solid #97bf0d;
">lorem ipsum</span>

<span class="label label-primary" style="
    display: inline-block;
    color: #97bf0d;  border: 1px solid #97bf0d;
">Stumbling</span> <span class="label label-primary" style="
    display: inline-block;
    color: #97bf0d;  border: 1px solid #97bf0d;
">Cinética</span></div><div style="
    color: #666666;
    height: 65px;
    overflow: hidden;
">
            Echando un vistazo al grupo, he visto que el tema sobre el que tenemos que hablar es Flexibilidad - Capacidad de personalización... os agradecería si fueseis capaces de darnos una breve explicación de qué es exactamente ese concepto porque supongo que es algo que estáis dando en vuestra asignatura.
        </div><div style="
    margin-top: 8px;
">
            <small>Created by <a href="http://juxtalearn.org/sandbox/clipit_befe/profile/" title="Mario Sanchez" rel="nofollow">Los manolos</a><span style="
    float: right;
">
<a> 10 <i class="fa fa-comment"></i></a> <abbr title="11 April 2014 @ 10:56am" style="
">12 days ago</abbr></span>
            </small>
        </div>
    </div>
</div>
<!-- -->
<div class="row" style="
    margin-bottom: 10px;
    border-bottom: 1px solid #bae6f6;
    padding-bottom: 10px;
">
    <div style="
    position: relative;
" class="col-lg-4">
  <span class="label label-primary" style="
    position:absolute;
    margin: 10px;
    background: rgba(0,0,0,0.3);  border-radius: 4px;
    color: #fff;
    border: 0;
">2/18 comments</span>

        <img src="https://i1.ytimg.com/vi/hgl-yDvA8vs/mqdefault.jpg" style="
    width: 100%;
">
    </div>
    <div class="col-lg-8">
        <h4 style="
    margin: 0;
"><a style="
    font-weight: bold;
">Lorem ipsum dolor sit amet, consectetur adipiscing elit. </a></h4><div style="
    margin: 5px 0;
">

            <div class="rating" style="
    color: #e7d333;
    float: right;
    border-radius: 3px;
    background: #f1f2f7;
    padding: 0 5px;
">
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star"></i>
                <i class="fa fa-star-half-o"></i>
                <i class="fa fa-star-o"></i>
            </div><span class="label label-primary" style="
    display: inline-block;
    color: #97bf0d;
    border: 1px solid #97bf0d;
">lorem ipsum</span>

<span class="label label-primary" style="
    display: inline-block;
    color: #97bf0d;  border: 1px solid #97bf0d;
">Stumbling</span> <span class="label label-primary" style="
    display: inline-block;
    color: #97bf0d;  border: 1px solid #97bf0d;
">Cinética</span></div><div style="
    color: #666666;
    height: 65px;
    overflow: hidden;
">
            Echando un vistazo al grupo, he visto que el tema sobre el que tenemos que hablar es Flexibilidad - Capacidad de personalización... os agradecería si fueseis capaces de darnos una breve explicación de qué es exactamente ese concepto porque supongo que es algo que estáis dando en vuestra asignatura.
        </div><div style="
    margin-top: 8px;
">
            <small>Created by <a href="http://juxtalearn.org/sandbox/clipit_befe/profile/" title="Mario Sanchez" rel="nofollow">Los manolos</a><span style="
    float: right;
">
<a> 10 <i class="fa fa-comment"></i></a> <abbr title="11 April 2014 @ 10:56am" style="
">12 days ago</abbr></span>
            </small>
        </div>
    </div>
</div>