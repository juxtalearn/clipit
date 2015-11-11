<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   04/09/2015
 * Last update:     04/09/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entities = elgg_extract('entities', $vars);
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
    <?php
    foreach($entities as $entity):
        $remote_site = array_pop(ClipitRemoteSite::get_by_id(array($entity->remote_site)));
        $tricky_topic = array_pop(ClipitTrickyTopic::get_by_id(array($entity->remote_tricky_topic)));
    ?>
    <li class="row public-activity list-item">
        <div class="col-md-7">
            <span class="activity-point margin-right-15 pull-left" style="background: #<?php echo $entity->color;?>;width: 15px;height: 15px;"></span>
            <div class="content-block">
                <h4 class="margin-0 margin-bottom-5">
                    <?php echo elgg_view('output/url', array(
                        'href' => "{$remote_site->url}clipit_activity/{$entity->remote_id}",
                        'title' => $entity->name,
                        'text'  => $entity->name
                    ));
                    ?>
                </h4>
                <div class="scroll-list-100">
                    <?php echo $entity->description;?>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="pull-right">
                <?php echo elgg_view('output/url', array(
                    'href' => "{$remote_site->url}clipit_activity/{$entity->remote_id}",
                    'class' => 'btn btn-primary btn-sm show margin-top-10',
                    'title' => elgg_echo('activity:join'),
                    'text'  => elgg_echo('activity:join')
                ));
                ?>
            </div>
            <div class="margin-bottom-10">
                <small class="show"><?php echo elgg_echo('educational:center');?></small>
                <?php echo elgg_view('output/url', array(
                    'href' => "videos/".elgg_get_friendly_title($remote_site->name)."/".$remote_site->id,
                    'class' => 'text-truncate',
                    'text'  => $remote_site->name,
                    'title' => $remote_site->name,
                ));
                ?>
            </div>
            <div>
                <small class="show"><?php echo elgg_echo('tricky_topic');?></small>
                <?php echo elgg_view('output/url', array(
                    'href' => "videos/search?by=trickytopic&id=".$entity->remote_tricky_topic,
                    'class' => 'text-truncate',
                    'title' => $tricky_topic->name,
                    'text'  => $tricky_topic->name
                ));
                ?>
            </div>
        </div>
    </li>
    <?php endforeach;?>
    <?php for($i=0;$i<10;$i++):?>
    <li class="row public-activity list-item      hide">
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