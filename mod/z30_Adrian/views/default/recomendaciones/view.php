<?php

/*
 * ADRIAN SANCHEZ IGLESIAS
 * 
 */
define('MAX_COLUMNS', '3');

$user_logged = array();
$user_logged[] = elgg_get_logged_in_user_guid();
$user = array_pop(ClipitUser::get_by_id($user_logged));

$filtertype = $_POST['filtertype'];
$media = $_POST['media'];

$videos_mejor_valorados = NULL;

function show_videos_better_ranking($videos, $media){
    $rangoInferior = $media - 1;
    print_r("<font size=6 color=#2E9AFE>Estos son los vídeos valorados <b>entre $rangoInferior y $media</b></font><br>");
    show_videos_cache($videos);
}

function show_videos_same_activity($videos_better_rankings){
    print_r("<font size=6 color=#2E9AFE>Estos son los vídeos recomendados de personas de <b>tus mismas actividades</b></font><br>");
    show_videos_cache($videos_better_rankings);
}

function show_videos_others_activities($videos_better_rankings) {
    print_r("<font size=6 color=#2E9AFE>Estos son los vídeos recomendados de personas de <b>otras actividades</b></font><br>");
    show_videos_cache($videos_better_rankings);
}

function show_videos_all_activities($videos_better_rankings){
    print_r("<font size=6 color=#2E9AFE>Estos son todos los vídeos recomendados de <b>todo tipo de actividades</b></font><br>");
    show_videos_cache($videos_better_rankings);
}

function show_videos_cache($videos_ranking) {
    echo "<table>";
    $count_columns = 0;
    $videos = ClipitVideo::get_by_id($videos_ranking);
    foreach ($videos as $video) {
        if ($count_columns == 0) echo "<tr>";
        $activity_id = ClipitVideo::get_activity($video->id);
        echo "<td>";
        echo elgg_view('output/url', array("href" => "clipit_activity/$activity_id/publications/view/$video->id", "text" => "<img src='$video->preview' title='$video->name' width='270' height='192.5' />"));
        echo "</td>";
        $count_columns++;
        if ($count_columns == MAX_COLUMNS){
            echo "</tr>";
            $count_columns = 0;
        }
    } // foreach
    echo "</table>";
}

//cacheRecommender::delete_all();
print_r(cacheRecommender::get_all());

//cacheRecommender::recommended_upload();


switch ($filtertype){
    case NULL:
        $videos_mejor_valorados = cacheRecommender::get_videos_better_rating();
        show_videos_better_ranking($videos_mejor_valorados, 5);
        break;
    case "none":
        $videos_mejor_valorados = cacheRecommender::get_videos_better_rating($media);
        show_videos_better_ranking($videos_mejor_valorados, $media);
        break;
    case "same":
        $videos_mejor_valorados = cacheRecommender::get_videos_same_activity($user->id);
        show_videos_same_activity($videos_mejor_valorados);
        break;
    case "others":
        $videos_mejor_valorados = cacheRecommender::get_videos_other_activities($user->id);
        show_videos_others_activities($videos_mejor_valorados);
        break;
    case "all":
        $videos_mejor_valorados = cacheRecommender::get_videos_all_activities($user->id);
        show_videos_all_activities($videos_mejor_valorados);
        break;
    default:
        print_exception("Ha habido un error");
} // switch

/*
 * echo elgg_view('output/url',array("href"=>url del video,"text"=>"todo img"))
 * url del video "clipit_activity/activity_id/publications/view/video_id"
 * 
 * para sacar la id de la actividad:
 *    clipitvideo::get_activity(id del video)
 */
?>

