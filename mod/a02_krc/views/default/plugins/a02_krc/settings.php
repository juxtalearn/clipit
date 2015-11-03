<?php
$users = ClipitUser::get_all();
$sbs = Clipittag::get_all();
echo "<p>Only Stumbling Block ratings greater than 0 are shown!</p>";
echo "<table>";
foreach ($users as $user ) {
    $profile = new UserProfile($user->id);
    echo "<tr><th> $user->name </th><td>";
    foreach($sbs as $sb){
        $level = $profile->get_level_for_tag($sb->id);
        if ($level !== 0.0) {
            echo "<p>$sb->name ($sb->id) : $level</p>";
        }
    }
    echo "</td></tr>";
}
echo "</table>";