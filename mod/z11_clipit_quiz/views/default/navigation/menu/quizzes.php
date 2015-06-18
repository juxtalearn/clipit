
<li> 
    <?php 
    $user_id = elgg_get_logged_in_user_guid();
    $prop_val_array = ClipitUser::get_properties($user_id, array("role"));
    $role = $prop_val_array["role"];
    
    if ($role == ClipitUser::ROLE_STUDENT){
        $permiso = "results/all_quizzes";
    } else {
        $permiso = "quizzes/all";
    }
    
    echo elgg_view('output/url', array (
        'href' => $permiso,
        "text" => '<span class="hidden-xs hidden-sm">Quizzes</span>'
    ));
    ?>
</li>
<li class="separator">|</li>

