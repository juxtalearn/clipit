<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   02/12/2014
 * Last update:     02/12/2014
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$tag = get_input('stumbling_block');
$tricky_topic = elgg_extract('tricky_topic', $vars);
$sb = elgg_extract('sb', $vars);
?>
<table class="table">
    <thead>
    <tr>
        <th><?php echo elgg_echo('title');?></th>
        <th><?php echo elgg_echo('example:education_level');?></th>
        <th><?php echo elgg_echo('example:location');?></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <tr class="info">
        <td>
            <strong>
            <?php echo elgg_view('output/url', array(
                'href'  => "tricky_topics/view/{$tricky_topic->id}",
                'title' => $tricky_topic->name,
                'text'  => 'Application of Equations',
            ));
            ?>
            </strong>
            <small class="show">
                Students fail to understand that the motion of the electron is not free.
                The electron is bound to the atom by the attractive force of the
            </small>
        </td>
        <td>15-16</td>
        <td>
            <a href=""><i class="fa fa-globe"></i> Spain</a>
        </td>
        <td>
            <a class="btn btn-xs btn-border-blue" style="padding: 2px 7px;">
                <i class="fa fa-download blue"></i>
            </a>
        </td>
    </tr>
    <tr class="info">
        <td>
            <strong>
                <?php echo elgg_view('output/url', array(
                    'href'  => "tricky_topics/view/{$tricky_topic->id}",
                    'title' => $tricky_topic->name,
                    'text'  => 'Application of Equations',
                ));
                ?>
            </strong>
        </td>
        <td>15-16</td>
        <td>
            <a href=""><i class="fa fa-globe"></i> Spain</a>
        </td>
        <td>
            <a class="btn btn-xs btn-border-blue" style="padding: 2px 7px;">
                <i class="fa fa-download blue"></i>
            </a>
        </td>
    </tr>
    <tr class="info">
        <td>
            <div>
                <strong>
                    <?php echo elgg_view('output/url', array(
                        'href'  => "tricky_topics/view/{$tricky_topic->id}",
                        'title' => $tricky_topic->name,
                        'text'  => 'Acceptance of all',
                    ));
                    ?>
                </strong>
                <small class="show">
                    Students fail to understand that the motion of the electron is not free.
                    The electron is bound to the atom by the attractive force of the
                    nucleus and consequently quantum mechanics predicts that the total
                    energy of the electron is quantized. As a result they are not able
                    to grasp the quantum model of the atom.
                </small>
            </div>
        </td>
        <td>18-24</td>
        <td>
            <a href=""><i class="fa fa-globe"></i> Spain</a>
        </td>
        <td>
            <a class="btn btn-xs btn-border-blue" style="padding: 2px 7px;">
                <i class="fa fa-download blue"></i>
            </a>
        </td>
    </tr>
    <tr>
        <td colspan="4">
            <?php echo elgg_view('output/url', array(
                'href'  => "tricky_topics/student_problems/create?tricky_topic={$tricky_topic}&stumbling_block={$sb}",
                'class' => 'btn btn-xs btn-primary',
                'title' => elgg_echo('example:add'),
                'text'  => elgg_echo('example:add'),
            ));
            ?>
        </td>
    </tr>
    </tbody>
</table>