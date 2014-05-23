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
$activity = elgg_extract("activity", $vars);
$url_item = $vars['item']['url'];

if($event):
    $author = new ElggUser($vars['author']->id);
    ?>
    <li class="list-item">
        <div class="pull-left" style="margin-right: 10px;margin-top: 5px; position: relative;">
            <?php echo elgg_view('output/url', array(
                'href'  => "z04_clipit_activity/".$activity->id,
                'title' => $activity->name,
                'text'  => "",
                'style' => 'background: #'.$activity->color.';width: 22px; height: 22px; position: absolute; border-radius: 15px; border: 2px solid #fff; left: -5px; top: -5px;'
            ));
            ?>
            <img src="<?php echo $author->getIconURL('small'); ?>">
        </div>
        <div style="overflow: hidden">
            <div class="text-truncate">
                <small class="pull-right"><?php echo elgg_view('output/friendlytime', array('time' => $event->time_created));?></small>
                <strong><a><?php echo $author->name;?></a></strong>
            </div>
            <div>
                <small class="show">
                    <i class="fa fa-<?php echo $vars['icon'];?>" style=" color: #C9C9C9; "></i>
                    <?php echo $vars['message'];?>
                    <?php if($vars['item']['name'] && !$vars['item']['icon']):?>
                        <?php echo elgg_view('output/url', array(
                            'href'  => $url_item,
                            'title' => $vars['item']['name'],
                            'text'  => $vars['item']['name'],
                        ));
                        ?>
                    <?php endif; ?>
                </small>
            </div>
            <?php
            if($vars['item']['description']):
                $description = trim(elgg_strip_tags($vars['item']['description']));
                // text truncate max length 70
                if(mb_strlen($description)>70){
                    $description = substr($description, 0, 70)."<b>...</b>";
                }
                if(!$vars['item']['icon']):
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
                                    'href'  => $url_item,
                                    'title' => $vars['item']['name'],
                                    'text'  => $vars['item']['name'],
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
