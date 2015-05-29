
<h3>This will check-out the latest ClipIt stable version and apply all necessary updates</h3>
<br>
<h3>Current version: <?php echo(get_config("clipit_version")); ?></h3>
<br>
<form action='<?php echo(elgg_get_site_url()); ?>action/update_clipit' method='post'>
    <?php echo elgg_view('input/securitytoken'); ?>
    Are you sure you want to proceed? <input name='update_clipit' value='Update' type='submit'>
</form>
