<?php
//
// Archivo para que los widgets no puedan ser configurables

?>
<a class="fa fa-chevron-down collapse" href="javascript:;"></a>

<?php if(isset($vars['view_all'])){ ?>
<a class="<?php echo $vars['view_all']; ?>">View all</a>
<?php } ?>