<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   28/07/14
 * Last update:     28/07/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$team_members = elgg_extract('team', $vars);
$images_dir = elgg_extract('images_dir', $vars);
?>
<script>
$(function(){
    $(".view-first").hover(function(){
        $(".first-img").show();
        if($(this).find(".mask").length > 0){
            $(this).find(".first-img").hide();
            $(this).find(".mask img").show();
        }

    },function(){
        $(".view-first").find(".mask img").hide();
        $(this).find(".first-img").show();
    });
});
</script>
<?php foreach($team_members as $color => $members):?>
    <div class="row margin-bottom-20">
        <?php
        foreach($members as $member):
           $id = uniqid();
        ?>
        <div class="col-md-3 col-xs-6 text-center">
            <div class="view view-first">
                <?php echo elgg_view('output/img', array(
                    'src' => $images_dir.$member['image'],
                    'class' => 'img-circle first-img'
                ));
                ?>
                <?php if($member['cartoon'] !== false):?>
                <div class="mask">
                    <?php echo elgg_view('output/img', array(
                        'src' => $images_dir."cartoon/".$member['image'],
                        'class' => 'img-circle',
                        'style' => 'display:none'
                    ));
                    ?>
                </div>
                <?php endif;?>
            </div>
            <div class="margin-top-10 <?php echo $color;?>">
                <span class="cursor-default author-text"><?php echo $member['name'];?></span>
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

