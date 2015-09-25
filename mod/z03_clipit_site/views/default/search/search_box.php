<?php
/**
 * Search box
 *
 * @uses $vars['value'] Current search query
 * @uses $vars['class'] Additional class
 */

if (array_key_exists('value', $vars)) {
    $value = $vars['value'];
} elseif ($value = get_input('text', get_input('tag', NULL))) {
    $value = $value;
}

$class = "";
if (isset($vars['class'])) {
    $class = $vars['class'];
}

// @todo - why the strip slashes?
$value = stripslashes($value);

// @todo - create function for sanitization of strings for display in 1.8
// encode <,>,&, quotes and characters above 127
if (function_exists('mb_convert_encoding')) {
    $display_query = mb_convert_encoding($value, 'HTML-ENTITIES', 'UTF-8');
} else {
    // if no mbstring extension, we just strip characters
    $display_query = preg_replace("/[^\x01-\x7F]/", "", $value);
}
$display_query = htmlspecialchars($display_query, ENT_QUOTES, 'UTF-8', false);

?>

<form class="<?php echo $class; ?>" action="<?php echo elgg_get_site_url();?>explore/search" method="GET">
    <div class="input-group">
        <input type="text" aria-label="<?php echo elgg_echo('search:btn');?>" class="form-control" size="21" name="text" value="<?php echo $display_query; ?>" placeholder="<?php echo elgg_echo('search');?>" />
        <input type="hidden" name="by" value="all" />
        <div class="input-group-btn">
            <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
        </div>
    </div>
</form>

