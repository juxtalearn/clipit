<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   24/10/2014
 * Last update:     24/10/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entities = elgg_extract('entities', $vars);
$instalations = array(
    array(
        'name' => 'El Átomo',
        'url' => 'http://juxtalearn.org/trials/clipit_atomo/',
    ),
    array(
        'name' => 'ED',
        'url' => 'http://juxtalearn.org/trials/clipit_ed/',
    ),
    array(
        'name' => 'Ingeniería de software',
        'url' => 'http://juxtalearn.org/trials/clipit_atomo/',
    ),
    array(
        'name' => 'Interacción persona ordenador',
        'url' => 'http://juxtalearn.org/trials/clipit_ipo/',
    ),
    array(
        'name' => 'Java - Programación orientada a objetos',
        'url' => 'http://juxtalearn.org/trials/elgg_05/',
    ),

);
?>
<h1 style="margin-bottom:40px;margin-top: 0;opacity: 0.7;"><?php echo elgg_echo('connect');?></h1>

<div class="row">
    <div class="col-md-6">
    <h3 class="margin-0 margin-bottom-10 margin-top-20"><?php echo elgg_echo('educational:centers');?></h3>
    <hr class="margin-0" style="border-top: 1px solid #E2E2E2;margin-bottom: 10px;">
        <ul>
        <?php
        foreach($entities as $edu):
            $edu_file = array_pop(ClipitFile::get_by_id(array(array_pop($edu->file_array))));
        ?>
            <li class="list-item overflow-hidden" style="padding-left: 10px;border-left:5px solid #ff4343">
            <?php echo elgg_view('output/img',array(
                'src' => $edu_file->thumb_small['url'],
                'class' => 'image-block',
                'style' => 'width: 45px;',
            ));?>
            <div class="content-block">
                <div class="pull-right">
                    <?php echo elgg_view('output/url', array(
                        'href' => "http://clipit.es/".$edu->description,
                        'class' => 'btn btn-xs btn-primary',
                        'text'  => elgg_echo('connect'),
                        'title' => elgg_echo('connect')
                    ));
                    ?>
                </div>
                <strong>
                    <?php echo elgg_view('output/url', array(
                        'href' => "http://www.clipit.es/".$edu->description,
                        'text'  => $edu->name,
                        'title' => $edu->name
                    ));
                    ?>
                </strong>
                <div>
                    <?php echo elgg_view('output/url', array(
                        'href' => "videos/".$edu->description,
                        'text'  => '<i class="fa fa-youtube-play"></i> '.elgg_echo('videos:view_all'),
                        'title' => elgg_echo('videos:view_all')
                    ));
                    ?>
                </div>
            </div>
            </li>
        <?php endforeach;?>
        </ul>
        <h3 class="margin-0 margin-bottom-10 margin-top-20"><?php echo elgg_echo('instalations');?></h3>
        <hr class="margin-0" style="border-top: 1px solid #E2E2E2;margin-bottom: 10px;">
        <ul>
            <?php
            $count = 1;
            foreach($instalations as $instalation):
                $style = "";
                switch($count){
                    case 1:
                        $style = "border-left:5px solid #ff4343";
                        break;
                    case 2:
                        $style = "border-left:5px solid #d8ba05";
                        break;
                    case 3:
                        $style = "border-left:5px solid #32b4e5";
                        $count = 0;
                        break;
                }
            ?>
            <li class="list-item-5 overflow-hidden" style="<?php echo $style;?>; padding-left: 10px;padding-top:5px;padding-bottom: 5px;margin-bottom: 0;">
                <?php echo elgg_view('output/url', array(
                    'href' => $instalation['url'],
                    'class' => 'btn btn-xs btn-primary pull-right',
                    'text'  => elgg_echo('connect'),
                    'title' => elgg_echo('connect')
                ));
                ?>
                <strong>
                <?php echo elgg_view('output/url', array(
                    'href' => $instalation['url'],
                    'text'  => $instalation['name'],
                    'title' => $instalation['name']
                ));
                ?>
                </strong>
            </li>
            <?php $count++; endforeach;?>
        </ul>
    </div>
</div>