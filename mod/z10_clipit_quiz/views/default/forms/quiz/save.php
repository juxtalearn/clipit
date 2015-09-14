<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   23/01/2015
 * Last update:     23/01/2015
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$user = array_pop(ClipitUser::get_by_id(array(elgg_get_logged_in_user_guid())));
$button_value = elgg_extract('submit_value', $vars);
$quiz = elgg_extract('entity', $vars);

$tricky_topics = ClipitTrickyTopic::get_all();
$owner_tt = array();
foreach($tricky_topics as $tricky_topic){
    $tt[$tricky_topic->id] = $tricky_topic->name;
    if($tricky_topic->owner_id == elgg_get_logged_in_user_guid()){
        $owner_tt[$tricky_topic->id] = $tricky_topic->name;
    }
}
$tt = array_diff($tt, $owner_tt);
?>

<?php echo elgg_view('activity/admin/tasks/quiz/quiz', array(
    'entity' => $quiz,
    'tricky_topic' => $quiz->tricky_topic,
    'select_tricky_topic' => array('owner' => $owner_tt, 'others' => $tt)
));?>
<div class="text-right margin-top-20">
    <?php echo elgg_view('input/submit', array(
        'class' => 'btn btn-primary',
        'value'  => $button_value,
    ));
    ?>
</div>

<?php if(!$quiz): // Creating mode ?>
    <script>
        $(function(){
            $('.select-tricky_topic').trigger('change');
        });
    </script>
<?php endif; ?>