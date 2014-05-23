<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   2/04/14
 * Last update:     2/04/14
 *
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, JuxtaLearn Project
 * @version         $Version$
 * @link            http://juxtalearn.org
 * @license         GNU Affero General Public License v3
 *                  (http://www.gnu.org/licenses/agpl-3.0.txt)
 *                  This program is free software: you can redistribute it and/or modify
 *                  it under the terms of the GNU Affero General Public License as
 *                  published by the Free Software Foundation, version 3.
 *                  This program is distributed in the hope that it will be useful,
 *                  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *                  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *                  GNU Affero General Public License for more details.
 *                  You should have received a copy of the GNU Affero General Public License
 *                  along with this program. If not, see
 *                  http://www.gnu.org/licenses/agpl-3.0.txt.
 */
$event = elgg_extract("event", $vars);
$activity = elgg_extract("activity", $vars);
$url_item = vsprintf($vars['item']['url'], $vars['item']['url_data']);

if($event):
    $author = new ElggUser($vars['author']->id);
?>
<li class="event">
    <?php echo elgg_view('output/url', array(
        'href'  => "z04_clipit_activity/".$activity->id,
        'title' => $activity->name,
        'text'  => '<div class="circle-activity" style="background: #'.$activity->color.'"></div>',
    ));
    ?>
    <div class="event-section">
        <i class="fa fa-<?php echo $vars['icon'];?>" style=" color: #<?php echo $activity->color; ?>; "></i>
        <span style="color: #666;"><?php echo $vars['message'];?></span>
        <?php if(!$vars['item']['description']): ?>
        <?php echo elgg_view('output/url', array(
            'href'  => $url_item,
            'title' => $vars['item']['name'],
            'text'  => $vars['item']['name'],
        ));
        ?>
        <?php endif; ?>
    <?php
        if($vars['item']['description']):
            $description = trim(elgg_strip_tags($vars['item']['description']));
            // text truncate max length 90
            if(mb_strlen($description)>90){
                $description = substr($description, 0, 90)."<b>...</b>";
            }
    ?>
    <div class="event-details">
        <?php if($vars['item']['icon']): ?>
        <i class="fa fa-file-o fa-<?php echo $vars['item']['icon'];?> icon"></i>
        <?php endif; ?>
        <div class="section">
            <div class="title">
                <strong>
                <?php echo elgg_view('output/url', array(
                    'href'  => $url_item,
                    'title' => $vars['item']['name'],
                    'text'  => $vars['item']['name'],
                    'class' => 'show'
                ));
                ?>
                </strong>
            </div>
            <div class="sub-title">
                by <?php echo elgg_view('output/url', array(
                    'href'  => "profile/".$vars['author']->login,
                    'title' => $vars['author']->name,
                    'text'  => $vars['author']->name,
                ));
                ?>
            </div>
            <div class="description">
                <?php echo $description;?>
            </div>
        </div>
    </div>
<?php else: ?>
    <!-- Author details -->
    <div class="event-details">
        <img src="<?php echo $author->getIconURL('small'); ?>" class="img-thumb">
        <div class="title">
            <?php echo elgg_view('output/url', array(
                'href'  => "profile/".$vars['author']->login,
                'title' => $vars['author']->name,
                'text'  => $vars['author']->name,
                'class' => 'show'
            ));
            ?>
        </div>
        <div class="section">
            <div class="sub-title">
                @<?php echo $vars['author']->login;?>
            </div>
            <div class="description">
                <?php echo $sub_title_details;?>
            </div>
        </div>
    </div>
    <!-- Author details end -->
<?php endif; ?>
<div class="event-date text-right">
    <?php echo elgg_view('output/friendlytime', array('time' => $event->time_created));?>
</div>

</div>
</li>
<?php endif; ?>