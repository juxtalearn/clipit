<?php
/**
 * Created by JetBrains PhpStorm.
 * User: equipo
 * Date: 14/02/14
 * Time: 15:30
 * To change this template use File | Settings | File Templates.
 */
if (isset($vars['class'])) {
    $vars['class'] = "progress-bar {$vars['class']}";
} else {
    $vars['class'] = "progress-bar";
}
$value = $vars['value'];
if($value > 100){
    $value = 100;
}elseif($value < 0){
    $value = 0;
}
$vars['aria-valuenow'] = $value;
$defaults = array(
    'width'         => "100%",
    'aria-valuenow' => 0,
    'aria-valuemin' => 0,
    'aria-valuemax' => 100,
    'style'         => 'width: '.$value.'%',
);

$vars = array_merge($defaults, $vars);
?>
<div class="progress" style="width:<?php echo $vars['width']; ?>">
  <div class="progress-bar" role="progressbar" aria-label="<?php echo elgg_echo('progressbar:name');?> "<?php echo elgg_format_attributes($vars); ?>>
      <?php echo $value; ?>%
  </div>
</div>