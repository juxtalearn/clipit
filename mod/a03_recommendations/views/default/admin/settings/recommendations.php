<?php
admin_gatekeeper();
//Vars required for action gatekeeper
$ts = time();
$token = generate_action_token($ts);
?>
    <div class="col-md-12">

        <form action="<?php echo $vars['url']; ?>action/recommendations/test" method="post">
            <p>
                <?php
                echo elgg_view('input/hidden', array('name' => "affirmative", 'value' => true));
                ?>
            </p>

            <p>
                <?php
                echo elgg_view('input/hidden', array('name' => '__elgg_token', 'value' => $token));
                echo elgg_view('input/hidden', array('name' => '__elgg_ts', 'value' => $ts));
                ?>
            </p>

            <p>
                <input type="submit" value="<?php echo elgg_echo('recommendations:test'); ?>"/>
            </p>


        </form>

        <h1><?php echo elgg_echo('recommendations:summary'); ?></h1>

        <p><br/>
            <?php
            $videos = ClipitSite::get_videos();
            $files = ClipitSite::get_files();
            $storyboards = ClipitSite::get_storyboards();
            $users = ClipitUser::get_all();
            echo(elgg_echo('recommendations:installation')."<br/><strong>" . count($videos) . "</strong> ".elgg_echo('recommendations:public_videos')."<br />");
            echo("<strong>" . count($files) . "</strong> ".elgg_echo('recommendations:public_files')."<br />");
            echo("<strong>" . count($storyboards) . "</strong> ".elgg_echo('recommendations:public_storyboards')."<br />");
            echo("<strong>" . count($users) . "</strong> ".elgg_echo('recommendations:users')."<br />");
            ?>
        </p>
    </div>
