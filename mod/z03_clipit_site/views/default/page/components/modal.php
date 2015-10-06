<?php
$title = elgg_extract('title', $vars, '');
$body = elgg_extract('body', $vars, '');
$target = elgg_extract('target', $vars);


// modal footer
$footer = "";
$cancel_button = "";
$ok_button = "";
if($vars['cancel_button']){
    $cancel_button = '<button type="button" class="btn-border-blue btn btn-default cancel" data-dismiss="modal">'.elgg_echo("cancel").'</button>';
}
if(isset($vars['ok_button'])){
    $ok_button = $vars['ok_button'];
}
if($vars['footer'] || $cancel_button || $ok_button){
    $footer = '<div class="modal-footer">'.$vars["footer"].$cancel_button.$ok_button.'</div>';
}
?>
<?php if(!isset($vars['remote']) || $vars['remote'] === false): ?>
<div class="modal fade <?php echo $vars['class']; ?>" id="<?php echo $target ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<?php endif; ?>
    <div class="modal-dialog <?php echo $vars['dialog_class']; ?>">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title"><?php echo $title; ?></h3>
            </div>
            <div class="modal-body"><?php echo $body; ?></div>
            <?php echo $footer; ?>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
<?php if(!isset($vars['remote']) || $vars['remote'] === false): ?>
</div>
<?php endif; ?>