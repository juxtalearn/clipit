<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   28/03/14
 * Last update:     28/03/14
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
$author = $event['author'];
$activity = $event['activity'];
$item = $event['item'];
$object = $event['object'];
$url_item = $vars['item']['url'];

if($event):
    ?>
    <li class="list-item" style="overflow: hidden">
        <?php if($author['icon']):?>
        <img src="<?php echo $author['icon']; ?>" class="pull-left" style="margin-right: 10px;">
        <?php endif; ?>
        <div style="overflow: hidden">
            <div>
                <strong>
                    <?php echo elgg_view('output/url', array(
                        'href'  => $author['url'],
                        'title' => $author['name'],
                        'text'  => $author['name'],
                    ));
                    ?>
                </strong>
                <span class="text-muted pull-right"><?php echo elgg_view('output/friendlytime', array('time' => $event['time']));?></span>
            </div>
            <div>
                <small class="show">
                    <i class="fa fa-<?php echo $event['icon'];?>" style="color: #<?php echo $activity ? $activity->color : "C9C9C9";?>"></i>
                    <?php echo $event['message'];?>
                    <?php if(!$item):?>
                        <?php echo elgg_view('output/url', array(
                            'href'  => $object['url'],
                            'title' => $object['name'],
                            'text'  => $object['name'],
                        ));
                        ?>
                    <?php endif; ?>
                    <?php if(!$item['icon']):?>
                        <?php echo elgg_view('output/url', array(
                            'href'  => $item['url'],
                            'title' => $item['name'],
                            'text'  => $item['name'],
                        ));
                        ?>
                    <?php endif; ?>
                </small>
            </div>
            <?php
            $description = trim(elgg_strip_tags($item['description']));
            if($description):
                // text truncate max length 205
                if(mb_strlen($description)>205){
                    $description = substr($description, 0, 205)."...";
                }
                if(!$item['icon']):
                    ?>
                    <p style=" color: #666666; padding-left: 5px; border-left: 3px solid #eee; overflow: hidden; margin-top: 5px; ">
                        <?php echo $description;?>
                    </p>
                <?php else: ?>
                    <div style=" margin-top: 5px;">
                        <i class="fa fa-file-o file-icon" style=" font-size: 35px; color: #C9C9C9; float: left; margin-right: 5px; "></i>
                        <div style="overflow: hidden">
                            <small>
                                <?php echo elgg_view('output/url', array(
                                    'href'  => $item['url'],
                                    'title' => $item['name'],
                                    'text'  => $item['name'],
                                    'class' => 'show'
                                ));
                                ?>
                                <strong><?php echo $description;?></strong>
                            </small>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </li>
<?php endif; ?>
