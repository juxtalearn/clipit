<div class="container">
    <!-- Social -->
    <div class="row">
        <div class="col-sm-12 social-connect text-center">
            <h2>Follow us</h2>
            <div class="social-icons">
                <?php if($vars['account_twitter']): ?>
                <img src="<?php echo $vars['img_path'];?>social/twitter.png" />
                <?php endif; ?>
                <?php if($vars['account_facebook']): ?>
                <img src="<?php echo $vars['img_path'];?>social/facebook.png" />
                <?php endif; ?>
                <?php if($vars['account_linkedin']): ?>
                <img src="<?php echo $vars['img_path'];?>social/linkedin.png" />
                <?php endif; ?>
                <?php if($vars['account_youtube']): ?>
                <img src="<?php echo $vars['img_path'];?>social/youtube.png" />
                <?php endif; ?>
                <?php if($vars['account_vimeo']): ?>
                <img src="<?php echo $vars['img_path'];?>social/vimeo.png" />
                <?php endif; ?>
            </div>
        </div>
    </div><!-- Social end-->
</div><!-- Container mid end-->