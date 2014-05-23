<div class="container">
    <!-- Clipit blocks -->
    <div class="row">
        <div class="col-sm-4 bg-red block text-center">
            <div class="arrow">
                <span class="red"></span>
            </div>
            <img src="<?php echo $vars['img_path'];?>crea.png">
            <h2>Create</h2>
            <p>Lorem ipsum sit amet constance ectetuer adipicin. Lorem ipsum sit amet constance</p>
        </div>
        <div class="col-sm-4 bg-yellow block text-center">
            <div class="arrow">
                <span class="yellow"></span>
            </div>
            <img src="<?php echo $vars['img_path'];?>aprende.png">
            <h2>Learn</h2>
            <p>Lorem ipsum sit amet constance ectetuer adipicin. Lorem ipsum sit amet constance</p>
        </div>
        <div class="col-sm-4 bg-blue block text-center">
            <img src="<?php echo $vars['img_path'];?>comparte.png">
            <h2>Share</h2>
            <p>Lorem ipsum sit amet constance ectetuer adipicin. Lorem ipsum sit amet constance</p>
        </div>
    </div><!-- Clipit blocks end -->
    <!-- Social -->
    <div class="row">
        <div class="col-sm-12 social-connect text-center">
            <h2>Follow us</h2>
            <div class="social-icons">
                <?php if($vars['account_twitter']): ?>
                <img src="<?php echo $vars['img_path'];?>social/twitter.png" />
                <? endif; ?>
                <?php if($vars['account_facebook']): ?>
                <img src="<?php echo $vars['img_path'];?>social/facebook.png" />
                <? endif; ?>
                <?php if($vars['account_linkedin']): ?>
                <img src="<?php echo $vars['img_path'];?>social/linkedin.png" />
                <? endif; ?>
                <?php if($vars['account_youtube']): ?>
                <img src="<?php echo $vars['img_path'];?>social/youtube.png" />
                <? endif; ?>
                <?php if($vars['account_vimeo']): ?>
                <img src="<?php echo $vars['img_path'];?>social/vimeo.png" />
                <? endif; ?>
            </div>
        </div>
    </div><!-- Social end-->
</div><!-- Container mid end-->