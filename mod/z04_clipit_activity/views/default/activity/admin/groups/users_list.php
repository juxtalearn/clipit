<?php
 /**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   25/08/14
 * Last update:     25/08/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$users = get_input('users');
$users = ClipitUser::get_by_id($users);
?>
<ul>
<?php foreach($users as $user):?>
<li data-user="<?php echo $user->id;?>" style="cursor: pointer">
    <?php echo elgg_view('output/img', array(
        'src' => get_avatar($user, 'small'),
        'class' => 'image-block avatar-tiny',
        'alt' => 'avatar-tiny',
    ));
    ?>
    <?php echo $user->name;?>
</li>
<?php endforeach; ?>
</ul>
