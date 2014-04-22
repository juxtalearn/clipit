<?php
/**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   10/04/14
 * Last update:     10/04/14
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
$quote_id = get_input('quote_id');
$message_destination_id = get_input('message_destination_id');

$quote = get_text_from_quote($quote_id, $message_destination_id);
$user = array_pop(ClipitUser::get_by_id(array($quote->owner_id)));
$elgg_user = new ElggUser($quote->owner_id);
?>
<img src="<?php echo $elgg_user->getIconURL('tiny');?>" class="pull-left" style="margin-right: 5px;margin-top: 5px;">
<div style="overflow: hidden;">
    <div>
        <small class="pull-right"><?php echo elgg_view('output/friendlytime', array('time' => $quote->time_created));?></small>
        <small>
        <?php echo elgg_view('output/url', array(
            'href'  => "profile/".$user->login,
            'title' => $user->name,
            'text'  => $user->name));
        ?> wrote:
        </small>
    </div>
    <?php echo text_reference($quote->description); ?>
</div>