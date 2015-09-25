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
    <table class="datatable display table table-striped margin-top-5" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th data-dynatable-no-sort="true" style="width: 60px;"></th>
            <th><?php echo elgg_echo('quiz:question');?></th>
            <th><?php echo elgg_echo('tags');?></th>
            <th style="width: 110px;" data-dynatable-sorts="dnumber"><?php echo elgg_echo('difficulty');?></th>
            <th style="display: none;">Dnumber</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $tags = ClipitTrickyTopic::get_tags($tricky_topic);
        $related_tags = array_keys(ClipitQuizQuestion::get_by_tag($tags));
        foreach(ClipitQuizQuestion::get_by_id($related_tags) as $question_tag):
                $clones = false;
                if(!$question_tag->cloned_from):
                    ?>
                    <tr>
                        <td>
                            <a class="btn btn-xs btn-primary questions-select" id="<?php echo $question_tag->id;?>">
                                <?php echo elgg_echo('select');?>
                            </a>
                        </td>
                        <td>
                            <?php echo $question_tag->name;?>
                            <?php if($clones = ClipitQuizQuestion::get_clones($question_tag->id, true)): ?>
                                <small class="show margin-top-5">
                                    <a class="get-clones" href="javascript:;" id="<?php echo $question_tag->id;?>">
                                        <i class="fa fa-clock-o"></i> <?php echo count($clones);?>
                                        <?php echo elgg_echo('quiz:question:versions')?>
                                    </a>
                                </small>
                            <?php endif;?>
                        </td>
                        <td>
                            <?php echo elgg_view('tricky_topic/tags/view', array('limit' => 2, 'tags' => $tags)); ?>
                        </td>
                        <td><?php echo difficulty_bar($question_tag->difficulty);?></td>
                        <td style="display: none;"><?php echo $question_tag->difficulty;?></td>
                    </tr>
                <?php endif;?>
        <?php endforeach;?>
        </tbody>
    </table>
</div>
