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
$vars['aria-valuenow'] = $vars['value'];

$defaults = array(
    'width'         => "100%",
    'aria-valuenow' => 0,
    'aria-valuemin' => 0,
    'aria-valuemax' => 100,
    'style'         => 'width: '.$vars['value'].'%',
);
$value = $vars['value'];
$vars = array_merge($defaults, $vars);
if($value > 100){
    $value = 100;
}
?>
<div class="progress" style="width:<?php echo $vars['width']; ?>">
  <div class="progress-bar" role="progressbar" <?php echo elgg_format_attributes($vars); ?>>
      <?php echo $value; ?>%
  </div>
</div>