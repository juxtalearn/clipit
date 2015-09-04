<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/02/2015
 * Last update:     23/02/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$videos = elgg_extract('entities', $vars);
?>
<div class="row" style="display: none;">
    <div class="col-md-8">
        <div class="row hm">
            <?php for($i=0; $i<15; $i++):?>
                <div class="col-md-12 margin-bottom-10 xs">
                    <div style="background: #ccc;height: 390px;"></div>
                </div>
                <div class="col-md-6">
                    <div style="background: #ccc;height: 325px;"></div>
                </div>
                <div class="col-md-6">
                    <div style="background: #ccc;height: 325px;"></div>
                </div>
                <div class="col-md-12 margin-top-10">
                    <div style="background: #ccc;height: 139px;"></div>
                </div>
            <?php endfor;?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="row sec">
            <?php for($i=0; $i<15; $i++):?>
                <div class="col-md-12 margin-bottom-10">
                    <div style="background: #ccc;height: 257px;"></div>
                </div>
                <div class="col-md-12 margin-bottom-10">
                    <div style="background: #ccc;height: 257px;"></div>
                </div>
                <div class="col-md-12 margin-bottom-10">
                    <div style="background: #ccc;height: 257px;"></div>
                </div>
                <div class="col-md-12 margin-bottom-10">
                    <div style="background: #ccc;height: 257px;"></div>
                </div>
            <?php endfor;?>
        </div>
    </div>
</div>
<script>
    $(function(){
        $('.structure').each(function(){
            num = $(this).data('num');
            $element = $(this);
            $col_main = $element.closest('.video-list').find('.col-main .row');
            $col_secondary = $element.closest('.video-list').find('.col-secondary .row');
            switch(num){
                case 1:
                    if($element.hasClass('first')) {
                        $element.wrap('<div class="col-md-8 col-main"><div class="row"></div></div>');
                        $element.addClass('col-md-12 margin-bottom-10');
                    } else {
                        $col_main.append(
                            $element.addClass('col-md-12 margin-bottom-10')
                        );
                    }
                    break;
                case 2:
                    if($element.hasClass('first')) {
                        $element.wrap('<div class="col-md-4 col-secondary"><div class="row"></div></div>');
                        $element.addClass('col-md-12 margin-bottom-10');
                    } else {
                        $col_secondary.append(
                            $element.addClass('col-md-12 margin-bottom-10')
                        );
                    }
                    break;
                case 3:
                case 4:
                    $col_main.append(
                        $element.addClass('col-md-6 margin-bottom-10')
                    );
                    break;
                case 5:
                case 6:
                    $col_secondary.append(
                        $element.addClass('col-md-12 margin-bottom-10')
                    );
                    break;
                case 7:
                    $col_main.append(
                        $element.addClass('col-md-12 margin-bottom-10')
                    );
                    break;
                case 8:
                    $col_secondary.append(
                        $element.addClass('col-md-12 margin-bottom-10')
                    );
                    break;
                default:
                    $element.hide();
            }
        });
    });
</script>
<div class="row video-listXX hide">
<div data-num="1" class="structure first">
    <div class="video-wrapper bg-color">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/lEDILlButjo/hqdefault.jpg');">
                <a href="http://clipit.es/landing/video/mrs-mole/546" class="thumb-video" title="Mrs Mole" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/lEDILlButjo/hqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h2 class="text-truncate margin-0 margin-bottom-10">
                <a href="http://clipit.es/landing/video/mrs-mole/546" style="color:white;" title="Mrs Mole" rel="nofollow">Mrs Mole</a>
            </h2> <small class="date">
                <i>Jul 24, 2015 17:31</i>
            </small>
            <p class="margin-top-5">
                This video illustrates how one mole of one substance is different from one mole of another using plasticene figures. It then uses the figures to demonstrate how to apply equations. </p>
        </div>
    </div>
</div>
<div data-num="2" class="structure first">
    <div class="video-wrapper element-item height2">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/LQRz5itVv9A/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/group-chat-titration-equations-for-moles/545" class="thumb-video" title="Group Chat - Titration Equations for Moles" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/LQRz5itVv9A/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/group-chat-titration-equations-for-moles/545" style="color:inherit;" title="Group Chat - Titration Equations for Moles" rel="nofollow">Group Chat - Titration Equations for Moles</a>
            </h3> <small class="date">
                <i>Jul 24, 2015 17:21</i>
            </small>
            <p class="margin-top-5">
                This video uses a group chat metaphor to explore which&nbsp;formula to use to work out how many moles of acid in a titration reaction with an alkali of a given volume.&nbsp; </p>
        </div>
    </div>
</div>
<div data-num="3" class="structure first">
    <div class="video-wrapper element-item height2">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/lEDILlButjo/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/mrs-mole/544" class="thumb-video" title="Mrs Mole" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/lEDILlButjo/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/mrs-mole/544" style="color:inherit;" title="Mrs Mole" rel="nofollow">Mrs Mole</a>
            </h3> <small class="date">
                <i>Jul 24, 2015 17:20</i>
            </small>
            <p class="margin-top-5">
                This video illustrates how one mole of one substance is different from one mole of another using plastecene figures. It then uses the figures to de... </p>
        </div>
    </div>
</div>
<div data-num="4" class="structure first">
    <div class="video-wrapper element-item height2">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/I9oxKR6grDU/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/square-root-beats-the-bully/538" class="thumb-video" title="Square Root beats the bully" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/I9oxKR6grDU/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/square-root-beats-the-bully/538" style="color:inherit;" title="Square Root beats the bully" rel="nofollow">Square Root beats the bully</a>
            </h3> <small class="date">
                <i>Jul 23, 2015 15:21</i>
            </small>
            <p class="margin-top-5">
                In this juxtaposed video, the square root is born into a family and goes to school. There he gets bullied by a big number 9. He goes off and lifts ... </p>
        </div>
    </div>
</div>
<div data-num="5" class="structure first">
    <div class="video-wrapper element-item width2 horizontal-view">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/Qjz42jGB0AQ/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/pizza-power/537" class="thumb-video" title="Pizza Power" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/Qjz42jGB0AQ/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/pizza-power/537" style="color:inherit;" title="Pizza Power" rel="nofollow">Pizza Power</a>
            </h3> <small class="date">
                <i>Jul 23, 2015 15:20</i>
            </small>
            <p class="margin-top-5">
                Five people need to build their strength in order to combat a monster. They buy 4 pizzas and need to share them between the five people. Revived by their pizza, they enjoy a gory battle with the monster. </p>
        </div>
    </div>
</div>
<div data-num="6" class="structure first">
    <div class="video-wrapper ">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/zs-W783mgR0/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/super-third/536" class="thumb-video" title="Super Third" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/zs-W783mgR0/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/super-third/536" style="color:inherit;" title="Super Third" rel="nofollow">Super Third</a>
            </h3> <small class="date">
                <i>Jul 23, 2015 15:20</i>
            </small>
            <p class="margin-top-5">
                The party could be a flop because there was not enough pizza to go around. Super Third comes to the rescue and explains how to divide by a fraction. </p>
        </div>
    </div>
</div>
<div data-num="7" class="structure first">
    <div class="video-wrapper element-item height2">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/wwZOeD_x60s/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/division-ghost-busters/535" class="thumb-video" title="Division Ghost Busters" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/wwZOeD_x60s/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/division-ghost-busters/535" style="color:inherit;" title="Division Ghost Busters" rel="nofollow">Division Ghost Busters</a>
            </h3> <small class="date">
                <i>Jul 23, 2015 15:20</i>
            </small>
            <p class="margin-top-5">
                Ghosts are invading. The only way to stop them is to call in the Ghost Busters who must divide in order to beat the ghosts. </p>
        </div>
    </div>
</div>
<div data-num="8" class="structure first">
    <div class="video-wrapper element-item height2">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/EMSE0XbS3jk/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/slug-division/534" class="thumb-video" title="Slug Division" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/EMSE0XbS3jk/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/slug-division/534" style="color:inherit;" title="Slug Division" rel="nofollow">Slug Division</a>
            </h3> <small class="date">
                <i>Jul 23, 2015 15:20</i>
            </small>
            <p class="margin-top-5">
                Slug-eating creatures need to divide&nbsp;a slug between them in order to beat the monster. </p>
        </div>
    </div>
</div>
<div data-num="1" class="structure ">
    <div class="video-wrapper bg-color">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/KXshZEeN9wc/hqdefault.jpg');">
                <a href="http://clipit.es/landing/video/pizza-problemo/533" class="thumb-video" title="Pizza Problemo" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/KXshZEeN9wc/hqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h2 class="text-truncate margin-0 margin-bottom-10">
                <a href="http://clipit.es/landing/video/pizza-problemo/533" style="color:white;" title="Pizza Problemo" rel="nofollow">Pizza Problemo</a>
            </h2> <small class="date">
                <i>Jul 23, 2015 15:20</i>
            </small>
            <p class="margin-top-5">
                Party characters need to divide the pizza by a fraction in order to share it between them. Listen carefully&nbsp;as the maths is explained through&nbsp;a well-known rap. </p>
        </div>
    </div>
</div>
<div data-num="2" class="structure ">
    <div class="video-wrapper element-item height2">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/Ziikx6hICWg/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/pizza-power/531" class="thumb-video" title="Pizza Power" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/Ziikx6hICWg/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/pizza-power/531" style="color:inherit;" title="Pizza Power" rel="nofollow">Pizza Power</a>
            </h3> <small class="date">
                <i>Jul 20, 2015 18:05</i>
            </small>
            <p class="margin-top-5">
                Video to explain division created by Yr7 students of Radcliffe School MK during a workshop visit to the Open University. </p>
        </div>
    </div>
</div>
<div data-num="3" class="structure ">
    <div class="video-wrapper element-item height2">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/apE5rPJ91Gk/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/mushroom-maths/527" class="thumb-video" title="Mushroom Maths" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/apE5rPJ91Gk/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/mushroom-maths/527" style="color:inherit;" title="Mushroom Maths" rel="nofollow">Mushroom Maths</a>
            </h3> <small class="date">
                <i>Jul 09, 2015 15:13</i>
            </small>
            <p class="margin-top-5">
                Players need to share mushrooms equally in order to get strength to defeat the monster.&nbsp; </p>
        </div>
    </div>
</div>
<div data-num="4" class="structure ">
    <div class="video-wrapper element-item height2">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/CMiQbb9VLk4/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/sports-day-maths/526" class="thumb-video" title="Sports Day Maths" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/CMiQbb9VLk4/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/sports-day-maths/526" style="color:inherit;" title="Sports Day Maths" rel="nofollow">Sports Day Maths</a>
            </h3> <small class="date">
                <i>Jul 09, 2015 15:13</i>
            </small>
            <p class="margin-top-5">
                Players need to do division in order to work out who plays the games on sports day and to share out water between them when they get thirsty after ... </p>
        </div>
    </div>
</div>
<div data-num="5" class="structure ">
    <div class="video-wrapper element-item width2 horizontal-view">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/nZpaxFjzF3s/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/the-adventure-of-the-remainders/525" class="thumb-video" title="The Adventure of the Remainders" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/nZpaxFjzF3s/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/the-adventure-of-the-remainders/525" style="color:inherit;" title="The Adventure of the Remainders" rel="nofollow">The Adventure of the Remainders</a>
            </h3> <small class="date">
                <i>Jul 09, 2015 15:12</i>
            </small>
            <p class="margin-top-5">
                How to share people fairly between people-eating monsters </p>
        </div>
    </div>
</div>
<div data-num="6" class="structure ">
    <div class="video-wrapper ">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/Z_h1xtelnHY/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/horse-jump-division/524" class="thumb-video" title="Horse Jump Division" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/Z_h1xtelnHY/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/horse-jump-division/524" style="color:inherit;" title="Horse Jump Division" rel="nofollow">Horse Jump Division</a>
            </h3> <small class="date">
                <i>Jul 09, 2015 15:12</i>
            </small>
            <p class="margin-top-5">
                Division using horse jumps </p>
        </div>
    </div>
</div>
<div data-num="7" class="structure ">
    <div class="video-wrapper element-item height2">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/f9memWTcoSQ/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/pizza/523" class="thumb-video" title="Pizza" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/f9memWTcoSQ/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/pizza/523" style="color:inherit;" title="Pizza" rel="nofollow">Pizza</a>
            </h3> <small class="date">
                <i>Jul 09, 2015 15:11</i>
            </small>
            <p class="margin-top-5">
                Mr Remainder comes to the rescue to avoid sharing out the pizza unfairly. </p>
        </div>
    </div>
</div>
<div data-num="8" class="structure ">
    <div class="video-wrapper element-item height2">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/dndxS2WFWIc/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/times-10-tunnel/522" class="thumb-video" title="Times 10 tunnel" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/dndxS2WFWIc/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/times-10-tunnel/522" style="color:inherit;" title="Times 10 tunnel" rel="nofollow">Times 10 tunnel</a>
            </h3> <small class="date">
                <i>Jul 09, 2015 15:11</i>
            </small>
            <p class="margin-top-5">
                As remainder passengers cannot fit on the bus, the bus goes through the times 10 tunnel to&nbsp;make room for the remainders. </p>
        </div>
    </div>
</div>
<div data-num="1" class="structure ">
    <div class="video-wrapper bg-color">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/8Nr_16sPZCA/hqdefault.jpg');">
                <a href="http://clipit.es/landing/video/bus-stop-division/521" class="thumb-video" title="Bus Stop Division" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/8Nr_16sPZCA/hqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h2 class="text-truncate margin-0 margin-bottom-10">
                <a href="http://clipit.es/landing/video/bus-stop-division/521" style="color:white;" title="Bus Stop Division" rel="nofollow">Bus Stop Division</a>
            </h2> <small class="date">
                <i>Jul 09, 2015 15:10</i>
            </small>
            <p class="margin-top-5">
                Bus returns with different numbers of seats to collect remainder people from the remainder bench. </p>
        </div>
    </div>
</div>
<div data-num="2" class="structure ">
    <div class="video-wrapper element-item height2">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('');">
                <a href="http://clipit.es/landing/video/estilos-de-aprendizagem/517" class="thumb-video" title="Estilos de aprendizagem" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/estilos-de-aprendizagem/517" style="color:inherit;" title="Estilos de aprendizagem" rel="nofollow">Estilos de aprendizagem</a>
            </h3> <small class="date">
                <i>Jul 03, 2015 15:37</i>
            </small>
            <p class="margin-top-5">
                Teorias de Kolb, Felder, VARK </p>
        </div>
    </div>
</div>
<div data-num="3" class="structure ">
    <div class="video-wrapper element-item height2">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/v7Gu-qKf4R8/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/posibilidades-didacticas-del-modelo-flipped-classroom-como-metodologia-docente-que-incorpora-el-uso-de-las-tic/513" class="thumb-video" title="Posibilidades didácticas del modelo Flipped Classroom como metodología docente que incorpora el uso de las TIC." rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/v7Gu-qKf4R8/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/posibilidades-didacticas-del-modelo-flipped-classroom-como-metodologia-docente-que-incorpora-el-uso-de-las-tic/513" style="color:inherit;" title="Posibilidades didácticas del modelo Flipped Classroom como metodología docente que incorpora el uso de las TIC." rel="nofollow">Posibilidades didácticas del modelo Flipped Classroom como metodología docente que incorpora el uso de las TIC.</a>
            </h3> <small class="date">
                <i>Jun 10, 2015 12:16</i>
            </small>
            <p class="margin-top-5">
                Trabajo de Investigación sobre las posibilidades didácticas del modelo Flipped Classroom como metodología docente que incorpor... </p>
        </div>
    </div>
</div>
<div data-num="4" class="structure ">
    <div class="video-wrapper element-item height2">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/QHI8i0jqayE/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/%C2%BFcuales-son-los-beneficios-del-uso-de-la-gamificacion-en-aulas-de-educacion-primaria/511" class="thumb-video" title="¿Cuáles son los beneficios del uso de la Gamificación en aulas de Educación Primaria?" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/QHI8i0jqayE/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/%C2%BFcuales-son-los-beneficios-del-uso-de-la-gamificacion-en-aulas-de-educacion-primaria/511" style="color:inherit;" title="¿Cuáles son los beneficios del uso de la Gamificación en aulas de Educación Primaria?" rel="nofollow">¿Cuáles son los beneficios del uso de la Gamificación en aulas de Educación Primaria?</a>
            </h3> <small class="date">
                <i>Jun 10, 2015 12:14</i>
            </small>
            <p class="margin-top-5">
                Vídeo realizado por los alumnos de Educación primaria de la URJC.Proyecto de investigación para la asignatura Metodolog&amp;ia... </p>
        </div>
    </div>
</div>
<div data-num="5" class="structure ">
    <div class="video-wrapper element-item width2 horizontal-view">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/WEsZcjHGhGs/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/metodologias-docentes-que-incorporan-el-uso-de-las-tic-que-tratan-los-elementos-transversales/505" class="thumb-video" title="Metodologías docentes que incorporan el uso de las TIC que tratan los elementos transversales" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/WEsZcjHGhGs/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/metodologias-docentes-que-incorporan-el-uso-de-las-tic-que-tratan-los-elementos-transversales/505" style="color:inherit;" title="Metodologías docentes que incorporan el uso de las TIC que tratan los elementos transversales" rel="nofollow">Metodologías docentes que incorporan el uso de las TIC que tratan los elementos transversales</a>
            </h3> <small class="date">
                <i>Jun 10, 2015 12:13</i>
            </small>
            <p class="margin-top-5">
                Trabajo de investigación educativa </p>
        </div>
    </div>
</div>
<div data-num="6" class="structure ">
    <div class="video-wrapper ">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/EBErJ_Y63IE/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/la-competencia-matematica-a-traves-de-la-gamificacion/504" class="thumb-video" title="La Competencia Matemática a través de la Gamificación" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/EBErJ_Y63IE/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/la-competencia-matematica-a-traves-de-la-gamificacion/504" style="color:inherit;" title="La Competencia Matemática a través de la Gamificación" rel="nofollow">La Competencia Matemática a través de la Gamificación</a>
            </h3> <small class="date">
                <i>Jun 10, 2015 12:12</i>
            </small>
            <p class="margin-top-5">
                En este video mostramos la Competencia Matemática &nbsp;a través de la Gamificación para alumnos de 1º y 2º de Primaria </p>
        </div>
    </div>
</div>
<div data-num="7" class="structure ">
    <div class="video-wrapper element-item height2">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/3T3qlD4RFsY/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/musikids-autores-patricia-cahue-fermin-garcia-sandra-gonzalez/497" class="thumb-video" title="Musikids - Autores: Patricia Cahue, Fermín García &amp; Sandra González" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/3T3qlD4RFsY/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/musikids-autores-patricia-cahue-fermin-garcia-sandra-gonzalez/497" style="color:inherit;" title="Musikids - Autores: Patricia Cahue, Fermín García &amp; Sandra González" rel="nofollow">Musikids - Autores: Patricia Cahue, Fermín García &amp; Sandra González</a>
            </h3> <small class="date">
                <i>Jun 08, 2015 23:40</i>
            </small>
            <p class="margin-top-5">
                Vídeo que muestra el funcionamiento de una aplicación para el aprendizaje de la música en Ed. Primaria y cómo los niños interactuarán con la aplicación \"Musikids\" según van aprendiendo los distintos conceptos trabajados.\r\n&nbsp; </p>
        </div>
    </div>
</div>
<div data-num="8" class="structure ">
    <div class="video-wrapper element-item height2">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('');">
                <a href="http://clipit.es/landing/video/tema-prueba/492" class="thumb-video" title="Tema prueba" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/tema-prueba/492" style="color:inherit;" title="Tema prueba" rel="nofollow">Tema prueba</a>
            </h3> <small class="date">
                <i>Jun 05, 2015 09:28</i>
            </small>
        </div>
    </div>
</div>
<div data-num="1" class="structure ">
    <div class="video-wrapper bg-color">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/dxdodwiP30E/hqdefault.jpg');">
                <a href="http://clipit.es/landing/video/the-smart-book-the-pencil-tool/482" class="thumb-video" title="The Smart Book &amp; The Pencil Tool" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/dxdodwiP30E/hqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h2 class="text-truncate margin-0 margin-bottom-10">
                <a href="http://clipit.es/landing/video/the-smart-book-the-pencil-tool/482" style="color:white;" title="The Smart Book &amp; The Pencil Tool" rel="nofollow">The Smart Book &amp; The Pencil Tool</a>
            </h2> <small class="date">
                <i>May 05, 2015 11:58</i>
            </small>
        </div>
    </div>
</div>
<div data-num="2" class="structure ">
    <div class="video-wrapper element-item height2">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/93S1p4hXzow/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/facilidad-de-uso-que-sea-predecible/481" class="thumb-video" title="Facilidad De Uso - Que Sea Predecible" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/93S1p4hXzow/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/facilidad-de-uso-que-sea-predecible/481" style="color:inherit;" title="Facilidad De Uso - Que Sea Predecible" rel="nofollow">Facilidad De Uso - Que Sea Predecible</a>
            </h3> <small class="date">
                <i>May 05, 2015 11:58</i>
            </small>
        </div>
    </div>
</div>
<div data-num="3" class="structure ">
    <div class="video-wrapper element-item height2">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/XFKEgKNXrVY/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/facilidad-de-aprendizaje/476" class="thumb-video" title="Facilidad de Aprendizaje" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/XFKEgKNXrVY/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/facilidad-de-aprendizaje/476" style="color:inherit;" title="Facilidad de Aprendizaje" rel="nofollow">Facilidad de Aprendizaje</a>
            </h3> <small class="date">
                <i>May 05, 2015 10:41</i>
            </small>
        </div>
    </div>
</div>
<div data-num="4" class="structure ">
    <div class="video-wrapper element-item height2">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/JrnlD322QaM/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/el-atomo/473" class="thumb-video" title="El Átomo" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/JrnlD322QaM/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/el-atomo/473" style="color:inherit;" title="El Átomo" rel="nofollow">El Átomo</a>
            </h3> <small class="date">
                <i>May 05, 2015 10:37</i>
            </small>
        </div>
    </div>
</div>
<div data-num="5" class="structure ">
    <div class="video-wrapper element-item width2 horizontal-view">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/jdEPsA7C8VA/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/cuadrado-magico/472" class="thumb-video" title="Cuadrado Mágico" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/jdEPsA7C8VA/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/cuadrado-magico/472" style="color:inherit;" title="Cuadrado Mágico" rel="nofollow">Cuadrado Mágico</a>
            </h3> <small class="date">
                <i>May 05, 2015 10:37</i>
            </small>
        </div>
    </div>
</div>
<div data-num="6" class="structure ">
    <div class="video-wrapper ">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/-XM19zPyHDg/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/tu-interfaz-me-suena/470" class="thumb-video" title="Tu Interfaz Me Suena" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/-XM19zPyHDg/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/tu-interfaz-me-suena/470" style="color:inherit;" title="Tu Interfaz Me Suena" rel="nofollow">Tu Interfaz Me Suena</a>
            </h3> <small class="date">
                <i>May 05, 2015 10:37</i>
            </small>
        </div>
    </div>
</div>
<div data-num="7" class="structure ">
    <div class="video-wrapper element-item height2">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/TfRrdVQuKwA/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/los-terremotos/471" class="thumb-video" title="Los Terremotos" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/TfRrdVQuKwA/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/los-terremotos/471" style="color:inherit;" title="Los Terremotos" rel="nofollow">Los Terremotos</a>
            </h3> <small class="date">
                <i>May 05, 2015 10:37</i>
            </small>
        </div>
    </div>
</div>
<div data-num="8" class="structure ">
    <div class="video-wrapper element-item height2">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/TWGGGcbF9nw/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/discapacidad-motora/469" class="thumb-video" title="Discapacidad Motora" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/TWGGGcbF9nw/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/discapacidad-motora/469" style="color:inherit;" title="Discapacidad Motora" rel="nofollow">Discapacidad Motora</a>
            </h3> <small class="date">
                <i>May 05, 2015 10:37</i>
            </small>
        </div>
    </div>
</div>
<div data-num="1" class="structure ">
    <div class="video-wrapper bg-color">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/89P7G2lamRE/hqdefault.jpg');">
                <a href="http://clipit.es/landing/video/persefone/440" class="thumb-video" title="Perséfone" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/89P7G2lamRE/hqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h2 class="text-truncate margin-0 margin-bottom-10">
                <a href="http://clipit.es/landing/video/persefone/440" style="color:white;" title="Perséfone" rel="nofollow">Perséfone</a>
            </h2> <small class="date">
                <i>Mar 03, 2015 19:31</i>
            </small>
            <p class="margin-top-5">
                Mito de Perséfone y Hades ilustrado. </p>
        </div>
    </div>
</div>
<div data-num="2" class="structure ">
    <div class="video-wrapper element-item height2">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/2WdN_Tromn8/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/el-minion-y-el-extraterrestre/439" class="thumb-video" title="El minion y el extraterrestre" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/2WdN_Tromn8/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/el-minion-y-el-extraterrestre/439" style="color:inherit;" title="El minion y el extraterrestre" rel="nofollow">El minion y el extraterrestre</a>
            </h3> <small class="date">
                <i>Mar 03, 2015 19:31</i>
            </small>
            <p class="margin-top-5">
                Corto sobre la aventura de un minion y un ser de otra galaxia. (Resubido) </p>
        </div>
    </div>
</div>
<div data-num="3" class="structure ">
    <div class="video-wrapper element-item height2">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/9zmibfS6aMw/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/venecia/435" class="thumb-video" title="Venecia" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/9zmibfS6aMw/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/venecia/435" style="color:inherit;" title="Venecia" rel="nofollow">Venecia</a>
            </h3> <small class="date">
                <i>Mar 03, 2015 19:31</i>
            </small>
            <p class="margin-top-5">
                Inicio dedicado a Helena y Randall con cariño. </p>
        </div>
    </div>
</div>
<div data-num="4" class="structure ">
    <div class="video-wrapper element-item height2">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/m3KE0s1rtCU/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/final-sonada/433" class="thumb-video" title="Final soñada" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/m3KE0s1rtCU/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/final-sonada/433" style="color:inherit;" title="Final soñada" rel="nofollow">Final soñada</a>
            </h3> <small class="date">
                <i>Mar 03, 2015 19:31</i>
            </small>
            <p class="margin-top-5">
                Final Champions 2014 </p>
        </div>
    </div>
</div>
<div data-num="5" class="structure ">
    <div class="video-wrapper element-item width2 horizontal-view">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/sCrlapQHMK8/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/el-deporte/431" class="thumb-video" title="El deporte" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/sCrlapQHMK8/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/el-deporte/431" style="color:inherit;" title="El deporte" rel="nofollow">El deporte</a>
            </h3> <small class="date">
                <i>Mar 03, 2015 19:31</i>
            </small>
            <p class="margin-top-5">
                Pequeño corto con algunas de las hazañas más impactantes del deporte reciente. </p>
        </div>
    </div>
</div>
<div data-num="6" class="structure ">
    <div class="video-wrapper ">
        <div class="video-block">
            <div class="video-preview" style="background-image: url('http://img.youtube.com/vi/fENcl5xVXKY/mqdefault.jpg');">
                <a href="http://clipit.es/landing/video/fragmento-de-cancion-de-tadeo/430" class="thumb-video" title="fragmento de canción de tadeo" rel="nofollow"><div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div><div class="bg-thumb" style="background-image: url('http://img.youtube.com/vi/fENcl5xVXKY/mqdefault.jpg')"></div></a> </div>
        </div>
        <div class="video-details">
            <h3 class="margin-0 margin-bottom-5 text-truncate">
                <a href="http://clipit.es/landing/video/fragmento-de-cancion-de-tadeo/430" style="color:inherit;" title="fragmento de canción de tadeo" rel="nofollow">fragmento de canción de tadeo</a>
            </h3> <small class="date">
                <i>Mar 03, 2015 19:31</i>
            </small>
            <p class="margin-top-5">
                En este video se puede escuchar un fragmento de la canción de tadeo, con un trozo de video y unas fotografias. </p>
        </div>
    </div>
</div>
</div>
<div class="row video-list">
    <?php
    $count = 1;
    $restart_count = false;
    foreach($videos as $video):
        $video_url = "video/".elgg_get_friendly_title($video->name)."/".$video->id;
        $date = date("M d, Y H:i", $video->time_created);
        $class = "element-item height2";
        $text_color = "";
        $image = get_video_thumbnail($video->url, 'normal');
        $description = $video->description;
        if(strlen($description)>350){
            $description = substr($description, 0, 350)."...";
        }
        $title = '<h3 class="margin-0 margin-bottom-5 text-truncate">
                '.elgg_view('output/url', array(
                'href' => $video_url,
                'style' => 'color:inherit;',
                'text'  => $video->name,
                'title' => $video->name
            )).'
            </h3>';
        $limit = 2;
        switch($count){
            case 1:
                $limit = 3;
                $class = "bg-color";
                $image = get_video_thumbnail($video->url, 'large');
                $title = '<h2 class="text-truncate margin-0 margin-bottom-10">
                        '.elgg_view('output/url', array(
                        'href' => $video_url,
                        'style' => 'color:white;',
                        'text'  => $video->name,
                        'title' => $video->name
                    )).'
                    </h2>';
                break;
            case 2:

                break;
            case 3:
            case 4:
                if(strlen($description)>150){
                    $description = substr($description, 0, 150)."...";
                }
                break;
            case 5:
                $class = "element-item width2 horizontal-view";
//            $description = false;
                $bg_img = elgg_view('output/img', array('src' =>  $image, 'style' => 'width: 100%'));
                break;
            case 6:
                $class = "";
                break;
            case 7:
                break;
            case 8:
//            $description = false;
                break;
            case 9:
                $limit = 3;
                $class = "bg-color";
                $image = get_video_thumbnail($video->url, 'large');
                $title = '<h2 class="text-truncate margin-0 margin-bottom-10">
                        '.elgg_view('output/url', array(
                        'href' => $video_url,
                        'style' => 'color:white;',
                        'text'  => $video->name,
                        'title' => $video->name
                    )).'
                    </h2>';
                $count = 1;
                $restart_count = true;
                break;
        }
        $bg_img = '<div class="bg-thumb" style="background-image: url(\''.$image.'\')"></div>';
        $video_thumb = elgg_view('output/url', array(
            'href' => $video_url,
            'class' => 'thumb-video',
            'text'  => '<div class="bg-play"><div><i class="fa fa-play-circle-o"></i></div></div>'.$bg_img,
            'title' => $video->name
        ));
        ?>
        <div data-num="<?php echo $count;?>" class="structure <?php echo $restart_count ? '':'first';?>">
            <div class="video-wrapper <?php echo $class;?>">
                <div class="video-block">
                    <div class="video-preview" style="background-image: url('<?php echo $image;?>');">
                        <?php echo $video_thumb;?>
                    </div>
                </div>
                <div class="video-details">
                    <?php echo $title;?>
                    <div>
                        <a class="text-truncate site-name">Instituto Real La Paloma</a>
                    </div>
                    <small class="date" style="margin-top: 2px;">
                        <i><?php echo $date;?></i>
                    </small>
                    <?php if($description):?>
                        <p class="margin-top-5">
                            <?php echo elgg_strip_tags($description);?>
                        </p>
                    <?php endif;?>
                    <?php echo elgg_view("global/tags/view", array('tags' => $video->tag_array, 'limit' => $limit)); ?>
                </div>
            </div>
        </div>

        <?php
        $count++;
    endforeach;

    ?>
</div>
<style>
    .tags{
        display: block;
    }
</style>