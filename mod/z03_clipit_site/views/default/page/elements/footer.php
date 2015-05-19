<?php
/**
 * Elgg footer
 * The standard HTML footer that displays across the site
 *
 * @package Elgg
 * @subpackage Core
 *
 */

$footer_menu = elgg_view_menu('footer_clipit', array(
    'sort_by' => 'priority',
    'class' => 'pull-right site-map col-sm-9 col-xs-12 col-md-5'
));
$site = elgg_get_site_entity();
$js = elgg_get_loaded_js('footer');
?>
<footer id="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-2 col-xs-4 hidden-xs">
                <div class="contact">
                    <h2>Hola!</h2>
                    <?php
                    echo elgg_view('output/url', array(
                        'href' => "mailto:{$site->email}?subject=site name: {$site->name}",
                        'title' => elgg_echo('send:email_to_site'),
                        'text' => elgg_view('output/img', array(
                            'src' => "mod/z03_clipit_site/graphics/mail.png",
                        )),
                        'is_trusted' => true,
                        'target' => '_blank'
                    ));
                    ?>
                </div>
            </div>
            <?php echo $footer_menu; ?>
        </div>
        <div class="row sponsors">
            <div class="col-sm-5 pull-right">
                <div class="row">
                <?php
                echo elgg_view('output/url', array(
                    'href' => "http://www.juxtalearn.eu",
                    'title' => "JuxtaLearn",
                    'text' => elgg_view('output/img', array(
                        'src' => "mod/z03_clipit_site/graphics/jxl_logo.png",
                    )),
                    'class' => 'col-xs-5 col-md-offset-1',
                    'is_trusted' => true,
                    'target' => '_blank'
                ));
                ?>
                <?php
                echo elgg_view('output/url', array(
                    'href' => "http://ec.europa.eu/research/fp7/index_en.cfm",
                    'title' => "FP7",
                    'text' => elgg_view('output/img', array(
                        'src' => "mod/z03_clipit_site/graphics/sponsors.png",
                    )),
                    'class' => 'col-xs-6',
                    'is_trusted' => true,
                    'target' => '_blank'
                ));
                ?>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php if (elgg_is_logged_in()) : ?>
    <!-- Messages modal -->
    <?php echo elgg_view_form('messages/compose', array('data-validate'=> 'true')); ?>
    <!-- Messages modal end -->
<?php endif; ?>
<?php foreach ($js as $script): ?>
    <script type="text/javascript" src="<?php echo $script; ?>"></script>
<?php endforeach;?>