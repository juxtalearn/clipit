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
 * @package         Clipit
 */
$file = elgg_extract("entity", $vars);
$user_loggedin = elgg_get_logged_in_user_guid();
$user_loggedin = new ElggUser($user_loggedin_id);
$owner_user = new ElggUser($file->owner_id);
?>
<!-- File info + details -->
<div class="file-owner">
    <i class="fa fa-file-o file-icon"></i>
    <div class="block">
        <div class="header-file">
            <h2 class="title"><?php echo $file->name; ?></h2>
            <small class="show sub-title">
                <img class="user-avatar" src="<?php echo $owner_user->getIconURL("tiny");?>">
                <i>
                    Uploaded by
                    <?php echo elgg_view('output/url', array(
                        'href'  => "profile/".$owner_user->login,
                        'title' => $owner_user->name,
                        'text'  => $owner_user->name));
                    ?>
                    <?php echo elgg_view('output/friendlytime', array('time' => $file->time_created));?>
                </i>
            </small>
        </div>
        <div class="body-file">
            <div class="file-details">
                <div>
                    <a class="btn btn-default">
                        <i class="fa fa-download"></i> Download
                    </a>
                    <div class="file-info">
                        <strong class="show">PDF document</strong>
                        <?php echo format_file_size(50000000); ?>
                    </div>
                </div>
                <div class="frame-file frame-container">
                    <iframe src="https://www.cs.tut.fi/~jkorpela/latin9.pdf"></iframe>
                </div>
            </div>
            <div>
                <?php echo $file->description; ?>
            </div>
        </div>
    </div>
</div>
<!-- File info + details end -->





<div class="discussion discussion-owner-msg" style="display: none">
    <div class="header-post">



        <i class="fa fa-file-o file-icon" style="
    font-size: 50px;  color: #C9C9C9;
    margin-right: 10px;    float: left !important;
"></i>

        <div class="block">
            <a href="http://juxtalearn.org/sandbox/clipit_befe/clipit_activity/74/group/discussion/view/150#create_reply" title="Comment" class="btn btn-default btn-sm reply-button" rel="nofollow" style="
    border: 1px solid #32b4e5;
    color: #32b4e5;
    background: #fff;
    padding: 3px 10px;
    float: right;
"><i class="fa fa-comments"></i>&nbsp;Comment</a>
            <h3 class="title" style="
    margin: 0;  font-weight: bold;
                         "><a>Guión técnico Videodoc</a></h3>

            <small class="show" style="
    margin-top: 5px;
    font-size: 85%;
">
                <img src="http://juxtalearn.org/sandbox/clipit02/mod/profile/icondirect.php?lastcache=1378887633&amp;joindate=1378887285&amp;guid=248&amp;size=tiny">
                <i>Uploaded by&nbsp;<a href="http://juxtalearn.org/sandbox/clipit_befe/profile/" title="Mario Sanchez" rel="nofollow">Mario Sanchez</a>                    <abbr title="6 March 2014 @ 2:54pm">15 days ago</abbr>                </i>
                <i class="pull-right">
                    Last post by
                    <a href="http://juxtalearn.org/sandbox/clipit_befe/profile/student_2" title="Mario Sanchez" rel="nofollow">Mario Sanchez</a> (<abbr title="20 March 2014 @ 3:28pm">19 hours ago</abbr>)</i>
            </small>


        </div>
    </div>
    <div id="bd" class="body-post" style="
    background: #fafafa;
    padding: 20px;
">
        <div style="
"><a class="btn btn-default" style=" padding: 5px 10px; margin-right: 10px; float: left;">
                <i class="fa fa-download"></i>
                Download
            </a><div style="
    text-align: left;
    overflow: hidden;
"><strong class="show" style="
    margin-top: -5px;
">PDF Document</strong>1.45 MB</div></div><div style="
    margin-top: 10px;
">

            <iframe src="https://www.cs.tut.fi/~jkorpela/latin9.pdf" style="
    width: 100%;
    height: 500px;
">
            </iframe>
        </div>

        <div class="video-container">
            <iframe src="http://www.youtube.com/embed/XFKEgKNXrVY?rel=0" frameborder="0" allowfullscreen=""></iframe>
        </div>

    </div>
    <div class="body-post">
        <div>hola chicos, a nosotros se nos a ocurrido otra idea para el video, es parecido al vuestro pero algo cambiado, no se si lo he escrito del todo bien, pero espero k lo entendais :)<br>representar un dia de 2 personas (puede ser un chico y una chica): uno ciudad y otro campo, k utilizan las mismas aplicaciones, sistemas, etc. pero con distintas formas:</div><ul><li>ciudad: todo mas ajetreado, rápido, etc.&nbsp;<br></li><li>campo: mas trankilo, con mas tiempo, etc.<br></li></ul><br>1. Por wathapp: uno elije enviar mensaje de voz, k seria mas rápido, mientras k el de campo, escribe…<br>2.
        En el metro o bus (sin el abono), el de ciudad, muchas veces no tiene
        monedas y elige tarjeta, mientras k el de ciudad lo tiene todo preparado
        y paga con las monedas y mas trankilo<br>3. Por Facebook : lo kerra
        enviar todo lo mas rápido posible, entonces pondrá jajaja, en vez de ir a
        los iconos y poner la carita sonriente, k es lo k haría el del campo; o
        uno envía bss y otro busca en los iconos un muñeco k besa; o los 2 con
        la carita de&nbsp;&nbsp;y se convierte solo en la carita esa<br>4. En otra
        aplicación: cuando pones tb se convierte directamente en también solo,
        mientras k es de campo lo escribe todo, o con k= que<br>5. Podemos hacer
        k uno sea de otro país, y usa grados kevin en vez de grados
        centígrados, asi podemos poner el ejemplo de la temperatura&nbsp;<br>6. En un
        juego, donde se puede elegir entre varios personajes: cada uno elije
        uno diferente, además de k pueden elegir los modos (fácil, difícil,
        on-line o no).<br><br><br></div>



</div>