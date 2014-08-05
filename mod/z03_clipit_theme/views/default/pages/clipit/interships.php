<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   1/08/14
 * Last update:     1/08/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$images_dir = "mod/z03_clipit_theme/graphics/team/";
$intership_members = array(
    array(
        array(
            'name' => 'Virginia del Castillo',
            'position' => 'Intership',
            'image' => "virginia.png",
            'description' => 'lorem ipsum.....',
        ),
        array(
            'name' => 'Ángel Francisco',
            'position' => 'Intership',
            'image' => "angel.png",
            'description' => 'lorem ipsum.....',
        ),
        array(
            'name' => 'Rocío Blanco',
            'position' => 'Intership',
            'image' => "rocio.png",
            'description' => 'lorem ipsum.....',
        )
    ),
);
?>
<h3 style="margin-left: 50px;" class="blue margin-bottom-20">Interships</h3>
<?php foreach($intership_members as $members):?>
    <div class="margin-top-20 row" style="padding-left: 50px;">
        <?php
        foreach($members as $member):
            $id = uniqid();
            ?>
            <div class="col-md-2 col-xs-4 text-center">
                <?php if($member['image']):?>
                    <?php echo elgg_view('output/img', array(
                        'src' => $images_dir.$member['image'],
                        'class' => 'img-circle',
                        'style' => 'width: 120px; height: 120px;'
                    ));
                    ?>
                <?php else:?>
                    <div style="width: 120px;height: 120px;border-radius: 100px;margin: 0 auto;background: #bae6f6"></div>
                <?php endif;?>
                <div class="margin-top-10 blue">
                    <span class="cursor-default author-text" style="font-size: 11px;"><?php echo $member['name'];?></span>
                    <i class="show"><?php echo $member['position'];?></i>
                    <div class="margin-top-5">
                        <?php
                        foreach($member['social'] as $name => $account):
                            $icon = $name;
                            switch($name){
                                case 'facebook':
                                    $link = 'https://www.facebook.com/'.$account;
                                    break;
                                case 'youtube':
                                    $link = 'http://www.youtube.com/'.$account;
                                    break;
                                case 'twitter':
                                    $link = 'https://www.twitter.com/'.$account;
                                    break;
                                case 'linkedin':
                                    $link = 'https://www.linkedin.com/'.$account;
                                    break;
                                case 'web':
                                    $icon = 'globe';
                                    $link = $account;
                                    break;
                            }
                            ?>
                            <a href="<?php echo $link;?>" target="_blank" class="fa-stack fa-md">
                                <i class="fa fa-circle <?php echo $icon;?>-color fa-stack-2x"></i>
                                <i class="fa fa-<?php echo $icon;?> fa-stack-1x fa-inverse"></i>
                            </a>
                        <?php endforeach;?>
                    </div>
                    <i class="cursor-pointer show fa fa-chevron-down author-description" data-toggle="collapse" data-target="#<?php echo $id;?>"></i>
                    <div id="<?php echo $id;?>" class="collapse"><?php echo $member['description'];?></div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
<?php endforeach;?>
