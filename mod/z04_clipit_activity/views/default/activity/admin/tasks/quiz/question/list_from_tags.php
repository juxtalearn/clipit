<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   17/11/2014
 * Last update:     17/11/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$tricky_topic = get_input('tricky_topic');
function get_questions_from_tag($tag){
    $return_array = array();
    $all_items = ClipitQuizQuestion::get_all(0, 0, "", true, true); // Get all item ids, not objects
    foreach($all_items as $item_id) {
        $item_tags = (array)ClipitQuizQuestion::get_tags((int)$item_id);
        if(array_search($tag, $item_tags) !== false) {
            $return_array[] = $item_id;
        }
    }
    return $return_array;
}
?>
<div>
    <div class="pull-right">
        <strong>
            <?php echo elgg_echo('filter');?>:
        </strong>
        <select class="search-difficulty form-control margin-left-5" style="padding: 5px;width: auto;display: inline-block" name="dnumber">
            <option value=""><?php echo elgg_echo('difficulty');?></option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
        </select>
    </div>
    <table class="datatable display table table-striped margin-top-5" cellspacing="0" width="100%" role="presentation">
        <thead role="presentation">
        <tr role="presentation">
            <th data-dynatable-no-sort="true" style="width: 60px;" role="presentation"></th>
            <th role="presentation"><?php echo elgg_echo('quiz:question');?></th>
            <th role="presentation"><?php echo elgg_echo('tags');?></th>
            <th role="presentation" style="width: 110px;" data-dynatable-sorts="dnumber"><?php echo elgg_echo('difficulty');?></th>
            <th role="presentation" style="display: none;">Dnumber</th>
        </tr>
        </thead>
        <tbody role="presentation">
        <?php
        $tags = ClipitTrickyTopic::get_tags($tricky_topic);
        foreach($tags as $tag_id):
            $tag = array_pop(ClipitTag::get_by_id(array($tag_id)));
            $questions_tag = ClipitQuizQuestion::get_by_id(get_questions_from_tag($tag->id));
            foreach($questions_tag as $question_tag):
                $clones = false;
                if(!$question_tag->cloned_from):
                    ?>
                    <tr role="presentation">
                        <td role="presentation">
                            <a class="btn btn-xs btn-primary questions-select" id="<?php echo $question_tag->id;?>">
                                <?php echo elgg_echo('select');?>
                            </a>
                        </td>
                        <td role="presentation">
                            <?php echo $question_tag->name;?>
                            <?php if($clones = ClipitQuizQuestion::get_clones($question_tag->id, true)): ?>
                                <small class="show margin-top-5">
                                    <a class="get-clones" href="javascript:;" id="<?php echo $question_tag->id;?>">
                                        <i class="fa fa-clock-o"></i> <?php echo count($clones);?> revisions
                                    </a>
                                </small>
                            <?php endif;?>
                        </td>
                        <td role="presentation">
                            <?php echo elgg_view('tricky_topic/tags/view', array('limit' => 2, 'tags' => array($tag_id))); ?>
                        </td>
                        <td role="presentation"><?php echo difficulty_bar($question_tag->difficulty);?></td>
                        <td role="presentation" style="display: none;"><?php echo $question_tag->difficulty;?></td>
                    </tr>
                <?php endif;?>
            <?php endforeach;?>
        <?php endforeach;?>
        </tbody>
    </table>
</div>
