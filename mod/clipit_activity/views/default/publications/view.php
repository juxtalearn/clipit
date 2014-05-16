<?php
 /**
 * ClipIt - JuxtaLearn Web Space
 * PHP version:     >= 5.2
 * Creation date:   14/05/14
 * Last update:     14/05/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC JuxtaLearn Project
 * @version         $Version$
 * @link            http://www.juxtalearn.eu
 * @license         GNU Affero General Public License v3
 * @package         ClipIt
 */
$entity = elgg_extract("entity", $vars);
$user_loggedin = elgg_get_logged_in_user_guid();
?>
<!-- Multimedia info + details -->
<div class="multimedia-owner multimedia-pub">
    <div class="block">
        <div class="header">
            <h2 class="title"><?php echo $entity->name; ?></h2>
        </div>
        <div class="multimedia-body">
            <div class="multimedia-view">
                <?php echo $vars['body'];?>
            </div>
            <div class="row details">
                <div class="col-md-8">
                    <h4><strong>Tags</strong></h4>
                    <div class="tags">
                        <a href="" class="label label-primary">Trabajo y Potencia</a>
                        <a href="" class="label label-primary">Cinética</a>
                        <a href="" class="label label-primary">Gravitación universal y campo gravitatorio</a>
                    </div>
                    <h4><strong>Description</strong></h4>
                    <div class="description">
                        <?php echo $entity->description; ?>
                    </div>
                </div>
                <!-- Star rating -->
                <div class="col-md-4">

                </div>
                <!-- Star rating end -->
            </div>
        </div>
    </div>
</div>
<!-- Multimedia info + details end -->
<h2 class="title-block">Evaluate</h2>
<?php echo elgg_view_form("publications/evaluate", array('style' => 'background: #f1f2f7;padding: 20px;margin: 10px 0;')); ?>