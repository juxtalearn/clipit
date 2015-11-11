<?php
/**
 * Clipit Web Space
 * PHP version:     >= 5.2
 * Creation date:   22/04/14
 * Last update:     22/04/14
 * @author          Miguel Ángel Gutiérrez <magutierrezmoreno@gmail.com>, URJC Clipit Project
 * @version         $Version$
 * @link            http://clipit.es
 * @license         GNU Affero General Public License v3
 * @package         Clipit
 */
$entity = elgg_extract('entity', $vars);
$hasToken = get_config("google_refresh_token");

echo elgg_view("input/hidden", array(
    'name' => 'entity-id',
    'value' => $entity->id,
));
echo elgg_view("input/hidden", array(
    'name' => 'tags',
));
?>
<div class="row">
    <div class="col-md-12 add-video">
        <div class="video-info">
            <div class="panel-group" id="accordion" style="margin-bottom: 10px;">
                <!-- Video upload -->
                <div class="panel panel-default">
                    <?php if($hasToken):?>
                    <div class="panel-heading">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                            <h4 class="panel-title">
                                <strong>
                                    <i class="fa fa-angle-down pull-right"></i>
                                    <?php echo elgg_echo('video:add:to_youtube');?>
                                </strong>
                            </h4>
                        </a>
                    </div>
                    <?php endif;?>
                    <div id="collapseThree" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="video-upload"><?php echo elgg_echo("video:upload");?></label>
                                <?php echo elgg_view("input/file", array(
                                    'name' => 'video-upload',
                                    'id' => 'video-upload',
                                    'style' => "width: 100%;"
                                ));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Video url -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                            <h4 class="panel-title">
                                <strong>
                                    <i class="fa fa-angle-down pull-right"></i>
                                    <?php echo elgg_echo('video:add:paste_url');?>
                                </strong>
                            </h4>
                        </a>
                    </div>
                    <div id="collapseTwo" class="panel-collapse collapse">
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="video-url"><?php echo elgg_echo("video:url");?></label>
                                <div class="icon">
                                    <?php echo elgg_view("input/text", array(
                                        'name' => 'video-url',
                                        'id' => 'video-url',
                                        'class' => 'form-control blue',
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="video-title"><?php echo elgg_echo("video:title");?></label>
                <?php echo elgg_view("input/text", array(
                    'name' => 'video-title',
                    'id' => 'video-title',
                    'class' => 'form-control',
                    'required' => true
                ));
                ?>
            </div>
            <div class="form-group">
                <label for="video-description"><?php echo elgg_echo("video:description");?></label>
                <?php echo elgg_view("input/plaintext", array(
                    'name' => 'video-description',
                    'class' => 'form-control mceEditor',
                    'id' => 'video-description',
                    'rows'  => 3,
                    'placeholder' => 'Set description...',
                    'style' => "width: 100%;"
                ));
                ?>
            </div>
        </div>
    </div>
</div>