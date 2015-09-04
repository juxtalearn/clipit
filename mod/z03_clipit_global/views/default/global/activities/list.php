<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   04/09/2015
 * Last update:     04/09/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
?>
<style>
    .container .content{
        background: #fff !important;
    }
    .tags{
        display: block;
    }
</style>
<ul class="public-activity-list">
    <?php for($i=0;$i<10;$i++):?>
    <li class="row public-activity list-item">
        <div class="col-md-7">
            <span class="activity-point margin-right-15 pull-left" style="background: #E4391B;width: 15px;height: 15px;"></span>
            <div class="content-block">
                <h4 class="margin-0 margin-bottom-5">Recursividad en la programación, casos de uso</h4>
                <div class="description scroll-list-200 details">
                    <p>
                        Donec sollicitudin molestie malesuada. Lorem ipsum dolor sit amet,
                        consectetur adipiscing elit. Vivamus suscipit tortor eget felis
                        porttitor volutpat. Praesent sapien massa, convallis a pellentesque nec,
                        egestas non nisi. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices
                        posuere cubilia Curae; Donec velit neque, auctor sit amet aliquam vel, ullamcorper sit
                        amet ligula. Quisque velit nisi, pretium ut lacinia in, elementum id enim. Mauris blandit
                        aliquet elit, eget tincidunt nibh pulvinar a. Curabitur non nulla sit amet nisl tempus convallis
                        quis ac lectus. Nulla porttitor accumsan tincidunt. Vivamus magna justo,
                        lacinia eget consectetur sed, convallis at tellus.
                    </p>
                </div>
                <div class="default-info details">
                    <span class="text-muted">8 estudiantes</span>
                    <div style="color: #999;text-transform: uppercase;" class="margin-top-10">
                        <i class="fa fa-calendar"></i>
                        01 Dec 2014                            -
                        30 Aug 2015
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="pull-right">
                <small class="activity-status status-closed">
                    <strong>Finalizada</strong>
                </small>
                <a class="btn btn-primary btn-sm show margin-top-10">Entrar</a>
            </div>
            <div class="margin-bottom-10">
                <small class="show">Centro educativo</small>
                <a class="text-truncate">Usabilidad - Migu Usabilidad - Miguel Usabilidad - Miguelel</a>
            </div>
            <div>
                <small class="show">Tema clave</small>
                <a>Usabilidad - Miguel</a>
            </div>
        </div>
    </li>
    <?php endfor;?>
</ul>