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
 * @package         ClipIt
 */
$quote_id = get_input('quote_id');
$message_destination_id = get_input('message_destination_id');

$quote = get_text_from_quote($quote_id, $message_destination_id);
$user = array_pop(ClipitUser::get_by_id(array($quote->owner_id)));
?>
<?php echo elgg_view('output/img', array(
    'src' => get_avatar($user, 'small'),
    'style' => 'margin-right: 5px;margin-top: 5px;',
    'class' => 'image-block avatar-tiny',
    'alt' => 'avatar-tiny',
));?>
<div class="content-block">
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